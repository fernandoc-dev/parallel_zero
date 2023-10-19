<?php

namespace ParallelZero\Core;

use ParallelZero\Core\Database\Connection;

/**
 * Class Model
 * A base model class for interacting with the database.
 *
 * @package ParallelZero\Core
 */
class Model
{
    /**
     * @var Container Dependency Injection Container instance.
     */
    protected Container $container;

    /**
     * @var Connection|null Database connection instance.
     */
    protected ?Connection $db = null;

    /**
     * @var string Table name.
     */
    protected string $table;

    /**
     * Model constructor.
     *
     * @param Container $container Dependency injection container.
     * @param string $table Table name.
     */
    public function __construct(Container $container, string $table)
    {
        $this->container = $container;
        $this->table = $table;
    }

    /**
     * Lazy-load database connection.
     *
     * @return Connection The database connection.
     */
    protected function getDb(): Connection
    {
        if ($this->db === null) {
            $this->db = $this->container->load('db', Connection::class);
        }
        return $this->db;
    }

    /**
     * Create a new record in the database.
     *
     * @param array $data The data to insert.
     * @return array The result of the query.
     */
    public function create(array $data): array
    {
        $fields = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        return $this->getDb()->executeQuery($query, $data);
    }

    /**
     * Read records from the database.
     *
     * @param string $where Optional WHERE clause.
     * @param array $params Parameters for the WHERE clause.
     * @return array The result of the query.
     */
    public function read(string $where = '', array $params = []): array
    {
        $query = "SELECT * FROM {$this->table} " . $where;
        return $this->getDb()->executeQuery($query, $params);
    }

    /**
     * Update a record in the database.
     *
     * @param array $data The data to update.
     * @param string $where WHERE clause.
     * @param array $params Parameters for the WHERE clause.
     * @return array The result of the query.
     */
    public function update(array $data, string $where, array $params = []): array
    {
        $setFields = '';
        foreach ($data as $field => $value) {
            $setFields .= "{$field}=:{$field},";
        }
        $setFields = rtrim($setFields, ',');

        $query = "UPDATE {$this->table} SET {$setFields} WHERE {$where}";
        return $this->getDb()->executeQuery($query, array_merge($data, $params));
    }

    /**
     * Delete a record from the database.
     *
     * @param string $where WHERE clause.
     * @param array $params Parameters for the WHERE clause.
     * @return array The result of the query.
     */
    public function delete(string $where, array $params): array
    {
        $query = "DELETE FROM {$this->table} WHERE {$where}";
        return $this->getDb()->executeQuery($query, $params);
    }
}