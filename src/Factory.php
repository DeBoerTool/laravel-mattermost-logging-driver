<?php

namespace Dbt\Mattermost\Logger;

use Monolog\Logger;

final class Factory
{
    /** @var \Dbt\Mattermost\Logger\Mattermost */
    private $mattermost;

    public function __construct (Mattermost $mattermost)
    {
        $this->mattermost = $mattermost;
    }

    public function __invoke (array $options): Logger
    {
        return new Logger('mattermost', [
            new Handler(
                $this->mattermost,
                DefaultOptions::of(
                    self::mergedOptions($options)
                ),
                $options['scribe'] ?? DefaultScribe::class,
                $options['message'] ?? DefaultMessage::class
            )
        ]);
    }

    public static function defaultOptions (): array
    {
        return [
            'webhook' => null,
            'level' => Logger::INFO,
            'level_mention' => Logger::ERROR,
            'title_format' => '**[%s]** %s',
            'title_mention_format' => ' (ping %s)',
            'channel' => 'town-square',
            'username' => 'Laravel Logs',
            'mentions' => ['@channel'],
            'short_field_length' => 62,
            'max_attachment_length' => 6000,
            'icon_url' => null,
        ];
    }

    private static function mergedOptions (array $options): array
    {
        return array_merge(self::defaultOptions(), $options);
    }
}
