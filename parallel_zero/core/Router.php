<?php

namespace ParallelZero\Core;

/**
 * Class Router
 * Manages the routing logic for incoming HTTP requests,
 * and maps them to corresponding handlers.
 *
 * @package ParallelZero\Core
 */
class Router
{
    /**
     * @var array<string, mixed> Associative array to store registered routes and their corresponding handlers.
     */
    private array $routes = [];

    /**
     * @var Container Dependency Injection Container instance.
     */
    private Container $container;

    /**
     * Router constructor.
     *
     * @param Container $container Dependency injection container.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Add a new route to the router.
     *
     * @param string $path URI path.
     * @param mixed $handler Callable function or Controller@Method string.
     *
     * @return void
     */
    public function addRoute(string $path, $handler): void
    {
        $this->routes[$path] = $handler;
    }

    /**
     * Route the request to the appropriate handler based on the path.
     *
     * @param string $path URI path.
     *
     * @return void
     */
    public function route(string $path): void
    {
        if (array_key_exists($path, $this->routes)) {
            $handler = $this->routes[$path];
            if (is_callable($handler)) {
                call_user_func($handler);
            } elseif (is_string($handler)) {
                $this->handleControllerAction($handler);
            }
        } else {
            http_response_code(404);
            echo '404 Not Found';
        }
    }

    /**
     * Handles routing to a controller's method.
     *
     * @param string $handler Controller@Method string.
     *
     * @return void
     */
    private function handleControllerAction(string $handler): void
    {
        [$controller, $method] = explode('@', $handler);
        $controllerFqn = "App\\Controllers\\{$controller}";

        if (class_exists($controllerFqn)) {
            $controllerInstance = new $controllerFqn($this->container);

            if (method_exists($controllerInstance, $method)) {
                $controllerInstance->$method();
            } else {
                http_response_code(500);
                echo "Error: Method {$method} not found in controller {$controllerFqn}";
            }
        } else {
            http_response_code(500);
            echo "Error: Controller {$controllerFqn} not found";
        }
    }
}
