<?php

namespace Dbt\Mattermost\Logger;

use Dbt\Mattermost\Logger\Interfaces\Options;
use Dbt\Mattermost\Logger\Interfaces\Scribe;
use Dbt\Mattermost\Logger\Values\Level;
use Monolog\Handler\AbstractProcessingHandler;

final class Handler extends AbstractProcessingHandler
{
    /** @var \Dbt\Mattermost\Logger\Interfaces\Options */
    private $options;

    /** @var \Dbt\Mattermost\Logger\Mattermost */
    private $mattermost;

    /** @var \Dbt\Mattermost\Logger\Interfaces\Scribe */
    private $scribeClass;

    /** @var \Dbt\Mattermost\Logger\Interfaces\Message */
    private $messageClass;

    public function __construct (
        Mattermost $mattermost,
        Options $options,
        string $scribeClass,
        string $messageClass
    )
    {
        $this->mattermost = $mattermost;
        $this->options = $options;
        $this->scribeClass = $scribeClass;
        $this->messageClass = $messageClass;
    }

    public function write (array $record): void
    {
        if (!$this->shouldWrite($record['level'])) {
            return;
        }

        $this->mattermost->send(
            $this->makeScribe($record)->message(),
            $this->options->webhook()
        );
    }

    private function makeScribe (array $record): Scribe
    {
        return new $this->scribeClass(
            new $this->messageClass,
            $this->options,
            $record
        );
    }

    private function shouldWrite (int $level): bool
    {
        $level = new Level($level);

        return $this->options->level()->isLessThan($level);
    }
}
