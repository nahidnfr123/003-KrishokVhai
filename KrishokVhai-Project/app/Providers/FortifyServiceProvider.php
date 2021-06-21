<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);



        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->username)
                ->orWhere('mobile_number', $request->username)
                ->orWhere('username', $request->username)
                ->with('roles')
                ->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        Fortify::verifyEmailView(function () {
            if (View::exists('layouts.index')) {
                return view('layouts.index');
            }
            return abort(404, "View Not Found.");
        });
        Fortify::resetPasswordView(function () {
            if (View::exists('layouts.index')) {
                return view('layouts.index');
            }
            return abort(404, "View Not Found.");
        });
    }
}
