<?php
// src/Database/Connection.php
namespace ParallelZero\Core\Database;

use PDO;
use PDOException;

class Connection {
    private static $instance = null;
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    // Method to fetch data from the database
    public function fetchQuery(string $query, array $params = []): array {
        $stmt = $this->pdo->prepare($query);
        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to modify data in the database
    public function executeModifyQuery(string $query, array $params = []): bool {
        $stmt = $this->pdo->prepare($query);
        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        return $stmt->execute();
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }
}
