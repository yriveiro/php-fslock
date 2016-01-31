<?php

namespace FSLock;

interface FSLockInterface
{
    public function id();
    public function release();
    public function destroy();
    public function getPath();
    public function acquire($blocker = false);
}
