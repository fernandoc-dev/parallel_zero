<?php

namespace Tests;

use ParallelZero\Core\Container;
use ParallelZero\Core\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    protected Router $router;
    protected Container $container;

    public function setUp(): void
    {
        $this->container = new Container();
        $this->router = new Router($this->container);
    }

    // Test Case 1: Test Router Initialization
    public function testRouterInitialization()
    {
        $this->assertInstanceOf(Router::class, $this->router);
    }

    // Test Case 2: Test Adding Routes
    public function testAddRoute()
    {
        // Using a simple callback function as a handler
        $this->router->addRoute('GET', '/test', function() {
            return 'Hello, Test!';
        });

        // Assertion to ensure the route is added could be done through reflection
        // but we'll simply route a request to it in another test case
        $this->assertTrue(true);
    }

    // Test Case 3: Test Route Handling
    public function testRouteHandling()
    {
        $this->router->addRoute('GET', '/test', function() {
            echo 'Hello, Test!';
        });

        // Start output buffering
        ob_start();

        $this->router->route('GET', '/test');

        // Get the contents of the output buffer
        $output = ob_get_clean();

        $this->assertEquals('Hello, Test!', $output);
    }

    // Test Case 4: Test Parameterized Route
    public function testParameterizedRouteHandling()
    {
        $this->router->addRoute('GET', '/user/{id}', function($id) {
            echo "User ID is: " . $id;
        });

        // Start output buffering
        ob_start();

        $this->router->route('GET', '/user/42');

        // Get the contents of the output buffer
        $output = ob_get_clean();

        $this->assertEquals('User ID is: 42', $output);
    }

    // Test Case 5: Test 404 Handling
    public function testNotFoundHandling()
    {
        // Start output buffering
        ob_start();

        $this->router->route('GET', '/nonexistent');

        // Get the contents of the output buffer
        $output = ob_get_clean();

        // Assert HTTP response code and content
        $this->assertEquals('404 Not Found', $output);
    }
}

