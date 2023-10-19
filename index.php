<?php
/**
 * Entry point of the ParallelZero application.
 * 
 * This script performs the following actions:
 * 1. Autoloads classes.
 * 2. Loads configuration files.
 * 3. Sets up error and exception handling based on the environment.
 * 4. Routes the incoming HTTP request.
 */

// Autoload classes from vendor and your project namespaces
require 'vendor/autoload.php';

// Load Configuration files
require 'app/config/database.php';
require 'app/config/config.php';
require 'app/config/routes.php';

use ParallelZero\Core\Container;
use ParallelZero\Core\Router;
use ParallelZero\Core\Logger;

/**
 * Initialize Dependency Injection Container
 * 
 * The container is used for managing object dependencies and performing 
 * dependency injection.
 */
$container = new Container();

// Error and Exception Handling
//------------------------------------------------------------
// Check if we are in a development environment
$isDevEnvironment = (ENVIRONMENT === 'development');

// Initialize the logger and register it into the container
$container->set('logger', new Logger('app/logs/error.log', $isDevEnvironment));

// Retrieve the logger instance from the container
$logger = $container->get('logger');

// Set custom error and exception handlers
set_error_handler([$logger, 'logError']);
set_exception_handler([$logger, 'logException']);

// Enable or disable error display based on the environment
if ($isDevEnvironment) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}
//------------------------------------------------------------

// Routing
//------------------------------------------------------------
/**
 * Instantiate the Router
 * 
 * The router is responsible for routing incoming HTTP requests to
 * the appropriate controller action.
 */
$router = new Router($container);

// Initialize the application routes
initializeRoutes($router);

// Get the request path and remove the base path, if necessary
$path = $_SERVER['REQUEST_URI'];
$path = str_replace(BASE_PATH, '', $path);

// Route the incoming HTTP request
$router->route($path);
//------------------------------------------------------------
