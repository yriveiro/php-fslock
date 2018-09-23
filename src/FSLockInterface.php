<?php
namespace FSLock;

interface FSLockInterface
{
    public function id(): string;

    public function release(): bool;

    public function destroy(): FSLock;

    public function getPath(): string;

    public function acquire(bool $blocker = false): bool;
}
