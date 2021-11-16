<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider() 
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallBack() 
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::where('provider_id', $githubUser->getId())->first();
    
        if(!$user) {
            $user = User::create([
                'email' => $githubUser->getEmail(),
                'name' =>  $githubUser->getNickname(),
                'provider_id' => $githubUser->getId(),
                'password' => Hash::make('virgilvandijk4')
                //'provider' => 'twitter'   if we use another provider
            ]);
        }

        Auth::login($user, true);

        return redirect($this->redirectTo);
    }

}
