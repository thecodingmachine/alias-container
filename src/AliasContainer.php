<?php
namespace Mouf\AliasContainer;

use Interop\Container\ContainerInterface;

/**
 * The Alias Container is a simple container that enables the creation of aliases for an existing container.
*  It follows the `ContainerInterface` and ArrayAccess interfaces.
 * The container can be seeded with an array or array-like object containing the aliases, and a container
 * to fetch the entries from. The "get" functionality will follow the declared aliases.
 * If no alias is defined an exception is thrown.
 */
class AliasContainer implements ContainerInterface
{
    /**
     * @var array|\ArrayAccess The aliases
     */
    protected $aliases;

    /**
     * @var ContainerInterface The container that will be used for lookups
     */
    protected $rootContainer;

    /**
     * @param ContainerInterface $rootContainer The container that will be used for entries lookups.
     * @param array|\ArrayAccess|\Traversable $aliases Data for the container
     *
     * @throws \InvalidArgumentException if the provided data is not an array or array-like object
     */
    public function __construct(ContainerInterface $rootContainer, $aliases = array())
    {
        if (is_array($aliases) || $aliases instanceof \ArrayAccess) {
            $this->aliases = $aliases;
        } elseif ($aliases instanceof \Traversable) {
            $this->aliases = iterator_to_array($aliases, true);
        } else {
            throw new \InvalidArgumentException('The AliasContainer requires either an array or an array-like object');
        }
        $this->rootContainer = $rootContainer;
    }

    public function get($id)
    {
        if (isset($this->aliases[$id])) {
            try {
                return $this->rootContainer->get($this->aliases[$id]);
            } catch (\Exception $prev) {
                throw new AliasContainerException("An error occured while fetching entry '".$id."' (alias of '".$this->aliases[$id]."'", 0, $prev);
            }
        } else {
            throw new AliasContainerNotFoundException("No alias found for identifier '".$id."'");
        }
    }

    public function has($identifier)
    {
        return isset($this->aliases[$identifier]);
    }

    /**
     * Sets a new alias.
     * 
     * @param string $identifier
     * @param string $alias
     */
	public function set($identifier, $alias) {
		$this->aliases[$identifier] = $alias;
	}
}
