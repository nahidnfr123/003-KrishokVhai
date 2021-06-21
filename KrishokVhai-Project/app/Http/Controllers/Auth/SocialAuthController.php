<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        return response()->json([
            "url" => $url
        ]);
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
            if (!$user->token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to authenticate ' . $provider . '!'
                ], 401);
            }

            $isUser = User::where('social_id', $user->id)->where('social_provider', $provider)->first();
            if (!$isUser) {
                if (User::where('email', $user->getEmail())->first()) {
                    return response()->json(['success' => false, 'message' => 'Account already exist with this email!'], 401);
                }
                $fullName = explode(" ", $user->getName());

                $userName = $user->getNickname() ? str_replace(" ", "", $user->getNickname()) : explode("@", $user->getEmail())[0];
                $createUser = new User();
                $createUser->social_id = $user->getId();
                $createUser->social_provider = $provider;
                $createUser->first_name = array_shift($fullName);
                $createUser->last_name = implode(" ", $fullName);
                $createUser->username = $userName;
                $createUser->email = $user->getEmail();
                $createUser->avatar = $user->getAvatar();
                $createUser->email_verified_at = Carbon::now();

                if ($createUser->save()) {
                    $createUser->assignRole(['customer']);
                    Auth::login($createUser);
                    return response()->json(['user' => $createUser]);
                }
                return response()->json(['success' => false, 'message' => 'Failed to register'], 401);
            }
            Auth::login($isUser);
            return response()->json(['user' => $isUser]);
        } catch (Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 401);
        }
    }


    public function tester()
    {
        /*try {
            $user = Socialite::driver($provider)->user();
        } catch (InvalidStateException $e) {
            $user = Socialite::driver($provider)->stateless()->user();
        }*/
    }
}
