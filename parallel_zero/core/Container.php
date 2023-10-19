<?php

namespace ParallelZero\Core;

use ParallelZero\Exceptions\ContainerException;

/**
 * Class Container
 * A Dependency Injection Container to manage services and dependencies.
 * 
 * @package ParallelZero\Core
 */
class Container
{
    /**
     * Associative array for storing registered services and instances.
     * 
     * @var array
     */
    private array $services = [];

    /**
     * Associative array for storing factory closures.
     * 
     * @var array
     */
    private array $factories = [];

    /**
     * Register a service into the container.
     *
     * @param string $name Name of the service.
     * @param mixed $service The service instance or closure.
     * 
     * @return void
     */
    public function set(string $name, $service): void
    {
        $this->services[$name] = $service;
    }

    /**
     * Retrieve a service from the container.
     * Singleton services will only be instantiated once.
     *
     * @param string $name Name of the service.
     * 
     * @return mixed The instance of the registered service.
     * 
     * @throws ContainerException If the service is not registered.
     */
    public function get(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new ContainerException("Service {$name} not found");
        }

        if ($this->services[$name] instanceof \Closure) {
            $this->services[$name] = $this->services[$name]($this);
        }

        return $this->services[$name];
    }

    /**
     * Register and immediately retrieve a service instance.
     *
     * @param string $name Name of the service.
     * @param mixed $service The service instance or closure.
     * @param mixed ...$args Optional arguments to pass to the service constructor.
     * 
     * @return mixed The instance of the registered service.
     */
    public function load(string $name, $service, ...$args)
    {
        if (!isset($this->services[$name])) {
            $this->set($name, function () use ($service, $args) {
                return new $service(...$args);
            });
        }

        return $this->get($name);
    }

    /**
     * Register a factory closure into the container.
     *
     * @param string $name Name of the factory.
     * @param \Closure $factory The factory closure.
     * 
     * @return void
     */
    public function factory(string $name, \Closure $factory): void
    {
        $this->factories[$name] = $factory;
    }

    /**
     * Retrieve a new instance from a registered factory.
     *
     * @param string $name Name of the factory.
     * 
     * @return mixed A new instance of the service.
     * 
     * @throws ContainerException If the factory is not registered.
     */
    public function make(string $name)
    {
        if (!isset($this->factories[$name])) {
            throw new ContainerException("Factory {$name} not found");
        }

        return $this->factories[$name]($this);
    }
}
