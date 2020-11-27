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

    /**
     * Redirects to appropriate providers based on
     * $provider
     *
     * @param string $provider
     * @return RedirectResponse
     */
    // public function redirectToProvider(string $provider) : RedirectResponse
    // {
    //     return Socialite::driver($provider)->redirect();
    // }

    /**
     * Undocumented function
     *
     * @param string $provider
     * @return RedirectResponse
     */
    // public function handleProviderCallback(string $provider) : RedirectResponse
    // {
    //     try {
    //         $data = Socialite::driver($provider)->user();
    //         return $this->handleUser($data, $provider);
    //     } catch (\Exception $e) {
    //         return redirect(route('login'))->with('status', $provider . ' Login failed');
    //     }
    // }

    /**
     * Handles the user's information and creates/updates
     * the record accordingly.
     *
     * @param object $data
     * @param string $provider
     * @return RedirectResponse
     */
    // public function handleUser(object $data, string $provider) : RedirectResponse
    // {
        // $user = User::where([
        //     'social->'.$provider.'->id' => $data->id,
        // ])->first();
        // if (!$user) {
            /**
             * If we don't user associated with the facebook id, then 
             * check for the user's email and associate the facebook id
             */
    //         $user = User::where([
    //             'email' => $data->email,
    //         ])->first();
    //     }
    //     if (!$user) {
    //         return $this->createUser($data, $provider);
    //     }
    //     $user->social->facebook->token = $data->token;
    //     $user->save();
    //     return $this->login($user);
    // }

    /**
     * Undocumented function
     *
     * @param object $data
     * @param string $provider
     * @return RedirectResponse
     */
    // public function createUser(object $data, string $provider) : RedirectResponse
    // {
    //     try {
    //         $user = new User;
    //         $user->name   = $data->name;
    //         $user->email  = $data->email;
    //         $user->social = json_encode([
    //             $provider => [
    //                 'id'    => $data->id,
    //                 'token' => $data->token
    //             ]
    //         ]);
    //         $user->save();
    //         return $this->login($user);
    //     } catch (Exception $e) {
    //         return redirect(route('login'))->with(['status' => 'Login failed. Please try again']);
    //     }
    // }

    /**
     * Logins the given user and redirects to home
     *
     * @param User $user
     * @return RedirectResponse
     */
    // public function login(User $user) : RedirectResponse
    // {
    //     auth()->loginUsingId($user->id);
    //     return redirect(route('home'));
    // }

}