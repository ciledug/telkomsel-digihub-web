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
        // dd($apiRequests);

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
    public function show($id)
    {
        //
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
        $apiRequests = ClientApiRequest::select('client_api_responses.status_code')
            ->where('client_api_requests.client_id', '=', Auth::user()->id)
            ->leftJoin('client_api_responses', 'client_api_requests.id', '=', 'client_api_responses.request_id')
            ->get();

        $totalSuccessCalls = 0;
        $totalFailedCalls = 0;
        $totalSuccessRate = 0;

        foreach ($apiRequests AS $keyApiRequest => $valApiRequest) {
            if (!empty($valApiRequest->status_code) && ((int)$valApiRequest->status_code == 0)) {
                $apiRequests[$keyApiRequest]->status_code = 0;
                $totalSuccessCalls++;
            } else {
                $apiRequests[$keyApiRequest]->status_code = -1;
                $totalFailedCalls++;
            }
        }

        if ($totalSuccessCalls > 0) $totalSuccessRate = ($totalSuccessCalls / $apiRequests->count()) * 100;

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
        $apiRequests = ClientApiRequest::select('client_api_requests.id')
            ->selectRaw('DATE(client_api_requests.created_at) created_at, COUNT(client_api_requests.product_id) total_api_calls')
            ->where('client_api_requests.client_id', '=', Auth::user()->id)
            ->leftJoin('client_api_responses', 'client_api_requests.id', '=', 'client_api_responses.request_id')
            ->groupBy(DB::raw('DATE(client_api_requests.created_at)'))
            ->orderBy('client_api_requests.id', 'DESC')
            ->paginate(10);
            // ->get();
        // dd($apiRequests);

        foreach ($apiRequests AS $keyApiRequest => $valApiRequest) {
            $apiRequests[$keyApiRequest]->total_calls = 0;
            $apiRequests[$keyApiRequest]->success_calls = 0;
            $apiRequests[$keyApiRequest]->failed_calls = 0;
            $apiRequests[$keyApiRequest]->success_rate = 0;

            $apiRequests[$keyApiRequest]->api_used = ClientApiRequest::select('client_api_requests.product_id')
                ->where('created_at', 'LIKE', Carbon::parse($valApiRequest->created_at)->format('Y-m-d') . '%')
                ->groupBy('product_id')
                ->count();

            $apiResponses = ClientApiResponse::select('client_api_responses.status_code', 'client_api_requests.product_id')
                ->leftJoin('client_api_requests', 'client_api_responses.request_id', '=', 'client_api_requests.id')
                ->where('client_api_responses.created_at', 'LIKE', Carbon::parse($valApiRequest->created_at)->format('Y-m-d') . '%')
                ->get();

            foreach ($apiResponses AS $keyApiResponse => $valApiResponse) {
                if (!empty($valApiResponse->status_code) && ((int)$valApiResponse->status_code == 0)) {
                    $apiRequests[$keyApiRequest]->success_calls++;
                } else {
                    $apiRequests[$keyApiRequest]->failed_calls++;
                }

                if ($apiRequests[$keyApiRequest]->success_calls > 0) {
                    $apiRequests[$keyApiRequest]->success_rate = ($apiRequests[$keyApiRequest]->success_calls / $apiResponses->count()) * 100;
                }
            }

            $apiRequests[$keyApiRequest]->total_calls = $apiResponses->count();
        }

        return $apiRequests;
    }
}
