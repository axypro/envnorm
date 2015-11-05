<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\tests\tst;

use axy\env\Env;

class TestEnv extends Env
{
    /**
     * The constructor
     *
     * @param array $options
     */
    public function __construct(array $options = null)
    {
        $this->options = $options;
        $config = [
            'functions' => [
                'ini_set' => [$this, 'iniSet'],
                'ini_get' => [$this, 'iniGet'],
                'error_reporting' => [$this, 'errorReporting'],
                'set_error_handler' => [$this, 'setErrorHandler'],
                'set_exception_handler' => [$this, 'setExceptionHandler'],
                'mb_internal_encoding' => [$this, 'mbInternalEncoding'],
                'date_default_timezone_set' => [$this, 'setTimezone'],
                'date_default_timezone_get' => [$this, 'getTimezone'],
            ],
        ];
        parent::__construct($config);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return string
     */
    public function iniSet($name, $value)
    {
        $old = $this->iniGet($name);
        $this->options[$name] = $value;
        return $old;
    }

    /**
     * @param string $name
     * @return string|bool
     */
    public function iniGet($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : false;
    }

    /**
     * @param int $level [optional]
     * @return int
     */
    public function errorReporting($level = null)
    {
        $old = $this->iniGet('error_reporting');
        if ($level !== null) {
            $this->iniSet('error_reporting', $level);
        }
        return $old;
    }

    /**
     * @param callable $errorHandler
     * @return callable
     */
    public function setErrorHandler($errorHandler)
    {
        $old = $this->errorHandler = $errorHandler;
        $this->errorHandler = $errorHandler;
        return $old;
    }

    /**
     * @return callable
     */
    public function getErrorHandler()
    {
        return $this->errorHandler;
    }

    /**
     * @param callable $exceptionHandler
     * @return callable
     */
    public function setExceptionHandler($exceptionHandler)
    {
        $old = $this->exceptionHandler;
        $this->exceptionHandler = $exceptionHandler;
        return $old;
    }

    /**
     * @return callable
     */
    public function getExceptionHandler()
    {
        $this->exceptionHandler;
    }

    /**
     * @param string $encoding [optional]
     * @return mixed
     */
    public function mbInternalEncoding($encoding = null)
    {
        if ($encoding === null) {
            return $this->iniGet('mbstring.internal_encoding');
        }
        $this->iniSet('mbstring.internal_encoding', $encoding);
        return true;
    }

    /**
     * @param string $tz
     */
    public function setTimezone($tz)
    {
        $this->iniSet('date.timezone', $tz);
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->iniGet('date.timezone');
    }

    /**
     * @var array
     */
    private $options;

    /**
     * @var callable
     */
    private $errorHandler;

    /**
     * @var callable
     */
    private $exceptionHandler;
}
