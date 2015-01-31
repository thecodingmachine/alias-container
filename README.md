Alias-Container
===============
[![Latest Stable Version](https://poser.pugx.org/mouf/alias-container/v/stable.svg)](https://packagist.org/packages/mouf/alias-container)
[![Latest Unstable Version](https://poser.pugx.org/mouf/alias-container/v/unstable.svg)](https://packagist.org/packages/mouf/alias-container)
[![License](https://poser.pugx.org/mouf/alias-container/license.svg)](https://packagist.org/packages/mouf/alias-container)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodingmachine/alias-container/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/thecodingmachine/alias-container/?branch=1.0) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/04f9f269-db42-4a3b-9cf9-1fd41aac2e8a/mini.png)](https://insight.sensiolabs.com/projects/04f9f269-db42-4a3b-9cf9-1fd41aac2e8a)
[![Build Status](https://travis-ci.org/thecodingmachine/alias-container.svg?branch=1.0)](https://travis-ci.org/thecodingmachine/alias-container)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/alias-container/badge.svg?branch=1.0)](https://coveralls.io/r/thecodingmachine/alias-container?branch=1.0)

This package contains a really minimalist dependency injection container that can be used to **create aliases** of instances
in existing containers. Alias-container is compatible with [container-interop](https://github.com/container-interop/container-interop)
and is meant to be used in conjunction with other containers. By itself, Alias-container does not store any entry. It can only be used
to **create aliases of instances stored in other containers**.

You can use AliasContainer to add support for alias for any container that does not support this feature.

Installation
------------

Before using AliasContainer in your project, add it to your `composer.json` file:

```
$ ./composer.phar require mouf/alias-container ~1.0
```


Defining aliases in the container
---------------------------------

Creating an alias container is a matter of creating an `AliasContainer` instance.
The `AliasContainer` class takes 2 parameters:

- a [delegate-lookup container](https://github.com/container-interop/container-interop/blob/master/docs/Delegate-lookup.md) (e.g. the container we will look aliases into)
- the list of aliases, as an **associative array of strings**

```php
use Mouf\AliasContainer;
use Interop\Container\ContainerInterface;

$aliasContainer = new AliasContainer($rootContainer, [
	"myAlias"=>"myInstance",
	"myAlias2"=>"myInstance2"
]);
```

The list of entries is an associative array.

- The key is the identifier of the alias to create
- The value is the identifier of the entry that will be aliased

Fetching entries from the container
-----------------------------------

Fetching entries from the container is as simple as calling the `get` method:

```php
$myInstance = $aliasContainer->get('myAlias');
```

Adding aliases to the container
-------------------------------

You can add new aliases using the `set` method.

```php
$aliasContainer->set('newAlias', 'myInstance');
```

<div class="alert alert-info">Note that it is more efficient to initialize aliases in the container
than calling recursively the <code>set</code> method.</div>

Removing aliases from the container
-----------------------------------

You can add new aliases using the `remove` method.

```php
$aliasContainer->remove('myAlias');
```

Why the need for this package?
------------------------------

This package is part of a long-term effort to bring [interoperability between DI containers](https://github.com/container-interop/container-interop). The ultimate goal is to
make sure that multiple containers can communicate together by sharing entries (one container might use an entry from another
container, etc...)
