<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm;

/**
 * Information of a PHP-error
 */
class Error
{
    /**
     * The constructor
     *
     * @param int $code
     * @param string $message
     * @param string $file
     * @param int $line
     * @param array $context
     * @param string $errorClass
     *        the exception class (ErrorException by default)
     */
    public function __construct($code, $message, $file, $line, array $context, $errorClass = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->file = $file;
        $this->line = $line;
        $this->context = $context;
        $this->errorClass = $errorClass;
    }

    /**
     * Throws an error exception
     *
     * @throws \ErrorException
     */
    public function raise()
    {
        self::$lastRaised = $this;
        $errorClass = $this->errorClass ?: 'ErrorException';
        throw new $errorClass($this->message, 0, $this->code, $this->file, $this->line);
    }

    /**
     * Returns the last raised error instance
     *
     * @return \axy\envnorm\Error
     */
    public static function getLastRaisedError()
    {
        return self::$lastRaised;
    }

    /**
     * The error level
     *
     * @var int
     */
    public $code;

    /**
     * The error message
     *
     * @var string
     */
    public $message;

    /**
     * The error file name
     *
     * @var string
     */
    public $file;

    /**
     * The error file line
     *
     * @var int
     */
    public $line;

    /**
     * The local context
     *
     * @var array
     */
    public $context;

    /**
     * @var string
     */
    private $errorClass;

    /**
     * @var \axy\envnorm\Error
     */
    private static $lastRaised;
}
