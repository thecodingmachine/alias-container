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

    public function testGet()
    {
        /** @var ContainerInterface|MockObject */
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())
            ->method('get')
            ->with('instance')
            ->willReturn('value');

        $aliasContainer = new AliasContainer($container, [
            'alias' => 'instance',
        ]);

        $this->assertEquals('value', $aliasContainer->get('alias'));
    }

    public function testGetException()
    {
        /** @var ContainerInterface|MockObject */
        $container = $this->createMock(ContainerInterface::class);

        $aliasContainer = new AliasContainer($container, []);

        $this->expectException(AliasContainerNotFoundException::class);
        $aliasContainer->get('nonexistant');
    }

    public function testHas()
    {
        /** @var ContainerInterface|MockObject */
        $container = $this->createMock(ContainerInterface::class);
        $container->method('has')
            ->willReturnCallback(function ($id) {
                return $id == 'instance';
            });

        $aliasContainer = new AliasContainer($container, [
            'alias' => 'instance',
        ]);

        $this->assertTrue($aliasContainer->has('alias'));
        $this->assertFalse($aliasContainer->has('alias2'));
    }
}
