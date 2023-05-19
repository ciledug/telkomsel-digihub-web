<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Models\BusinessField;
use App\Models\JobPosition;
use App\Models\LegalEntity;
use App\Models\UserProfile;

use App\User;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'register_client_id' => 'required|string|min:4|max:20|unique:user_profiles,client_id',
            'register_company_name' => 'required|string|min:5|max:50',
            'register_company_email' => 'required|email|min:5|max:50|unique:users,email',
            'register_full_name' => 'required|string|min:5|max:50',
            'register_email' => 'required|email|min:10|max:50|unique:user_profiles,cp_email',
            'register_phone' => 'required|numeric|min:810000000|max:999999999999999',
            'register_position' => 'required|numeric|min:1|max:15',
            'password' => 'required|string|min:6|max:15|confirmed',
            
            'register_legal_entity' => 'nullable|numeric|min:1|max:15',
            'register_business_field' => 'nullable|numeric|min:1|max:15',
            'register_address' => 'nullable|string|min:10|max:255',
            'register_company_website' => 'nullable|string|min:7|max:50',
        ]);
        // dd($data);
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Modes\User
     */
    protected function create(array $data)
    {
        // dd($data);
        $user = User::create([
            'name' => $data['register_full_name'],
            'email' => $data['register_company_email'],
            'username' => $data['register_company_email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($user) {
            $userProfile = UserProfile::create([
                'user_id' => $user->id,
                'api_id' => $data['api_id'],
                'client_id' => $data['register_client_id'],
                'company' => $data['register_company_name'],
                'legal_entity' => $data['register_legal_entity'],
                'business_field' => $data['register_business_field'],
                'address' => $data['register_address'],
                'company_site' => $data['register_company_website'],
                'contact_person' => $data['register_full_name'],
                'cp_position' => $data['register_position'],
                'cp_email' => $data['register_email'],
                'cp_phone' => $data['register_phone'],
            ]);
        }
        else
            $data = false;

        return $data;
    }

    public function index()
    {
        return view(
            'auth.register',
            [
                'business_fields' => BusinessField::all(),
                'job_positions' => JobPosition::orderBy('pos_sequence', 'ASC')->get(),
                'legal_entities' => LegalEntity::all(),
            ]
        );
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->input());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $curl = curl_init();
        $apisUrl = env('DALNET_TELCO_API_GATEWAY', '') . '/register';
    
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $apisUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $request->input(),
                CURLOPT_SSL_VERIFYHOST => storage_path('cacert/cacert.pem'),
                CURLOPT_SSL_VERIFYPEER => storage_path('cacert/cacert.pem'),
            )
        );

        $response = curl_exec($curl); // echo 'response: ' . $response; die();
        $err = curl_error($curl);
        curl_close($curl);
        
        if (empty($err) && !empty($response)) {
            $jsonResponse = json_decode($response); // dd($jsonResponse);

            if (isset($jsonResponse->code)
                && isset($jsonResponse->count)
                && isset($jsonResponse->message)
                && isset($jsonResponse->data)
            ) {
                $data = $request->input();
                $data['api_id'] = $jsonResponse->data->user->user_id;

                $this->create($data);
                return redirect()->route($this->redirectTo);
            }
            else {
                $validator->errors()->add('save_error', 'Data cannot be saved.');
                return back()->withErrors($validator)->withInput();
            }
        }
        else {
            $validator->errors()->add('save_error', 'Data cannot be saved.');
            return back()->withErrors($validator)->withInput();
        }
    }
}
