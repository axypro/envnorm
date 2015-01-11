<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\tests;

use axy\envnorm\ErrorHandler;
use axy\envnorm\Error;

/**
 * coversDefaultClass axy\envnorm\Error
 */
class ErrorHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::register
     * covers ::__invoke
     */
    public function testError()
    {
        $a = [];
        $handler = new ErrorHandler();
        $handler->register(E_ALL);
        $e = null;
        $line = null;
        try {
            $a['a'] = @$a['b'];
            $line = __LINE__;
            $a['a'] = $a['c'];
            $this->fail('ErrorHandler did not throw an exception');
        } catch (\ErrorException $e) {
        }
        restore_error_handler();
        $this->assertSame(__FILE__, $e->getFile());
        $this->assertSame($line + 1, $e->getLine());
        $error = Error::getLastRaisedError();
        $this->assertInstanceOf('axy\envnorm\Error', $error);
        $this->assertSame(__FILE__, $error->file);
        $this->assertSame($line + 1, $error->line);
    }
}
