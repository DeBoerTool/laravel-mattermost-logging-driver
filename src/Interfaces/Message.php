<?php

namespace Dbt\Mattermost\Logger\Interfaces;

use Closure;
use Exception;
use Illuminate\Contracts\Support\Arrayable;

interface Message extends Arrayable
{
    public function text($text);
    public function iconUrl($iconUrl);
    public function username($username);
    public function channel($channel);
    public function attachment(Closure $callback);
    public function addExceptionAttachment (Exception $ex, int $maxLen): void;
    public function addContextAttachment (array $context, int $shortLength): void;
}
