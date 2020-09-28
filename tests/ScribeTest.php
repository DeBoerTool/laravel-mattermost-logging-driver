<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Dbt\Tests;

use Dbt\Mattermost\Logger\DefaultMessage;
use Dbt\Mattermost\Logger\DefaultScribe;
use Dbt\Mattermost\Logger\Interfaces\Message;
use Dbt\Tests\Worlds\ScribeTestWorld;
use PHPUnit\Framework\TestCase;

class ScribeTest extends TestCase
{
    use ScribeTestWorld;

    /** @test */
    public function instantiating ()
    {
        $scribe = new DefaultScribe(
            new DefaultMessage(),
            $this->options(),
            []
        );

        $this->assertInstanceOf(DefaultScribe::class, $scribe);
    }

    /** @test */
    public function writing_a_message ()
    {
        $scribe = new DefaultScribe(
            new DefaultMessage(),
            $this->options(),
            $this->record()
        );

        $message = $scribe->message();

        $this->assertInstanceOf(Message::class, $message);
    }
}
