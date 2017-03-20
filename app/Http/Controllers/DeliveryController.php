<?php

namespace LaraCall\Http\Controllers;

use Carbon\Carbon;
use LaraCall\Domain\Entities\PinTokenDelivery;

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
     * @param PinTokenDelivery $token
     *
     * @return string
     */
    public function show(PinTokenDelivery $token)
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
