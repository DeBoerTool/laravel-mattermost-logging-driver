<?php

namespace Dbt\Mattermost\Logger;

use Dbt\Mattermost\Logger\Values\Level;
use Monolog\Logger;
use ThibaudDauce\Mattermost\Mattermost;
use Monolog\Handler\AbstractProcessingHandler;

final class Handler extends AbstractProcessingHandler
{
    /** @var \Dbt\Mattermost\Logger\Options */
    private $options;

    /** @var \ThibaudDauce\Mattermost\Mattermost */
    private $mattermost;

    public function __construct (Mattermost $mattermost, $options = [])
    {
        $this->mattermost = $mattermost;

        $this->options = Options::of(
            $this->mergedOptions($options)
        );
    }

    public function write (array $record)
    {
        if (!$this->shouldWrite($record['level'])) {
            return;
        }

        $scribe = new Scribe($this->options, $record);

        $this->mattermost->send(
            $scribe->message(),
            $this->options->webhook()
        );
    }

    protected function defaultOptions (): array
    {
        return [
            'webhook' => null,
            'level' => new Level(Logger::INFO),
            'level_mention' => new Level(Logger::ERROR),
            'channel' => 'town-square',
            'username' => 'Laravel Logs',
            'mentions' => ['@channel'],
            'short_field_length' => 62,
            'max_attachment_length' => 6000,
            'icon_url' => null,
        ];
    }

    private function mergedOptions (array $options): array
    {

        return array_merge($this->defaultOptions(), $options);
    }

    private function shouldWrite (int $level): bool
    {
        $level = new Level($level);

        return $this->options->level()->isLessThan($level);
    }
}
