<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm;

use axy\envnorm\helpers\Config;
use axy\env\Factory as EnvFactory;

/**
 * The environment normalizer
 */
class Normalizer
{
    /**
     * The constructor
     *
     * @param array $config [optional]
     * @param mixed $env [optional]
     */
    public function __construct(array $config = null, $env = null)
    {
        $this->config = Config::create($config ?: []);
        $this->env = EnvFactory::create($env);
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
     * Normalizes the error handling
     */
    private function normalizeErrors()
    {
        $errors = $this->config['errors'];
        if (!is_array($errors)) {
            return;
        }
        if ($errors['level'] !== null) {
            $this->env->error_reporting($errors['level']);
        }
        if ($errors['display'] !== null) {
            $this->env->ini_set('display_errors', $errors['display'] ? 1 : 0);
        }
        $handler = $errors['handler'];
        if ($handler) {
            if ($handler === true) {
                $handler = new ErrorHandler($errors['ErrorException'], $errors['allowSuppression'], $this->env);
            }
            $this->env->set_error_handler($handler, $errors['level']);
        }
        if ($errors['exceptionHandler']) {
            $this->env->set_exception_handler($errors['exceptionHandler']);
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
            $current = $this->env->ini_get('date.timezone');
            if ($current !== $datetime['timezone']) {
                if ((!$current) || (!$datetime['keepTimezone'])) {
                    $this->env->date_default_timezone_set($datetime['timezone']);
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
            if ($this->env->isFunctionExists('mb_internal_encoding')) {
                $this->env->__call('mb_internal_encoding', [$this->config['encoding']]);
            }
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
        $env = $this->env;
        foreach ($options as $k => $v) {
            $env->ini_set($k, $v);
        }
    }

    /**
     * @var array
     */
    private $config;

    /**
     * @var \axy\env\Env
     */
    private $env;
}
