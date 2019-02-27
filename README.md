# Laravel Mattermost Logging Driver

This driver allows you to send your logs to your Mattermost (open-source Slack alternative). It will send the exception stack traces and context of the log (the second argument of the `logger` function in Laravel).

![example.png](https://gitlab.com/thibauddauce/laravel-mattermost-logger/raw/master/example.png)

## Installation

```
composer require thibaud-dauce/laravel-mattermost-logger
```

## Configuration

### Add the log driver

Add the new driver in your `config/logging.php`:

```php
'mattermost' => [
    'driver' => 'custom',
    'via' => ThibaudDauce\MattermostLogger\MattermostLogger::class,
    'webhook' => env('MATTERMOST_WEBHOOK'),
],
```

And update your stack in `config/logging.php`:

```php
'stack' => [
    'driver' => 'stack',
    'channels' => ['single', 'mattermost'],
],
```

Don't forget to put `LOG_CHANNEL=single` in your local and testing environments if you don't want to send logs to Mattermost during your tests.

### Options availables

You can put options after the `driver` and `via` keys in your `config/logging.php`. All options with their defaults are in the code https://gitlab.com/thibauddauce/laravel-mattermost-logger/blob/master/src/MattermostHandler.php#L14-22

- **webhook** (nothing): webhook URL to your Mattermost instance
- **channel** (town-square): channel slug where the logs will be sent to
- **icon_url** (nothing): relative URL for the icon showed in Mattermost (the package will use the `url()` helper to generate the full path)
- **username** (Laravel Logs): username showed in Mattermost
- **level** (INFO): below this level, the logs will not be sent to your Mattermost instance (by default debug logs are not sent)
- **level_mention** (ERROR): above this level, the logs will be red in Mattermost and people will get pinged
- **mentions** ([@here]): array of people to ping in case of log above **level_mention**
- **short_field_length** (62): context content longer than this value will be put in a long field in Mattermost (two colmun layout, see screenshot)
- **max_attachment_length** (6000): truncate the content below this value (Mattermost will refuse the payload otherwise)

## Usage

```php
logger()->info('Some message', [
    'context' => 'Some contex',
    'an_array_of_things' => ['foo', 'bar', 'baz'],
]);

// Or

throw new Exception('An exception occured');
```

## TODO

- Add the possibility to queue the HTTP request
