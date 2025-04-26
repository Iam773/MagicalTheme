<?php
require_once 'MagicalTheme.php';

// Initialize the theme with blue color scheme
$theme = new MagicalTheme('blue');

// Set custom navigation items for a card game
$navItems = [
    'Home' => [
        'url' => 'index.php',
        'icon' => 'fa-home'
    ],
    'Card Collection' => [
        'url' => 'collection.php',
        'icon' => 'fa-layer-group',
        'badge' => '42'
    ],
    'Battle Arena' => [
        'url' => 'battle.php',
        'icon' => 'fa-swords',
        'submenu' => [
            'PvP Matches' => 'pvp.php',
            'Tournament' => 'tournament.php',
            'Practice Mode' => 'practice.php'
        ]
    ],
    'Shop' => [
        'url' => 'shop.php',
        'icon' => 'fa-store',
        'badge' => '<span class="bg-warning/90 text-dark text-xs py-0.5 px-2 rounded-full font-bold">New</span>'
    ],
    'Leaderboard' => 'leaderboard.php',
    'Profile' => [
        'url' => 'profile.php',
        'icon' => 'fa-user',
        'active' => true
    ]
];
$theme->setNavItems($navItems);

// Mock player data - in a real app, this would come from the database
$player = [
    'id' => 1,
    'username' => 'IceWizard',
    'avatar' => 'https://placehold.co/200x200/0284c7/ffffff?text=IW',
    'level' => 31,
    'xp' => 2750,
    'xp_next' => 3000,
    'tier' => 'Diamond',
    'joined_date' => '2023-06-15',
    'last_active' => '2023-11-28 14:35:22',
    'bio' => 'Water element master. Tournament finalist. Collector of rare cards. Looking for skilled opponents!',
    'currency' => [
        'coins' => 3452,
        'crystals' => 840,
        'dust' => 1205
    ]
];

// Player statistics
$stats = [
    'wins' => 542,
    'losses' => 267,
    'draws' => 41,
    'win_rate' => 67.0,
    'longest_streak' => 14,
    'current_streak' => 3,
    'total_matches' => 850,
    'tournaments_won' => 5,
    'best_tournament_placing' => '2nd place',
    'rating' => 2495,
    'rating_percentile' => 98.2, // Top 1.8%
    'rating_history' => [2478, 2486, 2495, 2510, 2495, 2483, 2495]
];

// Card collection statistics
$collection = [
    'total_cards' => 42,
    'max_cards' => 65,
    'completion_rate' => 64.6,
    'cards_by_rarity' => [
        'common' => ['owned' => 20, 'total' => 22, 'completion' => 90.9],
        'uncommon' => ['owned' => 12, 'total' => 18, 'completion' => 66.7],
        'rare' => ['owned' => 7, 'total' => 15, 'completion' => 46.7],
        'epic' => ['owned' => 3, 'total' => 8, 'completion' => 37.5],
        'legendary' => ['owned' => 0, 'total' => 2, 'completion' => 0.0]
    ],
    'cards_by_element' => [
        'water' => ['owned' => 15, 'total' => 18, 'completion' => 83.3],
        'fire' => ['owned' => 8, 'total' => 12, 'completion' => 66.7],
        'earth' => ['owned' => 7, 'total' => 12, 'completion' => 58.3],
        'air' => ['owned' => 7, 'total' => 13, 'completion' => 53.8],
        'arcane' => ['owned' => 5, 'total' => 10, 'completion' => 50.0]
    ],
    'favorite_card' => 'Ocean Guardian',
    'most_played_card' => 'Water Elemental'
];

// Recent battle history
$battles = [
    [
        'opponent' => 'FireMaster92',
        'opponent_avatar' => 'https://placehold.co/40x40/dc2626/ffffff?text=FM',
        'opponent_tier' => 'Platinum',
        'result' => 'win',
        'score' => '3-1',
        'time' => '2023-11-28 13:42:18',
        'time_ago' => '2 hours ago',
        'rating_change' => 12,
        'deck' => 'Water Control'
    ],
    [
        'opponent' => 'StormMage',
        'opponent_avatar' => 'https://placehold.co/40x40/8b5cf6/ffffff?text=SM',
        'opponent_tier' => 'Diamond',
        'result' => 'loss',
        'score' => '2-3',
        'time' => '2023-11-27 19:15:33',
        'time_ago' => '1 day ago',
        'rating_change' => -8,
        'deck' => 'Water Aggro'
    ],
    [
        'opponent' => 'ShadowAssassin',
        'opponent_avatar' => 'https://placehold.co/40x40/1e293b/ffffff?text=SA',
        'opponent_tier' => 'Gold',
        'result' => 'win',
        'score' => '3-0',
        'time' => '2023-11-27 16:20:11',
        'time_ago' => '1 day ago',
        'rating_change' => 10,
        'deck' => 'Water Control'
    ],
    [
        'opponent' => 'NatureSage',
        'opponent_avatar' => 'https://placehold.co/40x40/65a30d/ffffff?text=NS',
        'opponent_tier' => 'Diamond',
        'result' => 'win',
        'score' => '3-2',
        'time' => '2023-11-26 20:35:46',
        'time_ago' => '2 days ago',
        'rating_change' => 15,
        'deck' => 'Water Combo'
    ],
    [
        'opponent' => 'DragonMaster',
        'opponent_avatar' => 'https://placehold.co/40x40/7c3aed/ffffff?text=DM',
        'opponent_tier' => 'Grandmaster',
        'result' => 'loss',
        'score' => '1-3',
        'time' => '2023-11-25 14:12:09',
        'time_ago' => '3 days ago',
        'rating_change' => -5,
        'deck' => 'Water Control'
    ]
];

// Player decks
$decks = [
    [
        'name' => 'Water Control',
        'cards' => 30,
        'element' => 'water',
        'win_rate' => 72.4,
        'matches' => 145,
        'created' => '2023-08-15',
        'last_updated' => '2023-11-20'
    ],
    [
        'name' => 'Water Aggro',
        'cards' => 30,
        'element' => 'water',
        'win_rate' => 65.8,
        'matches' => 79,
        'created' => '2023-09-22',
        'last_updated' => '2023-11-15'
    ],
    [
        'name' => 'Water Combo',
        'cards' => 30,
        'element' => 'water',
        'win_rate' => 58.3,
        'matches' => 42,
        'created' => '2023-10-30',
        'last_updated' => '2023-11-18'
    ]
];

// Player achievements
$achievements = [
    [
        'name' => 'Tournament Champion',
        'description' => 'Win a weekly tournament',
        'icon' => 'fa-trophy',
        'completed' => true,
        'completion_date' => '2023-10-15',
        'progress' => 100,
        'reward' => 'Exclusive Card Back'
    ],
    [
        'name' => 'Element Master',
        'description' => 'Collect 75% of all Water cards',
        'icon' => 'fa-water',
        'completed' => true,
        'completion_date' => '2023-09-28',
        'progress' => 100,
        'reward' => '200 Crystals'
    ],
    [
        'name' => 'Perfect Victory',
        'description' => 'Win a match without losing a single card',
        'icon' => 'fa-award',
        'completed' => true,
        'completion_date' => '2023-07-12',
        'progress' => 100,
        'reward' => 'Rare Card'
    ],
    [
        'name' => 'Combo Master',
        'description' => 'Play 10 cards in a single turn',
        'icon' => 'fa-link',
        'completed' => false,
        'completion_date' => null,
        'progress' => 70,
        'reward' => '100 Dust'
    ],
    [
        'name' => 'Legendary Collection',
        'description' => 'Collect all Legendary cards',
        'icon' => 'fa-crown',
        'completed' => false,
        'completion_date' => null,
        'progress' => 0,
        'reward' => 'Legendary Avatar'
    ],
    [
        'name' => '1000 Victory',
        'description' => 'Win 1000 matches',
        'icon' => 'fa-medal',
        'completed' => false,
        'completion_date' => null,
        'progress' => 54.2,
        'reward' => '500 Crystals'
    ]
];

// Friends list
$friends = [
    [
        'username' => 'StormMage',
        'avatar' => 'https://placehold.co/40x40/8b5cf6/ffffff?text=SM',
        'tier' => 'Diamond',
        'status' => 'online',
        'last_active' => 'Playing Now'
    ],
    [
        'username' => 'FireMaster92',
        'avatar' => 'https://placehold.co/40x40/dc2626/ffffff?text=FM',
        'tier' => 'Platinum',
        'status' => 'online',
        'last_active' => 'In Shop'
    ],
    [
        'username' => 'NatureSage',
        'avatar' => 'https://placehold.co/40x40/65a30d/ffffff?text=NS',
        'tier' => 'Diamond',
        'status' => 'offline',
        'last_active' => '3 hours ago'
    ],
    [
        'username' => 'ShadowAssassin',
        'avatar' => 'https://placehold.co/40x40/1e293b/ffffff?text=SA',
        'tier' => 'Gold',
        'status' => 'offline',
        'last_active' => '1 day ago'
    ]
];

// Recent activity feed
$activities = [
    [
        'type' => 'battle',
        'description' => 'Won a match against FireMaster92',
        'time_ago' => '2 hours ago',
        'icon' => 'fa-gamepad'
    ],
    [
        'type' => 'collection',
        'description' => 'Acquired new card: Frost Nova',
        'time_ago' => '5 hours ago',
        'icon' => 'fa-layer-group'
    ],
    [
        'type' => 'achievement',
        'description' => 'Earned achievement: 50 Wins Streak',
        'time_ago' => '1 day ago',
        'icon' => 'fa-award'
    ],
    [
        'type' => 'tournament',
        'description' => 'Qualified for weekend tournament finals',
        'time_ago' => '2 days ago',
        'icon' => 'fa-trophy'
    ],
    [
        'type' => 'deck',
        'description' => 'Updated deck: Water Control',
        'time_ago' => '1 week ago',
        'icon' => 'fa-edit'
    ]
];

// Helper function to get tier color
function getTierColor($tier) {
    switch($tier) {
        case 'Grandmaster': return 'bg-purple-700 text-white';
        case 'Master': return 'bg-red-600 text-white';
        case 'Diamond': return 'bg-blue-500 text-white';
        case 'Platinum': return 'bg-cyan-500 text-white';
        case 'Gold': return 'bg-amber-400 text-black';
        case 'Silver': return 'bg-gray-400 text-black';
        case 'Bronze': return 'bg-amber-700 text-white';
        default: return 'bg-gray-700 text-white';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $player['username']; ?>'s Profile - Azure Cards</title>
    <?php echo $theme->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to our custom CSS file -->
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
    <?php include 'includes/nav.php'; ?>
    
    <div class="container mx-auto px-4 py-6">
        <!-- Profile Header -->
        <div class="game-banner shadow-magical mb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start">
                <div class="relative">
                    <img src="<?php echo $player['avatar']; ?>" alt="<?php echo $player['username']; ?>" class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
                    <div class="absolute -bottom-2 -right-2 w-12 h-12 flex items-center justify-center rounded-full text-lg font-bold bg-gradient-to-br from-primary to-secondary text-white">
                        <?php echo $player['level']; ?>
                    </div>
                </div>
                
                <div class="md:ml-6 mt-4 md:mt-0 text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-itim text-white mb-1 text-shadow-[0_2px_5px_rgba(0,0,0,0.3)]"><?php echo $player['username']; ?></h1>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-3 mb-2">
                        <span class="px-3 py-0.5 rounded-full <?php echo getTierColor($player['tier']); ?> text-sm font-bold">
                            <?php echo $player['tier']; ?>
                        </span>
                        <span class="px-3 py-0.5 rounded-full bg-blue-600/20 text-white text-sm font-medium flex items-center">
                            <i class="fas fa-calendar-alt mr-1"></i> Joined <?php echo date('M Y', strtotime($player['joined_date'])); ?>
                        </span>
                        <span class="px-3 py-0.5 rounded-full bg-green-600/20 text-white text-sm font-medium flex items-center">
                            <i class="fas fa-circle text-xs mr-1"></i> Online
                        </span>
                    </div>
                    
                    <p class="text-white/80 md:max-w-2xl"><?php echo $player['bio']; ?></p>
                </div>
                
                <div class="mt-4 md:mt-0 md:ml-auto flex gap-4">
                    <?php echo $theme->renderButton('Edit Profile', 'secondary', 'md', 'edit-profile.php', '', 'edit'); ?>
                    <?php echo $theme->renderButton('Settings', 'secondary', 'md', 'settings.php', '', 'cog'); ?>
                </div>
            </div>
            
            <div class="mt-6 pt-6 border-t border-white/20 flex flex-col md:flex-row justify-between">
                <div class="grid grid-cols-3 gap-6 w-full md:w-auto">
                    <div class="bg-white/10 backdrop-blur-sm py-2 px-4 rounded-lg text-center">
                        <div class="text-white text-3xl font-bold"><?php echo number_format($player['currency']['coins']); ?></div>
                        <div class="text-white/80 text-sm flex items-center justify-center">
                            <i class="fas fa-coins mr-1 text-yellow-300"></i> Coins
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm py-2 px-4 rounded-lg text-center">
                        <div class="text-white text-3xl font-bold"><?php echo number_format($player['currency']['crystals']); ?></div>
                        <div class="text-white/80 text-sm flex items-center justify-center">
                            <i class="fas fa-gem mr-1 text-blue-300"></i> Crystals
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm py-2 px-4 rounded-lg text-center">
                        <div class="text-white text-3xl font-bold"><?php echo number_format($player['currency']['dust']); ?></div>
                        <div class="text-white/80 text-sm flex items-center justify-center">
                            <i class="fas fa-magic mr-1 text-purple-300"></i> Dust
                        </div>
                    </div>
                </div>
                
                <div class="md:w-1/3 mt-6 md:mt-0">
                    <div class="bg-white/10 backdrop-blur-sm p-3 rounded-lg">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-white text-sm">Level <?php echo $player['level']; ?></span>
                            <span class="text-white text-sm"><?php echo $player['xp']; ?>/<?php echo $player['xp_next']; ?> XP</span>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full" style="width: <?php echo ($player['xp']/$player['xp_next']*100); ?>%"></div>
                        </div>
                        <div class="text-white/80 text-xs mt-1 text-right"><?php echo $player['xp_next'] - $player['xp']; ?> XP to Level <?php echo $player['level']+1; ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Statistics Section -->
                <div class="magic-card">
                    <h2 class="text-2xl font-itim text-primary mb-6 flex items-center">
                        <i class="fas fa-chart-line mr-3"></i> Battle Statistics
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-success/10 p-4 rounded-lg text-center">
                            <div class="text-success text-3xl font-bold"><?php echo number_format($stats['wins']); ?></div>
                            <div class="text-gray-600 text-sm">Wins</div>
                        </div>
                        <div class="bg-danger/10 p-4 rounded-lg text-center">
                            <div class="text-danger text-3xl font-bold"><?php echo number_format($stats['losses']); ?></div>
                            <div class="text-gray-600 text-sm">Losses</div>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg text-center">
                            <div class="text-gray-700 text-3xl font-bold"><?php echo number_format($stats['draws']); ?></div>
                            <div class="text-gray-600 text-sm">Draws</div>
                        </div>
                        <div class="bg-primary/10 p-4 rounded-lg text-center">
                            <div class="text-primary text-3xl font-bold"><?php echo $stats['win_rate']; ?>%</div>
                            <div class="text-gray-600 text-sm">Win Rate</div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-itim text-lg text-primary mb-3">Rating History</h3>
                            <div class="h-48 bg-blue-50/50 rounded-lg p-3">
                                <canvas id="ratingChart"></canvas>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-itim text-lg text-primary mb-3">More Stats</h3>
                            <ul class="space-y-2">
                                <li class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">Total Matches</span>
                                    <span class="font-medium"><?php echo number_format($stats['total_matches']); ?></span>
                                </li>
                                <li class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">Current Win Streak</span>
                                    <span class="font-medium"><?php echo $stats['current_streak']; ?></span>
                                </li>
                                <li class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">Longest Win Streak</span>
                                    <span class="font-medium"><?php echo $stats['longest_streak']; ?></span>
                                </li>
                                <li class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">Tournaments Won</span>
                                    <span class="font-medium"><?php echo $stats['tournaments_won']; ?></span>
                                </li>
                                <li class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-600">Best Tournament Result</span>
                                    <span class="font-medium"><?php echo $stats['best_tournament_placing']; ?></span>
                                </li>
                                <li class="flex justify-between pb-2">
                                    <span class="text-gray-600">Rating Percentile</span>
                                    <span class="font-medium">Top <?php echo number_format(100 - $stats['rating_percentile'], 1); ?>%</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Battles -->
                <div class="magic-card">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-itim text-primary flex items-center">
                            <i class="fas fa-gamepad mr-3"></i> Recent Battles
                        </h2>
                        <a href="battle-history.php" class="text-sm text-primary hover:text-primary-dark">View All</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opponent</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deck</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">When</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach($battles as $battle): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <img class="h-8 w-8 rounded-full" src="<?php echo $battle['opponent_avatar']; ?>" alt="<?php echo $battle['opponent']; ?>">
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900"><?php echo $battle['opponent']; ?></div>
                                                <div class="text-xs text-gray-500"><?php echo $battle['opponent_tier']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $battle['result'] === 'win' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                            <?php echo ucfirst($battle['result']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $battle['score']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $battle['deck']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <span class="<?php echo $battle['rating_change'] > 0 ? 'text-green-600' : 'text-red-600'; ?>">
                                            <?php echo $battle['rating_change'] > 0 ? '+' . $battle['rating_change'] : $battle['rating_change']; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $battle['time_ago']; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Decks Section -->
                <div class="magic-card">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-itim text-primary flex items-center">
                            <i class="fas fa-layer-group mr-3"></i> Your Decks
                        </h2>
                        <a href="decks.php" class="text-sm text-primary hover:text-primary-dark">Manage Decks</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php foreach($decks as $deck): ?>
                        <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                                <h3 class="font-itim text-lg text-primary"><?php echo $deck['name']; ?></h3>
                                <div class="flex items-center mt-1">
                                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                                    <span class="text-sm text-gray-600"><?php echo ucfirst($deck['element']); ?> Element</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Win Rate</span>
                                    <span class="font-medium"><?php echo $deck['win_rate']; ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4">
                                    <div class="bg-primary h-1.5 rounded-full" style="width: <?php echo $deck['win_rate']; ?>%"></div>
                                </div>
                                
                                <div class="flex justify-between text-xs text-gray-500 mb-3">
                                    <span>Cards: <?php echo $deck['cards']; ?></span>
                                    <span>Matches: <?php echo $deck['matches']; ?></span>
                                </div>
                                
                                <div class="flex justify-center">
                                    <a href="deck.php?id=<?php echo urlencode($deck['name']); ?>" class="text-sm bg-primary/10 hover:bg-primary/20 text-primary px-4 py-1 rounded-full transition-colors">
                                        View Deck
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <div class="border border-dashed border-gray-300 rounded-lg flex items-center justify-center p-8 hover:border-primary transition-colors">
                            <a href="create-deck.php" class="text-center">
                                <i class="fas fa-plus-circle text-4xl text-gray-400 mb-2"></i>
                                <div class="text-sm font-medium text-gray-600">Create New Deck</div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Achievements -->
                <div class="magic-card">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-itim text-primary flex items-center">
                            <i class="fas fa-award mr-3"></i> Achievements
                        </h2>
                        <a href="achievements.php" class="text-sm text-primary hover:text-primary-dark">View All</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach($achievements as $achievement): ?>
                        <div class="border border-gray-200 rounded-lg p-4 <?php echo $achievement['completed'] ? 'bg-gradient-to-br from-yellow-50 to-amber-50' : 'bg-gray-50'; ?>">
                            <div class="flex items-start">
                                <div class="w-12 h-12 flex items-center justify-center rounded-full <?php echo $achievement['completed'] ? 'bg-yellow-400' : 'bg-gray-300'; ?> text-white text-xl">
                                    <i class="fas <?php echo $achievement['icon']; ?>"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h4 class="font-itim text-lg <?php echo $achievement['completed'] ? 'text-primary' : 'text-gray-500'; ?>"><?php echo $achievement['name']; ?></h4>
                                    <p class="text-sm text-gray-600 mb-2"><?php echo $achievement['description']; ?></p>
                                    
                                    <?php if(!$achievement['completed']): ?>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1">
                                        <div class="bg-primary h-1.5 rounded-full" style="width: <?php echo $achievement['progress']; ?>%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500"><?php echo $achievement['progress']; ?>% Complete</div>
                                    <?php else: ?>
                                    <div class="text-xs text-gray-500">Completed <?php echo date('M d, Y', strtotime($achievement['completion_date'])); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mt-3 pt-2 border-t border-gray-200 text-xs text-gray-600">
                                <span class="font-medium">Reward:</span> <?php echo $achievement['reward']; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Card Collection Stats -->
                <div class="magic-card">
                    <h2 class="text-xl font-itim text-primary mb-5 flex items-center">
                        <i class="fas fa-cards mr-2"></i> Collection Progress
                    </h2>
                    
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-600 text-sm">Overall Completion</span>
                            <span class="text-sm font-medium"><?php echo $collection['completion_rate']; ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-primary h-2.5 rounded-full" style="width: <?php echo $collection['completion_rate']; ?>%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 text-right"><?php echo $collection['total_cards']; ?>/<?php echo $collection['max_cards']; ?> Cards Collected</div>
                    </div>
                    
                    <h3 class="font-itim text-lg text-primary mb-3">By Rarity</h3>
                    <div class="space-y-3 mb-6">
                        <?php foreach($collection['cards_by_rarity'] as $rarity => $data): ?>
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="capitalize text-sm text-gray-600"><?php echo $rarity; ?></span>
                                <span class="text-xs font-medium"><?php echo $data['owned']; ?>/<?php echo $data['total']; ?></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-primary h-1.5 rounded-full" style="width: <?php echo $data['completion']; ?>%"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <h3 class="font-itim text-lg text-primary mb-3">By Element</h3>
                    <div class="space-y-3 mb-6">
                        <?php foreach($collection['cards_by_element'] as $element => $data): 
                            $elementColor = getElementColor($element);
                        ?>
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full mr-2" style="background-color: <?php echo $elementColor; ?>"></div>
                                    <span class="capitalize text-sm text-gray-600"><?php echo $element; ?></span>
                                </div>
                                <span class="text-xs font-medium"><?php echo $data['owned']; ?>/<?php echo $data['total']; ?></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full" style="background-color: <?php echo $elementColor; ?>; width: <?php echo $data['completion']; ?>%"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="text-center">
                        <?php echo $theme->renderButton('View Collection', 'secondary', 'md', 'collection.php', '', 'layer-group'); ?>
                    </div>
                </div>
                
                <!-- Friends List -->
                <div class="magic-card">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-itim text-primary flex items-center">
                            <i class="fas fa-user-friends mr-2"></i> Friends
                        </h2>
                        <a href="friends.php" class="text-sm text-primary hover:text-primary-dark">Manage</a>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <?php foreach($friends as $friend): ?>
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <div class="flex items-center">
                                <div class="relative">
                                    <img src="<?php echo $friend['avatar']; ?>" alt="<?php echo $friend['username']; ?>" class="w-10 h-10 rounded-full">
                                    <div class="w-3 h-3 absolute bottom-0 right-0 rounded-full border-2 border-white <?php echo $friend['status'] === 'online' ? 'bg-green-500' : 'bg-gray-400'; ?>"></div>
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium text-sm"><?php echo $friend['username']; ?></div>
                                    <div class="text-xs text-gray-500"><?php echo $friend['last_active']; ?></div>
                                </div>
                            </div>
                            <div class="text-xs px-2 py-0.5 rounded-full <?php echo getTierColor($friend['tier']); ?>">
                                <?php echo $friend['tier']; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="flex justify-center">
                        <button class="text-sm bg-primary/10 hover:bg-primary/20 text-primary px-4 py-1 rounded-full transition-colors">
                            <i class="fas fa-user-plus mr-1"></i> Add Friend
                        </button>
                    </div>
                </div>
                
                <!-- Activity Feed -->
                <div class="magic-card">
                    <h2 class="text-xl font-itim text-primary mb-5 flex items-center">
                        <i class="fas fa-history mr-2"></i> Recent Activity
                    </h2>
                    
                    <div class="space-y-4">
                        <?php foreach($activities as $activity): ?>
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center">
                                    <i class="fas <?php echo $activity['icon']; ?> text-primary text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600"><?php echo $activity['description']; ?></p>
                                <span class="text-xs text-gray-500"><?php echo $activity['time_ago']; ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Upcoming Events -->
                <div class="magic-card">
                    <h2 class="text-xl font-itim text-primary mb-5 flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i> Upcoming Events
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-3">
                            <div class="text-xs text-primary font-medium mb-1">THIS WEEKEND</div>
                            <h3 class="font-itim text-lg text-primary mb-1">Water Element Tournament</h3>
                            <p class="text-sm text-gray-600 mb-3">Compete with your water element decks for exclusive rewards!</p>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500">Saturday, 10:00 AM</span>
                                <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded-full">Registered</span>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-xs text-gray-500 font-medium mb-1">NEXT WEEK</div>
                            <h3 class="font-itim text-lg text-gray-700 mb-1">Season Championship</h3>
                            <p class="text-sm text-gray-600 mb-3">End of season championship with huge crystal prizes!</p>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500">Dec 15, 12:00 PM</span>
                                <span class="bg-gray-200 text-gray-800 px-2 py-0.5 rounded-full">Qualify Now</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-10 mt-10">
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
        document.addEventListener('DOMContentLoaded', function() {
            // Rating history chart
            const ratingCtx = document.getElementById('ratingChart').getContext('2d');
            const ratingData = <?php echo json_encode($stats['rating_history']); ?>;
            const ratingLabels = ['7 Days Ago', '6 Days Ago', '5 Days Ago', '4 Days Ago', '3 Days Ago', '2 Days Ago', 'Today'];
            
            const ratingChart = new Chart(ratingCtx, {
                type: 'line',
                data: {
                    labels: ratingLabels,
                    datasets: [{
                        label: 'Rating',
                        data: ratingData,
                        backgroundColor: 'rgba(56, 189, 248, 0.1)',
                        borderColor: 'rgba(56, 189, 248, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(56, 189, 248, 1)',
                        pointRadius: 4,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            bodyFont: {
                                size: 13
                            },
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Rating: ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: Math.min(...ratingData) - 20,
                            grid: {
                                drawBorder: false,
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)',
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        });
        
        // Helper function to get element color
        function getElementColor(element) {
            switch(element) {
                case 'water': return '#0284c7';
                case 'fire': return '#dc2626';
                case 'earth': return '#65a30d';
                case 'air': return '#0ea5e9';
                case 'arcane': return '#8b5cf6';
                default: return '#64748b';
            }
        }
    </script>
</body>
</html>
<?php
// Helper function to get element color
function getElementColor($element) {
    switch($element) {
        case 'water': return '#0284c7';
        case 'fire': return '#dc2626';
        case 'earth': return '#65a30d';
        case 'air': return '#0ea5e9';
        case 'arcane': return '#8b5cf6';
        default: return '#64748b';
    }
}
?>
