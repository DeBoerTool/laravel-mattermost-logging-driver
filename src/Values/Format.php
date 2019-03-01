<?php

namespace Dbt\Mattermost\Logger\Values;

final class Format
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

    public function apply (...$vars)
    {
        return sprintf($this->value, ...$vars);
    }
}
