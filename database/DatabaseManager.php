<?php

namespace Database;

use PDO;
use PDOException;

class DatabaseManager
{
    private static $instance = null;
    private $connection;
    private $query;
    private $table;
    private $select = '*';
    private $where = [];
    private $orderBy = [];
    private $limit;
    private $offset;
    private $bindings = [];
    
    /**
     * Private constructor for singleton pattern
     */
    private function __construct($dbPath = null)
    {
        $dbPath = $dbPath ?? __DIR__ . 'db/games.db';
        
        try {
            $this->connection = new PDO('sqlite:' . $dbPath);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Get singleton instance
     */
    public static function getInstance($dbPath = null)
    {
        if (self::$instance === null) {
            self::$instance = new self($dbPath);
        }
        
        return self::$instance;
    }
    
    /**
     * Get the PDO instance
     */
    public function getPDO()
    {
        return $this->connection;
    }
    
    /**
     * Execute raw SQL query
     */
    public function raw($sql, $params = [])
    {
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    
    /**
     * Select table to query
     */
    public function table($tableName)
    {
        $this->reset();
        $this->table = $tableName;
        return $this;
    }
    
    /**
     * Select specific columns
     */
    public function select($columns = '*')
    {
        $this->select = is_array($columns) ? implode(', ', $columns) : $columns;
        return $this;
    }
    
    /**
     * Add where clause
     */
    public function where($column, $operator = null, $value = null)
    {
        // Handle different parameter formats
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $this->where[] = "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }
    
    /**
     * Add whereIn clause
     */
    public function whereIn($column, array $values)
    {
        $placeholders = rtrim(str_repeat('?, ', count($values)), ', ');
        $this->where[] = "$column IN ($placeholders)";
        $this->bindings = array_merge($this->bindings, $values);
        return $this;
    }
    
    /**
     * Order results
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy[] = "$column $direction";
        return $this;
    }
    
    /**
     * Limit number of results
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
    
    /**
     * Skip results (offset)
     */
    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }
    
    /**
     * Get all results
     */
    public function get()
    {
        $this->buildQuery('select');
        $statement = $this->raw($this->query, $this->bindings);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get first result
     */
    public function first()
    {
        $this->limit(1);
        $results = $this->get();
        return $results ? $results[0] : null;
    }
    
    /**
     * Find by ID
     */
    public function find($id)
    {
        return $this->where('id', $id)->first();
    }
    
    /**
     * Insert record
     */
    public function insert(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = rtrim(str_repeat('?, ', count($data)), ', ');
        
        $this->query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $this->bindings = array_values($data);
        
        $statement = $this->raw($this->query, $this->bindings);
        return $this->connection->lastInsertId();
    }
    
    /**
     * Update records
     */
    public function update(array $data)
    {
        $setParts = [];
        $updateBindings = [];
        
        foreach ($data as $column => $value) {
            $setParts[] = "$column = ?";
            $updateBindings[] = $value;
        }
        
        $setString = implode(', ', $setParts);
        
        $this->buildWhereClause();
        $this->query = "UPDATE {$this->table} SET $setString";
        
        if (!empty($this->where)) {
            $this->query .= " WHERE " . implode(' AND ', $this->where);
        }
        
        $this->bindings = array_merge($updateBindings, $this->bindings);
        
        $statement = $this->raw($this->query, $this->bindings);
        return $statement->rowCount();
    }
    
    /**
     * Delete records
     */
    public function delete()
    {
        $this->buildWhereClause();
        $this->query = "DELETE FROM {$this->table}";
        
        if (!empty($this->where)) {
            $this->query .= " WHERE " . implode(' AND ', $this->where);
        }
        
        $statement = $this->raw($this->query, $this->bindings);
        return $statement->rowCount();
    }
    
    /**
     * Begin a transaction
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }
    
    /**
     * Commit a transaction
     */
    public function commit()
    {
        return $this->connection->commit();
    }
    
    /**
     * Rollback a transaction
     */
    public function rollBack()
    {
        return $this->connection->rollBack();
    }
    
    /**
     * Create table schema
     */
    public function schema($tableName, callable $callback)
    {
        $schema = new Schema($this->connection, $tableName);
        $callback($schema);
        return $schema->execute();
    }
    
    /**
     * Build query based on current state
     */
    private function buildQuery($type)
    {
        if ($type === 'select') {
            $this->query = "SELECT {$this->select} FROM {$this->table}";
            
            $this->buildWhereClause();
            
            if (!empty($this->orderBy)) {
                $this->query .= " ORDER BY " . implode(', ', $this->orderBy);
            }
            
            if ($this->limit !== null) {
                $this->query .= " LIMIT {$this->limit}";
            }
            
            if ($this->offset !== null) {
                $this->query .= " OFFSET {$this->offset}";
            }
        }
    }
    
    /**
     * Build where clause for query
     */
    private function buildWhereClause()
    {
        if (!empty($this->where)) {
            $this->query .= " WHERE " . implode(' AND ', $this->where);
        }
    }
    
    /**
     * Reset query builder state
     */
    private function reset()
    {
        $this->table = null;
        $this->select = '*';
        $this->where = [];
        $this->orderBy = [];
        $this->limit = null;
        $this->offset = null;
        $this->bindings = [];
        $this->query = '';
    }
}
