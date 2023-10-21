<?php

namespace ParallelZero\Core;

use ParallelZero\Core\Database\Connection;

/**
 * Class Model
 * A base model for CRUD operations in the database.
 */
class Model
{
    protected Container $container;
    protected ?Connection $db = null;
    protected string $table;

    /**
     * Constructor to initialize container and table.
     *
     * @param Container $container
     * @param string $table
     */
    public function __construct(Container $container, string $table)
    {
        $this->container = $container;
        $this->table = $table;
    }

    /**
     * Get database connection.
     *
     * @return Connection
     */
    protected function getDb(): Connection
    {
        if ($this->db === null) {
            $this->db = $this->container->load('db', Connection::class);
        }
        return $this->db;
    }

    /**
     * Create new record.
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $fields = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";

        return $this->getDb()->executeModifyQuery($query, $data);
    }

    /**
     * Read records.
     *
     * @param string $where
     * @param array $params
     * @return array
     */
    public function read(string $where = '', array $params = []): array
    {
        $query = "SELECT * FROM {$this->table}";
        if (!empty($where)) {
            $query .= " WHERE " . $where;
        }
        return $this->getDb()->fetchQuery($query, $params);
    }

    /**
     * Update record.
     *
     * @param array $data
     * @param string $where
     * @param array $params
     * @return bool
     */
    public function update(array $data, string $where, array $params = []): bool
    {
        $setFields = implode(', ', array_map(fn ($key) => "$key = :$key", array_keys($data)));
        $query = "UPDATE {$this->table} SET {$setFields}";
        if (!empty($where)) {
            $query .= " WHERE " . $where;
        }
        return $this->getDb()->executeModifyQuery($query, array_merge($data, $params));
    }

    /**
     * Delete record.
     *
     * @param string $where
     * @param array $params
     * @return bool
     */
    public function delete(string $where, array $params): bool
    {
        $query = "DELETE FROM {$this->table}";
        if (!empty($where)) {
            $query .= " WHERE " . $where;
        }
        return $this->getDb()->executeModifyQuery($query, $params);
    }
}
