<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/2
 * Time: 15:52
 */

namespace Jenner\Kafka;


class Topic extends Client
{
    public function get()
    {
        return $this->httpGet('/topics');
    }

    public function getTopicMetadata($topic)
    {
        return $this->httpGet('/topics/' . $topic);
    }

}