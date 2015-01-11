<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\helpers;

/**
 * Access to the configuration
 */
class Config
{
    /**
     * Returns the default config
     *
     * @return array
     */
    public static function getDefaults()
    {
        if (self::$defaults === null) {
            self::$defaults = include __DIR__.'/../defaults.php';
        }
        return self::$defaults;
    }

    /**
     * Creates a custom config
     *
     * @param array $custom
     * @return array
     */
    public static function create(array $custom)
    {
        return array_replace_recursive(self::getDefaults(), $custom);
    }

    /**
     * @var array
     */
    private static $defaults;
}
