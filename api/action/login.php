<?php
include_once "../../database/autoloader.php";
use Database\DB;

// Set content type to JSON
header('Content-Type: application/json');

// เชื่อมต่อกับฐานข้อมูล
DB::connection("../../database/db/games.db");

// ตรวจสอบว่าเป็นการส่งข้อมูลด้วยวิธี POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    
    // ตรวจสอบว่ามีการส่งข้อมูลมาครบหรือไม่
    if (empty($email) || empty($password)) {
        echo json_encode([
            "success" => false,
            "message" => "กรุณากรอกอีเมลและรหัสผ่าน"
        ]);
        exit;
    }
    
    // ค้นหาผู้ใช้จากฐานข้อมูล
    $user = DB::table('users')
        ->where('email', $email)
        ->first();
    
    // ตรวจสอบว่าพบผู้ใช้หรือไม่ และรหัสผ่านถูกต้องหรือไม่
    if ($user && password_verify($password, $user['password'])) {
        // เริ่ม session
        session_start();
        
        // เก็บข้อมูลผู้ใช้ใน session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['logged_in'] = true;
        
        // ส่งข้อความแจ้งสถานะการ login สำเร็จ
        echo json_encode([
            "success" => true,
            "message" => "เข้าสู่ระบบสำเร็จ",
            "user" => [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email']
            ]
        ]);
    } else {
        header("location: ../../auth/login.php?error=invalid_credentials");
    }
} else {
    // กรณีไม่ใช่ POST method
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
}
?>