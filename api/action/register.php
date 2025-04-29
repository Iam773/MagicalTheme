<?php
include_once "../../database/autoloader.php";
use Database\DB;

// Connect to the database
DB::connection("../../database/db/games.db");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    // Validate form data
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header("location: ../../auth/register.php?error=empty_fields");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location: ../../auth/register.php?error=invalid_email");
        exit;
    }

    if ($password !== $confirm_password) {
        header("location: ../../auth/register.php?error=password_mismatch");
        exit;
    }

    if (strlen($password) < 8) {
        header("location: ../../auth/register.php?error=password_too_short");
        exit;
    }

    // Check if the email is already registered
    $existingUser = DB::table('users')
        ->where('email', $email)
        ->first();

    if ($existingUser) {
        header("location: ../../auth/register.php?error=email_exists");
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Get current datetime for timestamps
    $currentDateTime = date('Y-m-d H:i:s');

    // Insert the new user into the database
    $userId = DB::table('users')->insert([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword,
        'created_at' => $currentDateTime,
        'updated_at' => $currentDateTime
    ]);

    if ($userId) {
        // เริ่ม session
        session_start();
        
        // เก็บข้อมูลผู้ใช้ใน session
        $_SESSION['user_id'] = $userId;
        $_SESSION['email'] = $email;
        $_SESSION['logged_in'] = true;
        
        // ยังคงใช้ JSON response ในกรณีที่ลงทะเบียนสำเร็จ
        header('Content-Type: application/json');
        echo json_encode([
            "success" => true,
            "message" => "ลงทะเบียนสำเร็จ",
            "user" => [
                "id" => $userId,
                "email" => $email
            ]
        ]);
    } else {
        header("location: ../../auth/register.php?error=registration_failed");
        exit;
    }
} else {
    // If not a POST request
    header("location: ../../auth/register.php?error=method_not_allowed");
    exit;
}
