<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\tests\helpers;

use axy\envnorm\helpers\NativeIniSetter;

/**
 * coversDefaultClass axy\envnorm\helpers\NativeIniSetter
 */
class NativeIniSetterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::set
     * covers ::get
     */
    public function testGetSet()
    {
        $setter = new NativeIniSetter();
        $value = ini_get('sendmail_from');
        $this->assertSame($value, $setter->get('sendmail_from'));
        $setter->set('sendmail_from', 'me@example.loc');
        $this->assertSame('me@example.loc', ini_get('sendmail_from'));
        $this->assertSame('me@example.loc', $setter->get('sendmail_from'));
        ini_set('sendmail_from', $value);
        $this->assertSame($value, ini_get('sendmail_from'));
        $this->assertSame($value, $setter->get('sendmail_from'));
    }

    /**
     * covers ::setErrorReporting
     * covers ::getErrorReporting
     */
    public function testErrorReporting()
    {
        $setter = new NativeIniSetter();
        $value = error_reporting();
        $newValue = 17;
        if ($value === $newValue) {
            $newValue++;
        }
        $this->assertEquals($value, $setter->getErrorReporting());
        $setter->setErrorReporting($newValue);
        $this->assertEquals($newValue, error_reporting());
        $this->assertEquals($newValue, $setter->getErrorReporting());
        error_reporting($value);
        $this->assertEquals($value, error_reporting());
        $this->assertEquals($value, $setter->getErrorReporting());
    }

    /**
     * covers ::setTimezone
     * covers ::getTimezone
     */
    public function testTimezone()
    {
        $setter = new NativeIniSetter();
        $value = @date_default_timezone_get();
        $newValue = 'UTC';
        if ($value === $newValue) {
            $newValue = 'Europe/London';
        }
        $this->assertSame($value, $setter->getTimezone());
        $setter->setTimezone($newValue);
        $this->assertSame($newValue, date_default_timezone_get());
        $this->assertSame($newValue, $setter->getTimezone());
        date_default_timezone_set($value);
        $this->assertSame($value, date_default_timezone_get());
        $this->assertSame($value, $setter->getTimezone());
    }

    /**
     * covers ::setEncoding
     */
    public function testEncoding()
    {
        $setter = new NativeIniSetter();
        $value = mb_internal_encoding();
        $newValue = 'Windows-1252';
        if ($value === $newValue) {
            $newValue = 'Windows-1251';
        }
        $setter->setEncoding($newValue);
        $this->assertSame($newValue, mb_internal_encoding());
        mb_internal_encoding($value);
    }
}
