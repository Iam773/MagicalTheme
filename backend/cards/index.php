<?php
session_start();
require_once '../../database/autoloader.php';
use Database\DB;

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../../MagicalTheme.php';
$theme = new MagicalTheme('blue');
include '../../includes/nav.php'; // Add this line to include nav.php

// Connect to database
$db = DB::connection("../../database/db/games.db");

// Get all cards
$cards = $db->table('cards')->get();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Cards - Admin Dashboard</title>
    <?php echo $theme->render(); ?>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../assets/js/MagicalUI.js"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 2fr));
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .card-item {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid var(--blue-100);
            transition: transform 0.3s;
            min-height: 400px;
            display: flex;
            flex-direction: column;
        }

        .card-image {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
            background-color: var(--blue-50);
            border-bottom: 2px solid var(--blue-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue-400);
            font-size: 3rem;
        }

        .card-header {
            padding: 1rem;
            border-bottom: 2px solid var(--blue-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-content {
            padding: 1.5rem;
            flex-grow: 1;
        }

        .card-content > div {
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .card-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-top: 1rem;
            background: var(--blue-50);
            padding: 0.75rem;
            border-radius: 0.5rem;
        }

        .card-stat {
            background: white;
            padding: 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card-actions {
            padding: 1rem;
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>
<body class="bg-light">
    <?php 
    $websiteName = 'Azure Cards';
    renderNavbar();
    ?>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 flex justify-between items-center border-b border-gray-200">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-cards text-primary"></i> Manage Cards
                </h1>
                <a href="add.php" class="magic-button magic-button-primary">
                    <i class="fas fa-plus mr-2"></i> Add New Card
                </a>
            </div>

            <div class="cards-grid">
                <?php foreach ($cards as $card): ?>
                    <div class="card-item">
                        <div class="card-image">
                            <?php if (!empty($card['image'])): ?>
                                <img src="<?php echo htmlspecialchars($card['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($card['name']); ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="fas fa-hat-wizard opacity-20"></i>
                            <?php endif; ?>
                        </div>
                        <div class="card-content flex-grow">
                            <div class="card-header">
                                <h3 class="font-bold text-primary text-lg"><?php echo htmlspecialchars($card['name']); ?></h3>
                                <span class="badge bg-<?php echo strtolower($card['rarity']); ?>">
                                    <?php echo $card['rarity']; ?>
                                </span>
                            </div>
                            <div class="mt-2">
                                <div class="text-sm text-gray-600">Type: <?php echo ucfirst($card['type']); ?></div>
                                <div class="text-sm text-gray-600">Element: <?php echo $card['element']; ?></div>
                                <div class="card-stats">
                                    <div class="card-stat">
                                        <div class="text-xs text-gray-500">MANA</div>
                                        <div class="text-primary font-bold"><?php echo $card['mana_cost']; ?></div>
                                    </div>
                                    <?php if ($card['type'] === 'creature'): ?>
                                        <div class="card-stat">
                                            <div class="text-xs text-gray-500">ATK</div>
                                            <div class="text-danger font-bold"><?php echo $card['attack']; ?></div>
                                        </div>
                                        <div class="card-stat">
                                            <div class="text-xs text-gray-500">DEF</div>
                                            <div class="text-success font-bold"><?php echo $card['defense']; ?></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($card['effect']): ?>
                                    <p class="text-sm text-gray-600 mt-3 italic">
                                        "<?php echo htmlspecialchars($card['effect']); ?>"
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-actions border-t border-gray-100">
                            <button onclick="editCard(<?php echo $card['id']; ?>)" 
                                    class="magic-button magic-button-secondary flex-1">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <button onclick="deleteCard(<?php echo $card['id']; ?>)" 
                                    class="magic-button magic-button-danger flex-1">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        function deleteCard(id) {
            MagicalUI.renderPopup('Are you sure you want to delete this card?', 'warning', {
                title: 'Confirm Delete',
                confirmText: 'Yes, Delete',
                showTime: 0,
                onConfirm: async () => {
                    try {
                        const response = await fetch('../../api/backend/delete.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ id: id })
                        });
                        
                        const result = await response.json();
                        if (result.success) {
                            MagicalUI.renderAlert('success', 'Card deleted successfully!');
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            MagicalUI.renderAlert('error', result.message);
                        }
                    } catch (error) {
                        MagicalUI.renderAlert('error', 'Failed to delete card');
                    }
                }
            });
        }

        function editCard(id) {
            window.location.href = `edit.php?id=${id}`;
        }
    </script>
</body>
</html>
