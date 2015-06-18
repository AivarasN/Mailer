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

        $rules = array(
            'email' => 'required|email|unique:addresses',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {

            return Redirect::to('/')->withErrors($validator);

        }
        else
        {

            $new_ad = new Address;
            $new_ad->email = Input::get('email');;
            $new_ad->save();

            return Redirect::to('/')->with('success', 'Email registered.');

        }

    }

}


