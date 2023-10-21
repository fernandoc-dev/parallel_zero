<?php
// parallel_zero/tests/unit_test/LoggerTest.php

namespace Tests;

use ParallelZero\Core\Logger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    private $logFile = 'app/logs/test_error.log';
    private $logger;

    protected function setUp(): void
    {
        // Reset log file
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }

        // Instantiate Logger
        $this->logger = new Logger($this->logFile, true);
    }

    public function testLogError()
    {
        // Generate a sample error
        $errno = 1;
        $errstr = 'Test Error';
        $errfile = 'test.php';
        $errline = 20;

        // Call logError method
        $this->logger->logError($errno, $errstr, $errfile, $errline);

        // Assert the log file is created
        $this->assertFileExists($this->logFile);

        // Assert the content of the log file
        $logContents = file_get_contents($this->logFile);
        $this->assertStringContainsString($errstr, $logContents);
    }

    public function testLogException()
    {
        // Generate a sample exception
        $exception = new \Exception('Test Exception', 1);

        // Call logException method
        $this->logger->logException($exception);

        // Assert the log file is created
        $this->assertFileExists($this->logFile);

        // Assert the content of the log file
        $logContents = file_get_contents($this->logFile);
        $this->assertStringContainsString('Test Exception', $logContents);
    }

    public function testDisplayErrors()
    {
        $this->expectOutputRegex("/Exception: Test Exception in " . preg_quote(__FILE__, '/') . " on line \d+\n/");

        // Generate a sample exception
        $exception = new \Exception('Test Exception', 1);

        // Call logException method
        $this->logger->logException($exception);
    }
}
