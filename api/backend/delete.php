<?php
include_once "../../database/autoloader.php";
use Database\DB;

header('Content-Type: application/json');

try {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Invalid request method");
    }

    // Get JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['id'])) {
        throw new Exception("Card ID is required");
    }

    $db = DB::connection("../../database/db/games.db");
    
    // Delete the card
    $result = $db->table('cards')->where('id', $data['id'])->delete();

    if ($result) {
        echo json_encode([
            "success" => true,
            "message" => "Card deleted successfully"
        ]);
    } else {
        throw new Exception("Failed to delete card");
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
