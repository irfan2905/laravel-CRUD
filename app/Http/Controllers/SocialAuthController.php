<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialFacebookAccountService;

class SocialAuthController extends Controller {

    /**
     * Create a redirect method to facebook api.
     *
     * @return void
     */
    public function redirect() {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(ProviderUser $providerUser) {
        $user = $providerUser->createOrGetUser(Socialite::driver('facebook')->User());
        auth()->login($user);
        return redirect()->to('/passports');
    }

}
