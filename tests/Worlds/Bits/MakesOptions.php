<?php

namespace Dbt\Tests\Worlds\Bits;

use Dbt\Mattermost\Logger\DefaultOptions;
use Dbt\Mattermost\Logger\Interfaces\Options;

trait MakesOptions
{
    protected function options (): Options
    {
        return DefaultOptions::of([
            'webhook' => 'test-webhook',
            'level' => 100,
            'level_mention' => 200,
            'channel' => 'test-channel',
            'icon_url' => null,
            'username' => 'test-username',
            'mentions' => ['@unfortunate_mention_target'],
            'short_field_length' => 62,
            'max_attachment_length' => 6000,
            'title_format' => '%s title format',
            'title_mention_format' => '%s title mention format',
        ]);
    }
}
