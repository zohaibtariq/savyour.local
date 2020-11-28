<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SocialIdentity;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class SocialController extends Controller
{

    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider) {
        try{
            $user = Socialite::driver($provider)->user();
        }
        catch (Exception $e){
            return redirect('/login');
        }
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect(config('fortify.home'));
    }


    public function findOrCreateUser($providerUser, $provider) {
        $account = SocialIdentity::whereProviderName($provider)
        ->whereProviderId($providerUser->getId())
        ->first();
        if ($account)
            return $account->user;
        else {
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (! $user)
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName(),
                ]);
            $user->identities()->create([
                'provider_id'   => $providerUser->getId(),
                'provider_name' => $provider,
            ]);
            return $user;
        }
    }

}