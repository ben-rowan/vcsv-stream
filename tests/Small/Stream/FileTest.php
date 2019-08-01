<?php declare(strict_types=1);

namespace BenRowan\VCsvStream\Tests\Small\Stream;

use BenRowan\VCsvStream\Stream\File;
use BenRowan\VCsvStream\Tests\Assets\AbstractTestCase;
use function function_exists;

class FileTest extends AbstractTestCase
{
    /**
     * @var File
     */
    private $file;

    public function setUp()
    {
        $this->file = new File();
    }

    /**
     * @test
     */
    public function iGetMyUid(): void
    {
        if (! function_exists('posix_getuid')) {
            $this->markTestSkipped('Function posix_getuid does not exist.');
        }

        $expected = posix_getuid();
        $actual   = $this->file->stat()['uid'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iGetMyGid(): void
    {
        if (! function_exists('posix_getgid')) {
            $this->markTestSkipped('Function posix_getgid does not exist.');
        }

        $expected = posix_getgid();
        $actual   = $this->file->stat()['gid'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iGetRootUid(): void
    {
        $refProp = self::$reflectionHelper
            ->createReflectionProperty($this->file, 'uidFuncExists');

        $refProp->setValue($this->file, false);

        $expected = 0;
        $actual   = $this->file->stat()['uid'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function iGetRootGid(): void
    {
        $refProp = self::$reflectionHelper
            ->createReflectionProperty($this->file, 'gidFuncExists');

        $refProp->setValue($this->file, false);

        $expected = 0;
        $actual   = $this->file->stat()['gid'];

        $this->assertSame($expected, $actual);
    }
}