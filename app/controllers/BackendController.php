<?php

use Illuminate\Routing\Controller as BaseController;

class BackendController extends BaseController
{


    /**
     * Shows all registered email addresses.
     */
    public function index()
    {
        $addresses = Address::all();
        return View::make('admin_index')->with('addresses', $addresses);
    }


    /**
     * Shows email compose form.
     */
    public function newEmail()
    {
        return View::make('admin_new_email');
    }


    /**
     * Shows mailtrap inbox.
     */
    public function mailQueue()
    {
        $mails = Mailtrap::getEmails();
        if ($mails !== false)
        {
            return View::make('admin_mail_queue')->with('mails', $mails);
        }
        else
        {
            return View::make('admin_mail_queue')->with('warning', 'Error!');
        }
    }

    /**
     * Cleans the mailtrap inbox and redirects with success or warning message.
     */
    public function cleanInbox()
    {
        $result = Mailtrap::cleanInbox();
        if ($result !== false)
        {
            return Redirect::route('backendMailQueue')->with('success', 'Inbox cleaned.');
        }
        else
        {
            return Redirect::route('backendMailQueue')->with('warning', 'Error!');
        }
    }


    /**
     * Handles submission of email sending form. Validates fields, queues emails for sending.
     */
    public function sendEmail()
    {

        $mass_email = new MassEmail();
        if ($mass_email->validate(Input::all()))
        {
            $addresses = Address::all();

            /**
             * If the size of $addresses list is big, this part of code should be moved to a separate function
             * and called via cronjob. Implementation should look something like this:
             *  1. save the contents of the email to a database
             *  2. generate list of recipients and email ID
             *  3. cronjob calls a function which checks generated list and send a bunch of emails
             */
            foreach ($addresses as $single)
            {
                Mail::queue('emails.html_email', array('text' => Input::get('text')), function($message) use ($single)
                {
                    $message->from(Input::get('from'));
                    $message->to($single->email, $single->email)->subject(Input::get('subject'));
                });
            }

            return Redirect::route('backendNewEmail')->with('success', 'Email queued for sending.');
        }
        else
        {
            return Redirect::route('backendNewEmail')->withErrors($mass_email->errors());
        }

    }

}


