<?php

use Illuminate\Routing\Controller as BaseController;

class FrontendController extends BaseController
{

    /**
     * Show the email registration form.
     */
    public function index()
    {
        return View::make('index');
    }

    /**
     * Handles email form submission.
     */
    public function registerAddress()
    {

        $address = new Address();
        if ($address->validate(Input::all()))
        {
            $address->email = Input::get('email');
            $address->save();

            return Redirect::route('frontendIndex')->with('success', 'Email registered.');
        }
        else
        {
            return Redirect::route('frontendIndex')->withErrors($address->errors());
        }

    }

}


