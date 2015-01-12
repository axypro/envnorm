<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\tests;

use axy\envnorm\Normalizer;
use axy\envnorm\helpers\TestIniSetter;

/**
 * coversDefaultClass axy\envnorm\Normalizer
 */
class NormalizerTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaults()
    {
        $ini = new TestIniSetter(['display_errors' => false]);
        $normalizer = new Normalizer([], ['ini' => $ini]);
        $normalizer->normalize();
        $this->assertSame('UTF-8', $ini->get('mbstring.internal_encoding'));
        $this->assertSame('UTC', $ini->getTimezone());
        $this->assertSame(E_ALL, $ini->getErrorReporting());
        $handler = $ini->getErrorHandler();
        $this->assertInstanceOf('axy\envnorm\ErrorHandler', $handler);
        $e = null;
        try {
            $line = __LINE__ + 1;
            $handler(E_NOTICE, 'Error', __FILE__, $line, []);
        } catch (\ErrorException $e) {
        }
        $this->assertSame($line, $e->getLine());
        $this->assertSame(false, $ini->get('display_errors'));
        $this->assertSame(null, $ini->get('x'));
    }

    public function testCustom()
    {
        $ini = new TestIniSetter(['display_errors' => false, 'date.timezone' => 'Europe/London']);
        $config = [
            'errors' => [
                'display' => true,
            ],
            'encoding' => 'Windows-1252',
            'options' => [
                'x' => 10,
            ],
        ];
        $normalizer = new Normalizer($config, ['ini' => $ini]);
        $normalizer->normalize();
        $this->assertSame('Windows-1252', $ini->get('mbstring.internal_encoding'));
        $this->assertSame('Europe/London', $ini->getTimezone());
        $handler = $ini->getErrorHandler();
        $this->assertInstanceOf('axy\envnorm\ErrorHandler', $handler);
        $e = null;
        try {
            $line = __LINE__ + 1;
            $handler(E_NOTICE, 'Error', __FILE__, $line, []);
        } catch (\ErrorException $e) {
        }
        $this->assertSame($line, $e->getLine());
        $this->assertSame(true, (bool)$ini->get('display_errors'));
        $this->assertSame(10, $ini->get('x'));
        $this->assertSame(null, $ini->get('y'));
    }

    public function testEmptyCustomConfig()
    {
        $normalizer = Normalizer::createInstance();
        $this->assertInstanceOf('axy\envnorm\Normalizer', $normalizer);
    }
}
