<?php

namespace TDispatch\Booking\Message;

class Message
{

    protected $tdispatch;
    protected $connection;
    public $result;

    public function __construct($tdispatch)
    {
        $this->tdispatch = $tdispatch;
        $this->connection = $tdispatch->connection;
    }

    protected function request($url, $postdata = array())
    {
        try {
            if (!empty($postdata)) {
                $this->result = $this->connection->post($url, json_encode($postdata));
            } else {
                $this->result = $this->connection->get($url);
            }
        } catch (Exception $e) {
            var_dump($this->connection->response);
            if ($info["http_code"] != "200") {
                $this->tdispatch->setError($$this->connection->response);
                return false;
            }
        }

        return json_decode($this->result, true);
    }

    protected function makeUrl($endpoint)
    {
        return $this->connection->buildQueryUrl($this->tdispatch->getFullApiUrl() . $endpoint, Array("access_token" => $this->tdispatch->getToken()));
    }

}
