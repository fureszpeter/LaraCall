<?php namespace LaraCall\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\ResponseFactory;
use LaraCall\Domain\Entities\User;

class God
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The response factory implementation.
     *
     * @var ResponseFactory
     */
    protected $response;

    /**
     * Create a new filter instance.
     *
     * @param  Guard           $auth
     * @param  ResponseFactory $response
     */
    public function __construct(
        Guard $auth,
        ResponseFactory $response
    ) {
        $this->auth     = $auth;
        $this->response = $response;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            /** @var User $userEntity */
            $userEntity = $this->auth->user();
            if ( ! $userEntity->isAdmin()) {
                return $this->response->redirectTo('/');
            }

            return $next($request);
        }

        return $this->response->redirectTo('/');
    }

}
