FSLock
==========

[![Build Status](https://travis-ci.org/yriveiro/php-FSLock.png?branch=master)](https://travis-ci.org/yriveiro/php-FSLock)
[![Coverage Status](https://coveralls.io/repos/yriveiro/php-FSLock/badge.png)](https://coveralls.io/r/yriveiro/php-FSLock)

A simple lock implementation using flock.

Usage
-----

```PHP

use FSLock\FSLock;

$lock = new FSLock('test');
$lock->acquire();

// Critical code.

$lock->release();

