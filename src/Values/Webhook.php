<?php

namespace Dbt\Mattermost\Logger\Values;

final class Webhook
{
    /** @var string */
    private $value;

    public function __construct (string $value)
    {
        $this->value = $value;
    }

    public function value (): string
    {
        return $this->value;
    }
}
