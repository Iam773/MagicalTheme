<?php

namespace Database;

class DB
{
    /**
     * Get database manager instance
     */
    public static function connection($connection = null)
    {
        return DatabaseManager::getInstance($connection);
    }
    
    /**
     * Start a new query on a table
     */
    public static function table($tableName)
    {
        return self::connection()->table($tableName);
    }
    
    /**
     * Execute a raw query
     */
    public static function raw($sql, $params = [])
    {
        return self::connection()->raw($sql, $params);
    }
    
    /**
     * Create or modify tables
     */
    public static function schema($tableName, callable $callback)
    {
        return self::connection()->schema($tableName, $callback);
    }
    
    /**
     * Begin a transaction
     */
    public static function beginTransaction()
    {
        return self::connection()->beginTransaction();
    }
    
    /**
     * Commit a transaction
     */
    public static function commit()
    {
        return self::connection()->commit();
    }
    
    /**
     * Roll back a transaction
     */
    public static function rollBack()
    {
        return self::connection()->rollBack();
    }
}
