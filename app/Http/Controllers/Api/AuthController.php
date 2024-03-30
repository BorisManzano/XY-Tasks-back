<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\RecoverPasswordMailable;
use App\Mail\WelcomeMailable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required|string|max: 255',
            'email' => 'required|email|unique:users|max: 255',
            'role' =>'required|in:employee,super_admin|string',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($user->save()) {

            $token = Password::createToken($user);

            Mail::to($request->email)->queue(new WelcomeMailable($token));
            return response($user, Response::HTTP_CREATED);

        } else {
            return response('Error creating user', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function checkAuthStatus()
    {if (Auth::check()) {
        $user = Auth::user();
        return response([
            'isLogged' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ], Response::HTTP_OK);
    } else {
        return response(['isLogged' => false], Response::HTTP_UNAUTHORIZED);
    }
    }

    public function recoverPassword(Request $request){
        $request->validate([
            'email' =>'required|email|exists:users',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = Password::createToken($user);

        Mail::to($request->email)->queue(new RecoverPasswordMailable($token, $request->email));

        return response($user, Response::HTTP_OK);
    }


    public function updatePassword(Request $request){
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);

        $status = Password::getRepository()->exists(
            $user = User::where('email', $request->email)->first(),
            $request->token
        );

        if ($status) {
            $user->password = Hash::make($request->password);
            $user->save();     
            return response(['message' => 'Password updated'], Response::HTTP_OK);
        }

        return response(['error' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' =>['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);

            return response()->json([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ],
                'token' => $token
            ], Response::HTTP_OK)->withCookie($cookie);
        }
        else {
            return response(['message'=> 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(){
        $cookie = Cookie::forget('cookie_token');
        return response(['message' => 'Logged out'], Response::HTTP_OK)->withCookie($cookie);
    }

    public function allEmployees(Request $request){
        $employees = User::where('role', 'employee')->select('name', 'email', 'id')->get();

        return response($employees, Response::HTTP_OK);
    }


    public function employeeTasks(Request $request){
        $userID = $request->user()->id;
    
        $user = User::where('role', 'employee')->where('id', $userID);
        $user->select('id', 'name', 'email');
        $user->with('tasks');
    
        return response($user->paginate()->appends($request->query()), Response::HTTP_OK);
    }
    

    public function allEmployeesTasks(Request $request){

    $users = User::whereHas('tasks')->where('role', 'employee');
    $users = $users->with('tasks');
    
    return response($users->paginate()->appends($request->query()), Response::HTTP_OK);
}

}
