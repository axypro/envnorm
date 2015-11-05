<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm;

use axy\env\Factory as EnvFactory;

/**
 * The error handler
 * For every error is thrown an exception.
 */
class ErrorHandler
{
    /**
     * The constructor
     *
     * @param string $exceptionClass
     * @param bool $allowSuppression
     * @param mixed $env
     */
    public function __construct($exceptionClass = null, $allowSuppression = true, $env = null)
    {
        $this->exceptionClass = $exceptionClass;
        $this->allowSuppression = $allowSuppression;
        $this->env = EnvFactory::create($env);
    }

    /**
     * Registers as the system error handler
     *
     * @param int $level
     */
    public function register($level)
    {
        $this->env->set_error_handler($this, $level);
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
        if ($this->allowSuppression && ((int)$this->env->error_reporting() === 0)) {
            return;
        }
        $error = new Error($errno, $errstr, $errfile, $errline, $errcontext, $this->exceptionClass);
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
     * @var \axy\env\Env
     */
    private $env;
}
