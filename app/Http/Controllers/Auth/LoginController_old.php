<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\UserLog;
use App\Models\UserProfile;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->input(), [
            'username' => 'required|string|min:5|max:20',
            'password' => 'required|string|min:6|max:15'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validator->errors()->add('login_invalid', 'Username or Password is incorrect!');
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (auth()->attempt(array(
            $fieldType => $input['username'],
            'password' => $input['password']
        ))) {
            $userProfile = UserProfile::where('user_id', '=', Auth::user()->id)
                ->first();

            if ($userProfile) {
                Auth::user()->client_id = $userProfile->client_id;

                $loginApiResponse = json_decode($this->loginApi(Auth::user()->email, $input['password'])); // dd($loginApiResponse); // die();

                if (isset($loginApiResponse->code) && ($loginApiResponse->code === 200)) {
                    $loginApiResponse = $loginApiResponse->data->token;
                }
                else {
                    $loginApiResponse = '';
                }

                session(['api_token' => $loginApiResponse]);
                session(['client_id' => $userProfile->client_id]);

                UserLog::create([
                    'user_id' => Auth::user()->id,
                    'last_login' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                    'last_ip_address' => $request->ip(),
                ]);
    
                return redirect()->route('dashboard');
            }
            else {
                return back()->withErrors($validator)->withInput();
            }
        }
        else {
            return back()->withErrors($validator)->withInput();
        }
    }

    private function loginApi($email, $password)
    {
        $apiLoginUrl = env('DALNET_TELCO_API_GATEWAY', '') . '/login';
        // dd($apiLoginUrl);

        $curl = curl_init();
        
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $apiLoginUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'email' => $email,
                    'password' => $password,
                ],
                CURLOPT_HTTPHEADER => array(
                    'Accept: */*',
                ),
                CURLOPT_SSL_VERIFYHOST => storage_path('cacert/cacert.pem'),
                CURLOPT_SSL_VERIFYPEER => storage_path('cacert/cacert.pem'),
            )
        );
        
        $response = curl_exec($curl); // echo 'response: ' . $response; die();
        $err = curl_error($curl);
        $curlResult = '';
        curl_close($curl);

        if (empty($err)) return $response;
        else return $err;
    }
}
