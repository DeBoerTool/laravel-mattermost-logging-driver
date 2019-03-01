<?php

namespace Dbt\Mattermost\Logger;

use Dbt\Mattermost\Logger\Values\Level;

final class Scribe
{
    /** @var array */
    private $record;

    /** @var array */
    private $context;

    /** @var ?Exception */
    private $exception;

    /** @var \Dbt\Mattermost\Logger\Options */
    private $options;

    private $titleFormat = '**[%s]** %s';
    private $titleMentionFormat = ' (ping %s)';

    public function __construct(Options $options, array $record)
    {
        $this->options = $options;

        $this->setRecord($record);
        $this->setContext($record);
        $this->setException($record);
    }

    public function message (): Message
    {
        $message = new Message();

        $message->channel($this->options->channel());
        $message->username($this->options->username());
        $message->iconUrl($this->options->iconUrl());
        $message->text($this->title());

        if ($this->exception) {
            $message->addExceptionAttachment(
                $this->exception,
                $this->options->maxAttachmentLength()
            );
        }

        if ($this->context) {
            $message->addContextAttachment(
                $this->context,
                $this->options->shortFieldLength()
            );
        }

        return $message;
    }

    public function title (): string
    {
        $title = sprintf(
            $this->titleFormat,
            $this->record['level_name'],
            $this->record['message']
        );

        if ($this->shouldMention()) {
            $title .= sprintf(
                $this->titleMentionFormat,
                $this->mentions()
            );
        }

        return $title;
    }

    private function shouldMention (): bool
    {
        return Level::of($this->record['level'])->isGreaterThanOrEqualTo(
            $this->options->levelMention()
        );
    }

    public function mentions ()
    {
        $mentions = array_map(function ($mention) {
            return str_start($mention, '@');
        }, $this->options->mentions());

        return implode(', ', $mentions);
    }

    private function setRecord (array $record): void
    {
        if (isset($record['context'])) {
            unset($record['context']);
        }

        $this->record = $record;
    }

    private function setContext (array $record): void
    {
        if (isset($record['context']['exception'])) {
            unset($record['context']['exception']);
        }

        if (isset($record['context']) && count($record['context'])) {
            $this->context = $record['context'];
        }
    }

    private function setException (array $record): void
    {
        if (isset($record['context']['exception'])) {
            $this->exception = $record['context']['exception'];
        }
    }
}
