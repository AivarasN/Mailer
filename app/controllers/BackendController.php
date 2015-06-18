<?php

use Illuminate\Routing\Controller as BaseController;
use MailtrapController;

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
        $mailtrap = new MailtrapController(Config::get('app.mailtrap_api'));

        try
        {
            $mails = $mailtrap->getEmails();
        }
        catch (Exception $e)
        {
            return View::make('admin_mail_queue')->with('warning', 'Error! ' . $e->getMessage());
        }

        return View::make('admin_mail_queue')->with('mails', $mails);
    }

    /**
     * Cleans the mailtrap inbox and redirects with success or warning message.
     */
    public function cleanInbox()
    {
        $mailtrap = new MailtrapController(Config::get('app.mailtrap_api'));

        try
        {
            $mailtrap->cleanInbox();
        }
        catch (Exception $e)
        {
            return Redirect::to('/admin/mail_queue')->with('warning', 'Error! ' . $e->getMessage());
        }

        return Redirect::to('/admin/mail_queue')->with('success', 'Inbox cleaned.');
    }


    /**
     * Handles submission of email sending form. Validates fields, queues emails for sending.
     */
    public function sendEmail()
    {

        $rules = array(
            'from'      => 'required|email',
            'subject'   => 'required',
            'text'      => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {

            return Redirect::to('/admin/new_email')->withErrors($validator);

        }
        else
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

            return Redirect::to('/admin/new_email')->with('success', 'Email queued for sending.');
        }

    }

}


