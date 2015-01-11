<?php
/**
 * The normalizer default config
 *
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

return [
    /* Error handling */
    'errors' => [
        /* Error level for handling */
        'level' => E_ALL,
        /* Display errors (TRUE/FALSE). If NULL - keep ini setting */
        'display' => null,
        /* Error handler (callback). TRUE - envnorm-handler, NULL - not used */
        'handler' => true,
        /* Class of ErrorException for envnorm-error handler */
        'ErrorException' => 'ErrorException',
        /* Exception handler (callback) NULL - not used */
        'exceptionHandler' => null,
    ],

    'datetime' => [
        /* Default timezone */
        'timezone' => 'UTC',
        /* If TRUE - set timezone only if it is not defined in php.ini */
        'keepTimezone' => true,
    ],

    /* Default encoding for mbstring and etc */
    'encoding' => 'UTF-8',

    /* php.ini options (key => value) */
    'options' => [],
];
