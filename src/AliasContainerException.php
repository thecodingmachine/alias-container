<?php
namespace Mouf\AliasContainer;

use Exception;
use Psr\Container\ContainerExceptionInterface;

/**
 * This exception is thrown when something goes wrong with dependency lookups of aliases.
 *
 * @author David Négrier <david@mouf-php.com>
 */
class AliasContainerException extends Exception implements ContainerExceptionInterface
{
}
