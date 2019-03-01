# Laravel Mattermost Logging Driver

This driver allows you to send your logs to your Mattermost instance. It will attach exception stack traces and the log context/


## Installation

```
composer require dbt/laravel-mattermost-logging-driver
```

## Configuration

Add the new driver in your `config/logging.php`:

```php
'mattermost' => [
    'driver' => 'custom',
    'via' => Dbt\Mattermost\Logger\Factory::class,
    'webhook' => env('MATTERMOST_WEBHOOK'),
],
```

You can also add the `mattermost` channel to your `stack` driver if you wish:

```php
'stack' => [
    'driver' => 'stack',
    'channels' => ['single', 'mattermost'],
],
```

Don't forget to set `LOG_CHANNEL=single` in your local and testing environments if you don't want to send logs to Mattermost during your tests.

### Options

You can add additional options after the `driver` and `via` keys in your `config/logging.php`.

| Option                  | Default         | Description                                                                                                                                            |
|-------------------------|-----------------|--------------------------------------------------------------------------------------------------------------------------------------------------------|
| `webhook`               |                 | Your Mattermost webhook url. You must set this.                                                                                                        |
| `channel`               | `town-square`   | The channel slug where the logs will be send.                                                                                                          |
| `level`                 | `Logger::INFO`  | Messages below this log level will not be sent.                                                                                                        |
| `level_mention`         | `Logger::ERROR` | Messages at or above this level will ping the usernames in the `mentions` key                                                                          |
| `title_format`          | `'**[%s]** %s'` | The message title format, expressed at a `sprintf()` formatted string                                                                                  |
| `title_mention_format`  | `' (ping %s)'`  | The message title mention format, expressed at a `sprintf()` formatted string                                                                          |
| `username`              | `Laravel Log`   | The username to display                                                                                                                                |
| `mentions`              | `['@channel']`  | An array of usernames to ping                                                                                                                          |
| `short_field_length`    | `62`            | Context content longer than this value will be formatted with a long field                                                                             |
| `max_attachment_length` | `6000`          | Content past this length will be truncated to avoid Mattermost refusing the payload.                                                                   |
| `icon_url`              | `null`          | A relative icon URL to display. `UrlGenerator` is called to get the full path, so you can use this in multiple environments without resetting the key. |
| `scribe`                | `null`          | If you want to override the default message builder, provide your own fully qualified `Scribe` interface implementation                                | 
| `message`               | `null`          | If you want to override the default message, provide your own fully qualified `Message` interface implementation                                       | 

## Usage

Use this driver like any other. You can send directly to the `mattermost` channel by using the `Log` facade, calling the `logger` function, or getting `LogManager` from the container. Then call `channel(...)` or `stack([...])`. 

```php
resolve(LogManager::class)
    ->channel('mattermost') // or ->stack(['single', 'bugsnag', 'mattermost'])
    ->info('Everyone loves a good log message.');
```

## Sundries

Contributions welcomed.

MIT Licensed. Do as you wish.

Based on https://gitlab.com/thibauddauce/laravel-mattermost-logger/ 
