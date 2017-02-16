<?php

namespace LaraCall\Http\Controllers;

use Carbon\Carbon;
use LaraCall\Domain\Entities\Delivery;

class DeliveryController extends Controller
{

    /**
     * Show the application dashboard to the user.
     */
    public function index()
    {
        return 'delivery index';
    }

    /**
     * @param Delivery $token
     *
     * @return string
     */
    public function show(Delivery $token)
    {
        $errors = [];

        if (
            $token->getDateExpire() < Carbon::now()
            || $token->getDisplayCounter() > 1
        ) {
            $errors[] = 'Token expired or already displayed.';
        }

        $pin = $token->getPin()->getPin();
        $balance = $token->getPin()->getSubscription();

        return view('pages.delivery', compact('errors', 'token'));
    }
}
