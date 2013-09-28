FSLock
==========

[![Build Status](https://travis-ci.org/yriveiro/php-FSLock.png?branch=master)](https://travis-ci.org/yriveiro/php-FSLock)

A simple lock implementation using flock.

Usage
-----

```PHP

use FSLock\FSLock;

$lock = new FSLock('test');
$lock->acquire();

// Critical code.

$lock->release();

