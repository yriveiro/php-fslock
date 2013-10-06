<?php
namespace FSLock;


class FSLock {

	protected $lockID;
	protected $lock;
	protected $lockBucket;

	public function __construct($lockID)
	{
		$this->lockID = $lockID;
		$this->lockBucket = sys_get_temp_dir();
		$this->lock = fopen(sprintf("%s/%s.fslock", $this->lockBucket, $this->lockID), 'c');
	}

	public function __destruct()
   	{
		flock($this->lock, LOCK_UN);
		fclose($this->lock);
	}

	public function acquire($blocker = false)
	{
		return flock($this->lock, ($blocker) ? LOCK_EX : LOCK_EX | LOCK_NB);
	}

	public function release()
   	{
		return flock($this->lock,LOCK_UN);
	}

	public function id()
	{
		return $this->lockID;
	}

	public function getPath()
	{
		return sprintf("%s/%s.fslock",	$this->lockBucket, $this->lockID);
	}
}