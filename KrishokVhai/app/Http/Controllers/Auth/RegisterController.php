<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{

    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function store(Request $request, CreatesNewUsers $creator): RegisterResponse
    {
        event(new Registered($user = $creator->create($request->all())));
        // Auto login after register ...
        $this->guard->login($user);
        return app(RegisterResponse::class);
    }

    public function register(Request $request)
    {

    }
}
