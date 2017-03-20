<?php

namespace LaraCall\Http\Controllers\Auth;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Str;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\Services\PasswordService;
use LaraCall\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function resetPassword(User $user, $password)
    {
        $user->setPassword(app(PasswordService::class)->encrypt($password));
        $user->setRememberToken(Str::random(60));

        app(EntityManagerInterface::class)->flush();

        Auth::guard($this->getGuard())->login($user);
    }
}
