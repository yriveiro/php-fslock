<?php
namespace FSLock;

class FSLock implements FSLockInterface
{
    /**
     * Lock id.
     *
     * @var string
     */
    protected $lockID;

    /**
     * The resource linked to current lock.
     *
     * @var resource|null
     */
    protected $lock;

    /**
     * Temporal folder to store lock files.
     *
     * @var string
     */
    protected $lockBucket;

    /**
     * @param string      $lockID the id of the lock with want to work, if not
     *                            exists a new resource is created
     * @param string|null $bucket the directory to store the locks
     *
     * @throws RuntimeException if temporal folder lockBucket is not writable
     */
    public function __construct(string $lockID, $bucket = null)
    {
        $this->lockID = $lockID;
        $this->lockBucket = $bucket ?: sys_get_temp_dir();
        $lockFile = sprintf('%s/%s.fslock', $this->lockBucket, $this->lockID);

        $this->lock = @fopen($lockFile, 'c');

        if ($this->lock === false) {
            throw new FSLockIOException("$bucket is not writable");
        }
    }

    /**
     * Clean up.
     */
    public function __destruct()
    {
        if (is_resource($this->lock)) {
            flock($this->lock, LOCK_UN);
            fclose($this->lock);

            $this->lock = null;
        }
    }

    /**
     * Acquires the lock.
     *
     * @param bool $blocker if the lock is acquire by other process before,
     *                      and we call acquire as blocker, this call blocks
     *                      after previous acquire release the lock
     *
     * @return bool
     */
    public function acquire(bool $blocker = false): bool
    {
        if (!is_resource($this->lock)) {
            return false;
        }

        return flock($this->lock, ($blocker) ? LOCK_EX : LOCK_EX | LOCK_NB);
    }

    /**
     * Releases the lock.
     *
     * @return bool
     */
    public function release(): bool
    {
        if (!is_resource($this->lock)) {
            return true;
        }

        return flock($this->lock, LOCK_UN);
    }

    /**
     * Returns the lock id.
     *
     * @return string
     */
    public function id(): string
    {
        return $this->lockID;
    }

    /**
     * Returns the lock path.
     *
     * @return string
     */
    public function getPath(): string
    {
        return "$this->lockBucket/$this->lockID.fslock";
    }
}
