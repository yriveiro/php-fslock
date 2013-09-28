FSLock
==========

[![Build Status](https://travis-ci.org/yriveiro/php-fslock.png?branch=master)](https://travis-ci.org/yriveiro/php-fslock)
[![Coverage Status](https://coveralls.io/repos/yriveiro/php-fslock/badge.png)](https://coveralls.io/r/yriveiro/php-fslock)

A simple lock implementation using flock.

Usage
-----

```PHP

use FSLock\FSLock;

$lock = new FSLock('test');
$lock->acquire();

// Critical code.

$lock->release();

