@echo off

:: Root directories
mkdir app
mkdir parallel_zero
mkdir statics

:: App subdirectories
mkdir app\config
mkdir app\controllers
mkdir app\models
mkdir app\views
mkdir app\libs
mkdir app\tests
mkdir app\middlewares
mkdir app\cache
mkdir app\logs
mkdir app\seeds
mkdir app\docs
mkdir app\public
mkdir app\vendor
mkdir app\cli
mkdir app\libs\validations

:: Parallel_zero subdirectories
mkdir parallel_zero\core
mkdir parallel_zero\libs
mkdir parallel_zero\cli
mkdir parallel_zero\libs\validations

:: Statics subdirectories
mkdir statics\css
mkdir statics\js
mkdir statics\img

:: Done
echo Structure has been created.
