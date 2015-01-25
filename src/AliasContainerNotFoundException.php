<?php
namespace Mouf\AliasContainer;

use Interop\Container\Exception\NotFoundException;

/**
 * This exception is thrown when an identifier is passed to AliasContainer and is not found.
 *
 * @author David Négrier <david@mouf-php.com>
 */
class AliasContainerNotFoundException extends \InvalidArgumentException implements NotFoundException
{
}
