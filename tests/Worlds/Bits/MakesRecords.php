<?php

namespace Dbt\Tests\Worlds\Bits;

trait MakesRecords
{
    protected function record (): array
    {
        return [
            "message" => "This is a test error",
            "context" => [],
            "level" => 400,
            "level_name" => "ERROR",
            "channel" => "local",
            "datetime" => new \DateTime(),
            "extra" => [],
            "formatted" => "[2019-03-01 09:35:58] local.ERROR: This is a test error [] []\n"
        ];
    }
}
