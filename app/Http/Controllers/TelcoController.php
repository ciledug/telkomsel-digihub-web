<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\ClientApiRequest;
use App\Models\ClientApiResponse;
use App\Models\Product;
use App\Models\UserProfile;

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
            'profile' => UserProfile::where('user_id', '=', Auth::user()->id)->first(),
            'products' => Product::all(),
        ]);
    }

    public function index_02()
    {
        return view('telco.v02.index', [
            'profile' => UserProfile::where('user_id', '=', Auth::user()->id)->first(),
            'products' => Product::all(),
        ]);
    }

    public function send(Request $request)
    {
        // dd($request->input());
        // dd(Auth::user());

        $response = [
            'code' => 500,
            'message' => 'Server error',
            'count' => 0,
            'data' => [],
        ];

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

        $requestId = $this->saveApiRequest(
            Auth::user()->id,
            $request->input_transaction_id,
            $product->id,
            $request->input_consent,
            Carbon::now('Asia/Jakarta')->getTimestamp()
        );

        if ($product) {
            $apisUrl = env('DALNET_TELCO_API_GATEWAY', '') . '/v1';
            $statusCode = '-1';
            $statusDesc = 'Access token failed';
        
            $postedRequest = array(
                'transaction_id' => $request->input_transaction_id,
                'client_id' => session('client_id'),
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
                    $apisUrl = str_replace('<endpoint>', 'ktp_match', $apisUrl);
                    $postedRequest['nik'] = $request->input_nik;
                    break;
        
                case 'recycle':
                    $apisUrl = str_replace('<endpoint>', 'recycle_number', $apisUrl);
                    $postedRequest['timestamp'] = date('Y-m-d', time());
                    break;
        
                case 'roaming2':
                    $apisUrl = str_replace('<endpoint>', 'active_roaming', $apisUrl);
                    break;
        
                case 'lastloc2':
                    $apisUrl = str_replace('<endpoint>', 'last_location', $apisUrl);
                    $postedRequest['param'] = strtoupper($request->input_param);
                    break;
        
                case 'loyalist':
                    $apisUrl = str_replace('<endpoint>', 'interest', $apisUrl);
                    $postedRequest['partner'] = $request->input_partner_name;
                    break;
        
                case 'telcoses':
                    $apisUrl = str_replace('<endpoint>', 'telco_ses', $apisUrl);
                    $postedRequest['consent_id'] = $request->input_consent_id;
                    $postedRequest['partner'] = $request->input_partner_name;
                    break;
        
                case 'substat2':
                    $apisUrl = str_replace('<endpoint>', 'active_status', $apisUrl);
                    break;
        
                case 'numberswitching2': 
                    $apisUrl = str_replace('<endpoint>', '1_imei_multiple_number', $apisUrl);
                    $postedRequest['msisdn_imei_key'] = $request->input_imei;
                    $postedRequest['param'] = $request->input_param_1_imei_multiple_number;
                    $postedRequest['min'] = $request->input_min;
                    $postedRequest['max'] = $request->input_max;
                    break;
        
                case 'forwarding2':
                    $apisUrl = str_replace('<endpoint>', 'call_forwarding_status', $apisUrl);
                    break;
        
                case 'simswap':
                    $apisUrl = str_replace('<endpoint>', 'sim_swap', $apisUrl);
                    break;
        
                case 'tscore':
                    $apisUrl = str_replace('<endpoint>', 'telco_score_bin_25', $apisUrl);
                    $postedRequest['srd_flag'] = $request->radio_srd_flag;
                    break;
            }
            // dd($postedRequest); die();
        
            $curl = curl_init();
        
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $apisUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $postedRequest,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTPHEADER => array(
                        'Accept: */*',
                        'Authorization: Bearer ' . session('api_token'),
                    ),
                    CURLOPT_SSL_VERIFYHOST => storage_path('cacert/cacert.pem'),
                    CURLOPT_SSL_VERIFYPEER => storage_path('cacert/cacert.pem'),
                )
            );
            
            $curlResponse = curl_exec($curl); // echo 'curlResponse: ' . $curlResponse; die();
            $err = curl_error($curl); // echo $err; die();
            $curlResult = '';
            curl_close($curl);
            
            if (empty($err)) {
                // dd($curlResponse); die();

                if ($curlResponse != null) {
                    $curlResponse = json_decode($curlResponse);
                    // dd($curlResponse); die();

                    if (isset($curlResponse->data)) {
                        $statusCode = $curlResponse->data->api_response->transaction->status_code;
                        $statusDesc = $curlResponse->data->api_response->transaction->status_desc;
                        $response['code'] = 200;
                        $response['message'] = 'OK';
                        $response['count'] = 1;
                        $response['data'] = $curlResponse->data;
                    }
                    else {
                        $response['code'] = 403;
                        $response['message'] = 'Login is expired or required';
                    }
                }
            }
            else {
                $statusDesc = $err;
                $response['message'] = $err;
            }
        }
        else {
            $response['code'] = 404;
            $response['message'] = 'Product API does not exist';
        }

        $this->saveApiResponse($requestId->id, $statusCode, $statusDesc);
        return response()->json($response, 200);
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
