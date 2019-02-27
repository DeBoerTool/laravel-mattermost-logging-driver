<?php

namespace Dbt\Mattermost\Logger;

use Illuminate\Routing\UrlGenerator;
use Monolog\Logger as Monolog;

final class Options
{
    /** @var string */
    private $webhook;

    /** @var string */
    private $channel;

    /** @var string */
    private $username;

    /** @var array */
    private $mentions;

    /** @var int */
    private $level;

    /** @var int */
    private $levelMention;

    /** @var int */
    private $shortFieldLength;

    /** @var int */
    private $maxAttachmentLength;

    /** @var string|null */
    private $iconUrl;

    public function __construct (
        string $webhook,
        string $channel = 'town-square',
        string $username = 'Laravel Logs',
        array $mentions = ['@here'],
        int $level = Monolog::INFO,
        int $levelMention = Monolog::ERROR,
        int $shortFieldLength = 62,
        int $maxAttachmentLength = 6000,
        ?string $iconUrl = null
    )
    {
        $this->webhook = $webhook;
        $this->channel = $channel;
        $this->username = $username;
        $this->mentions = $mentions;
        $this->level = $level;
        $this->levelMention = $levelMention;
        $this->shortFieldLength = $shortFieldLength;
        $this->maxAttachmentLength = $maxAttachmentLength;
        $this->iconUrl = $iconUrl;
    }

    public static function of (array $options)
    {
        return new self(
            $options['webhook'],
            $options['channel'],
            $options['icon_url'],
            $options['username'],
            $options['level'],
            $options['level_mention'],
            $options['mentions'],
            $options['short_field_length'],
            $options['max_attachment_length']
        );
    }

    public function webhook (): string
    {
        return $this->webhook;
    }

    public function channel (): string
    {
        return $this->channel;
    }

    public function username (): string
    {
        return $this->username;
    }

    public function mentions (): array
    {
        return $this->mentions;
    }

    public function level (): int
    {
        return $this->level;
    }

    public function levelMention (): int
    {
        return $this->levelMention;
    }

    public function shortFieldLength (): int
    {
        return $this->shortFieldLength;
    }

    public function maxAttachmentLength (): int
    {
        return $this->maxAttachmentLength;
    }

    public function iconUrl (): ?string
    {
        return $this->iconUrl
            ? app(UrlGenerator::class)->to($this->iconUrl, [], null)
            : null;
    }
}
