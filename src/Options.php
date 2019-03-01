<?php

namespace Dbt\Mattermost\Logger;

use Dbt\Mattermost\Logger\Values\Level;
use Illuminate\Routing\UrlGenerator;

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
        Level $level,
        Level $levelMention,
        string $channel,
        string $username,
        array $mentions = [],
        int $shortFieldLength = 62,
        int $maxAttachmentLength = 6000,
        ?string $iconUrl = null
    )
    {
        $this->webhook = $webhook;
        $this->level = $level;
        $this->levelMention = $levelMention;
        $this->channel = $channel;
        $this->username = $username;
        $this->mentions = $mentions;
        $this->shortFieldLength = $shortFieldLength;
        $this->maxAttachmentLength = $maxAttachmentLength;
        $this->iconUrl = $iconUrl;
    }

    public static function of (array $options)
    {
        return new self(
            $options['webhook'],
            new Level($options['level']),
            new Level($options['level_mention']),
            $options['channel'],
            $options['username'],
            $options['mentions'],
            $options['short_field_length'],
            $options['max_attachment_length'],
            $options['icon_url']
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

    public function level (): Level
    {
        return $this->level;
    }

    public function levelMention (): Level
    {
        return $this->levelMention;
    }

    public function username (): string
    {
        return $this->username;
    }

    public function mentions (): array
    {
        return $this->mentions;
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
