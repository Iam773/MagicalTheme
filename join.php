<?php
require_once 'MagicalTheme.php';
require_once 'game/GameManager.php';

// Initialize the theme with blue color scheme
$theme = new MagicalTheme('blue');

// Get game ID from URL
$gameId = $_GET['game'] ?? '';
$gameData = null;
$joinStatus = null;
$errorMessage = null;

// Check if game exists
if (!empty($gameId)) {
    $gameData = GameManager::loadGame($gameId);
    
    // If game doesn't exist, show error
    if (!$gameData) {
        $errorMessage = "Game room not found. Please check the ID and try again.";
    }
    // If game is not accepting players, show error
    else if ($gameData['status'] !== 'waiting') {
        $errorMessage = "This game is no longer accepting new players.";
    }
    // If game is full, show error
    else if (count($gameData['players']) >= $gameData['options']['maxPlayers']) {
        $errorMessage = "This game room is full.";
    }
}

// Check if form was submitted to join game
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($gameId) && $gameData && !$errorMessage) {
    // Get player name
    $playerName = $_POST['player_name'] ?? 'Player';
    if (empty($playerName)) $playerName = 'Player';
    
    // Generate avatar
    $avatarColor = $_POST['avatar_color'] ?? '0284c7';
    $playerAvatar = "https://placehold.co/200x200/{$avatarColor}/ffffff?text=" . substr($playerName, 0, 2);
    
    // Join the game
    $joinStatus = GameManager::joinGame($gameId, $playerName, $playerAvatar);
    
    // If successful, store player ID in session
    if ($joinStatus['status'] === 'success') {
        session_start();
        $_SESSION['player_id'] = $joinStatus['playerId'];
        $_SESSION['player_name'] = $playerName;
        $_SESSION['game_id'] = $gameId;
    } else {
        $errorMessage = $joinStatus['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Game - Azure Cards</title>
    <?php echo $theme->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to our custom CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <?php include 'includes/nav.php'; ?>
    
    <div class="container mx-auto px-4 py-6 min-h-screen">
        <div class="max-w-3xl mx-auto">
            <?php if ($joinStatus && $joinStatus['status'] === 'success'): ?>
                <!-- Successfully joined game -->
                <div class="magic-card shadow-magical mt-10 bg-gradient-to-br from-primary/5 to-secondary/5">
                    <div class="text-center mb-8">
                        <div class="inline-block p-5 bg-success/10 rounded-full mb-4">
                            <i class="fas fa-check text-4xl text-success"></i>
                        </div>
                        <h1 class="font-itim text-4xl text-primary mb-2">Successfully Joined Game!</h1>
                        <p class="text-gray-600">You have successfully joined the game room.</p>
                    </div>
                    
                    <div class="bg-dark/5 backdrop-blur-sm rounded-xl p-6 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-500">Game ID:</span>
                            <span class="font-mono text-lg text-primary font-bold"><?php echo $gameId; ?></span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Players:</span>
                            <span class="font-medium"><?php echo $joinStatus['currentPlayers']; ?> / <?php echo $joinStatus['maxPlayers']; ?></span>
                        </div>
                    </div>
                    
                    <div class="text-center space-y-4">
                        <p class="text-sm text-gray-600 mb-4">
                            <?php if ($joinStatus['currentPlayers'] < $joinStatus['maxPlayers']): ?>
                                Waiting for other players to join...
                            <?php else: ?>
                                All players have joined! The game will start shortly.
                            <?php endif; ?>
                        </p>
                        
                        <div class="flex justify-center space-x-4">
                            <?php echo $theme->renderButton('Enter Game Lobby', 'primary', 'lg', 'gameplay.php?game_id=' . $gameId, '', 'door-open'); ?>
                            <?php echo $theme->renderButton('Leave Game', 'secondary', 'lg', 'battle.php', '', 'sign-out-alt'); ?>
                        </div>
                    </div>
                </div>
            <?php elseif (!empty($gameId) && $gameData && !$errorMessage): ?>
                <!-- Show join form -->
                <h1 class="font-itim text-4xl text-primary text-center mb-8">Join Game</h1>
                
                <div class="magic-card shadow-magical mb-8">
                    <h2 class="font-itim text-2xl text-primary mb-4">Game Information</h2>
                    
                    <div class="bg-dark/5 backdrop-blur-sm rounded-xl p-6 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-500">Game ID:</span>
                            <span class="font-mono text-lg text-primary font-bold"><?php echo $gameId; ?></span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-500">Created by:</span>
                            <span class="font-medium"><?php echo $gameData['players'][0]['name']; ?></span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-500">Players:</span>
                            <span class="font-medium"><?php echo count($gameData['players']); ?> / <?php echo $gameData['options']['maxPlayers']; ?></span>
                        </div>
                    </div>
                    
                    <form method="POST" action="join.php?game=<?php echo $gameId; ?>">
                        <div class="mb-6">
                            <h3 class="font-itim text-xl text-primary mb-4">Your Information</h3>
                            
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
                        
                        <div class="flex justify-center space-x-4">
                            <?php echo $theme->renderButton('Join Game', 'primary', 'lg', '', 'type="submit"', 'sign-in-alt'); ?>
                            <?php echo $theme->renderButton('Cancel', 'secondary', 'lg', 'battle.php'); ?>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <!-- Show error or game ID entry form -->
                <div class="magic-card shadow-magical mt-10">
                    <h1 class="font-itim text-3xl text-primary mb-6 text-center">Join a Game</h1>
                    
                    <?php if ($errorMessage): ?>
                        <div class="bg-danger/10 text-danger p-4 rounded-lg mb-6">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="join.php" method="GET" class="mb-6">
                        <div class="mb-4">
                            <label for="game" class="block text-sm font-medium text-gray-700 mb-1">Game ID</label>
                            <input type="text" name="game" id="game" 
                                   class="magic-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                   placeholder="Enter the 8-character game ID" required>
                        </div>
                        
                        <div class="flex justify-center">
                            <?php echo $theme->renderButton('Find Game', 'primary', 'md', '', 'type="submit"', 'search'); ?>
                        </div>
                    </form>
                    
                    <div class="text-center border-t border-gray-200 pt-6">
                        <p class="text-gray-600 mb-4">Don't have a game ID? Create your own game!</p>
                        <?php echo $theme->renderButton('Create Game', 'secondary', 'md', 'create-game.php', '', 'plus'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
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
