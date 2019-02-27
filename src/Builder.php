<?php

namespace Dbt\Mattermost\Logger;

use ThibaudDauce\Mattermost\Attachment;
use ThibaudDauce\Mattermost\Message;

final class Builder
{
    /** @var array */
    private $record;

    /** @var \Dbt\Mattermost\Logger\Options */
    private $options;

    public function __construct(Options $options, array $record)
    {
        $this->record = $record;
        $this->options = $options;
    }

    public function message (): Message
    {
        $message = new Message();

        $message->channel($this->options->channel());
        $message->username($this->options->username());
        $message->iconUrl($this->options->iconUrl());
        $message->text($this->title());
    }

    public static function fromArrayAndOptions($record, $options)
    {
        $messageBuilder = new self($record, $options);

        $messageBuilder->addExceptionAttachment();
        $messageBuilder->addContextAttachment();

        return $messageBuilder->message;
    }

    public function addTitleText()
    {
        $this->message->text($this->title());
    }

    public function title()
    {
        $title = sprintf('**[%s]** %s', $this->record['level_name'], $this->record['message']);

        if ($this->shouldMention()) {
            $title .= sprintf(' (ping %s)', $this->mentions());
        }

        return $title;
    }

    public function mentions()
    {
        $mentions = array_map(function ($mention) {
            return str_start($mention, '@');
        }, $this->options['mentions']);

        return implode(', ', $mentions);
    }

    public function addExceptionAttachment()
    {
        if (! $exception = $this->popException()) {
            return;
        }

        $this->attachment(function (Attachment $attachment) use ($exception) {
            $attachment->text(
                substr($exception->getTraceAsString(), 0, $this->options['max_attachment_length'])
            );
        });
    }

    public function popException()
    {
        if (! isset($this->record['context']['exception'])) {
            return null;
        }

        $exception = $this->record['context']['exception'];
        unset($this->record['context']['exception']);

        return $exception;
    }

    public function addContextAttachment()
    {
        if (! isset($this->record['context']) or empty($this->record['context'])) {
            return;
        }

        $this->attachment(function (Attachment $attachment) {
            foreach ($this->record['context'] as $key => $value) {
                $stringifyValue = is_string($value) ? $value : json_encode($value);
                $attachment->field($key, $stringifyValue, strlen($stringifyValue) < $this->options['short_field_length']);
            }
        });
    }

    public function shouldMention()
    {
        return $this->record['level'] >= $this->options['level_mention'];
    }

    public function attachment($callback)
    {
        $this->message->attachment(function (Attachment $attachment) use ($callback) {
            if ($this->shouldMention()) {
                $attachment->error();
            }

            $callback($attachment);
        });
    }
}
