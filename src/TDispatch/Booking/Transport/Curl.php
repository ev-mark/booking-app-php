<?php

namespace TDispatch\Booking\Transport;

use TDispatch\Booking\RuntimeException;

class Curl
{
    public $response;
    public $info;
    public $contentType;

    public function __construct($contentType = "application/json") {
        $this->contentType = $contentType;
    }

    public function buildQueryUrl($url, $data = array()) {
        if (!empty($data)) {
            return $url . "?" . http_build_query($data);
        } else return $url;
    }

    public function get($url, $data = array())
    {
        $this->response = $this->doRequest($this->buildQueryUrl($url, $data));
        return $this->response;
    }

    public function post($url, $data)
    {
        $this->response = $this->doRequest($url, $data);
        return $this->response;
    }

    public function doRequest($url, $postData) {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        if (!empty($this->contentType)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: ' . $this->contentType
            ));
        }

        if (!empty($postdata)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        }

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $this->response = curl_exec($curl);
        $this->info = curl_getinfo($curl);
        curl_close($curl);

        if ($this->info["http_code"] != "200") {
            throw new \Exception("Request $url failed");
            return false;
        }

        return $this->response;

    }

}
