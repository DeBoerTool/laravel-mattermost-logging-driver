<?php

namespace Dbt\Mattermost\Logger;

use Closure;
use Coduo\ToString\StringConverter;
use Exception;
use ThibaudDauce\Mattermost\Attachment;
use ThibaudDauce\Mattermost\Message as MatterMostMessage;

class Message extends MatterMostMessage
{
    public function addExceptionAttachment (Exception $ex, int $maxLen): void
    {
        $this->attachment(
            $this->exceptionCb($ex, $maxLen)
        );
    }

    public function addContextAttachment(array $context, int $shortLength): void
    {
        $this->attachment(
            $this->contextCb($context, $shortLength)
        );
    }

    private function exceptionCb (Exception $exception, int $maxLength): Closure
    {
        return function (Attachment $attachment) use ($exception, $maxLength) {
            $attachment->text(
                substr($exception->getTraceAsString(), 0, $maxLength)
            );
        };
    }

    private function contextCb (array $context, int $shortLength)
    {
        return function (Attachment $attachment) use ($context, $shortLength) {
            foreach ($context as $key => $value) {
                $valueAsString = (string) new StringConverter($value);

                $attachment->field(
                    $key,
                    $valueAsString,
                    $this->isShort($valueAsString, $shortLength)
                );
            }
        };
    }

    private function isShort (string $value, int $length): bool
    {
        return strlen($value) < $length;
    }
}
