<?php

namespace Database;

use PDO;

class Schema
{
    private $connection;
    private $tableName;
    private $columns = [];
    private $primaryKey = null;
    private $foreignKeys = [];
    private $tableExists = false;
    
    public function __construct(PDO $connection, $tableName)
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
        
        // Check if table exists
        $stmt = $this->connection->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$tableName'");
        $this->tableExists = (bool) $stmt->fetch();
    }
    
    /**
     * Create integer column
     */
    public function integer($name, $autoIncrement = false, $nullable = false)
    {
        $type = $autoIncrement ? 'INTEGER' : 'INT';
        $this->addColumn($name, $type, $nullable, $autoIncrement);
        
        if ($autoIncrement) {
            $this->primaryKey = $name;
        }
        
        return $this;
    }
    
    /**
     * Create id column (shorthand for integer primary key)
     */
    public function id()
    {
        return $this->integer('id', true);
    }
    
    /**
     * Create string column
     */
    public function string($name, $length = 255, $nullable = false)
    {
        $this->addColumn($name, "VARCHAR($length)", $nullable);
        return $this;
    }
    
    /**
     * Create text column
     */
    public function text($name, $nullable = false)
    {
        $this->addColumn($name, 'TEXT', $nullable);
        return $this;
    }
    
    /**
     * Create boolean column
     */
    public function boolean($name, $nullable = false)
    {
        $this->addColumn($name, 'BOOLEAN', $nullable);
        return $this;
    }
    
    /**
     * Create datetime column
     */
    public function datetime($name, $nullable = false)
    {
        $this->addColumn($name, 'DATETIME', $nullable);
        return $this;
    }
    
    /**
     * Create timestamp columns (created_at, updated_at)
     */
    public function timestamps()
    {
        $this->datetime('created_at');
        $this->datetime('updated_at');
        return $this;
    }
    
    /**
     * Add foreign key constraint
     */
    public function foreignKey($column, $referencedTable, $referencedColumn = 'id')
    {
        $this->foreignKeys[] = [
            'column' => $column,
            'referencedTable' => $referencedTable,
            'referencedColumn' => $referencedColumn
        ];
        return $this;
    }
    
    /**
     * Execute the schema creation
     */
    public function execute()
    {
        if ($this->tableExists) {
            // For existing tables, we might add alter table functionality here
            return false;
        }
        
        $sql = "CREATE TABLE {$this->tableName} (";
        
        $columnDefinitions = [];
        foreach ($this->columns as $column) {
            $definition = "{$column['name']} {$column['type']}";
            
            if ($column['name'] === $this->primaryKey) {
                $definition .= ' PRIMARY KEY';
            }
            
            if ($column['autoIncrement']) {
                $definition .= ' AUTOINCREMENT';
            }
            
            if (!$column['nullable']) {
                $definition .= ' NOT NULL';
            }
            
            $columnDefinitions[] = $definition;
        }
        
        // Add foreign keys
        foreach ($this->foreignKeys as $foreignKey) {
            $columnDefinitions[] = "FOREIGN KEY ({$foreignKey['column']}) REFERENCES {$foreignKey['referencedTable']}({$foreignKey['referencedColumn']})";
        }
        
        $sql .= implode(', ', $columnDefinitions) . ")";
        
        try {
            $this->connection->exec($sql);
            return true;
        } catch (\Exception $e) {
            die("Table creation failed: " . $e->getMessage());
        }
    }
    
    /**
     * Add column definition
     */
    private function addColumn($name, $type, $nullable = false, $autoIncrement = false)
    {
        $this->columns[] = [
            'name' => $name,
            'type' => $type,
            'nullable' => $nullable,
            'autoIncrement' => $autoIncrement
        ];
    }
}
