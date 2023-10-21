<?php
// parallel_zero/tests/unit_tests/ConnectionTest.php

namespace ParallelZero\Tests;

use ParallelZero\Core\Database\Connection;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    public function testConnectionIsSingleton()
    {
        $conn1 = Connection::getInstance();
        $conn2 = Connection::getInstance();
        
        $this->assertSame($conn1, $conn2);
    }

    
}
