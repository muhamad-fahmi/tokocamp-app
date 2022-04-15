<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showlogin()
    {
        return view('auth.login');
    }
    public function showregist()
    {
        return view('auth.register');
    }
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|max:40',
                'password' => 'required|string|max:25'
            ]
        );

        $user = User::where('email', $request->email)->first();
        if (!isset($user)) {
            return redirect(route('login'))->with('error', 'Account not found!');
        } else {
            if ($user->email_verified_at) {
                Auth::attempt(
                    [
                        'email' => $request->email,
                        'password' => $request->password
                    ]
                );

                if (Auth::check()) {
                    if ($request->email == "tokocamp.indonesia@gmail.com" && $request->password == "Fahsal26%%%.,") {
                        return redirect(route('dashboard'));
                    } else {
                        return redirect('/');
                    }
                } else {
                    return redirect(route('login'))->with('error', 'username or password invalid !');
                }
            } else {
                return redirect(route('login'))->with('error', 'Please verify your account first. We have sent email verification to your account !');
            }
        }
    }

     // LOGIN WITH GOOGLE
     public function redirectToGoogle()
     {
         return Socialite::driver('google')->redirect();
     }
     public function handleGoogleCallback()
     {
         try {

             $user = Socialite::driver('google')->user();
             //dd($user);
             $finduser = User::where('google_id', $user->id)->first();

             if($finduser){

                 Auth::login($finduser);

                 if($user->email == "tokocamp.indonesia@gmail.com"){
                     return redirect()->intended(route('dashboardadmin'))->with('success', 'Hi '.$user->name.' Welcome to e-Invitation');
                 }else{
                     return redirect()->intended(route('dashboarduser'))->with('success', 'Hi '.$user->name.' Welcome to e-Invitation');
                 }

             }else{
                 $password = Hash::make(strstr($user->email, "@", true)."1122334455%");
                 if($user->email == "tokocamp.indonesia@gmail.com"){
                     $newUser = User::create([
                         'name' => $user->name,
                         'email' => $user->email,
                         'google_id'=> $user->id,
                         'password' => $password,
                         'avatar' => $user->avatar,
                         'role' => 1
                     ]);
                 }else{
                     $newUser = User::create([
                         'name' => $user->name,
                         'email' => $user->email,
                         'google_id'=> $user->id,
                         'password' => $password,
                         'avatar' => $user->avatar,
                         'role' => 2
                     ]);
                 }


                 Auth::login($newUser);

                 if($user->email == "tokocamp.indonesia@gmail.com"){
                     return redirect()->intended(route('dashboardadmin'))->with('success', 'Hi '.$user->name.' Welcome to e-Invitation');
                 }else{
                     return redirect()->intended(route('dashboarduser'))->with('success', 'Hi '.$user->name.' Welcome to e-Invitation');
                 }

             }

         } catch (Exception $e) {
             return redirect(route('login'))->with('error', $e->getMessage());
         }
     }




    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
