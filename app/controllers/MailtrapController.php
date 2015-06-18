<?php

use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client as GuzzleHttp;

class MailtrapController extends BaseController
{

    private $api_token;
    private $guzzle;
    private $headers;


    /**
     * @param $api_token
     */
    public function __construct($api_token)
    {
        $this->api_token = $api_token;
        $this->guzzle = new GuzzleHttp([
            'base_uri' => 'https://mailtrap.io',
            'timeout'  => 2.0,
        ]);

        $this->headers = [ 'Api-Token' => $this->api_token ];
    }


    /**
     * Getting emails in object format.
     *
     * @param bool $inbox_id ID of the inbox. If no ID set, getting the first inbox ID.
     * @return mixed
     * @throws Exception
     */
    public function getEmails($inbox_id = false)
    {
        if (!$inbox_id)
        {
            try
            {
                $inbox_id = $this->getInboxID();
            }
            catch (Exception $e)
            {
                throw $e;
            }
        }

        try
        {
            $response = $this->send_request('get', "/api/v1/inboxes/$inbox_id/messages");
        }
        catch (Exception $e)
        {
            throw $e;
        }

        return json_decode($response);
    }


    /**
     * Cleaning the inbox.
     *
     * @param string $inbox_id ID of the inbox. If no ID set, getting the first inbox ID.
     * @return bool
     * @throws Exception
     */
    public function cleanInbox($inbox_id = false)
    {
        if (!$inbox_id)
        {
            try
            {
                $inbox_id = $this->getInboxID();
            }
            catch (Exception $e)
            {
                throw $e;
            }
        }

        try
        {
            $this->send_request('patch', "/api/v1/inboxes/$inbox_id/clean");
        }
        catch (Exception $e)
        {
            throw $e;
        }

        return true;
    }


    /**
     * Free version of mailtrap has only one inbox, getting the inbox ID.
     *
     * @return string Inbox ID
     * @throws Exception
     */
    public function getInboxID()
    {
        try
        {
            $response = $this->send_request('get', '/api/v1/inboxes');
        }
        catch (Exception $e)
        {
            throw $e;
        }

        $result = json_decode($response);
        return $result[0]->id;
    }


    /**
     * Sending request to Mailtrap API.
     *
     * @param $type Request type
     * @param $path Request path
     * @return string JSON encoded string
     * @throws Exception
     */
    private function send_request($type, $path)
    {
        try
        {
            $response = $this->guzzle->{$type}( $path, [ 'headers' => $this->headers ] );
        }
        catch (Exception $e)
        {
            throw $e;
        }

        return (string)$response->getBody();
    }

}