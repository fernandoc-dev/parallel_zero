<?php
// parallel_zero/core/Logger.php

namespace ParallelZero\Core;

class Logger
{
    private string $logFile;
    private bool $displayErrors;

    public function __construct(string $logFile = 'app/logs/error.log', bool $displayErrors = false)
    {
        $this->logFile = $logFile;
        $this->displayErrors = $displayErrors;
    }

    public function logError($errno, $errstr, $errfile, $errline)
    {
        $errorMessage = "[" . date('Y-m-d H:i:s') . "] Error: [{$errno}] {$errstr} - {$errfile} on line {$errline}\n";
        error_log($errorMessage, 3, $this->logFile);

        if ($this->displayErrors) {
            echo $errorMessage;
        }
    }

    public function logException($exception)
    {
        $errorMessage = "[" . date('Y-m-d H:i:s') . "] Exception: {$exception->getMessage()} in {$exception->getFile()} on line {$exception->getLine()}\n";
        error_log($errorMessage, 3, $this->logFile);

        if ($this->displayErrors) {
            echo $errorMessage;
        }
    }
}