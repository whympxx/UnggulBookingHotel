<?php
/**
 * Database Provider
 * Handles database connections and operations
 */

class DatabaseProvider {
    private $connection;
    private $config = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'hotel_booking'
    ];
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->config['host']};dbname={$this->config['database']}",
                $this->config['username'],
                $this->config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            // For now, continue without database connection
            // In production, you might want to handle this differently
            $this->connection = null;
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        if (!$this->connection) {
            return false;
        }
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    public function find($table, $conditions = []) {
        $sql = "SELECT * FROM $table";
        $params = [];
        
        if (!empty($conditions)) {
            $where = array_map(fn($key) => "$key = :$key", array_keys($conditions));
            $sql .= " WHERE " . implode(' AND ', $where);
            $params = $conditions;
        }
        
        return $this->query($sql, $params);
    }
    
    public function insert($table, $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->query($sql, $data);
    }
    
    public function update($table, $data, $conditions) {
        $set = array_map(fn($key) => "$key = :$key", array_keys($data));
        $where = array_map(fn($key) => "$key = :where_$key", array_keys($conditions));
        
        $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE " . implode(' AND ', $where);
        
        $params = $data;
        foreach ($conditions as $key => $value) {
            $params["where_$key"] = $value;
        }
        
        return $this->query($sql, $params);
    }
    
    public function delete($table, $conditions) {
        $where = array_map(fn($key) => "$key = :$key", array_keys($conditions));
        $sql = "DELETE FROM $table WHERE " . implode(' AND ', $where);
        
        return $this->query($sql, $conditions);
    }
}
?>
