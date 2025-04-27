<?php
include_once "../../database/autoloader.php";
use Database\DB;

// Set content type to JSON
header('Content-Type: application/json');

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
        echo json_encode([
            "success" => false,
            "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "success" => false,
            "message" => "อีเมลไม่ถูกต้อง"
        ]);
        exit;
    }

    if ($password !== $confirm_password) {
        echo json_encode([
            "success" => false,
            "message" => "รหัสผ่านไม่ตรงกัน"
        ]);
        exit;
    }

    if (strlen($password) < 8) {
        echo json_encode([
            "success" => false,
            "message" => "รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร"
        ]);
        exit;
    }

    // Check if the email is already registered
    $existingUser = DB::table('users')
        ->where('email', $email)
        ->first();

    if ($existingUser) {
        echo json_encode([
            "success" => false,
            "message" => "อีเมลนี้ถูกใช้ไปแล้ว"
        ]);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $userId = DB::table('users')->insert([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword
    ]);

    if ($userId) {
        echo json_encode([
            "success" => true,
            "message" => "ลงทะเบียนสำเร็จ"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "เกิดข้อผิดพลาดในการลงทะเบียน"
        ]);
    }
} else {
    // If not a POST request
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
}
