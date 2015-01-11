<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac.gmail.com>
 */

namespace axy\envnorm\helpers;

/**
 * The implementation of IIniSetter for real setting
 */
class NativeIniSetter extends BaseIniSetter
{
    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        ini_set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return ini_get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function setErrorReporting($level)
    {
        error_reporting($level);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorReporting()
    {
        return error_reporting();
    }

    /**
     * {@inheritdoc}
     */
    public function setTimezone($timezone)
    {
        date_default_timezone_set($timezone);
    }

    /**
     * {@inheritdoc}
     */
    public function getTimezone()
    {
        return date_default_timezone_get();
    }

    /**
     * {@inheritdoc}
     */
    public function setEncoding($encoding)
    {
        if (function_exists('mb_internal_encoding')) {
            mb_internal_encoding($encoding);
        }
    }
}
