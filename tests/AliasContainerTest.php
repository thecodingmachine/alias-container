<?php

namespace Mouf\AliasContainer;

use Mouf\AliasContainer\AliasContainer;
use Mouf\AliasContainer\AliasContainerNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * Test class for AliasContainer
 *
 * @author David Négrier <david@mouf-php.com>
 */
class AliasContainerTest extends TestCase
{
    /**
     * Test that get() method returns alias got from wrapped container.
     *
     * @return void
     */
    public function testGet()
    {
        /**
         * @var ContainerInterface|MockObject
        */
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())
            ->method('get')
            ->with('instance')
            ->willReturn('value');

        $aliasContainer = new AliasContainer(
            $container,
            array('alias' => 'instance')
        );

        $this->assertEquals('value', $aliasContainer->get('alias'));
    }

    /**
     * Test that get() throws AliasContainerNotFoundException
     * when alias is not specified.
     *
     * @return void
     */
    public function testGetException()
    {
        /**
         * @var ContainerInterface|MockObject
        */
        $container = $this->createMock(ContainerInterface::class);

        $aliasContainer = new AliasContainer($container, array());

        $this->expectException(AliasContainerNotFoundException::class);
        $aliasContainer->get('nonexistant');
    }

    /**
     * Test that has() returns true when alias is set.
     *
     * @return void
     */
    public function testHas()
    {
        /**
         * @var ContainerInterface|MockObject
        */
        $container = $this->createMock(ContainerInterface::class);
        $container->method('has')
            ->willReturnCallback(
                function ($id) {
                    return $id == 'instance';
                }
            );

        $aliasContainer = new AliasContainer(
            $container,
            array('alias' => 'instance')
        );

        $this->assertTrue($aliasContainer->has('alias'));
    }

    /**
     * Test that has() return false when alias is not set.
     *
     * @return void
     */
    public function testHasnt()
    {
        /**
         * @var ContainerInterface|MockObject
        */
        $container = $this->createMock(ContainerInterface::class);

        $aliasContainer = new AliasContainer($container, array());

        $this->assertFalse($aliasContainer->has('nonexistant'));
    }
}
