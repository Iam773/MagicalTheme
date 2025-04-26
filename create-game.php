<?php
require_once 'MagicalTheme.php';
require_once 'game/GameManager.php';

// Initialize the theme with blue color scheme
$theme = new MagicalTheme('blue');

// Check if form was submitted
$gameCreated = false;
$gameData = null;
$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get player name
        $playerName = $_POST['player_name'] ?? 'Player';
        if (empty($playerName)) $playerName = 'Player';
        
        // Generate avatar
        $avatarColor = $_POST['avatar_color'] ?? '0284c7';
        $playerAvatar = "https://placehold.co/200x200/{$avatarColor}/ffffff?text=" . substr($playerName, 0, 2);
        
        // Get game options
        $gameOptions = [
            'maxPlayers' => intval($_POST['max_players'] ?? 2),
            'turnTimeLimit' => intval($_POST['turn_time'] ?? 60),
            'initialCards' => intval($_POST['initial_cards'] ?? 4),
            'gameMode' => $_POST['game_mode'] ?? 'standard'
        ];
        
        // Create the game
        $gameData = GameManager::createGame($playerName, $playerAvatar, $gameOptions);
        $gameCreated = true;
        
        // Store the player ID in session
        session_start();
        $_SESSION['player_id'] = 1; // Creator is always player 1
        $_SESSION['player_name'] = $playerName;
        $_SESSION['game_id'] = $gameData['gameId'];
    } catch (Exception $e) {
        $errorMessage = "Error creating game: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $gameCreated ? 'Game Created' : 'Create Game'; ?> - Azure Cards</title>
    <?php echo $theme->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to our custom CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <?php include 'includes/nav.php'; ?>
    
    <div class="container mx-auto px-4 py-6 min-h-screen">
        <?php if ($gameCreated): ?>
            <!-- Game created successfully -->
            <div class="magic-card shadow-magical max-w-3xl mx-auto mt-10 bg-gradient-to-br from-primary/5 to-secondary/5">
                <div class="text-center mb-8">
                    <div class="inline-block p-5 bg-primary/10 rounded-full mb-4">
                        <i class="fas fa-gamepad text-4xl text-primary"></i>
                    </div>
                    <h1 class="font-itim text-4xl text-primary mb-2">Game Created Successfully!</h1>
                    <p class="text-gray-600">Your game room is ready. Share the link with friends to invite them!</p>
                </div>
                
                <div class="bg-dark/5 backdrop-blur-sm rounded-xl p-6 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-500">Game ID:</span>
                        <span class="font-mono text-lg text-primary font-bold"><?php echo $gameData['gameId']; ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Players:</span>
                        <span class="font-medium">1 / <?php echo $gameData['maxPlayers']; ?></span>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Share this link with friends</label>
                    <div class="flex">
                        <input type="text" value="<?php echo $gameData['joinUrl']; ?>" readonly 
                               class="magic-input flex-1 bg-white/80 focus:ring-primary focus:border-primary" id="join-url">
                        <button onclick="copyToClipboard('join-url')" class="magic-button magic-button-primary ml-2">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
                
                <div class="text-center space-y-4">
                    <p class="text-sm text-gray-600 mb-4">Waiting for other players to join...</p>
                    
                    <div class="flex justify-center space-x-4">
                        <?php echo $theme->renderButton('Enter Game Lobby', 'primary', 'lg', 'gameplay.php?game_id=' . $gameData['gameId'], '', 'door-open'); ?>
                        <?php echo $theme->renderButton('Cancel Game', 'secondary', 'lg', 'battle.php', '', 'times'); ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Create game form -->
            <div class="max-w-3xl mx-auto">
                <h1 class="font-itim text-4xl text-primary text-center mb-8">Create a New Game</h1>
                
                <?php if ($errorMessage): ?>
                    <div class="bg-danger/10 text-danger p-4 rounded-lg mb-6">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="magic-card shadow-magical">
                    <div class="mb-6">
                        <h2 class="font-itim text-2xl text-primary mb-4">Player Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="player_name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                                <input type="text" name="player_name" id="player_name" 
                                       class="magic-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                       placeholder="Enter your name" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Avatar Color</label>
                                <div class="flex space-x-2">
                                    <input type="hidden" name="avatar_color" id="avatar_color" value="0284c7">
                                    <div class="h-10 w-10 rounded-full bg-[#0284c7] cursor-pointer ring-2 ring-primary avatar-color" data-color="0284c7"></div>
                                    <div class="h-10 w-10 rounded-full bg-[#dc2626] cursor-pointer avatar-color" data-color="dc2626"></div>
                                    <div class="h-10 w-10 rounded-full bg-[#65a30d] cursor-pointer avatar-color" data-color="65a30d"></div>
                                    <div class="h-10 w-10 rounded-full bg-[#7c3aed] cursor-pointer avatar-color" data-color="7c3aed"></div>
                                    <div class="h-10 w-10 rounded-full bg-[#ec4899] cursor-pointer avatar-color" data-color="ec4899"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h2 class="font-itim text-2xl text-primary mb-4">Game Settings</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="max_players" class="block text-sm font-medium text-gray-700 mb-1">Number of Players</label>
                                <select name="max_players" id="max_players" 
                                        class="magic-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    <option value="2">2 Players</option>
                                    <option value="3">3 Players</option>
                                    <option value="4">4 Players</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="turn_time" class="block text-sm font-medium text-gray-700 mb-1">Turn Time Limit</label>
                                <select name="turn_time" id="turn_time" 
                                        class="magic-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    <option value="30">30 Seconds</option>
                                    <option value="60" selected>1 Minute</option>
                                    <option value="90">1.5 Minutes</option>
                                    <option value="120">2 Minutes</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="initial_cards" class="block text-sm font-medium text-gray-700 mb-1">Starting Hand Size</label>
                                <select name="initial_cards" id="initial_cards" 
                                        class="magic-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    <option value="3">3 Cards</option>
                                    <option value="4" selected>4 Cards</option>
                                    <option value="5">5 Cards</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="game_mode" class="block text-sm font-medium text-gray-700 mb-1">Game Mode</label>
                                <select name="game_mode" id="game_mode" 
                                        class="magic-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                    <option value="standard">Standard</option>
                                    <option value="draft">Draft</option>
                                    <option value="arena">Arena</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-center space-x-4">
                        <?php echo $theme->renderButton('Create Game', 'primary', 'lg', '', 'type="submit"', 'gamepad'); ?>
                        <?php echo $theme->renderButton('Cancel', 'secondary', 'lg', 'battle.php'); ?>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-10 mt-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-itim mb-4 text-blue-300">Azure Cards</h3>
                    <p class="text-blue-100 mb-4">The ultimate magical card game with stunning visuals and strategic gameplay.</p>
                </div>
                
                <div>
                    <h3 class="text-xl font-itim mb-4 text-blue-300">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-blue-100 hover:text-white">Home</a></li>
                        <li><a href="collection.php" class="text-blue-100 hover:text-white">Card Collection</a></li>
                        <li><a href="battle.php" class="text-blue-100 hover:text-white">Battle Arena</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-itim mb-4 text-blue-300">Contact</h3>
                    <p class="text-blue-100">
                        <i class="fas fa-envelope mr-2"></i> support@azurecards.com
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        // Copy join URL to clipboard
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            element.select();
            document.execCommand('copy');
            
            // Show success message
            createMagicalAlert('success', 'Link copied to clipboard!');
        }
        
        // Avatar color selection
        document.addEventListener('DOMContentLoaded', function() {
            const avatarColors = document.querySelectorAll('.avatar-color');
            const avatarColorInput = document.getElementById('avatar_color');
            
            avatarColors.forEach(color => {
                color.addEventListener('click', function() {
                    // Remove active class from all colors
                    avatarColors.forEach(c => c.classList.remove('ring-2', 'ring-primary'));
                    
                    // Add active class to selected color
                    this.classList.add('ring-2', 'ring-primary');
                    
                    // Update hidden input value
                    avatarColorInput.value = this.getAttribute('data-color');
                });
            });
        });
    </script>
</body>
</html>
