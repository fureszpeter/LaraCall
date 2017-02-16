<?php namespace LaraCall\Http\Controllers;

class SubscriberController extends Controller {

    /**
     * Initializer.
     *
     * @return self
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('subscriber');
    }
}
