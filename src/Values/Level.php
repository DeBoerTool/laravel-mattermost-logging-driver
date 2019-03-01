<?php

namespace Dbt\Mattermost\Logger\Values;

final class Level
{
    /** @var int */
    private $level;

    /** @var int[] */
    private $levels = [
        'DEBUG' => 100,
        'INFO' => 200,
        'NOTICE' => 250,
        'WARNING' => 300,
        'ERROR' => 400,
        'CRITICAL' => 500,
        'ALERT' => 550,
        'EMERGENCY' => 600,
    ];

    public function __construct (int $level, array $levels = [])
    {
        $this->setLevel($level);

        if (count($levels)) {
            $this->levels = $levels;
        }
    }

    public static function of (int $level): Level
    {
        return new self($level);
    }

    public function value (): int
    {
        return $this->level;
    }

    public function isGreaterThanOrEqualTo (Level $level): bool
    {
        return $this->value() >= $level->value();
    }

    public function isLessThan (Level $level): bool
    {
        return $this->value() < $level->value();
    }

    private function setLevel (int $level): void
    {
        if (!in_array($level, $this->levels)) {
            throw new \Exception('The logging level you provided is invalid.');
        }

        $this->level = $level;
    }
}
