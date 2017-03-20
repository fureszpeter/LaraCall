<?php namespace LaraCall\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use LaraCall\Domain\Entities\User;

class GodController extends Controller {
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var User
     */
    protected $user;

    /**
     * Initializer.
     *
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->middleware('auth');
        $this->middleware('god');
        $this->guard = $guard;
        $this->user = $guard->user();
    }

}
