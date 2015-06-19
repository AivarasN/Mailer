<?php namespace Services\Mailtrap;

use GuzzleHttp\Client as GuzzleHttp;

class Mailtrap
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
     * @return string|bool JSON object of emails on success, false on failure
     */
    public function getEmails($inbox_id = false)
    {
        if (!$inbox_id)
        {
            $inbox_id = $this->getInboxID();

            // Unable to get inboxID, returning false
            if (!$inbox_id)
            {
                return false;
            }
        }

        $response = $this->send_request('get', "/api/v1/inboxes/$inbox_id/messages");
        if ($response)
        {
            return json_decode($response);
        }
        else
        {
            return false;
        }
    }


    /**
     * Cleaning the inbox.
     *
     * @param string $inbox_id ID of the inbox. If no ID set, getting the first inbox ID.
     * @return string|bool JSON data on success, false on failure
     */
    public function cleanInbox($inbox_id = false)
    {
        if (!$inbox_id)
        {
            $inbox_id = $this->getInboxID();

            // Unable to get inboxID, returning false
            if (!$inbox_id)
            {
                return false;
            }
        }

        return $this->send_request('patch', "/api/v1/inboxes/$inbox_id/clean");
    }


    /**
     * Free version of mailtrap has only one inbox, getting the inbox ID.
     *
     * @return string|bool Inbox ID or false on failure
     */
    public function getInboxID()
    {
        $response = $this->send_request('get', '/api/v1/inboxes');
        if ($response)
        {
            $result = json_decode($response);
            return $result[0]->id;
        }
        else
        {
            return false;
        }
    }


    /**
     * Sending request to Mailtrap API.
     *
     * @param $type Request type
     * @param $path Request path
     * @return string|bool JSON encoded string or false on failure
     */
    private function send_request($type, $path)
    {
        try
        {
            $response = $this->guzzle->{$type}( $path, [ 'headers' => $this->headers ] );
        }
        catch (Exception $e)
        {
            return false;
        }

        return (string)$response->getBody();
    }

}