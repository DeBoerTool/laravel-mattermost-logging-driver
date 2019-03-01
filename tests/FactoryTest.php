<?php

namespace Dbt\Tests;

use Dbt\Mattermost\Logger\Factory;
use GuzzleHttp\Client;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use ThibaudDauce\Mattermost\Mattermost;

class FactoryTest extends TestCase
{
    /** @test */
    public function invoking ()
    {
        $factory = new Factory(
            new Mattermost(new Client())
        );

        $logger = $factory([
            'webhook' => 'test-webhook'
        ]);

        $this->assertInstanceOf(Logger::class, $logger);
    }
}
