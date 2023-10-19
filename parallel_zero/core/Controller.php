<?php

namespace ParallelZero\Core;

use ParallelZero\Core\Container;

/**
 * Class Controller
 * Base controller for handling views and models.
 *
 * @package ParallelZero\Core
 */
class Controller
{
    /**
     * @var Container Dependency injection container.
     */
    protected Container $container;

    /**
     * Controller constructor.
     *
     * @param Container $container Dependency injection container.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Create and return a new model instance.
     *
     * @param string $model The model class to instantiate.
     * @return object The instantiated model.
     */
    protected function model(string $model): object
    {
        $model = "App\\Models\\" . $model;
        return new $model($this->container);
    }

    /**
     * Load a view file and pass optional data to it.
     *
     * @param string $view The view to load.
     * @param array $data Optional data to pass to the view.
     * @return void
     */
    protected function view(string $view, array $data = []): void
    {
        // Convert array keys to variables. For example, ['name' => 'Fernando'] becomes $name = 'Fernando'.
        extract($data);

        // Load the corresponding view file.
        require_once "app/views/{$view}.php";
    }
}
