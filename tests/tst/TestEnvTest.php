<?php
/**
 * @package axy\envnorm
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\envnorm\tests\tst;

/**
 * coversDefaultClass axy\envnorm\tests\tst\TestEnv
 */
class TestEnvTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::ini_set
     * covers ::ini_get
     */
    public function testIni()
    {
        $native = (int)ini_get('max_file_uploads');
        $test = $native + 5;
        $env = new TestEnv(['max_file_uploads' => $test]);
        $this->assertSame($test, $env->ini_get('max_file_uploads'));
        $test += 2;
        $env->ini_set('max_file_uploads', $test);
        $this->assertSame($test, $env->ini_get('max_file_uploads'));
        $this->assertSame($native, (int)ini_get('max_file_uploads'));
    }

    /**
     * covers ::error_reporting
     */
    public function testErrorReporting()
    {
        $native = error_reporting();
        $test = $native + 5;
        $env = new TestEnv(['error_reporting' => $test]);
        $this->assertSame($test, $env->error_reporting());
        $test += 3;
        $env->error_reporting($test);
        $this->assertSame($test, $env->error_reporting());
        $this->assertSame($native, error_reporting());
    }
}
