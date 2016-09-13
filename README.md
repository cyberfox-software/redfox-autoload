`Redfox PHP Framework - a lightweight library of useful snippets, classes and tools for fast and simplified software development`

Redfox - Class Autoload
=======================

The autoload component provides a facility to automatic load your classes without include the class files by yourself.

[![Build Status](https://api.travis-ci.org/cyberfox-software/redfox-autoload.svg)](https://api.travis-ci.org/cyberfox-software/redfox-autoload)

Installation
------------

Installation with [composer](https://getcomposer.org) as a dependency in your project:

```bash
composer require --dev cyberfox-software/redfox-autoload:*
```

Usage
-----

To use the automatic class loading feature, you simple have to add the following line of code(s) to your bootstrapping
file or class.

```php
( \Redfox\Autoload\ClassLoader(
    'My\Designated\Namespace', 
    'full qualified base directory to search the class files in') )->register();
```

Changelog
---------

See the [CHANGELOG](CHANGELOG.md) file.

License
-------

For the license and copyright see the [LICENSE](LICENSE) file.