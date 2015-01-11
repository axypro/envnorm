<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm;

use axy\envnorm\helpers\NativeIniSetter;

/**
 * The error handler
 * For every error is thrown an exception.
 */
class ErrorHandler
{
    /**
     * The constructor
     *
     * @param null $exceptionClass
     * @param bool $allowSuppression
     * @param \axy\envnorm\helpers\IIniSetter $ini
     */
    public function __construct($exceptionClass = null, $allowSuppression = true, $ini = null)
    {
        $this->exceptionClass = $exceptionClass;
        $this->allowSuppression = $allowSuppression;
        if ($ini === null) {
            $ini = new NativeIniSetter();
        }
        $this->ini = $ini;
    }

    /**
     * Registers as the system error handler
     *
     * @param int $level
     */
    public function register($level)
    {
        $this->ini->setErrorHandler($this, $level);
    }

    /**
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param array $errcontext
     * @throws \ErrorException
     */
    public function __invoke($errno, $errstr, $errfile, $errline, $errcontext)
    {
        if ($this->allowSuppression && ((int)$this->ini->getErrorReporting() === 0)) {
            return;
        }
        $error = new Error($errno, $errstr, $errfile, $errline, $errcontext);
        $error->raise();
    }

    /**
     * @var string
     */
    private $exceptionClass;

    /**
     * @var bool
     */
    private $allowSuppression;

    /**
     * @var \axy\envnorm\helpers\IIniSetter
     */
    private $ini;
}
