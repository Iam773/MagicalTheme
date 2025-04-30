<?php
include_once "../../database/autoloader.php";
use Database\DB;

header('Content-Type: application/json');

// Connect to the database
DB::connection("../../database/db/games.db");

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $username = trim($_POST["username"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";
        $confirm_password = $_POST["confirm_password"] ?? "";

        // Validation
        $errors = [];
        
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception("All fields are required");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        if ($password !== $confirm_password) {
            throw new Exception("Passwords do not match");
        }

        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters");
        }

        // Check if email already exists
        $existingUser = DB::table('users')
            ->where('email', $email)
            ->first();

        if ($existingUser) {
            throw new Exception("Email already registered");
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Get current datetime
        $currentDateTime = date('Y-m-d H:i:s');

        // Insert new user
        $userId = DB::table('users')->insert([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ]);

        if ($userId) {
            // Start session and store user data
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['user'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;

            echo json_encode([
                "success" => true,
                "message" => "Registration successful!",
                "user" => [
                    "id" => $userId,
                    "username" => $username,
                    "email" => $email
                ]
            ]);
        } else {
            throw new Exception("Failed to create account");
        }
    } else {
        throw new Exception("Invalid request method");
    }
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
