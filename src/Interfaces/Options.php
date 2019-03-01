<?php

namespace Dbt\Mattermost\Logger\Interfaces;

use Dbt\Mattermost\Logger\Values\Format;
use Dbt\Mattermost\Logger\Values\Level;
use Dbt\Mattermost\Logger\Values\Webhook;

interface Options
{
    public function webhook (): Webhook;
    public function level (): Level;
    public function channel (): string;
    public function titleFormat (): Format;
    public function titleMentionFormat (): Format;
    public function levelMention (): Level;
    public function username (): string;
    public function mentions (): array;
    public function shortFieldLength (): int;
    public function maxAttachmentLength (): int;
    public function iconUrl (): ?string;
}
