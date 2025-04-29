<?php

require_once __DIR__ . '/DatabaseManager.php';
require_once __DIR__ . '/Schema.php';
require_once __DIR__ . '/DB.php';

use Database\DB;

// Example usage:

// Create a table
DB::schema('users', function($table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->string('password');
    $table->timestamps();
});

// Insert data
$userId = DB::table('users')->insert([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => password_hash('secret', PASSWORD_DEFAULT),
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
]);

// Query data
$users = DB::table('users')
    ->select(['id', 'name', 'email'])
    ->where('id', '>', 1)
    ->orderBy('name')
    ->limit(10)
    ->get();

// Find by ID
$user = DB::table('users')->find(1);

// Update data
$affected = DB::table('users')
    ->where('id', 1)
    ->update([
        'name' => 'Jane Doe',
        'updated_at' => date('Y-m-d H:i:s')
    ]);

// Delete data
$deleted = DB::table('users')
    ->where('id', 1)
    ->delete();

// Transaction example
try {
    DB::beginTransaction();
    
    DB::table('users')->insert([/* data */]);
    DB::table('profiles')->insert([/* related data */]);
    
    DB::commit();
} catch (Exception $e) {
    DB::rollBack();
    echo "Transaction failed: " . $e->getMessage();
}
