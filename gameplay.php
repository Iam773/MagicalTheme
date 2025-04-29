<?php
require_once 'MagicalTheme.php';

// Initialize the theme with blue color scheme
$theme = new MagicalTheme('blue');

// Get game ID and player count from query parameters (or use defaults)
$gameId = $_GET['game_id'] ?? 'demo-12345';
$playerCount = min(4, max(2, intval($_GET['players'] ?? 2))); // Ensure between 2-4 players

// Player data (in a real app this would come from a database)
$currentPlayerId = 1; // Assumes the current user is player 1
$players = [
    1 => [
        'id' => 1,
        'name' => 'IceWizard',
        'avatar' => 'https://placehold.co/200x200/0284c7/ffffff?text=IW',
        'health' => 25,
        'mana' => 8,
        'deck_count' => 18,
        'hand' => [
            ['id' => 101, 'name' => 'Water Dragon', 'mana' => 5, 'power' => 8, 'health' => 7, 'type' => 'creature', 
             'image' => 'https://placehold.co/150x200/88c3f9/ffffff?text=Dragon', 'element' => 'water', 'rarity' => 'rare'],
            ['id' => 102, 'name' => 'Frost Nova', 'mana' => 4, 'power' => 3, 'health' => null, 'type' => 'spell', 
             'image' => 'https://placehold.co/150x200/4baeff/ffffff?text=Frost+Nova', 'element' => 'water', 'rarity' => 'uncommon'],
            ['id' => 103, 'name' => 'Ocean Guardian', 'mana' => 6, 'power' => 5, 'health' => 9, 'type' => 'creature', 
             'image' => 'https://placehold.co/150x200/0c4a6e/ffffff?text=Guardian', 'element' => 'water', 'rarity' => 'epic'],
            ['id' => 104, 'name' => 'Ice Shield', 'mana' => 2, 'power' => null, 'health' => 4, 'type' => 'equipment', 
             'image' => 'https://placehold.co/150x200/bae6fd/000000?text=Shield', 'element' => 'water', 'rarity' => 'common']
        ],
        'field' => [
            ['id' => 105, 'name' => 'Water Elemental', 'power' => 4, 'health' => 4, 'type' => 'creature', 
             'image' => 'https://placehold.co/150x200/38bdf8/ffffff?text=Elemental', 'element' => 'water', 'rarity' => 'common'],
            ['id' => 106, 'name' => 'Ice Wall', 'power' => 0, 'health' => 8, 'type' => 'creature', 
             'image' => 'https://placehold.co/150x200/93c5fd/000000?text=Ice+Wall', 'element' => 'water', 'rarity' => 'uncommon']
        ],
        'effects' => ['Frostbite: -1 to enemy attacks']
    ],
    2 => [
        'id' => 2,
        'name' => 'FireMaster92',
        'avatar' => 'https://placehold.co/200x200/ef4444/ffffff?text=FM',
        'health' => 21,
        'mana' => 6,
        'deck_count' => 16,
        'hand_count' => 5,
        'field' => [
            ['id' => 201, 'name' => 'Flame Imp', 'power' => 3, 'health' => 2, 'type' => 'creature', 
             'image' => 'https://placehold.co/150x200/dc2626/ffffff?text=Flame+Imp', 'element' => 'fire', 'rarity' => 'common'],
            ['id' => 202, 'name' => 'Fire Shield', 'power' => null, 'health' => 3, 'type' => 'equipment', 
             'image' => 'https://placehold.co/150x200/f97316/ffffff?text=F-Shield', 'element' => 'fire', 'rarity' => 'common'],
            ['id' => 203, 'name' => 'Fire Elemental', 'power' => 5, 'health' => 5, 'type' => 'creature', 
             'image' => 'https://placehold.co/150x200/ef4444/ffffff?text=Elemental', 'element' => 'fire', 'rarity' => 'rare']
        ],
        'effects' => ['Burning: Deal 1 damage to enemies each turn']
    ]
];

// If we have 3 or 4 players, add them
if ($playerCount >= 3) {
    $players[3] = [
        'id' => 3,
        'name' => 'EarthShaker',
        'avatar' => 'https://placehold.co/200x200/84cc16/ffffff?text=ES',
        'health' => 23,
        'mana' => 7,
        'deck_count' => 17,
        'hand_count' => 4,
        'field' => [
            ['id' => 301, 'name' => 'Stone Golem', 'power' => 2, 'health' => 10, 'type' => 'creature', 
             'image' => 'https://placehold.co/150x200/65a30d/ffffff?text=Golem', 'element' => 'earth', 'rarity' => 'rare']
        ],
        'effects' => ['Fortified: +2 health to all creatures']
    ];
}

if ($playerCount >= 4) {
    $players[4] = [
        'id' => 4,
        'name' => 'WindWalker',
        'avatar' => 'https://placehold.co/200x200/7dd3fc/000000?text=WW',
        'health' => 20,
        'mana' => 10,
        'deck_count' => 15,
        'hand_count' => 6,
        'field' => [
            ['id' => 401, 'name' => 'Air Sprite', 'power' => 2, 'health' => 1, 'type' => 'creature', 
             'image' => 'https://placehold.co/150x200/e0f2fe/000000?text=Sprite', 'element' => 'air', 'rarity' => 'common'],
            ['id' => 402, 'name' => 'Tornado', 'power' => 2, 'health' => null, 'type' => 'spell', 
             'image' => 'https://placehold.co/150x200/7dd3fc/000000?text=Tornado', 'element' => 'air', 'rarity' => 'uncommon']
        ],
        'effects' => ['Swift: Can attack immediately after playing']
    ];
}

// Game state information
$gameState = [
    'current_turn' => 1,
    'current_player' => 1,
    'turn_time' => 30, // seconds
    'action_log' => [
        ['player' => 2, 'action' => 'Played Flame Imp (3/2)', 'time' => '2 min ago'],
        ['player' => 1, 'action' => 'Played Ice Wall (0/8)', 'time' => '1 min ago'],
        ['player' => 2, 'action' => 'Attacked with Flame Imp', 'time' => 'Just now']
    ]
];

// Determine layout based on player count
$layoutClass = "two-player";
if ($playerCount == 3) {
    $layoutClass = "three-player";
} else if ($playerCount == 4) {
    $layoutClass = "four-player";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battle Arena - Azure Cards</title>
    <?php echo $theme->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to our custom CSS file -->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Gameplay specific styles */
        .battle-arena {
            height: 100vh;
            width: 100vw;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(to bottom, #0c4a6e, #0284c7);
            overflow: hidden;
            z-index: 40;
        }

        .container {
            padding: 0 !important;
            max-width: none !important;
        }

        /* Adjust nav z-index to stay above battle arena */
        .navbar {
            z-index: 45;
            position: relative;
        }

        /* Update game-center position for fullscreen */
        .game-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            height: 60%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        
        .battle-arena::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }
        
        .player-zone {
            position: absolute;
            transition: all 0.3s ease;
            z-index: 20;
            background: transparent;
            border: none;
            outline: none;
        }
        
        /* Player zone positioning for different layouts */
        .two-player .player-zone.player-1 {
            bottom: 0;
            left: 0;
            right: 0;
            height: 250px;
        }
        
        .two-player .player-zone.player-2 {
            top: 0;
            left: 0;
            right: 0;
            height: 250px;
        }
        
        .three-player .player-zone.player-1 {
            bottom: 0;
            left: 0;
            right: 0;
            height: 250px;
        }
        
        .three-player .player-zone.player-2 {
            top: 0;
            left: 0;
            width: 45%;
            height: 250px;
        }
        
        .three-player .player-zone.player-3 {
            top: 0;
            right: 0;
            width: 45%;
            height: 250px;
        }
        
        .four-player .player-zone.player-1 {
            bottom: 0;
            left: 0;
            right: 0;
            height: 210px;
        }
        
        .four-player .player-zone.player-2 {
            top: 0;
            left: 0;
            right: 0;
            height: 210px;
        }
        
        .four-player .player-zone.player-3 {
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            width: 230px;
            height: 290px;
        }
        
        .four-player .player-zone.player-4 {
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            width: 230px;
            height: 290px;
        }
        
        .player-info {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            padding: 8px;
            display: flex;
            align-items: center;
            color: white;
            position: absolute;
            z-index: 30;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .player-1 .player-info {
            bottom: 5px;
            left: 10px;
        }
        
        .player-2 .player-info {
            top: 5px;
            right: 10px;
        }
        
        .player-3 .player-info {
            top: 5px;
            left: 10px;
        }
        
        .player-4 .player-info {
            bottom: 5px;
            right: 10px;
        }
        
        .player-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid var(--primary);
        }
        
        .player-stats {
            display: flex;
            gap: 10px;
        }
        
        .player-stat {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
        }
        
        .player-stat i {
            margin-right: 4px;
        }
        
        .player-field {
            position: absolute;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 10px;
        }
        
        .player-1 .player-field {
            bottom: 70px;
        }
        
        .player-2 .player-field {
            top: 70px;
        }
        
        .player-3 .player-field,
        .player-4 .player-field {
            top: 50%;
            transform: translateY(-50%);
            flex-direction: column;
            align-items: center;
        }
        
        .player-hand {
            position: absolute;
            display: flex;
            justify-content: center;
            gap: 2px;
        }
        
        .player-1 .player-hand {
            bottom: 10px;
            left: 130px;
            right: 10px;
            height: 100px;
        }
        
        .game-card-mini {
            border-radius: 8px;
            overflow: hidden;
            background: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            position: relative;
            transition: all 0.2s ease;
            transform-origin: bottom center;
            cursor: pointer;
        }

        /* Player 1 (bottom) - ใหญ่ที่สุด */
        .player-1 .game-card-mini {
            width: 100px;
            height: 150px;
            transform: translateY(-40px);
        }

        /* Player 2 (top) - เล็กกว่า player 1 */
        .player-2 .game-card-mini {
            width: 100px;
            height: 150px;
            transform: translateY(40px);
        }

        /* Player 3 (left) - เล็กที่สุด */
        .player-3 .game-card-mini {
            width: 80px;
            height: 120px;
            transform: translateX(40px);
        }

        /* Player 4 (right) - เล็กที่สุด */
        .player-4 .game-card-mini {
            width: 80px;
            height: 120px;
            transform: translateX(-40px);
        }

        /* Hover effects for each player */
        .player-1 .game-card-mini:hover {
            transform: translateY(-45px) scale(1.1);
            z-index: 10;
        }

        .player-2 .game-card-mini:hover {
            transform: translateY(50px) scale(1.1);
            z-index: 10;
        }

        .player-3 .game-card-mini:hover {
            transform: translateX(50px) scale(1.1);
            z-index: 10;
        }

        .player-4 .game-card-mini:hover {
            transform: translateX(-50px) scale(1.1);
            z-index: 10;
        }
        
        .game-card-mini img {
            width: 100%;
            height: 70%;
            object-fit: cover;
        }
        
        .card-mini-stats {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-around;
            padding: 2px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            font-size: 0.7rem;
        }
        
        .field-card {
            width: 80px;
            height: 100px;
            border-radius: 6px;
            position: relative;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
            transition: all 0.2s ease;
            overflow: hidden;
        }

        /* Player 1 field cards - ล่าง */
        .player-1 .field-card {
            transform: translateY(-100px);
        }

        /* Player 2 field cards - บน */
        .player-2 .field-card {
            transform: translateY(80px);
        }

        /* Player 3 field cards - ซ้าย */
        .player-3 .field-card {
            transform: translateX(40px);
        }

        /* Player 4 field cards - ขวา */ 
        .player-4 .field-card {
            transform: translateX(-40px);
        }
        
        .field-card:hover {
            z-index: 5;
        }

        /* Player 1 hover - ล่าง */
        .player-1 .field-card:hover {
            transform: translateY(-110px) scale(1.1);
        }

        /* Player 2 hover - บน */
        .player-2 .field-card:hover {
            transform: translateY(70px) scale(1.1);
        }

        /* Player 3 hover - ซ้าย */
        .player-3 .field-card:hover {
            transform: translateX(50px) scale(1.1);
        }

        /* Player 4 hover - ขวา */
        .player-4 .field-card:hover {
            transform: translateX(-50px) scale(1.1);
        }
        
        .field-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .field-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.7) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3px;
        }
        
        .field-card-stats {
            display: flex;
            justify-content: space-between;
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
        }
        
        .game-controls {
            position: absolute;
            bottom: 200px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 40;
        }
        
        .turn-indicator {
            position: absolute;
            bottom: 150px;
            left: 250px;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            z-index: 30;
            backdrop-filter: blur(5px);
        }
        
        .turn-timer {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            position: absolute;
            bottom: 145px;
            left: 440px;
            transform: translateY(-50%);
            z-index: 30;
            box-shadow: 0 0 10px rgba(var(--warning-rgb), 0.8);
        }
        
        .action-log {
            position: absolute;
            bottom: 100px;
            right: 10px;
            width: 250px;
            max-height: 200px;
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            border-radius: 10px;
            padding: 10px;
            color: white;
            z-index: 30;
            font-size: 0.8rem;
        }
        
        .action-log-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 5px;
        }
        
        .log-entry {
            margin-bottom: 5px;
            padding-bottom: 5px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .log-time {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.7rem;
            margin-left: 5px;
        }
        
        .player-effects {
            position: absolute;
            display: flex;
            gap: 5px;
        }
        
        .player-1 .player-effects {
            bottom: 80px;
            left: 10px;
        }
        
        .effect-badge {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(3px);
            color: white;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .magic-button.end-turn {
            background-image: linear-gradient(to right, #38bdf8, #0ea5e9);
            transition: all 0.3s ease;
        }
        
        .magic-button.end-turn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.7);
        }
        
        .chat-button {
            position: absolute;
            bottom: 20px;
            right: 80px;
            width: 50px;
            height: 50px;
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 100;
            transition: all 0.3s ease;
        }
        
        .chat-button:hover {
            transform: scale(1.1);
        }
        
        .chat-panel {
            position: absolute;
            bottom: 80px;
            right: 20px;
            width: 300px;
            height: 400px;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            z-index: 90;
            overflow: hidden;
            display: none;
            flex-direction: column;
        }
        
        .chat-header {
            padding: 10px 15px;
            background-color: rgba(56, 189, 248, 0.3);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px 15px;
        }
        
        .chat-message {
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
        }
        
        .message-sender {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2px;
        }
        
        .message-content {
            background-color: rgba(56, 189, 248, 0.2);
            padding: 5px 10px;
            border-radius: 10px;
            color: white;
            align-self: flex-start;
            max-width: 80%;
            word-wrap: break-word;
        }
        
        .chat-message.self .message-content {
            background-color: rgba(56, 189, 248, 0.5);
            align-self: flex-end;
        }
        
        .chat-input {
            display: flex;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .chat-input input {
            flex-grow: 1;
            padding: 10px 15px;
            background-color: transparent;
            color: white;
            border: none;
            outline: none;
        }
        
        .chat-input button {
            padding: 10px 15px;
            background-color: var(--primary);
            color: white;
            border: none;
            cursor: pointer;
        }

        /* เพิ่ม CSS ใหม่สำหรับ surrender button */
        .surrender-button {
            position: fixed;
            bottom: 10px;
            left: 200px;
            z-index: 100;
        }

        /* แก้ไข style ของปุ่มให้เข้ากับ theme */
        .surrender-button button {
            background: linear-gradient(to right, #ef4444, #dc2626);
            padding: 5px 16px;
            border-radius: 8px;
            color: white;
            font-size: 0.875rem;
            line-height: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .surrender-button button:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(185, 28, 28, 0.5);
            background: linear-gradient(to right, #b91c1c, #991b1b);
        }
    </style>
</head>
<body class="bg-light overflow-hidden">
    <?php include 'includes/nav.php'; ?>
    
    <div class="container">
        <!-- Game Arena -->
        <div class="battle-arena <?php echo $layoutClass; ?>">
            <!-- Turn indicator -->
            <div class="turn-indicator">
                <span class="font-itim">Turn <?php echo $gameState['current_turn']; ?> - <?php echo $players[$gameState['current_player']]['name']; ?>'s turn</span>
            </div>
            
            <!-- Turn timer -->
            <div class="turn-timer">
                <span id="time-remaining"><?php echo $gameState['turn_time']; ?></span>
            </div>
            
            <!-- Game center -->
            <div class="game-center">
                <div class="game-controls">
                    <button class="magic-button end-turn">End Turn</button>
                </div>
            </div>
            
            <!-- Player zones -->
            <?php foreach ($players as $playerId => $player): ?>
                <div class="player-zone player-<?php echo $playerId; ?> <?php echo $playerId == $gameState['current_player'] ? 'active-player' : ''; ?>">
                    <!-- Player info -->
                    <div class="player-info">
                        <img class="player-avatar" src="<?php echo $player['avatar']; ?>" alt="<?php echo $player['name']; ?>">
                        <div>
                            <div class="font-itim"><?php echo $player['name']; ?></div>
                            <div class="player-stats">
                                <div class="player-stat"><i class="fas fa-heart text-danger"></i> <?php echo $player['health']; ?></div>
                                <div class="player-stat"><i class="fas fa-tint text-primary"></i> <?php echo $player['mana']; ?></div>
                                <div class="player-stat"><i class="fas fa-layer-group text-secondary"></i> <?php echo $player['deck_count']; ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Player field (cards in play) -->
                    <div class="player-field">
                        <?php if (isset($player['field'])): ?>
                            <?php foreach ($player['field'] as $card): ?>
                                <div class="field-card" data-card-id="<?php echo $card['id']; ?>">
                                    <img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>">
                                    <div class="field-card-overlay">
                                        <div class="field-card-stats">
                                            <?php if ($card['power'] !== null): ?>
                                                <div class="text-danger"><?php echo $card['power']; ?></div>
                                            <?php endif; ?>
                                            
                                            <?php if ($card['health'] !== null): ?>
                                                <div class="text-success"><?php echo $card['health']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Player effects -->
                    <?php if (isset($player['effects']) && count($player['effects']) > 0): ?>
                        <div class="player-effects">
                            <?php foreach ($player['effects'] as $effect): ?>
                                <div class="effect-badge">
                                    <?php echo $effect; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Player hand (only visible to current player) -->
                    <?php if ($playerId == $currentPlayerId && isset($player['hand'])): ?>
                        <div class="player-hand">
                            <?php foreach ($player['hand'] as $card): ?>
                                <div class="game-card-mini" data-card-id="<?php echo $card['id']; ?>">
                                    <img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>">
                                    <div class="p-1 text-center text-xs font-bold truncate">
                                        <?php echo $card['name']; ?>
                                    </div>
                                    <div class="card-mini-stats">
                                        <span class="text-primary"><?php echo $card['mana']; ?></span>
                                        <?php if ($card['power'] !== null): ?>
                                            <span class="text-danger"><?php echo $card['power']; ?></span>
                                        <?php endif; ?>
                                        <?php if ($card['health'] !== null): ?>
                                            <span class="text-success"><?php echo $card['health']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            
            <!-- Action log -->
            <div class="action-log" id="action-log">
                <div class="action-log-header">
                    <span class="font-itim">Battle Log</span>
                    <button class="text-xs bg-primary/30 hover:bg-primary/50 px-2 py-1 rounded">
                        <i class="fas fa-refresh"></i>
                    </button>
                </div>
                
                <div class="action-log-content">
                    <?php foreach ($gameState['action_log'] as $entry): ?>
                        <div class="log-entry">
                            <span class="font-medium"><?php echo $players[$entry['player']]['name']; ?>: </span>
                            <?php echo $entry['action']; ?>
                            <span class="log-time"><?php echo $entry['time']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Chat button and panel -->
            <div class="chat-button" id="chat-toggle">
                <i class="fas fa-comments"></i>
            </div>
            
            <div class="chat-panel" id="chat-panel">
                <div class="chat-header">
                    <span>Game Chat</span>
                    <button id="chat-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="chat-messages">
                    <div class="chat-message">
                        <div class="message-sender">FireMaster92</div>
                        <div class="message-content">Good luck all!</div>
                    </div>
                    <div class="chat-message self">
                        <div class="message-sender">IceWizard (You)</div>
                        <div class="message-content">Thanks, you too!</div>
                    </div>
                    <div class="chat-message">
                        <div class="message-sender">FireMaster92</div>
                        <div class="message-content">Nice move with that Ice Wall!</div>
                    </div>
                </div>
                <div class="chat-input">
                    <input type="text" placeholder="Type a message...">
                    <button><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
        
        <!-- Surrender button -->
        <div class="surrender-button">
            <button id="surrender-btn">
                <i class="fas fa-flag"></i>
                <span>Surrender</span>
            </button>
        </div>
        
    </div>
    
    <!-- Card Preview Modal -->
    <div id="card-preview-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-70" id="modal-overlay"></div>
        <div class="w-72 h-96 bg-white rounded-xl shadow-2xl transform transition-all relative z-10">
            <img id="preview-card-image" class="w-full h-2/3 object-cover rounded-t-xl" src="" alt="">
            <div class="p-4">
                <h3 id="preview-card-name" class="font-itim text-lg text-primary mb-1"></h3>
                <p id="preview-card-description" class="text-sm text-gray-600 mb-2"></p>
                <div class="flex justify-between">
                    <div class="flex space-x-3">
                        <div class="flex items-center">
                            <i class="fas fa-tint text-primary mr-1"></i>
                            <span id="preview-card-mana"></span>
                        </div>
                        <div class="flex items-center" id="preview-card-power-container">
                            <i class="fas fa-fire-alt text-danger mr-1"></i>
                            <span id="preview-card-power"></span>
                        </div>
                        <div class="flex items-center" id="preview-card-health-container">
                            <i class="fas fa-heart text-success mr-1"></i>
                            <span id="preview-card-health"></span>
                        </div>
                    </div>
                    <div class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full flex items-center">
                        <span id="preview-card-type"></span>
                    </div>
                </div>
            </div>
            <button class="absolute top-2 right-2 w-8 h-8 rounded-full bg-black bg-opacity-50 text-white flex items-center justify-center" id="close-preview">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    
    <!-- Add reference to our JavaScript file -->
    <script src="js/game.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Timer functionality
            let timeRemaining = <?php echo $gameState['turn_time']; ?>;
            const timerElement = document.getElementById('time-remaining');
            
            const timer = setInterval(function() {
                timeRemaining--;
                
                if (timeRemaining <= 0) {
                    clearInterval(timer);
                    // Auto-end turn logic would go here
                    timerElement.textContent = "0";
                    
                    // Flash the timer to indicate time's up
                    timerElement.parentElement.classList.add('bg-danger');
                    setTimeout(() => {
                        timerElement.parentElement.classList.remove('bg-danger');
                    }, 500);
                } else {
                    timerElement.textContent = timeRemaining;
                    
                    // Add warning color when time is running low
                    if (timeRemaining <= 10) {
                        timerElement.parentElement.classList.add('bg-warning');
                    }
                }
            }, 1000);
            
            // End turn button
            document.querySelector('.end-turn').addEventListener('click', function() {
                createMagicalAlert('info', 'Ending your turn...');
                
                // In a real app, send this to server
                console.log('End turn requested');
                
                // Simulate turn change (would come from server in real app)
                setTimeout(() => {
                    window.location.reload(); // For demo, just reload
                }, 1000);
            });
            
            // Card preview functionality
            const previewModal = document.getElementById('card-preview-modal');
            const modalOverlay = document.getElementById('modal-overlay');
            const closePreviewBtn = document.getElementById('close-preview');
            
            // Open preview when clicking on a card (hand or field)
            document.querySelectorAll('.game-card-mini, .field-card').forEach(card => {
                card.addEventListener('click', function() {
                    // In a real app, this would fetch card data from server
                    // For this example, we'll use dummy data
                    
                    // Get card ID (in real app, use this to fetch data)
                    const cardId = this.getAttribute('data-card-id');
                    
                    // Find card data - this would be a server request
                    let cardData;
                    <?php 
                    echo "const allCards = " . json_encode(array_merge(
                        $players[1]['hand'] ?? [], 
                        $players[1]['field'] ?? [],
                        $players[2]['field'] ?? [],
                        $players[3]['field'] ?? [],
                        $players[4]['field'] ?? []
                    )) . ";\n";
                    ?>
                    
                    cardData = allCards.find(c => c.id == cardId);
                    
                    if (!cardData) return;
                    
                    // Populate modal with card data
                    document.getElementById('preview-card-image').src = cardData.image;
                    document.getElementById('preview-card-name').textContent = cardData.name;
                    document.getElementById('preview-card-mana').textContent = cardData.mana;
                    
                    // Description - in real app, would be part of card data
                    document.getElementById('preview-card-description').textContent = 
                        cardData.description || 'No description available';
                    
                    // Handle optional stats
                    const powerContainer = document.getElementById('preview-card-power-container');
                    const healthContainer = document.getElementById('preview-card-health-container');
                    
                    if (cardData.power !== null) {
                        document.getElementById('preview-card-power').textContent = cardData.power;
                        powerContainer.classList.remove('hidden');
                    } else {
                        powerContainer.classList.add('hidden');
                    }
                    
                    if (cardData.health !== null) {
                        document.getElementById('preview-card-health').textContent = cardData.health;
                        healthContainer.classList.remove('hidden');
                    } else {
                        healthContainer.classList.add('hidden');
                    }
                    
                    // Set type and element
                    document.getElementById('preview-card-type').textContent = 
                        (cardData.element ? (cardData.element.charAt(0).toUpperCase() + cardData.element.slice(1) + ' ') : '') + 
                        (cardData.type ? cardData.type.charAt(0).toUpperCase() + cardData.type.slice(1) : '');
                    
                    // Show modal
                    previewModal.classList.remove('hidden');
                });
            });
            
            // Close preview modal
            closePreviewBtn.addEventListener('click', () => {
                previewModal.classList.add('hidden');
            });
            
            modalOverlay.addEventListener('click', () => {
                previewModal.classList.add('hidden');
            });
            
            // Chat functionality
            const chatToggle = document.getElementById('chat-toggle');
            const chatPanel = document.getElementById('chat-panel');
            const chatClose = document.getElementById('chat-close');
            
            chatToggle.addEventListener('click', () => {
                chatPanel.style.display = chatPanel.style.display === 'flex' ? 'none' : 'flex';
            });
            
            chatClose.addEventListener('click', () => {
                chatPanel.style.display = 'none';
            });
            
            // Surrender confirmation
            document.getElementById('surrender-btn').addEventListener('click', function() {
                if (confirm('Are you sure you want to surrender this game?')) {
                    createMagicalAlert('warning', 'You surrendered the game.');
                    setTimeout(() => {
                        window.location.href = 'battle.php';
                    }, 2000);
                }
            });
            
            // Allow drag and drop for cards (simplified)
            document.querySelectorAll('.game-card-mini').forEach(card => {
                card.setAttribute('draggable', true);
                
                card.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', card.getAttribute('data-card-id'));
                    e.target.classList.add('opacity-50');
                });
                
                card.addEventListener('dragend', (e) => {
                    e.target.classList.remove('opacity-50');
                });
            });
            
            document.querySelectorAll('.player-field').forEach(field => {
                field.addEventListener('dragover', (e) => {
                    // Only allow dropping in the current player's field
                    if (field.closest('.player-zone').classList.contains('player-1')) {
                        e.preventDefault();
                        field.classList.add('bg-primary/20');
                    }
                });
                
                field.addEventListener('dragleave', () => {
                    field.classList.remove('bg-primary/20');
                });
                
                field.addEventListener('drop', (e) => {
                    e.preventDefault();
                    field.classList.remove('bg-primary/20');
                    
                    // Only allow dropping in the current player's field
                    if (field.closest('.player-zone').classList.contains('player-1')) {
                        const cardId = e.dataTransfer.getData('text/plain');
                        console.log(`Playing card ${cardId} to field`);
                        createMagicalAlert('success', 'Card played to the field!');
                        
                        // In a real app, send this to server and update the UI based on response
                    }
                });
            });
            
            // Highlight current player's zone
            const currentPlayerZone = document.querySelector('.player-zone.player-<?php echo $gameState['current_player']; ?>');
            if (currentPlayerZone) {
                currentPlayerZone.classList.add('border-2', 'border-primary');
            }
        });
    </script>
</body>
</html>
