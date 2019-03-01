<?php

namespace Dbt\Mattermost\Logger;

use Dbt\Mattermost\Logger\Interfaces\Message;
use Dbt\Mattermost\Logger\Values\Webhook;
use GuzzleHttp\Client;

final class Mattermost
{
    /** @var \GuzzleHttp\Client */
    private $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function send (Message $message, Webhook $webhook)
    {
        $this->http->post(
            $webhook->value(),
            [
                'json' => $message->toArray(),
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
    }
}
