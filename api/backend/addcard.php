<?php
include_once "../../database/autoloader.php";
use Database\DB;

header('Content-Type: application/json');

try {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Invalid request method");
    }

    // Validate and sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $type = $_POST['type'] ?? '';
    $element = $_POST['element'] ?? '';
    $rarity = $_POST['rarity'] ?? '';
    $mana_cost = filter_var($_POST['mana_cost'], FILTER_VALIDATE_INT);
    
    // คำนวณค่า attack และ defense เฉพาะเมื่อเป็นการ์ดประเภท creature
    if ($type === 'creature') {
        $attack = filter_var($_POST['attack'], FILTER_VALIDATE_INT);
        $defense = filter_var($_POST['defense'], FILTER_VALIDATE_INT);
        
        if ($attack === false || $defense === false) {
            throw new Exception("Attack and Defense must be valid numbers for creature cards");
        }
        if ($attack < 0 || $defense < 0) {
            throw new Exception("Attack and Defense cannot be negative");
        }
    } else {
        $attack = null;
        $defense = null;
    }

    // Validate mana cost
    if ($mana_cost === false || $mana_cost < 0 || $mana_cost > 10) {
        throw new Exception("Mana cost must be between 0 and 10");
    }

    $effect = trim($_POST['effect'] ?? '');

    $db = DB::connection("../../database/db/games.db");
    
    // Insert card with validated data
    $result = $db->table('cards')->insert([
        'name' => $name,
        'type' => $type,
        'element' => $element,
        'rarity' => $rarity,
        'mana_cost' => $mana_cost,
        'attack' => $attack,
        'defense' => $defense,
        'effect' => $effect,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    if (!$result) {
        throw new Exception("Failed to add card");
    }

    echo json_encode([
        "success" => true,
        "message" => "Card added successfully!"
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
