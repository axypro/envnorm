<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\tests\helpers;

use axy\envnorm\helpers\TestIniSetter;

/**
 * coversDefaultClass axy\envnorm\helpers\TestIniSetter
 */
class TestIniSetterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::set
     * covers ::get
     * covers ::setErrorReporting
     * covers ::getErrorReporting
     * covers ::setTimezone
     * covers ::getTimezone
     * covers ::setEncoding
     */
    public function testSetter()
    {
        $options = [
            'sendmail_path' => 'sendmail',
            'error_reporting' => 4,
        ];
        $setter = new TestIniSetter($options);
        $this->assertSame('sendmail', $setter->get('sendmail_path'));
        $this->assertSame(4, $setter->get('error_reporting'));
        $this->assertSame(null, $setter->get('sendmail_from'));
        $setter->set('sendmail', 'qwerty');
        $setter->set('sendmail_from', 'me@example.loc');
        $this->assertSame('qwerty', $setter->get('sendmail'));
        $this->assertSame('me@example.loc', $setter->get('sendmail_from'));
        $this->assertSame(4, $setter->getErrorReporting());
        $setter->setErrorReporting(12345);
        $this->assertSame(12345, $setter->get('error_reporting'));
        $this->assertSame(12345, $setter->getErrorReporting());
        $this->assertSame(null, $setter->getTimezone());
        $setter->setTimezone('UTC');
        $this->assertSame('UTC', $setter->get('date.timezone'));
        $this->assertSame('UTC', $setter->getTimezone());
        $this->assertSame(null, $setter->get('mbstring.internal_encoding'));
        $setter->setEncoding('windows-1252');
        $this->assertSame('windows-1252', $setter->get('mbstring.internal_encoding'));
    }
}
