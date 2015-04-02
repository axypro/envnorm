# axy\envnorm 

Initial normalization of the environment
 
 * GitHub: [axypro/envnorm](https://github.com/axypro/envnorm)
 * Composer: [axy/envnorm](https://packagist.org/packages/axy/envnorm)

PHP 5.4+

Library does not require any dependencies.

## How to use

```php
use axy\envnorm\Normalizer;

$normalizer = new Normalizer();
$normalizer->normalize();
```

Or (do not litter in the global scope):

```php
Normalizer::createInstance()->normalize();
```
 
Or (custom configuration):

```php
$config = [
    'datetime' => null,
    'encoding' => 'Windows-1251',
];

Normalizer::createInstance($config)->normalize();
```

The library is intended for rearrangement of the PHP-environment before the application start.

## The configuration

The default configuration is this

```php
[
    'errors' => [
        'level' => E_ALL,
        'display' => null,
        'handler' => true,
        'ErrorException' => 'ErrorException',
        'exceptionHandler' => null,
        'allowSuppression' => true,
    ],
    'datetime' => [
        'timezone' => 'UTC',
        'keepTimezone' => true,
    ],
    'encoding' => 'UTF-8',
    'options' => [],
];
```

You can override the parameters that you need.
A custom configuration merges with the default by `array_replace_recursive()`.

`NULL` in a value means that action should not be performed.
 
```php
$custom = [
    'errors' => [
        'handler' => null, // do not use a custom error handler
    ],
    'datetime' => null, // do not perform any action on the date and time settings
];
```

## Errors

Default means the following behavior:

* All errors (including warnings, notices and etc) lead to the stop (by an exception).
* Show or hide the error depends on the platform (development or production).

The following describes the fields of the configuration section `errors`.

#### `level (int)`

[The bitmask](http://php.net/manual/en/errorfunc.constants.php) of handled error types.
By default is `E_ALL`.

#### `display (boolean)`

The value for the `display_errors` option.
By default is `NULL`: a script shouldn't set `display_errors`, it must be set in php.ini (depends on the platform). 

#### `handler (callback)`

The callback for the error handler (see [set_error_handler()](http://php.net/manual/en/function.set-error-handler.php)).
IF `NULL` then do not set a custom handler.
IF `TRUE` then set the handler from the library.

The library handler throws an exception (`ErrorException` or its child) for each error.

```php
$a = [];
$a['a'] = $a['b']; // ErrorException
```

#### `ErrorException (string)`

The library `handler` uses this option.
This is the class name of the exception.
It is `ErrorException` by default and can be a child of `ErrorException`.
 
#### `allowSuppression (bool)`

This option allows suppression of error by @-operator.

```php
$a = [];
$a['a'] = @$a['b'];
```

The default (`allowSuppression=TRUE`) it do not lead to the exception.
If set this option to `FALSE` the exception will be thrown regardless of `@`.

#### `exceptionHandler (callback)`

The top level handler for exceptions.
See [set_exception_handler()](http://php.net/manual/en/function.set-exception-handler.php).

The default is `NULL`: the handler will not set.

## Timezone

#### `datetime.timezone (string)`

The default timezone.
`UTC` by default.

#### `datetime.keepTimezone (bool)`

The default (`keepTimezone=TRUE`) remains the timezone from php.ini.
`datetime.timezone` only used if the timezone is not defined in php.ini. 

## Encoding

The `encoding` option used in `mbstring` (if it is installed).

## Options

All other PHP-options that should be changed.

```php
$config = [
    'options' => [
        'sendmail_from' => 'me@server.loc',
        'mysqli.default_port' => 3307,
    ],
];
```
