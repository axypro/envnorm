<?php
/**
 * Initial normalization of the environment
 *
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 * @license https://raw.github.com/axypro/envnorm/master/LICENSE MIT
 * @link https://github.com/axypro/envnorm repository
 * @uses PHP5.4+
 */

namespace axy\envnorm;

if (!is_file(__DIR__.'/vendor/autoload.php')) {
    throw new \LogicException('Please: ./composer install');
}

require_once(__DIR__.'/vendor/autoload.php');
