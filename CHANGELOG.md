# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## 3.0.0 - 2018-10-01

- Bump minimal PHP version to 7.x.
- Declare explicit return values in methods.
- Destroy method removed, after call destroy method, the instance is useless and
it can not be initialized again.
- Allow lock bucket to be configurable when FSLock instance it's declared.


## 2.0.0 - 2016-01-31

### Added
- New method destroy, allows manually destruction of the lock. Internally release the lock and perform a cleanup operation. It's the same process used by the `__destruct` magic method.
- FSLock now implements FSLockInterface.

### Changed
- Improve test suit.
- Update PSR-0 autoload to PSR-4 format.
- Update README.
