<?php

namespace Dbt\Tests;

use Dbt\Mattermost\Logger\DefaultOptions;
use Dbt\Mattermost\Logger\Values\Format;
use Dbt\Mattermost\Logger\Values\Level;
use Dbt\Mattermost\Logger\Values\Webhook;
use Dbt\Tests\Worlds\OptionsTestWorld;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
    use OptionsTestWorld;

    /** @test */
    public function instantiating ()
    {
        $viaConstructor = new DefaultOptions(
            new Webhook('test-webhook'),
            new Level(100),
            new Level(200),
            new Format('%s'),
            new Format('%s'),
            'town-square',
            'test-username',
            []
        );

        $viaFactoryMethod = $this->options();

        $this->assertInstanceOf(DefaultOptions::class, $viaConstructor);
        $this->assertInstanceOf(DefaultOptions::class, $viaFactoryMethod);
    }

    /** @test */
    public function getting_webhook ()
    {
        $this->assertSame(
            'test-webhook',
            $this->options()->webhook()->value()
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
    public function getting_title_format ()
    {
        $this->assertSame(
            '%s title format',
            $this->options()->titleFormat()->value()
        );
    }

    /** @test */
    public function getting_title_mention_format ()
    {
        $this->assertSame(
            '%s title mention format',
            $this->options()->titleMentionFormat()->value()
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
