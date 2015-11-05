<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\tests;

use axy\envnorm\Normalizer;
use axy\envnorm\tests\tst\TestEnv;

/**
 * coversDefaultClass axy\envnorm\Normalizer
 */
class NormalizerTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaults()
    {
        $env = new TestEnv(['display_errors' => true]);
        $normalizer = new Normalizer([], $env);
        $normalizer->normalize();
        $this->assertSame('UTF-8', $env->ini_get('mbstring.internal_encoding'));
        $this->assertSame('UTC', $env->ini_get('date.timezone'));
        $this->assertSame(E_ALL, $env->error_reporting());
        $handler = $env->getErrorHandler();
        $this->assertInstanceOf('axy\envnorm\ErrorHandler', $handler);
        $e = null;
        $line = null;
        try {
            $line = __LINE__ + 1;
            $handler(E_NOTICE, 'Error', __FILE__, $line, []);
        } catch (\ErrorException $e) {
        }
        $this->assertSame($line, $e->getLine());
        $this->assertSame(true, $env->ini_get('display_errors'));
        $this->assertSame(false, $env->ini_get('x'));
    }

    public function testCustom()
    {
        $config = [
            'errors' => [
                'display' => true,
            ],
            'encoding' => 'Windows-1252',
            'options' => [
                'x' => 10,
            ],
        ];
        $env = new TestEnv(['display_errors' => false, 'date.timezone' => 'Europe/London']);
        $normalizer = new Normalizer($config, $env);
        $normalizer->normalize();
        $this->assertSame('Windows-1252', $env->ini_get('mbstring.internal_encoding'));
        $this->assertSame('Europe/London', $env->date_default_timezone_get());
        $handler = $env->getErrorHandler();
        $this->assertInstanceOf('axy\envnorm\ErrorHandler', $handler);
        $line = null;
        $e = null;
        try {
            $line = __LINE__ + 1;
            $handler(E_NOTICE, 'Error', __FILE__, $line, []);
        } catch (\ErrorException $e) {
        }
        $this->assertSame($line, $e->getLine());
        $this->assertSame(true, (bool)$env->ini_get('display_errors'));
        $this->assertSame(10, $env->ini_get('x'));
        $this->assertSame(false, $env->ini_get('y'));
    }

    public function testEmptyCustomConfig()
    {
        $normalizer = Normalizer::createInstance();
        $this->assertInstanceOf('axy\envnorm\Normalizer', $normalizer);
    }
}
