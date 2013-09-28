<?php

namespace tests\src\FSLock;

use Exception;
use \FSLock\FSLock;
use PHPUnit_Framework_TestCase;

class FSLockTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->lockBucket = sys_get_temp_dir();
	}

	public function testCreateFSLock()
	{
		$lock = new FSLock('unittest');
		$this->assertEquals($this->lockBucket . '/' . 'unittest.fslock', $lock->getPath());
		unset($lock);
	}

	public function testAdquire()
	{
		$lock = new FSLock('unittest');
		$lockFile = fopen($lock->getPath(), 'a');

		$this->assertTrue($lock->adquire());
		$this->assertFalse(flock($lockFile, LOCK_EX | LOCK_NB));
		$this->assertTrue($lock->release());
		$this->assertTrue(flock($lockFile, LOCK_EX | LOCK_NB));

		unset($lock);
	}

	public function testRelease()
	{
		$lock = new FSLock('unittest');
		$lockFile = fopen($lock->getPath(), 'a');

		$this->assertTrue($lock->adquire());
		$this->assertFalse(flock($lockFile, LOCK_EX | LOCK_NB));
		$this->assertTrue($lock->release());
		$this->assertTrue(flock($lockFile, LOCK_EX | LOCK_NB));

		unset($lock);
	}

	public function testGetFSLockID()
	{
		$lock = new FSLock('unittest');

		$this->assertEquals('unittest', $lock->id());

		unset($lock);
	}
}