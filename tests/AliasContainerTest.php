<?php
namespace Mouf\Picotainer;

use Mouf\AliasContainer\AliasContainer;
/**
 * Test class for AliasContainer
 *
 * @author David Négrier <david@mouf-php.com>
 */
class AliasContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $container = new Picotainer([
                "instance" => function () { return "value"; },
        ]);
        $aliasContainer = new AliasContainer($container, [
        	"alias" => "instance",
        ]);
        

        $this->assertEquals('value', $aliasContainer->get('alias'));
    }

    /**
     *
     * @expectedException Mouf\AliasContainer\AliasContainerNotFoundException
     */
    public function testGetException()
    {
        $container = new Picotainer([
                "instance" => function () { return "value"; },
        ]);
    	$aliasContainer = new AliasContainer($container, []);

        $aliasContainer->get('nonexistant');
    }

    public function testOneInstanceOnly()
    {
        $container = new Picotainer([
                "instance" => function () { return "value"; },
        ]);
        $aliasContainer = new AliasContainer($container, [
        	"alias" => "instance",
        ]);
        

        $this->assertEquals($container->get('instance'), $aliasContainer->get('alias'));
    }

    public function testHas()
    {
        $container = new Picotainer([
                "instance" => function () { return "value"; },
        ]);
        $aliasContainer = new AliasContainer($container, [
        	"alias" => "instance",
        ]);
        
        $this->assertTrue($aliasContainer->has('alias'));
        $this->assertFalse($aliasContainer->has('alias2'));
    }
}
