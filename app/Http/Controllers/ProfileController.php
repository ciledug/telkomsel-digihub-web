<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\UserProfile;

class ProfileController extends Controller
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
        $profile = UserProfile::select(
                'users.name', 'users.email',
                'user_profiles.client_id', 'user_profiles.company', 'user_profiles.address', 'user_profiles.company_site',
                'user_profiles.contact_person', 'user_profiles.cp_email', 'user_profiles.cp_phone', 'user_profiles.status',
                'legal_entities.name AS legal_entity_name',
                'business_fields.name AS business_field_name',
                'job_positions.name AS job_position_name'
            )
            ->leftJoin('users', 'user_profiles.user_id', '=', 'users.id')
            ->leftJoin('legal_entities', 'user_profiles.legal_entity', '=', 'legal_entities.id')
            ->leftJoin('business_fields', 'user_profiles.business_field', '=', 'business_fields.id')
            ->leftJoin('job_positions', 'user_profiles.cp_position', '=', 'job_positions.id')
            ->where('user_profiles.user_id', '=', Auth::user()->id)
            ->first();
        // dd($profile);

        return view('profile.index', [
            'profile' => $profile,
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

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'old_password' => 'required|string|min:6|max:15',
            'password' => 'required|string|min:6|max:15|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::find(Auth::user()->id);

        if ($user) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
                return back()->with([
                    'password_changed_ok' => 'Password has been changed!',
                ]);
            }
            else {
                $validator->errors()->add('old_password', 'Password incorrect!');
                return back()->withErrors($validator)->withInput();
            }
        }
        else {
            return back()->withInput();
        }
    }
}
