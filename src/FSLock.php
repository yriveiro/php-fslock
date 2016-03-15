<?php
namespace FSLock;

class FSLock implements FSLockInterface
{
    /**
     * Lock id
     *
     * @var string
     */
    protected $lockID;

    /**
     * The resource linked to current lock
     *
     * @var resource
     */
    protected $lock;

    /**
     * Temporal folder to store lock files
     *
     * @var string
     */
    protected $lockBucket;

    /**
     * @param string $lockID The id of the lock with want to work, if not exists
     *                       a new resource is created.
     */
    public function __construct($lockID)
    {
        $this->lockID = $lockID;
        $this->lockBucket = sys_get_temp_dir();
        $lockFile = sprintf("%s/%s.fslock", $this->lockBucket, $this->lockID);

        $this->lock = fopen($lockFile, 'c');
    }

    /**
     * Destructor method. Internally calls FSLock::destroy()
     */
    public function __destruct()
    {
        $this->destroy();
    }

    /**
     * Acquires the lock
     *
     * @param boolean $blocker If the lock is acquire by other process before,
     *                         and we call acquire as blocker, this call blocks
     *                         after previous acquire release the lock.
     *
     * @return boolean
     */
    public function acquire($blocker = false)
    {
        if (!is_resource($this->lock)) {
            return false;
        }

        return flock($this->lock, ($blocker) ? LOCK_EX : LOCK_EX | LOCK_NB);
    }

    /**
     * Releases the lock
     *
     * @return boolean
     */
    public function release()
    {
        if (!is_resource($this->lock)) {
            return true;
        }

        return flock($this->lock, LOCK_UN);
    }

    /**
     * Destroy the lock manually
     */
    public function destroy()
    {
        if (is_resource($this->lock)) {
            flock($this->lock, LOCK_UN);
            fclose($this->lock);
            $this->lock = null;
        }
    }

    /**
     * Returns the lock id
     *
     * @return string
     */
    public function id()
    {
        return $this->lockID;
    }

    /**
     * Returns the lock path
     *
     * @return string
     */
    public function getPath()
    {
        return sprintf("%s/%s.fslock", $this->lockBucket, $this->lockID);
    }
}
