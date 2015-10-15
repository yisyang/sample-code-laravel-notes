<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UsersModel;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return UsersModel
     */
    protected function create(array $data)
    {
        return UsersModel::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function postLoginHack(Request $request)
    {
        // TODO: extend exception handler to output JSON message on validation failure
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
        } catch (\Exception $e) {
            // TODO: actually show the errors... in JSON (see note above)
            return response()->json('Bad parameters.', 400);
        }

        try{
            $success = Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]);
        }
        catch(\Exception $e) {
            return response()->json('Nope', 401);
        }

        // Just to be sure...
        if(!$success){
            return response()->json('Nope', 401);
        }

        $user = UsersModel::where([
            'email' => $request->input('email')
        ])->get();

        // Hack: (non-crypto) put user info in token
        $token = base64_encode(json_encode($user->toArray()));
        return response()->json(['token' => $token]);
    }
}
