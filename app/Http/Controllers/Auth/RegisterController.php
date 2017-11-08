<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Input;

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
    protected $redirectTo = '/home';

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
    public function register(Request $request)
    {
        // $rules = [
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'email' => 'required|email|unique:user',
        //     'password' => 'required|confirmed|min:8',
        //     'password_confirmation' => 'required|same:password',
        //     'accepted_terms' => 'required'
        // ];
        
    
        // die('OK');
        // $input = $request->only(
        //     'first_name',
        //     'last_name',
        //     'email',
        //     'password',
        //     'password_confirmation',
        //     'accepted_terms'
        // );
        // die(var_dump($input));
        // $validator = Validator::make($input, $rules);
        // if($validator->fails()) {
        //     $error = $validator->messages()->toJson();
        //     return response()->json(['success'=> false, 'error'=> $error]);
        // }
        // $request->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|confirmed|min:8',
        //     'password_confirmation' => 'required|same:password',
        //     'accepted_terms' => 'required'
        // ]);
        $validator = Validator::make(Input::all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            // 'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
            'accepted_terms' => 'required'
        ]);

        if($validator->fails()) {
            $error = $validator->messages()->toJson();
            return response()->json(['success'=> false, 'error'=> $error]);
        }
        $user = new User();       
        // $user = User::create([
        //     'first_name' => $request->firstName, 
        //     'last_name' => $request->lastName, 
        //     'email' => $request->email, 
        //     'password' => bcrypt($request->password), 
        //     'password_confirmation' => bcrypt($request->passwordConfirmation), 
        //     'accepted_terms' => $request->acceptedTerms
        // ]);
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->accepted_terms = request('accepted_terms');
        
        $user->save();
        return $user;
    }
}
