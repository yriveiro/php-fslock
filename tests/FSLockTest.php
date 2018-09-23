<?php

namespace FSLock\tests;

use Exception;
use FSLock\FSLock;
use ReflectionProperty;
use PHPUnit\Framework\TestCase as TestCase;

class FSLockTest extends TestCase
{
    public function setUp()
    {
        $this->lockBucket = sys_get_temp_dir();
    }

    public function tearDown()
    {
        @unlink(sprintf("%s/unittest.fslock", $this->lockBucket));
    }

    public function testCreateFSLockInstance()
    {
        $mutex = new FSLock('unittest');

        $this->assertEquals(
            $this->lockBucket . '/' . 'unittest.fslock',
            $mutex->getPath()
        );
    }

    public function testDestroyFSLockInstance()
    {
        $mutex = new FSLock('unittest');

        $fileLock = $mutex->getPath();
        $mutex->destroy();

        $this->assertFalse($mutex->acquire());
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
        $mutex = new FSLock('unittest');
        $this->assertEquals('unittest', $mutex->id());
    }

    public function testReleaseUnlockedFile()
    {
        $mutex = new FSLock('unittest');
        $mutex->destroy();

        $lock = new ReflectionProperty($mutex, 'lock');
        $lock->setAccessible(true);

        $this->assertEquals(null, $lock->getValue($mutex));
        $this->assertTrue($mutex->release());
    }
}
