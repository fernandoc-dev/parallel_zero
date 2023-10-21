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
     * @var array Associative array to store registered routes and their corresponding handlers.
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
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $pattern URI path pattern.
     * @param mixed $handler Callable function or Controller@Method string.
     *
     * @return void
     */
    public function addRoute(string $method, string $pattern, $handler): void
    {
        $this->routes[] = [$method, $pattern, $handler];
    }

    /**
     * Route the request to the appropriate handler based on the path.
     *
     * @param string $method HTTP method.
     * @param string $uri Request URI.
     *
     * @return void
     */
    public function route(string $method, string $uri): void
    {
        foreach ($this->routes as [$routeMethod, $routePattern, $routeHandler]) {
            if ($routeMethod === $method) {
                $pattern = '@^' . preg_replace('/{([a-zA-Z0-9_]+)}/', '(?P<\1>[a-zA-Z0-9_\-]+)', $routePattern) . '$@';
                if (preg_match($pattern, $uri, $matches)) {
                    foreach ($matches as $key => $match) {
                        if (is_numeric($key)) {
                            unset($matches[$key]);
                        }
                    }
                    if (is_callable($routeHandler)) {
                        call_user_func_array($routeHandler, $matches);
                    } elseif (is_string($routeHandler)) {
                        $this->handleControllerAction($routeHandler, $matches);
                    }
                    return;
                }
            }
        }
        http_response_code(404);
        echo '404 Not Found';
    }

    /**
     * Handles routing to a controller's method.
     *
     * @param string $handler Controller@Method string.
     * @param array $params Parameters from the URL.
     *
     * @return void
     */
    private function handleControllerAction(string $handler, array $params = []): void
    {
        [$controller, $method] = explode('@', $handler);
        $controllerFqn = "App\\Controllers\\{$controller}";

        if (class_exists($controllerFqn)) {
            $controllerInstance = new $controllerFqn($this->container);
            if (method_exists($controllerInstance, $method)) {
                call_user_func_array([$controllerInstance, $method], $params);
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

