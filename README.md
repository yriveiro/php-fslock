# FSLock

[![Build Status](https://travis-ci.org/yriveiro/php-fslock.png?branch=master)](https://travis-ci.org/yriveiro/php-fslock)
[![Coverage Status](https://coveralls.io/repos/yriveiro/php-fslock/badge.png)](https://coveralls.io/r/yriveiro/php-fslock)
[![Total Downloads](https://poser.pugx.org/yriveiro/php-fslock/downloads.svg)](https://packagist.org/packages/yriveiro/php-fslock)

A simple lock implementation using flock.

# Usage

```PHP

use FSLock\FSLock;

$lock = new FSLock('test');

if ($lock->acquire()) {
    // Critical code.

    $lock->release();
}
```

# API

- `acquire`: Acquires the lock, returns _true_ if the operation was successful otherwise the return is _false_.
- `release`: Releases the lock, returns _true_ if the operation was successful otherwise the return is _false_.
- `destroy`: allows manually destruction of the lock. Internally release the lock and perform a cleanup operation. It's the same process used by the `__destruct` magic method.
- `id`: returns the lock id.
- `getPath`: returns the lock path

# Install

The recommended way to install this package is through [Composer](http://getcomposer.org/download/).

```sh
composer require yriveiro/php-fslock:2.0.0
```

# Tests

Tests are performed using the `phpunit` library, to run them:

```sh
php vendor/bin/phpunit tests
```

# License

FSLock is licensed under MIT license.