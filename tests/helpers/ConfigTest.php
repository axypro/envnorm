<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\tests\helpers;

use axy\envnorm\helpers\Config;

/**
 * coversDefaultClass axy\envnorm\helpers\Config
 */
class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::getDefaults
     */
    public function testGetDefaults()
    {
        $expected = include __DIR__.'/../../defaults.php';
        $this->assertEquals($expected, Config::getDefaults());
        $this->assertEquals($expected, Config::getDefaults());
    }

    /**
     * covers ::create
     */
    public function testCreate()
    {
        $expected = Config::getDefaults();
        $custom = [
            'errors' => [
                'display' => true,
            ],
            'datetime' => null,
            'encoding' => 'Windows-1252',
        ];
        $expected['errors']['display'] = true;
        $expected['datetime'] = null;
        $expected['encoding'] = 'Windows-1252';
        $this->assertEquals($expected, Config::create($custom));
    }
}
