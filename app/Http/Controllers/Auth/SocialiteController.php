<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\AuthService;
use App\Services\ConsumerService;
use App\Services\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {

            $info = Socialite::driver($provider)->user();
            Session::put([
                'social_auth' => $info,
            ]);

            $register = $this->create($info, $provider);

            if($register === 419) {
                return redirect('/auth/login')->with('error', 'Login failed! Email already associated with another account');
            }

            $login = AuthService::social_login(new Request([
                'email' => $info->email ?? '',
                'provider' => $provider,
                'provider_id' => $info->id ?? '',
                '_token' => $info->token ?? '',
            ]));

            if ($register && $login->status() !== 200) {
                return redirect('/auth/login')->with('error', 'Login failed! Email already associated with another account');
            }

            $rp = session('rp');
            session()->forget('rp');
            if ($rp) {
                return redirect($rp);
            }
            return redirect(RouteServiceProvider::HOME);

        } catch (\Exception $exception) {
            return redirect('/home')->with('error', 'Login failed! Please try again');
        }

    }

    public function create($info, $provider)
    {
        $email = $info->email ?? null;
        if (!$email) return null;

        // check if this email already exist
        $exist = Utils::checkEmail($email);
        if($exist) {
            $provider = $exist->provider ?? null;
            if(!$provider) {
                return 419; // conflict
            }
        }

        // if not then register
        if (!$exist) {
            // register
            return AuthService::social_register(new Request([
                'first_name' => $info->user['given_name'] ?? '',
                'last_name' => $info->user['family_name'] ?? '',
                'avatar' => $info->avatar ?? '',
                'name' => $info->name ?? '',
                'email' => $email,
                'provider_id' => $info->id ?? '',
                'provider' => $provider,
                '_token' => $info->token,
            ]));
        }
        return null;

    }
}
