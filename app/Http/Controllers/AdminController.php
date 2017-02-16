<?php namespace LaraCall\Http\Controllers;

class AdminController extends Controller {

    /**
     * Initializer.
     *
     * @return self
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

}
