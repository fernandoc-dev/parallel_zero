<?php

namespace Tests;

use ParallelZero\Core\Container;
use ParallelZero\Core\Database\Connection;
use ParallelZero\Core\Model;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    private Container $container;
    private Connection $db;
    private Model $model;

    protected function setUp(): void
    {
        $this->container = new Container();
        // TODO: Configure your container and database connection here
        $this->db = $this->container->load('db', Connection::class); // Replace with your actual setup

        // Create test_table if it doesn't exist
        $createTableSQL = "CREATE TABLE IF NOT EXISTS test_table (id INT PRIMARY KEY, name VARCHAR(255), age INT);";
        $this->db->executeModifyQuery($createTableSQL, []);

        $this->model = new Model($this->container, 'test_table');
    }

    public function testCreate()
    {
        $data = [
            'id' => 1,
            'name' => 'John',
            'age' => 30
        ];
        $result = $this->model->create($data);
        $this->assertTrue($result);
    }

    public function testRead()
    {
        // First, create a record to read
        $data = [
            'id' => 1,
            'name' => 'John',
            'age' => 30
        ];
        $this->model->create($data);

        // Now, read the record
        $where = 'id = :id';
        $params = ['id' => 1];
        $result = $this->model->read($where, $params);
        $this->assertNotEmpty($result);
    }

    public function testUpdate()
    {
        $data = ['name' => 'Jane'];
        $where = 'id = :id';
        $params = ['id' => 1];
        $result = $this->model->update($data, $where, $params);
        $this->assertTrue($result);
    }

    public function testDelete()
    {
        $where = 'id = :id';
        $params = ['id' => 1];
        $result = $this->model->delete($where, $params);
        $this->assertTrue($result);
    }

    public function testFailCreateWithInvalidData()
    {
        $data = [];  // Empty array
        $result = $this->model->create($data);
        $this->assertFalse($result);
    }

    protected function tearDown(): void
    {
        // Cleanup: Remove test_table
        $dropTableSQL = "DROP TABLE IF EXISTS test_table;";
        $this->db->executeModifyQuery($dropTableSQL, []);
    }
}
