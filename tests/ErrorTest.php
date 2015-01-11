<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\tests;

use axy\envnorm\Error;

/**
 * coversDefaultClass axy\envnorm\Error
 */
class ErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::raise
     * covers ::getLastRaisedError
     */
    public function testError()
    {
        $context = ['x' => 1, 'y' => 2];
        $error = new Error(10, 'Error', 'x.php', 11, $context);
        $this->assertSame(10, $error->code);
        $this->assertSame('Error', $error->message);
        $this->assertSame('x.php', $error->file);
        $this->assertSame(11, $error->line);
        $this->assertEquals($context, $error->context);
        $this->assertNotSame($error, Error::getLastRaisedError());
        $e = null;
        try {
            $error->raise();
            $this->fail('Error::raise() did not throw an exception');
        } catch (\ErrorException $e) {
        }
        $this->assertSame($error, Error::getLastRaisedError());
        $this->assertSame('x.php', $e->getFile());
        $this->assertSame(11, $e->getLine());
        $this->assertSame('Error', $e->getMessage());
    }
}
