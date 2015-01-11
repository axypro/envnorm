<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm;

use axy\envnorm\helpers\Config;
use axy\envnorm\helpers\NativeIniSetter;

/**
 * The environment normalizer
 */
class Normalizer
{
    /**
     * The constructor
     *
     * @param array $config [optional]
     * @param array $di [optional]
     */
    public function __construct(array $config = null, array $di = null)
    {
        $this->config = Config::create($config);
        $this->loadDI($di ?: []);
    }

    /**
     * Normalizes the environment
     */
    public function normalize()
    {
        $this->normalizeTimezone();
        $this->normalizeErrors();
        $this->normalizeEncoding();
        $this->normalizeOptions();
    }

    /**
     * Creates a normalizer instance
     *
     * @param array $config [optional]
     * @return \axy\envnorm\Normalizer
     */
    public static function createInstance(array $config = null)
    {
        return new self($config);
    }

    /**
     * @param array $di
     */
    private function loadDI(array $di)
    {
        if (empty($di['ini'])) {
            $this->ini = new NativeIniSetter();
        } else {
            $this->ini = $di['ini'];
        }
    }

    /**
     * Normalizes the error handling
     */
    private function normalizeErrors()
    {
        $errors = $this->config['errors'];
        if (!is_array($errors)) {
            return;
        }
        if ($errors['level'] !== null) {
            $this->ini->setErrorReporting($errors['level']);
        }
        if ($errors['display'] !== null) {
            $this->ini->set('display_errors', $errors['display'] ? 1 : 0);
        }
        $handler = $errors['handler'];
        if ($handler) {
            if ($handler === true) {
                $handler = new ErrorHandler($errors['ErrorException'], $errors['allowSuppression'], $this->ini);
            }
            $this->ini->setErrorHandler($handler, $errors['level']);
        }
        if ($errors['exceptionHandler']) {
            $this->ini->setExceptionHandler($errors['exceptionHandler']);
        }
    }

    /**
     * Normalizes the default timezone
     */
    private function normalizeTimezone()
    {
        $datetime = $this->config['datetime'];
        if (!is_array($datetime)) {
            return;
        }
        if ($datetime['timezone']) {
            $current = $this->ini->get('date.timezone');
            if ($current !== $datetime['timezone']) {
                if ((!$current) || (!$datetime['keepTimezone'])) {
                    $this->ini->setTimezone($datetime['timezone']);
                }
            }
        }
    }

    /**
     * Normalizes the default encoding
     */
    private function normalizeEncoding()
    {
        if ($this->config['encoding']) {
            $this->ini->setEncoding($this->config['encoding']);
        }
    }

    /**
     * Normalizes the PHP settings
     */
    private function normalizeOptions()
    {
        $options = $this->config['options'];
        if (empty($options)) {
            return;
        }
        $ini = $this->ini;
        foreach ($options as $k => $v) {
            $ini->set($k, $v);
        }
    }

    /**
     * @var array
     */
    private $config;

    /**
     * @var \axy\envnorm\helpers\IIniSetter
     */
    private $ini;
}
