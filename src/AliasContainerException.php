<?php
namespace Mouf\AliasContainer;

use Interop\Container\Exception\NotFoundException;

/**
 * This exception is thrown when something goes wrong with dependency lookups of aliases.
 *
 * @author David Négrier <david@mouf-php.com>
 */
class AliasContainerException implements NotFoundException
{
}
