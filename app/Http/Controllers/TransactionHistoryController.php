<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ClientApiRequest;
use App\Models\ClientApiResponse;

class TransactionHistoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalCallsData = $this->getTotalCallsData();
        $apiRequests = $this->getTransactionsByDate();
        // dd($totalCallsData); die();

        return view('transaction.index', [
            'api_requests' => $apiRequests,
            'total_api_calls' => $totalCallsData['total_api_calls'],
            'total_success_rate' => $totalCallsData['total_success_rate'],
            'total_success_calls' => $totalCallsData['total_success_calls'],
            'total_failed_calls' => $totalCallsData['total_failed_calls'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        return view('transaction.index', [
            'show' => 'list-per-date',
            'transactions_list' => $this->getTransactionsList($param),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getTotalCallsData()
    {
        $apiRequests = ClientApiRequest::select(
                'client_api_responses.status_code'
            )
            ->where('client_api_requests.client_id', '=', Auth::user()->id)
            ->leftJoin('client_api_responses', 'client_api_requests.id', '=', 'client_api_responses.request_id')
            ->orderBy('client_api_requests.created_at', 'DESC')
            ->get();
        // dd($apiRequests); die();

        $totalSuccessCalls = 0;
        $totalFailedCalls = 0;
        $totalSuccessRate = 0;

        foreach ($apiRequests AS $keyApiRequest => $valApiRequest) {
            if (!empty($valApiRequest->status_code)) {
                if ($valApiRequest->status_code === '00000') {
                    $totalSuccessCalls++;
                }
                else {
                    $totalFailedCalls++;
                }
            }
            else {
                $totalFailedCalls++;
            }
        }

        if ($totalSuccessCalls > 0)
            $totalSuccessRate = ($totalSuccessCalls / $apiRequests->count()) * 100;

        return [
            'total_api_calls' => $apiRequests->count(),
            'total_success_rate' => $totalSuccessRate,
            'total_success_calls' => $totalSuccessCalls,
            'total_failed_calls' => $totalFailedCalls,
        ];
    }

    private function getTransactionsByMonth()
    {
        $apiRequests = ClientApiRequest::select(
            'client_api_requests.id',
            'client_api_responses.status_code'
        )
        ->selectRaw('
            MONTH(client_api_requests.created_at) created_at,
            COUNT(client_api_requests.product_id) total_api_calls
        ')
        ->leftJoin('client_api_responses', 'client_api_requests.id', '=', 'client_api_responses.request_id')
        ->leftJoin('products', 'client_api_requests.product_id', '=', 'products.id')
        ->groupBy(DB::raw('MONTH(client_api_requests.created_at)'));

        
        $apiRequests->where('client_api_requests.client_id', '=', Auth::user()->id)
            ->orderBy('client_api_requests.id', 'DESC')
            // ->paginate(10);
            ->get();

        return $apiRequests;
    }

    private function getTransactionsByDate()
    {
        $apiRequests = ClientApiRequest::selectRaw("
                DATE(client_api_requests.created_at) AS api_date,
                COUNT(DISTINCT(product_id)) AS count_product_apis,
                COUNT(IF(client_api_responses.status_code = '00000', 1, NULL)) AS count_success_calls,
                COUNT(IF(client_api_responses.status_code <> '00000', 1, IF(client_api_responses.status_code IS NULL, 1, NULL))) AS count_failed_calls,
                COUNT(client_api_requests.id) AS count_total_calls
            ")
            ->leftJoin('client_api_responses', 'client_api_requests.id', '=', 'client_api_responses.request_id')
            ->where('client_api_requests.client_id', '=', Auth::user()->id)
            ->groupBy(DB::raw('DATE(client_api_requests.created_at)'))
            ->orderBy('client_api_requests.created_at', 'DESC')
            ->paginate(10);
        // dd($apiRequests); die();
        return $apiRequests;
    }

    private function getTransactionsList($paramDate)
    {
        $apiRequests = ClientApiRequest::select(
                'client_api_requests.transaction_id', 'client_api_requests.consent_ref', 'client_api_requests.created_at',
                'client_api_responses.status_code', 'client_api_responses.status_description',
                'products.name AS api_name'
            )
            ->leftJoin('client_api_responses', 'client_api_requests.id', '=', 'client_api_responses.request_id')
            ->leftJoin('products', 'client_api_requests.product_id', '=', 'products.id')
            ->where('client_api_requests.client_id', '=', Auth::user()->id)
            ->where('client_api_requests.created_at', 'LIKE', $paramDate . '%')
            ->orderBy('client_api_requests.id', 'DESC')
            ->paginate(15);
        // dd($apiRequests); die();

        return $apiRequests;
    }
}
