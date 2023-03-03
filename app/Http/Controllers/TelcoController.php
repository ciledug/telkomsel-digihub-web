<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\ClientApiRequest;
use App\Models\ClientApiResponse;
use App\Models\Product;

class TelcoController extends Controller
{
    private $ADDRESS_TYPE = array('geolocation', 'address', 'zipcode');

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('telco.v01.index', [
            'products' => Product::all(),
        ]);
    }

    public function index_02()
    {
        return view('telco.v02.index', [
            'products' => Product::all(),
        ]);
    }

    public function send(Request $request)
    {
        // dd($request->input());
        // dd(Auth::user());

        $validator = Validator::make($request->input(), [
            'input_product_id' => 'required|string',
            'input_transaction_id' => 'required|string',
            'input_consent' => 'required|string',
            'input_msisdn' => 'nullable|numeric|min:62800000000|max:6289999999999999',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::select('id', 'name', 'telco_name')
            ->where('telco_name', '=', $request->input_product_id)
            ->first();

        if ($product) {
            $gatewayUrl = env('DALNET_TELCO_API_GATEWAY', '');
        
            $postedRequest = array(
                'transaction_id' => $request->input_transaction_id,
                'product_id' => $product->telco_name,
                'consent' => $request->input_consent,
                'msisdn_imei_key' => $request->input_msisdn,
            );
        
            switch($product->telco_name) {
                case 'idver':
                    $long = '';
                    $lat = '';
                    $address = '';
                    $zipCode = '';
        
                    $selectedAddressType = strtolower($_POST['selected-address-info']);
                    if (in_array($selectedAddressType, $this->ADDRESS_TYPE)) {
                        switch($selectedAddressType) {
                            case 'geolocation':
                                $long = $request->input_longitude;
                                $lat = $request->input_latitude;
                                break;
                            case 'address': $address = $request->input_address; break;
                            case 'zipcode': $zipCode = $request->input_zip_code; break;
                            default: break;
                        }
                    }
        
                    $gatewayUrl = str_replace('<endpoint>', 'location_scoring', $gatewayUrl);
                    $postedRequest['home_work'] = $request->radio_home_work;
                    $postedRequest['long'] = $long;
                    $postedRequest['lat'] = $lat;
                    $postedRequest['address'] = $address;
                    $postedRequest['zipcode'] = $zipCode;
                    break;
        
                case 'ktpscore':
                    $gatewayUrl = str_replace('<endpoint>', 'ktp_match', $gatewayUrl);
                    $postedRequest['nik'] = $request->input_nik;
                    break;
        
                case 'recycle':
                    $gatewayUrl = str_replace('<endpoint>', 'recycle_number', $gatewayUrl);
                    $postedRequest['timestamp'] = date('Y-m-d', time());
                    break;
        
                case 'roaming2':
                    $gatewayUrl = str_replace('<endpoint>', 'active_roaming', $gatewayUrl);
                    break;
        
                case 'lastloc2':
                    $gatewayUrl = str_replace('<endpoint>', 'last_location', $gatewayUrl);
                    $postedRequest['param'] = strtoupper($request->input_param);
                    break;
        
                case 'loyalist':
                    $gatewayUrl = str_replace('<endpoint>', 'interest', $gatewayUrl);
                    $postedRequest['partner'] = $request->input_partner_name;
                    break;
        
                case 'telcoses':
                    $gatewayUrl = str_replace('<endpoint>', 'telco_ses', $gatewayUrl);
                    $postedRequest['consent_id'] = $request->input_consent_id;
                    $postedRequest['partner'] = $request->input_partner_name;
                    break;
        
                case 'substat2':
                    $gatewayUrl = str_replace('<endpoint>', 'active_status', $gatewayUrl);
                    break;
        
                case 'numberswitching2': 
                    $gatewayUrl = str_replace('<endpoint>', '1_imei_multiple_number', $gatewayUrl);
                    $postedRequest['msisdn_imei_key'] = $request->input_imei;
                    $postedRequest['param'] = $request->input_param_1_imei_multiple_number;
                    $postedRequest['min'] = $request->input_min;
                    $postedRequest['max'] = $request->input_max;
                    break;
        
                case 'forwarding2':
                    $gatewayUrl = str_replace('<endpoint>', 'call_forwarding_status', $gatewayUrl);
                    break;
        
                case 'simswap':
                    $gatewayUrl = str_replace('<endpoint>', 'sim_swap', $gatewayUrl);
                    break;
        
                case 'tscore':
                    $gatewayUrl = str_replace('<endpoint>', 'telco_score_bin_25', $gatewayUrl);
                    $postedRequest['srd_flag'] = $request->radio_srd_flag;
                    break;
            }
            // dd($postedRequest);
        
            $curl = curl_init();
        
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $gatewayUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $postedRequest,
                    CURLOPT_HTTPHEADER => array(
                        "Accept: */*",
                    ),
                    // CURLOPT_SSL_VERIFYHOST => $CA_LOCATION,
                    // CURLOPT_SSL_VERIFYPEER => $CA_LOCATION,
                )
            );
            
            $response = curl_exec($curl); // echo 'response: ' . $response; die();
            $err = curl_error($curl);
            $curlResult = '';
            curl_close($curl);

            if ($err) {
                $curlResult = [ 'error' => $err ];
            }
            else { $curlResult = $response; }
            // dd($curlResult);

            $requestId = $this->saveApiRequest(
                Auth::user()->id,
                $postedRequest['transaction_id'],
                $product->id,
                $postedRequest['consent'],
                Carbon::now('Asia/Jakarta')->getTimestamp()
            );

            if (empty($err)) {
                $jsonResponse = json_decode($response);
                $this->saveApiResponse(
                    $requestId->id,
                    $jsonResponse->api_response->transaction->status_code,
                    $jsonResponse->api_response->transaction->status_desc
                );
            }
            
            return response()->json(json_decode($curlResult), 200);
        }
        else {
            echo 'Product does not exist';
        }
    }

    public function send_02(Request $request)
    {
        // dd($request->input());
        $validator = Validator::make($request->input(), [
            'input_product_id' => 'required|string',
            'input_transaction_id' => 'required|string',
            'input_client_id' => 'required|string',
            'input_consent' => 'required|string',
            'input_ciphered_text' => 'required|string',

            // 'input_msisdn' => 'nullable|numeric',
            // 'radio_home_work' => 'nullable|numeric',
            // 'radio_address_info' => 'nullable|string',
            // 'input_latitude' => 'nullable|string',
            // 'input_longitude' => 'nullable|string',
            // 'input_address' => 'nullable|string',
            // 'input_zip_code' => 'nullable|string',
            // 'input_nik' => 'nullable|numeric|min:16|max:16',
            // 'input_param' => 'nullable|string',
            // 'input_partner_name' => 'nullable|string',
            // 'input_consent_id' => 'nullable|string',
            // 'input_imei' => 'nullable|numeric',
            // 'input_param_1_imei_multiple_number' => 'nullable|string',
            // 'input_min' => 'nullable|numeric',
            // 'input_max' => 'nullable|numeric',
            // 'input_ciphered_text' => 'nullable|string',
        ]);

        return back()->withErrors($validator)->withInput();
    }

    private function saveApiRequest($clientId, $transactionId, $productId, $consentRef, $createdAtTimestamp)
    {
        $requestId = ClientApiRequest::create([
            'client_id' => $clientId,
            'transaction_id' => $transactionId,
            'product_id' => $productId,
            'consent_ref' => $consentRef,
            'created_at_timestamp' => $createdAtTimestamp,
        ]);
        return $requestId;
    }

    private function saveApiResponse($requestId, $statusCode, $statusDesc)
    {
        ClientApiResponse::create([
            'request_id' => $requestId,
            'status_code' => $statusCode,
            'status_description' => $statusDesc,
        ]);
    }
}
