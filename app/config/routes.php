<?php
// app/config/routes.php

// No require is needed if you are using Composer autoloading

use ParallelZero\Core\Router; // Updated namespace to align with new directory structure

/**
 * Initializes application routes.
 *
 * @param Router $router Router instance.
 */
function initializeRoutes(Router $router): void {
    $router->addRoute('GET', '/', 'ExampleController@index');
    $router->addRoute('GET', '/create-user', 'ExampleController@create_user');
    $router->addRoute('GET', '/read-user/{id}', 'ExampleController@read_user');
    $router->addRoute('GET', '/read-user', 'ExampleController@read_user');
    $router->addRoute('GET', '/update-user/{id}', 'ExampleController@update_user');
    $router->addRoute('GET', '/delete-user/{id}', 'ExampleController@delete_user');
}


