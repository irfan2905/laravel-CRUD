<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;

class SocialAuthController extends Controller {

    public function redirect() {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialFacebookAccountService $service) {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->User());
        auth()->login($user);
        return redirect()->to('/passports');
    }

}
