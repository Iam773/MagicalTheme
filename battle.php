<?php
require_once 'MagicalTheme.php';

// Initialize the theme with blue color scheme
$theme = new MagicalTheme('blue');

// Battle mode data
$battleModes = [
    'pvp' => [
        'name' => 'PvP Battle',
        'description' => 'Challenge other players in real-time battles',
        'players' => '1,234',
        'status' => 'active',
        'icon' => 'fa-users',
        'image' => 'https://placehold.co/600x400/0284c7/ffffff?text=PvP+Arena',
        'button_text' => 'Find Match'
    ],
    'tournament' => [
        'name' => 'Tournament',
        'description' => 'Compete in weekly tournaments for exclusive rewards',
        'players' => '578',
        'status' => 'active',
        'icon' => 'fa-trophy',
        'image' => 'https://placehold.co/600x400/4f46e5/ffffff?text=Tournament+Arena',
        'button_text' => 'Join Tournament'
    ],
    'practice' => [
        'name' => 'Practice',
        'description' => 'Hone your skills against the AI',
        'players' => '342',
        'status' => 'active',
        'icon' => 'fa-robot',
        'image' => 'https://placehold.co/600x400/65a30d/ffffff?text=Practice+Arena',
        'button_text' => 'Start Practice'
    ],
    'story' => [
        'name' => 'Story Mode',
        'description' => 'Experience the epic saga of Azure Cards',
        'players' => '756',
        'status' => 'active',
        'icon' => 'fa-book-open',
        'image' => 'https://placehold.co/600x400/0c4a6e/ffffff?text=Story+Mode',
        'button_text' => 'Continue Story'
    ]
];

// Recent match history data
$recentMatches = [
    [
        'opponent' => 'FireMaster92',
        'opponent_rank' => 'Platinum',
        'result' => 'win',
        'score' => '3-1',
        'rewards' => '120 coins, 50 XP',
        'time' => '2 hours ago'
    ],
    [
        'opponent' => 'DragonSlayer',
        'opponent_rank' => 'Diamond',
        'result' => 'loss',
        'score' => '2-3',
        'rewards' => '30 coins, 20 XP',
        'time' => '5 hours ago'
    ],
    [
        'opponent' => 'MysticWolf',
        'opponent_rank' => 'Gold',
        'result' => 'win',
        'score' => '3-0',
        'rewards' => '150 coins, 75 XP',
        'time' => '8 hours ago'
    ]
];

// Player battle statistics
$playerStats = [
    'rank' => 'Diamond',
    'rating' => 2350,
    'wins' => 124,
    'losses' => 43,
    'win_rate' => '74.3%',
    'current_streak' => 5,
    'best_streak' => 12,
    'tournaments_won' => 3,
    'favorite_card' => 'Ocean Guardian'
];

// Current tournament data
$currentTournament = [
    'name' => 'Elemental Masters Cup',
    'status' => 'active',
    'participants' => 128,
    'current_round' => 'Quarter-finals',
    'end_time' => date('Y-m-d H:i:s', strtotime('+2 days')),
    'prize_pool' => '5,000 coins + Legendary Card',
    'player_status' => 'Qualified for semi-finals'
];
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
        /* Battle page specific styles */
        .battle-mode-card {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .battle-mode-card:hover {
            transform: translateY(-10px);
        }
        
        .battle-mode-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.3) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transition: left 0.7s ease-in-out;
            z-index: 1;
        }
        
        .battle-mode-card:hover::before {
            left: 100%;
        }
        
        .battle-mode-image {
            height: 180px;
            transition: all 0.5s ease;
        }
        
        .battle-mode-card:hover .battle-mode-image {
            transform: scale(1.05);
        }
        
        .match-history-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .match-history-item.win {
            border-left-color: var(--success);
        }
        
        .match-history-item.loss {
            border-left-color: var(--danger);
        }
        
        .match-history-item:hover {
            transform: translateX(5px);
        }
        
        .player-rank {
            position: relative;
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .rank-border {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid transparent;
            border-top-color: var(--primary);
            animation: rotate 2s linear infinite;
        }
        
        .rank-inner {
            width: 80%;
            height: 80%;
            border-radius: 50%;
            background: linear-gradient(135deg, #0c4a6e, #38bdf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-family: var(--primary-font);
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.5);
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        
        .status-active {
            background-color: var(--success);
            box-shadow: 0 0 8px var(--success);
        }
        
        .tournament-timer {
            background: rgba(0,0,0,0.2);
            padding: 5px 10px;
            border-radius: 20px;
            font-family: monospace;
            letter-spacing: 1px;
        }
        
        .vs-container {
            position: relative;
        }
        
        .vs-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(56, 189, 248, 0.5);
        }
    </style>
</head>
<body class="bg-light">
    <?php 
    // Include the navigation file
    include 'includes/nav.php'; 
    ?>
    
    <div class="container mx-auto px-4 py-6">
        <!-- Battle Arena Banner -->
        <div class="game-banner shadow-magical mb-10">
            <h1 class="text-4xl md:text-5xl font-itim text-white mb-2 text-shadow-[0_2px_5px_rgba(0,0,0,0.3)]">Battle Arena</h1>
            <p class="text-white text-xl md:text-2xl font-itim opacity-90">Test your skills and strategy against others!</p>
            
            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center gap-2">
                    <div class="bg-white/10 backdrop-blur-sm py-1 px-3 rounded-full text-white">
                        <span class="font-bold">2,910</span> Players Online
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm py-1 px-3 rounded-full text-white">
                        <span class="font-bold">324</span> Battles in Progress
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <?php echo $theme->renderButton('View Leaderboard', 'secondary', 'md', 'leaderboard.php', '', 'ranking-star'); ?>
                </div>
            </div>
        </div>
        
        <!-- Battle Modes Section -->
        <div class="magic-card mb-10">
            <h2 class="text-2xl font-itim text-primary mb-6 flex items-center">
                <i class="fas fa-gamepad mr-3 text-primary"></i> Battle Modes
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($battleModes as $key => $mode): ?>
                <div class="battle-mode-card magic-card transition-transform shadow-lg">
                    <div class="relative overflow-hidden rounded-t-xl">
                        <img src="<?php echo $mode['image']; ?>" alt="<?php echo $mode['name']; ?>" class="w-full battle-mode-image object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent px-4 py-3">
                            <div class="flex justify-between items-center">
                                <h3 class="text-white font-itim text-lg"><?php echo $mode['name']; ?></h3>
                                <div class="flex items-center">
                                    <span class="status-indicator status-active"></span>
                                    <span class="text-white text-sm"><?php echo $mode['players']; ?> online</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <p class="text-gray-600 mb-4 h-12"><?php echo $mode['description']; ?></p>
                        <?php echo $theme->renderButton($mode['button_text'], 'primary', 'md', $key.'.php', 'w-full', $mode['icon']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Battle Statistics and History -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            <!-- Player Battle Statistics -->
            <div class="magic-card">
                <h2 class="text-xl font-itim text-primary mb-5 flex items-center">
                    <i class="fas fa-chart-line mr-2"></i> Your Battle Stats
                </h2>
                
                <div class="flex flex-col items-center mb-6">
                    <div class="player-rank mb-3">
                        <div class="rank-border"></div>
                        <div class="rank-inner"><?php echo $playerStats['rank']; ?></div>
                    </div>
                    <div class="text-center">
                        <h3 class="font-itim text-lg text-primary"><?php echo $playerStats['rating']; ?> Rating</h3>
                        <p class="text-sm text-gray-600">Top 5% of all players</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center p-3 bg-success/10 rounded-lg">
                        <span class="text-lg font-bold text-success"><?php echo $playerStats['wins']; ?></span>
                        <p class="text-xs text-gray-600">Wins</p>
                    </div>
                    <div class="text-center p-3 bg-danger/10 rounded-lg">
                        <span class="text-lg font-bold text-danger"><?php echo $playerStats['losses']; ?></span>
                        <p class="text-xs text-gray-600">Losses</p>
                    </div>
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <span class="text-lg font-bold text-primary"><?php echo $playerStats['win_rate']; ?></span>
                        <p class="text-xs text-gray-600">Win Rate</p>
                    </div>
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <span class="text-lg font-bold text-primary"><?php echo $playerStats['current_streak']; ?></span>
                        <p class="text-xs text-gray-600">Win Streak</p>
                    </div>
                </div>
                
                <div class="border-t border-gray-100 pt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-600">Tournaments Won</span>
                        <span class="font-bold text-primary"><?php echo $playerStats['tournaments_won']; ?></span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-600">Best Win Streak</span>
                        <span class="font-bold text-primary"><?php echo $playerStats['best_streak']; ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Favorite Card</span>
                        <span class="font-bold text-primary"><?php echo $playerStats['favorite_card']; ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Match History -->
            <div class="magic-card">
                <h2 class="text-xl font-itim text-primary mb-5 flex items-center">
                    <i class="fas fa-history mr-2"></i> Recent Matches
                </h2>
                
                <div class="space-y-4">
                    <?php foreach ($recentMatches as $match): ?>
                    <div class="match-history-item <?php echo $match['result']; ?> p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="flex items-center">
                                    <span class="font-itim text-primary"><?php echo $match['opponent']; ?></span>
                                    <span class="ml-2 text-xs bg-blue-100 text-primary px-2 py-0.5 rounded-full"><?php echo $match['opponent_rank']; ?></span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <span class="font-medium <?php echo $match['result'] === 'win' ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo ucfirst($match['result']); ?>
                                    </span>
                                    <span class="mx-1">•</span>
                                    <span><?php echo $match['score']; ?></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-500"><?php echo $match['time']; ?></div>
                                <div class="text-xs text-primary mt-1"><?php echo $match['rewards']; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-5">
                    <?php echo $theme->renderButton('View Full History', 'secondary', 'sm', 'history.php', 'w-full', 'list'); ?>
                </div>
            </div>
            
            <!-- Current Tournament -->
            <div class="magic-card bg-gradient-to-br from-dark/80 to-dark text-white">
                <h2 class="text-xl font-itim text-blue-300 mb-5 flex items-center">
                    <i class="fas fa-trophy mr-2 text-warning"></i> <?php echo $currentTournament['name']; ?>
                </h2>
                
                <div class="bg-white/10 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-blue-200">Status</span>
                        <div>
                            <span class="status-indicator status-active"></span>
                            <span class="text-sm"><?php echo $currentTournament['status']; ?></span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-blue-200">Participants</span>
                        <span><?php echo $currentTournament['participants']; ?></span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-blue-200">Current Round</span>
                        <span><?php echo $currentTournament['current_round']; ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-blue-200">Ends In</span>
                        <span class="tournament-timer">47:16:22</span>
                    </div>
                </div>
                
                <div class="bg-white/10 rounded-lg p-4 mb-4">
                    <div class="text-center mb-2">
                        <span class="text-sm text-blue-200">Prize Pool</span>
                        <div class="font-itim text-lg text-warning"><?php echo $currentTournament['prize_pool']; ?></div>
                    </div>
                </div>
                
                <div class="bg-success/20 rounded-lg p-3 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-success"></i>
                        <span class="text-sm"><?php echo $currentTournament['player_status']; ?></span>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <?php echo $theme->renderButton('Tournament Bracket', 'secondary', 'sm', 'tournament.php', 'flex-1', 'sitemap'); ?>
                    <?php echo $theme->renderButton('My Match', 'primary', 'sm', 'tournament-match.php', 'flex-1', 'play'); ?>
                </div>
            </div>
        </div>
        
        <!-- Quick Match Section -->
        <div class="magic-card text-center my-10 py-8 px-4">
            <h2 class="text-2xl md:text-3xl font-itim text-primary mb-2">Ready for a Quick Match?</h2>
            <p class="text-lg text-gray-600 mb-4">Choose your opponent's skill level</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto mt-8">
                <div class="p-4 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 shadow-sm border border-blue-200 hover:shadow-lg transition-shadow">
                    <i class="fas fa-chess-pawn text-4xl text-primary mb-3"></i>
                    <h3 class="font-itim text-xl text-primary mb-1">Beginner</h3>
                    <p class="text-sm text-gray-600 mb-4">For casual playing and learning the basics</p>
                    <?php echo $theme->renderButton('Find Match', 'secondary', 'md', 'match.php?level=beginner', '', 'search'); ?>
                </div>
                
                <div class="p-4 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 shadow-magical border border-blue-200">
                    <i class="fas fa-chess-knight text-4xl text-primary mb-3"></i>
                    <h3 class="font-itim text-xl text-primary mb-1">Intermediate</h3>
                    <p class="text-sm text-gray-600 mb-4">For players with good understanding of strategy</p>
                    <?php echo $theme->renderButton('Find Match', 'primary', 'md', 'match.php?level=intermediate', '', 'search'); ?>
                </div>
                
                <div class="p-4 rounded-xl bg-gradient-to-br from-blue-200 to-blue-300 shadow-sm border border-blue-200 hover:shadow-lg transition-shadow">
                    <i class="fas fa-chess-king text-4xl text-primary mb-3"></i>
                    <h3 class="font-itim text-xl text-primary mb-1">Expert</h3>
                    <p class="text-sm text-gray-600 mb-4">For experienced players seeking a challenge</p>
                    <?php echo $theme->renderButton('Find Match', 'secondary', 'md', 'match.php?level=expert', '', 'search'); ?>
                </div>
            </div>
            
            <p class="mt-8 text-sm text-gray-500">
                Matches are determined by your rating and current online players
            </p>
            
            <!-- Add custom game creation option -->
            <div class="mt-12 border-t border-gray-200 pt-8">
                <h3 class="font-itim text-2xl text-primary mb-3">Create a Custom Game</h3>
                <p class="text-gray-600 mb-6">Set up your own game and invite friends to play</p>
                <div class="flex justify-center gap-4">
                    <?php echo $theme->renderButton('Create Game Room', 'primary', 'lg', 'create-game.php', '', 'plus-circle'); ?>
                    <?php echo $theme->renderButton('Join Game Room', 'secondary', 'lg', 'join.php', '', 'sign-in-alt'); ?>
                </div>
            </div>
        </div>
        
        <!-- Featured Battle -->
        <div class="magic-card mb-10">
            <h2 class="text-2xl font-itim text-primary mb-6 flex items-center">
                <i class="fas fa-star mr-3 text-warning"></i> Featured Battle
            </h2>
            
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-7 gap-4 items-center">
                    <!-- Player 1 -->
                    <div class="md:col-span-3">
                        <div class="flex items-center justify-center md:justify-end">
                            <div class="text-right mr-4 md:order-1">
                                <h3 class="font-itim text-xl text-primary">DragonLord</h3>
                                <div class="flex items-center justify-end mt-1">
                                    <span class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded-full">Diamond</span>
                                </div>
                                <div class="text-sm text-gray-600 mt-2">Rating: 2420</div>
                            </div>
                            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold md:order-2">
                                DL
                            </div>
                        </div>
                    </div>
                    
                    <!-- VS -->
                    <div class="md:col-span-1 flex justify-center">
                        <div class="vs-circle">VS</div>
                    </div>
                    
                    <!-- Player 2 -->
                    <div class="md:col-span-3">
                        <div class="flex items-center justify-center md:justify-start">
                            <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                FM
                            </div>
                            <div class="ml-4">
                                <h3 class="font-itim text-xl text-primary">FireMage</h3>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs bg-red-600 text-white px-2 py-0.5 rounded-full">Champion</span>
                                </div>
                                <div class="text-sm text-gray-600 mt-2">Rating: 2510</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-8">
                    <div class="mb-4">
                        <span class="bg-blue-600/20 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                            Tournament Finals
                        </span>
                    </div>
                    <div class="flex justify-center">
                        <?php echo $theme->renderButton('Watch Live', 'primary', 'md', 'watch-battle.php?id=finalmatch', '', 'play'); ?>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">1,245 viewers watching now</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-itim mb-4 text-blue-300">Azure Cards</h3>
                    <p class="text-blue-100 mb-4">The ultimate magical card game with stunning visuals and strategic gameplay.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-blue-300 hover:text-blue-100"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-blue-300 hover:text-blue-100"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-blue-300 hover:text-blue-100"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-blue-300 hover:text-blue-100"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-xl font-itim mb-4 text-blue-300">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-blue-100 hover:text-white">Home</a></li>
                        <li><a href="collection.php" class="text-blue-100 hover:text-white">Card Collection</a></li>
                        <li><a href="battle.php" class="text-blue-100 hover:text-white">Battle Arena</a></li>
                        <li><a href="shop.php" class="text-blue-100 hover:text-white">Card Shop</a></li>
                        <li><a href="leaderboard.php" class="text-blue-100 hover:text-white">Leaderboard</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-itim mb-4 text-blue-300">Contact</h3>
                    <ul class="space-y-2">
                        <li><i class="fas fa-envelope mr-2 text-blue-300"></i> support@azurecards.com</li>
                        <li><i class="fas fa-phone mr-2 text-blue-300"></i> (123) 456-7890</li>
                        <li><i class="fas fa-map-marker-alt mr-2 text-blue-300"></i> 123 Game Street, Virtual City</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-blue-800 mt-8 pt-8 text-center text-blue-200">
                <p>&copy; 2023 Azure Cards. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Add reference to our JavaScript file -->
    <script src="js/game.js"></script>
    
    <script>
        // Tournament countdown timer
        document.addEventListener('DOMContentLoaded', function() {
            const endTime = new Date('<?php echo $currentTournament['end_time']; ?>').getTime();
            const timerElement = document.querySelector('.tournament-timer');
            
            if (timerElement) {
                // Update the timer every second
                const timerInterval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = endTime - now;
                    
                    // Calculate time units
                    const hours = Math.floor(distance / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    // Format with leading zeros
                    const formattedHours = hours.toString().padStart(2, '0');
                    const formattedMinutes = minutes.toString().padStart(2, '0');
                    const formattedSeconds = seconds.toString().padStart(2, '0');
                    
                    // Display the formatted time
                    timerElement.textContent = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
                    
                    // If the countdown is over
                    if (distance < 0) {
                        clearInterval(timerInterval);
                        timerElement.textContent = 'ENDED';
                    }
                }, 1000);
            }
            
            // Battle mode card hover effect
            const battleModeCards = document.querySelectorAll('.battle-mode-card');
            
            battleModeCards.forEach(card => {
                card.addEventListener('click', function() {
                    const link = this.querySelector('a');
                    if (link) {
                        link.click();
                    }
                });
            });
        });
    </script>
</body>
</html>
