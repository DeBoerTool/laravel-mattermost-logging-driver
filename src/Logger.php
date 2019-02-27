<?php

namespace Dbt\Mattermost\Logger;

use Monolog\Logger as Monolog;
use ThibaudDauce\Mattermost\Mattermost;

final class Logger
{
    /** @var \ThibaudDauce\Mattermost\Mattermost */
    private $mattermost;

    public function __construct(Mattermost $mattermost)
    {
        $this->mattermost = $mattermost;
    }

    public function __invoke ($options): Monolog
    {
        return new Monolog('mattermost', [
            new Handler($this->mattermost, $options)
        ]);
    }
}
