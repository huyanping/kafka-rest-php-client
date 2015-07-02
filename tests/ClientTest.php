<?php

/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/2
 * Time: 16:05
 */
class ClientTest extends PHPUnit_Framework_TestCase
{

    protected $client;

    public function setUp(){
        $this->client = new \Jenner\Kafka\Client('127.0.0.1', 8082);
    }

    public function testGet()
    {
        var_dump($this->client->httpGet('/topics'));
    }
}