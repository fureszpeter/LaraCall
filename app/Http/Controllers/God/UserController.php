<?php
namespace LaraCall\Http\Controllers\God;

use A2bApiClient\Client;
use LaraCall\Domain\Repositories\UserRepository;
use LaraCall\Http\Controllers\GodController;

class UserController extends GodController
{
    public function listUsersAction(Client $client)
    {
        $credit = $client->getSubscription()->getByPin($this->user->getSubscription()->getDefaultPin()->getPin())->credit;

        return view('god.users.index', ['credit' => $credit]);
    }

    public function listUsers(UserRepository $userRepository)
    {

    }
}
