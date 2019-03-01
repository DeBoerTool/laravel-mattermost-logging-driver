<?php

namespace Dbt\Tests;

use Dbt\Mattermost\Logger\Options;
use Dbt\Mattermost\Logger\Scribe;
use Dbt\Mattermost\Logger\Values\Level;
use PHPUnit\Framework\TestCase;
use ThibaudDauce\Mattermost\Message;

class ScribeTest extends TestCase
{
    private function options (): Options
    {
        return Options::of([
            'webhook' => 'test-webhook',
            'level' => new Level(100),
            'level_mention' => new Level(200),
            'channel' => 'test-channel',
            'icon_url' => null,
            'username' => 'test-username',
            'mentions' => ['@unfortunate_mention_target'],
            'short_field_length' => 62,
            'max_attachment_length' => 6000,
        ]);
    }

    private function record (): array
    {
        return [
            "message" => "This is a test error",
            "context" => [],
            "level" => 400,
            "level_name" => "ERROR",
            "channel" => "local",
            "datetime" => new \DateTime(),
            "extra" => [],
            "formatted" => "[2019-03-01 09:35:58] local.ERROR: This is a test error [] []\n"
        ];
    }

    /** @test */
    public function instantiating ()
    {
        $scribe = new Scribe($this->options(), []);

        $this->assertInstanceOf(Scribe::class, $scribe);
    }

    /** @test */
    public function writing_a_message ()
    {
        $scribe = new Scribe($this->options(), $this->record());
        $message = $scribe->message();

        $this->assertInstanceOf(Message::class, $message);
    }
}
