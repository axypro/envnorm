<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac.gmail.com>
 */

namespace axy\envnorm\helpers;

/**
 * The interface of objects that work with php settings
 */
interface IIniSetter
{
    /**
     * Sets an option value
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * Returns an option by name
     *
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * Sets the error reporting level
     *
     * @param int $level
     */
    public function setErrorReporting($level);

    /**
     * Returns the error reporting level
     *
     * @return int
     */
    public function getErrorReporting();

    /**
     * Sets the default timezone
     *
     * @param string $timezone
     */
    public function setTimezone($timezone);

    /**
     * Returns the default timezone
     *
     * @return string
     */
    public function getTimezone();

    /**
     * Sets the default encoding
     *
     * @param string $encoding
     */
    public function setEncoding($encoding);
}
