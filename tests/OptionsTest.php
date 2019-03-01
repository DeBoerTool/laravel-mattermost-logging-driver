<?php

namespace Dbt\Tests;

use Dbt\Mattermost\Logger\Options;
use Dbt\Mattermost\Logger\Values\Level;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
    private function options ()
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

    /** @test */
    public function instantiating ()
    {
        $viaConstructor = new Options(
            'test-webhook',
            new Level(100),
            new Level(200),
            'town-square',
            'test-username',
            []
        );

        $viaFactoryMethod = $this->options();

        $this->assertInstanceOf(Options::class, $viaConstructor);
        $this->assertInstanceOf(Options::class, $viaFactoryMethod);
    }

    /** @test */
    public function getting_webhook ()
    {
        $this->assertSame(
            'test-webhook',
            $this->options()->webhook()
        );
    }

    /** @test */
    public function getting_level ()
    {
        $this->assertSame(
            100,
            $this->options()->level()->value()
        );
    }

    /** @test */
    public function getting_level_mention ()
    {
        $this->assertSame(
            200,
            $this->options()->levelMention()->value()
        );
    }

    /** @test */
    public function getting_channel ()
    {
        $this->assertSame(
            'test-channel',
            $this->options()->channel()
        );
    }

    /** @test */
    public function getting_username ()
    {
        $this->assertSame(
            'test-username',
            $this->options()->username()
        );
    }

    /** @test */
    public function getting_mentions ()
    {
        $this->assertSame(
            '@unfortunate_mention_target',
            $this->options()->mentions()[0]
        );
    }
}
