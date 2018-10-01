<?php
namespace FSLock\tests;

use ReflectionProperty;
use FSLock\FSLock;
use FSLock\FSLockIOException;
use PHPUnit\Framework\TestCase as TestCase;

class FSLockTest extends TestCase
{
    public function setUp()
    {
        $this->lockBucket = sys_get_temp_dir();
    }

    public function tearDown()
    {
        @unlink("$this->lockBucket/unittest.fslock");
    }

    public function testCreateFSLockInstance()
    {
        $this->assertEquals(
            "$this->lockBucket/unittest.fslock",
            (new FSLock('unittest'))->getPath()
        );
    }

    public function testBucketWorksInSystemTempDir()
    {
        $this->assertInstanceOf('FSLock\\FSLock', new FSLock('unittest'));
    }

    /**
     * @expectedException \FSLock\FSLockIOException
     */
    public function testBucketIsNotWritable()
    {
        new FSLock('unittest', '/foo');
    }

    public function testAcquire()
    {
        $mutex1 = new FSLock('unittest');
        $mutex2 = new FSLock('unittest');

        $this->assertTrue($mutex1->acquire());
        $this->assertFalse($mutex2->acquire());
    }

    public function testRelease()
    {
        $mutex1 = new FSLock('unittest');
        $mutex2 = new FSLock('unittest');

        $this->assertTrue($mutex1->acquire());
        $this->assertFalse($mutex2->acquire());

        $mutex1->release();

        $this->assertTrue($mutex2->acquire());
    }

    public function testGetFSLockID()
    {
        $this->assertEquals('unittest', (new FSLock('unittest'))->id());
    }

    public function testReleaseUnlockedFile()
    {
        $mutex = new FSLock('unittest');

        $lock = new ReflectionProperty($mutex, 'lock');
        $lock->setAccessible(true);
        $lock->setValue($mutex, null);

        $this->assertTrue($mutex->release());
    }

    public function testAcquireFSLockNoResource()
    {
        $mutex = new FSLock('unittest');

        $lock = new ReflectionProperty($mutex, 'lock');
        $lock->setAccessible(true);
        $lock->setValue($mutex, null);

        $this->assertFalse($mutex->acquire());
    }
}
