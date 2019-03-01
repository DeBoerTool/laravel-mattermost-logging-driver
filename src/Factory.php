<?php

namespace Dbt\Mattermost\Logger;

use Monolog\Logger;
use ThibaudDauce\Mattermost\Mattermost;

final class Factory
{
    /** @var \ThibaudDauce\Mattermost\Mattermost */
    private $mattermost;

    public function __construct (Mattermost $mattermost)
    {
        $this->mattermost = $mattermost;
    }

    public function __invoke (array $options): Logger
    {
        return new Logger('mattermost', [
            new Handler($this->mattermost, $options)
        ]);
    }
}
