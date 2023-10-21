<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ParallelZero\Core\Container;
use ParallelZero\Core\Controller;

// Extend Controller to expose protected methods for testing.
class TestableController extends Controller
{
    public function exposeModel(string $model): object
    {
        return $this->model($model);
    }

    public function exposeView(string $view, array $data = []): void
    {
        $this->view($view, $data);
    }
}

class ControllerTest extends TestCase
{
    protected $container;
    protected $controller;

    public function setUp(): void
    {
        // Mocking the Container dependency.
        $this->container = $this->createMock(Container::class);
        // Creating an instance of the TestableController.
        $this->controller = new TestableController($this->container);
    }

    public function testConstruct(): void
    {
        // Ensure the object is instantiated properly.
        $this->assertInstanceOf(Controller::class, $this->controller);
    }

    public function testModelMethod(): void
    {
        // Assuming you have a mock model class 'App\Models\TestModel'.
        // If the Container class has a 'load' method, it will never be called.
        $this->container->expects($this->never())->method('load');

        // Test that the model method returns an instance of the expected class.
        $model = $this->controller->exposeModel('TestModel');
        $this->assertInstanceOf('App\\Models\\TestModel', $model);
    }

    public function testViewMethod(): void
    {
        // Testing view method is a bit tricky because it involves output and file handling.
        // This would only work if you actually have a view file 'mockView.php' at the proper location.
        ob_start();
        $this->controller->exposeView('mockView', ['name' => 'John']);
        $output = ob_get_clean();
        
        // Assuming 'mockView.php' does something like `echo $name;`
        $this->assertEquals('John', $output);
    }
}
