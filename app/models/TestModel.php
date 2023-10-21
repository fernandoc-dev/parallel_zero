<?php

namespace App\Models;

use ParallelZero\Core\Container;

/**
 * Class TestModel
 * Basic mock model for testing purposes.
 *
 * @package App\Models
 */
class TestModel
{
    /**
     * @var Container Dependency injection container.
     */
    protected Container $container;

    /**
     * TestModel constructor.
     *
     * @param Container $container Dependency injection container.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Dummy method for testing.
     *
     * @return string
     */
    public function greet(): string
    {
        return "Hello, this is TestModel.";
    }
}
