<?php

namespace Dbt\Mattermost\Logger;

use Monolog\Logger as MonologLogger;
use ThibaudDauce\Mattermost\Mattermost;
use Monolog\Handler\AbstractProcessingHandler;

final class Handler extends AbstractProcessingHandler
{
    /** @var array */
    private $defaultOptions = [
        'webhook' => null,
        'channel' => 'town-square',
        'icon_url' => null,
        'username' => 'Laravel Logs',
        'level' => MonologLogger::INFO,
        'level_mention' => MonologLogger::ERROR,
        'mentions' => ['@here'],
        'short_field_length' => 62,
        'max_attachment_length' => 6000,
    ];

    /** @var \Dbt\Mattermost\Logger\Options */
    private $options;

    /** @var \ThibaudDauce\Mattermost\Mattermost */
    private $mattermost;

    public function __construct (Mattermost $mattermost, $options = [])
    {
        $this->mattermost = $mattermost;
        $this->options = Options::of(
            array_merge($this->defaultOptions, $options)
        );
    }

    public function write (array $record)
    {
        if ($record['level'] < $this->options['level']) {
            return;
        }

        $builder = new Builder($this->options, $record);

        $this->mattermost->send(
            $builder->message(),
            $this->options['webhook']
        );
    }
}
