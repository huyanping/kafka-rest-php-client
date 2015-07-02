<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/2
 * Time: 14:46
 */

namespace Jenner\Kafka;

class Client
{

    protected $domain;

    protected $port;

    protected $time_out;

    protected $transfer_time_out;

    protected $accept = 'application/vnd.kafka.v1+json, application/vnd.kafka+json, application/json';

    public function __construct($domain, $port, $time_out = 10, $transfer_time_out = 180)
    {
        $this->domain = $domain;
        $this->port = $port;
        $this->time_out = $time_out;
        $this->transfer_time_out = $transfer_time_out;
    }

    public function setAccept($accept)
    {
        $this->accept = $accept;
    }

    public function httpPost($uri, $params)
    {
        $uri = 'http://' . $this->domain . ':' . $this->port . $uri;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->time_out);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->transfer_time_out);
        curl_setopt($curl, CURLOPT_POST, 1);
        $post_fields = http_build_query($params);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
        $json_content = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $content = json_decode($json_content, true);
        if (!$content) {
            $message = 'json_decode failed. the http response code is' . $http_code;
            throw new KafkaException($message);
        }

        if ($http_code != 200) {
            throw new KafkaException($content['message'], $content['error_code']);
        }

        curl_close($curl);

        return $content;
    }

    public function httpGet($uri)
    {
        $uri = 'http://' . $this->domain . ':' . $this->port . $uri;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->time_out);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->transfer_time_out);
        $json_content = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $content = json_decode($json_content, true);
        if (!$content) {
            $message = 'json_decode failed. the http response code is' . $http_code;
            throw new KafkaException($message);
        }

        if ($http_code != 200) {
            throw new KafkaException($content['message'], $content['error_code']);
        }

        curl_close($curl);

        return $content;
    }
}