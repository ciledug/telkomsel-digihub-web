<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\ClientApiRequest;

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
        $apiRequests = ClientApiRequest::select(
                'client_api_requests.id', 'client_api_requests.transaction_id', 'client_api_requests.created_at',
                'client_api_responses.status_code', 'client_api_responses.status_description',
                'products.name AS product_name'
            )
            ->leftJoin('client_api_responses', 'client_api_requests.id', '=', 'client_api_responses.request_id')
            ->leftJoin('products', 'client_api_requests.product_id', '=', 'products.id')
            ->where('client_api_requests.client_id', '=', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        // dd($apiRequest);

        $totalSuccessCalls = 0;
        $totalFailedCalls = 0;
        $totalSuccessRate = 0;

        foreach ($apiRequests AS $keyApiRequest => $valApiRequest) {
            if (!empty($valApiRequest->status_code) && ((int)$valApiRequest->status_code == 0)) {
                $valApiRequest->status_code = 0;
                $totalSuccessCalls++;
            } else {
                $valApiRequest->status_code = -1;
                $totalFailedCalls++;
            }
        }

        if ($totalSuccessCalls > 0) $totalSuccessRate = ($totalSuccessCalls / count($apiRequests)) * 100;

        return view('dashboard.index', [
            'api_calls' => $apiRequests,
            'total_success_calls' => $totalSuccessCalls,
            'total_failed_calls' => $totalFailedCalls,
            'total_success_rate' => number_format($totalSuccessRate, 2, ',', '.')
        ]);
    }
}
