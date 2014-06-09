FSLock
==========

[![Build Status](https://travis-ci.org/yriveiro/php-fslock.png?branch=master)](https://travis-ci.org/yriveiro/php-fslock)
[![Coverage Status](https://coveralls.io/repos/yriveiro/php-fslock/badge.png)](https://coveralls.io/r/yriveiro/php-fslock)
[![Total Downloads](https://poser.pugx.org/yriveiro/php-fslock/downloads.svg)](https://packagist.org/packages/yriveiro/php-fslock)

A simple lock implementation using flock.

Usage
-----

```PHP

use FSLock\FSLock;

$lock = new FSLock('test');

if ($lock->acquire()) {
    // Critical code.

    $lock->release();
}
```

API
---

* **acquire**: Acquires the lock, returns _true_ if the operation was successful otherwise the return is _false_.
* **release**: Releases the lock, returns _true_ if the operation was successful otherwise the return is _false_.


Install
--------------

* Composer:

        "require": {
            "yriveiro/php-fslock": "0.1"
        }
