<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientApiRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apiRequests = $this->getTodayData();
        // dd($apiRequests);

        return view('dashboard.index', [
            'total_api_request' => $apiRequests['total_api_request'],
            'total_success_calls' => $apiRequests['total_success_calls'],
            'total_failed_calls' => $apiRequests['total_failed_calls'],
            'total_success_rate' => $apiRequests['total_success_rate'],
            'last_requests_list' => $apiRequests['last_requests_list'],
            'used_apis_list' => $apiRequests['used_apis_list'],
        ]);
    }

    private function getTodayData()
    {
        $today = Carbon::now('Asia/Jakarta');

        $apiRequests = ClientApiRequest::select(
                    'client_api_requests.created_at',
                    'client_api_responses.status_code', 'client_api_responses.status_description',
                    'products.telco_name', 'products.name AS product_name'
            )
            ->leftJoin('client_api_responses', 'client_api_requests.id', '=', 'client_api_responses.request_id')
            ->leftJoin('products', 'client_api_requests.product_id', '=', 'products.id')
            ->where('client_api_requests.client_id', '=', Auth::user()->id)
            ->whereRaw('DATE(client_api_requests.created_at) = \'' . $today->format('Y-m-d') . '\'')
            // ->whereRaw('DATE(client_api_requests.created_at) = \'2023-04-19\'')
            ->orderBy('client_api_requests.id', 'DESC')
            ->get();
        // dd($apiRequests);

        $apiList = [];
        $totalSuccessCalls = 0;
        $totalFailedCalls = 0;
        $totalSuccessRate = 0;
        $topTenList = [];

        foreach ($apiRequests AS $keyApiRequest => $valApiRequest) {
            if (!empty($valApiRequest->status_code) && ((int) $valApiRequest->status_code == 0)) {
                $totalSuccessCalls++;
            } else {
                $totalFailedCalls++;
            }

            if (!array_key_exists($valApiRequest['telco_name'], $apiList)) {
                $apiList[$valApiRequest['telco_name']] = $valApiRequest['product_name'];
            }

            if (count($topTenList) < 11) {
                $topTenList[] = $valApiRequest;
            }
        }

        if ($totalSuccessCalls > 0)
            $totalSuccessRate = ($totalSuccessCalls / count($apiRequests)) * 100;

        return array(
            'total_api_request' => count($apiList),
            'total_success_calls' => $totalSuccessCalls,
            'total_failed_calls' => $totalFailedCalls,
            'total_success_rate' => $totalSuccessRate,
            'last_requests_list' => $topTenList,
            'used_apis_list' => $apiList,
        );
    }
}
