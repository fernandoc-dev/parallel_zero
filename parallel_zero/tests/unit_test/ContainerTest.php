<?php
namespace ParallelZero\Tests;

use ParallelZero\Core\Container;
use ParallelZero\Exceptions\ContainerException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testSetAndGetService()
    {
        $container = new Container();
        
        $service = new \stdClass;
        $service->name = 'TestService';

        $container->set('testService', $service);
        
        $retrievedService = $container->get('testService');
        
        $this->assertSame($service, $retrievedService);
    }

    public function testServiceNotFound()
    {
        $this->expectException(ContainerException::class);

        $container = new Container();
        $container->get('nonExistentService');
    }

    public function testServiceClosureIsResolved()
    {
        $container = new Container();
        
        $container->set('closureService', function () {
            $service = new \stdClass;
            $service->name = 'ClosureService';
            return $service;
        });
        
        $retrievedService = $container->get('closureService');
        
        $this->assertInstanceOf(\stdClass::class, $retrievedService);
        $this->assertSame('ClosureService', $retrievedService->name);
    }

    public function testFactoryMethod()
    {
        $container = new Container();

        $container->factory('factoryService', function () {
            $service = new \stdClass;
            $service->name = 'FactoryService';
            return $service;
        });

        $instance1 = $container->make('factoryService');
        $instance2 = $container->make('factoryService');

        $this->assertNotSame($instance1, $instance2);
        $this->assertSame('FactoryService', $instance1->name);
        $this->assertSame('FactoryService', $instance2->name);
    }

    public function testFactoryNotFound()
    {
        $this->expectException(ContainerException::class);

        $container = new Container();
        $container->make('nonExistentFactory');
    }
}
