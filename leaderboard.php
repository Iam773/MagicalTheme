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
    'Leaderboard' => [
        'url' => 'leaderboard.php',
        'icon' => 'fa-ranking-star',
        'active' => true
    ],
    'Profile' => [
        'url' => 'profile.php',
        'icon' => 'fa-user'
    ]
];
$theme->setNavItems($navItems);

// Sample leaderboard data
$globalRankings = [
    [
        'rank' => 1,
        'name' => 'DragonMaster',
        'avatar' => 'https://placehold.co/40x40/7c3aed/ffffff?text=DM',
        'level' => 42,
        'wins' => 837,
        'losses' => 241,
        'win_rate' => 77.6,
        'rating' => 2854,
        'tier' => 'Grandmaster',
        'change' => 0
    ],
    [
        'rank' => 2,
        'name' => 'SpellWeaver',
        'avatar' => 'https://placehold.co/40x40/dc2626/ffffff?text=SW',
        'level' => 39,
        'wins' => 782,
        'losses' => 302,
        'win_rate' => 72.1,
        'rating' => 2791,
        'tier' => 'Grandmaster',
        'change' => 2
    ],
    [
        'rank' => 3,
        'name' => 'CardShark99',
        'avatar' => 'https://placehold.co/40x40/0ea5e9/ffffff?text=CS',
        'level' => 41,
        'wins' => 804,
        'losses' => 329,
        'win_rate' => 71.0,
        'rating' => 2753,
        'tier' => 'Grandmaster',
        'change' => -1
    ],
    [
        'rank' => 4,
        'name' => 'MysticQueen',
        'avatar' => 'https://placehold.co/40x40/ec4899/ffffff?text=MQ',
        'level' => 38,
        'wins' => 731,
        'losses' => 294,
        'win_rate' => 71.3,
        'rating' => 2702,
        'tier' => 'Grandmaster',
        'change' => 1
    ],
    [
        'rank' => 5,
        'name' => 'AzureKnight',
        'avatar' => 'https://placehold.co/40x40/0284c7/ffffff?text=AK',
        'level' => 36,
        'wins' => 692,
        'losses' => 301,
        'win_rate' => 69.7,
        'rating' => 2678,
        'tier' => 'Master',
        'change' => 3
    ],
    [
        'rank' => 6,
        'name' => 'ElementalFury',
        'avatar' => 'https://placehold.co/40x40/65a30d/ffffff?text=EF',
        'level' => 37,
        'wins' => 671,
        'losses' => 312,
        'win_rate' => 68.3,
        'rating' => 2641,
        'tier' => 'Master',
        'change' => -3
    ],
    [
        'rank' => 7,
        'name' => 'WizardKing',
        'avatar' => 'https://placehold.co/40x40/8b5cf6/ffffff?text=WK',
        'level' => 35,
        'wins' => 642,
        'losses' => 278,
        'win_rate' => 69.8,
        'rating' => 2619,
        'tier' => 'Master',
        'change' => 0
    ],
    [
        'rank' => 8,
        'name' => 'FireStorm',
        'avatar' => 'https://placehold.co/40x40/ef4444/ffffff?text=FS',
        'level' => 34,
        'wins' => 612,
        'losses' => 298,
        'win_rate' => 67.3,
        'rating' => 2587,
        'tier' => 'Master',
        'change' => 5
    ],
    [
        'rank' => 9,
        'name' => 'IceWizard',
        'avatar' => 'https://placehold.co/40x40/0284c7/ffffff?text=IW',
        'level' => 31,
        'wins' => 542,
        'losses' => 267,
        'win_rate' => 67.0,
        'rating' => 2495,
        'tier' => 'Diamond',
        'change' => -2
    ],
    [
        'rank' => 10,
        'name' => 'ShadowAssassin',
        'avatar' => 'https://placehold.co/40x40/1e293b/ffffff?text=SA',
        'level' => 30,
        'wins' => 521,
        'losses' => 261,
        'win_rate' => 66.6,
        'rating' => 2468,
        'tier' => 'Diamond',
        'change' => 0
    ]
];

// Top players by win rate (different sorting of the same data)
$topWinRates = $globalRankings;
usort($topWinRates, function($a, $b) {
    return $b['win_rate'] <=> $a['win_rate'];
});

// Player's personal ranking
$playerRanking = [
    'rank' => 9,
    'name' => 'IceWizard',
    'avatar' => 'https://placehold.co/40x40/0284c7/ffffff?text=IW',
    'level' => 31,
    'wins' => 542,
    'losses' => 267,
    'win_rate' => 67.0,
    'rating' => 2495,
    'tier' => 'Diamond',
    'percentile' => 98.2, // Top 1.8%
    'history' => [2478, 2486, 2495, 2510, 2495, 2483, 2495]
];

// Tournament winners (recent tournaments)
$tournaments = [
    [
        'name' => 'Summer Championship 2023',
        'date' => '2023-08-15',
        'winner' => [
            'name' => 'DragonMaster',
            'avatar' => 'https://placehold.co/40x40/7c3aed/ffffff?text=DM',
            'prize' => '5,000 Crystals + Legendary Card'
        ],
        'participants' => 512
    ],
    [
        'name' => 'Azure Cup Week 42',
        'date' => '2023-10-21',
        'winner' => [
            'name' => 'SpellWeaver',
            'avatar' => 'https://placehold.co/40x40/dc2626/ffffff?text=SW',
            'prize' => '2,000 Crystals + Epic Card'
        ],
        'participants' => 256
    ],
    [
        'name' => 'Elemental Showdown',
        'date' => '2023-11-05',
        'winner' => [
            'name' => 'MysticQueen',
            'avatar' => 'https://placehold.co/40x40/ec4899/ffffff?text=MQ',
            'prize' => '3,500 Crystals + Card Pack'
        ],
        'participants' => 128
    ],
];

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

function getRankChangeIcon($change) {
    if($change > 0) {
        return '<span class="text-green-500"><i class="fas fa-arrow-up"></i> ' . $change . '</span>';
    } else if($change < 0) {
        return '<span class="text-red-500"><i class="fas fa-arrow-down"></i> ' . abs($change) . '</span>';
    } else {
        return '<span class="text-gray-500"><i class="fas fa-minus"></i></span>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - Azure Cards</title>
    <?php echo $theme->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to our custom CSS file -->
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
    <?php 
    // Include the navigation file
    include 'includes/nav.php'; 
    ?>
    
    <div class="container mx-auto px-4 py-6">
        <!-- Leaderboard Banner -->
        <div class="game-banner shadow-magical mb-10">
            <h1 class="text-4xl md:text-5xl font-itim text-white mb-2 text-shadow-[0_2px_5px_rgba(0,0,0,0.3)]">Leaderboard</h1>
            <p class="text-white text-xl md:text-2xl font-itim opacity-90">See how you rank among the Azure Cards elite players</p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                <div class="bg-white/10 backdrop-blur-sm py-2 px-4 rounded-lg text-center">
                    <div class="text-white text-3xl font-bold">3,482</div>
                    <div class="text-white/80 text-sm">Active Players</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm py-2 px-4 rounded-lg text-center">
                    <div class="text-white text-3xl font-bold">156,429</div>
                    <div class="text-white/80 text-sm">Matches Played</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm py-2 px-4 rounded-lg text-center">
                    <div class="text-white text-3xl font-bold">142</div>
                    <div class="text-white/80 text-sm">Tournaments</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm py-2 px-4 rounded-lg text-center">
                    <div class="text-white text-3xl font-bold">8,500</div>
                    <div class="text-white/80 text-sm">Crystal Prize Pool</div>
                </div>
            </div>
        </div>
        
        <!-- Top Players Section -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <!-- Top 3 Players -->
            <div class="lg:col-span-3">
                <h2 class="text-2xl font-itim text-primary mb-6">Top Players</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php
                    // Display the top 3 players
                    for($i = 0; $i < 3; $i++):
                        $player = $globalRankings[$i];
                        $medalColors = ['from-yellow-300 to-yellow-500', 'from-gray-300 to-gray-500', 'from-amber-600 to-amber-700'];
                        $medalIcons = ['fa-medal', 'fa-medal', 'fa-medal'];
                    ?>
                    <div class="magic-card overflow-visible relative">
                        <div class="absolute -top-4 -left-4 w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-br <?php echo $medalColors[$i]; ?> shadow-lg z-10">
                            <i class="fas <?php echo $medalIcons[$i]; ?> text-white text-xl"></i>
                        </div>
                        <div class="flex flex-col items-center pt-2">
                            <div class="relative">
                                <img src="<?php echo $player['avatar']; ?>" alt="<?php echo $player['name']; ?>" class="w-24 h-24 rounded-full border-4 border-white shadow-md">
                                <div class="absolute -bottom-2 -right-2 w-10 h-10 flex items-center justify-center rounded-full text-sm font-bold bg-gradient-to-br from-primary to-secondary text-white">
                                    <?php echo $player['level']; ?>
                                </div>
                            </div>
                            <h3 class="mt-4 text-xl font-itim text-primary"><?php echo $player['name']; ?></h3>
                            <div class="my-1 px-3 py-1 rounded-full <?php echo getTierColor($player['tier']); ?> text-xs font-bold">
                                <?php echo $player['tier']; ?>
                            </div>
                            <div class="w-full border-t border-gray-200 mt-4 pt-4">
                                <div class="grid grid-cols-3 gap-2 text-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-500">Rating</div>
                                        <div class="text-lg font-bold text-primary"><?php echo $player['rating']; ?></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-500">Wins</div>
                                        <div class="text-lg font-bold text-primary"><?php echo $player['wins']; ?></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-500">Win Rate</div>
                                        <div class="text-lg font-bold text-primary"><?php echo $player['win_rate']; ?>%</div>
                                    </div>
                                </div>
                            </div>
                            <button class="mt-4 text-sm bg-primary/10 hover:bg-primary/20 text-primary px-4 py-1 rounded-full transition-colors">
                                View Profile
                            </button>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
            
            <!-- Your Ranking Card -->
            <div class="lg:col-span-1">
                <h2 class="text-2xl font-itim text-primary mb-6">Your Ranking</h2>
                
                <div class="magic-card player-stats overflow-visible">
                    <div class="absolute -top-6 -right-6 w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-blue-300 to-blue-500 shadow-lg">
                        <span class="text-white text-lg font-bold">#<?php echo $playerRanking['rank']; ?></span>
                    </div>
                    
                    <div class="flex items-center mb-4">
                        <img src="<?php echo $playerRanking['avatar']; ?>" alt="<?php echo $playerRanking['name']; ?>" class="w-16 h-16 rounded-full border-2 border-white shadow-md">
                        <div class="ml-4">
                            <h3 class="text-xl font-itim text-white"><?php echo $playerRanking['name']; ?></h3>
                            <div class="flex items-center">
                                <span class="px-2 py-0.5 rounded-full <?php echo getTierColor($playerRanking['tier']); ?> text-xs font-bold mr-2">
                                    <?php echo $playerRanking['tier']; ?>
                                </span>
                                <span class="text-blue-200 text-sm">Level <?php echo $playerRanking['level']; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="h-28">
                            <canvas id="playerRatingChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-blue-200">Rating:</span>
                            <span class="text-white font-bold"><?php echo $playerRanking['rating']; ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-200">Win Rate:</span>
                            <span class="text-white font-bold"><?php echo $playerRanking['win_rate']; ?>%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-200">Wins/Losses:</span>
                            <span class="text-white font-bold"><?php echo $playerRanking['wins']; ?>W / <?php echo $playerRanking['losses']; ?>L</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-200">Top:</span>
                            <span class="text-white font-bold"><?php echo $playerRanking['percentile']; ?>%</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <?php echo $theme->renderButton('View Full Stats', 'primary', 'md', 'profile.php', 'w-full', 'chart-line'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rankings Tabs and Table -->
        <div class="magic-card mb-10">
            <div class="mb-6 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-primary rounded-t-lg text-primary active" id="global-tab" data-target="global-leaderboard" role="tab">
                            <i class="fas fa-globe mr-2"></i> Global Rankings
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-primary hover:border-primary" id="win-rate-tab" data-target="win-rate-leaderboard" role="tab">
                            <i class="fas fa-percentage mr-2"></i> Win Rate
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-primary hover:border-primary" id="tournaments-tab" data-target="tournaments-leaderboard" role="tab">
                            <i class="fas fa-trophy mr-2"></i> Tournaments
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-primary hover:border-primary" id="friends-tab" data-target="friends-leaderboard" role="tab">
                            <i class="fas fa-user-friends mr-2"></i> Friends
                        </button>
                    </li>
                </ul>
            </div>
            
            <div id="leaderboardContent">
                <!-- Global Rankings Table -->
                <div id="global-leaderboard" class="leaderboard-table active">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <span class="text-gray-500">Season 7 - Week 12</span>
                            <span class="ml-3 px-2 py-1 bg-primary/10 text-primary text-xs rounded-full">Updated 2 hours ago</span>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <select class="magic-input border-gray-300 focus:border-primary focus:ring-primary rounded-md text-sm">
                                <option>All Regions</option>
                                <option>Americas</option>
                                <option>Europe</option>
                                <option>Asia</option>
                            </select>
                            
                            <select class="magic-input border-gray-300 focus:border-primary focus:ring-primary rounded-md text-sm">
                                <option>All Tiers</option>
                                <option>Grandmaster</option>
                                <option>Master</option>
                                <option>Diamond</option>
                                <option>Platinum</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Player</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tier</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Win Rate</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">W/L</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach($globalRankings as $player): ?>
                                <tr class="<?php echo $player['name'] === 'IceWizard' ? 'bg-primary/5' : ''; ?> hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-sm font-bold <?php echo $player['rank'] <= 3 ? 'bg-amber-100 text-amber-800' : 'bg-gray-100'; ?> rounded-lg">#<?php echo $player['rank']; ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="<?php echo $player['avatar']; ?>" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo $player['name']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $player['level']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo getTierColor($player['tier']); ?>">
                                            <?php echo $player['tier']; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $player['win_rate']; ?>%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo $player['rating']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $player['wins']; ?>W / <?php echo $player['losses']; ?>L
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo getRankChangeIcon($player['change']); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination for global rankings -->
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">3,482</span> players
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <button class="px-3 py-2 text-sm bg-white border border-gray-300 text-gray-500 rounded-md hover:bg-gray-50 disabled:opacity-50" disabled>
                                Previous
                            </button>
                            <button class="px-3 py-2 text-sm bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                1
                            </button>
                            <button class="px-3 py-2 text-sm bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                2
                            </button>
                            <button class="px-3 py-2 text-sm bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                3
                            </button>
                            <span class="text-gray-500">...</span>
                            <button class="px-3 py-2 text-sm bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                349
                            </button>
                            <button class="px-3 py-2 text-sm bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Win Rate Table -->
                <div id="win-rate-leaderboard" class="leaderboard-table hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <span class="text-gray-500">Top Win Rates • Minimum 100 Matches</span>
                            <span class="ml-3 px-2 py-1 bg-primary/10 text-primary text-xs rounded-full">Updated 2 hours ago</span>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <select class="magic-input border-gray-300 focus:border-primary focus:ring-primary rounded-md text-sm">
                                <option>All Time</option>
                                <option>This Season</option>
                                <option>This Month</option>
                                <option>This Week</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Player</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tier</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-bold">Win Rate</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">W/L</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php 
                                $rank = 1;
                                foreach($topWinRates as $player): 
                                ?>
                                <tr class="<?php echo $player['name'] === 'IceWizard' ? 'bg-primary/5' : ''; ?> hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-sm font-bold <?php echo $rank <= 3 ? 'bg-amber-100 text-amber-800' : 'bg-gray-100'; ?> rounded-lg">#<?php echo $rank++; ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="<?php echo $player['avatar']; ?>" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo $player['name']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $player['level']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo getTierColor($player['tier']); ?>">
                                            <?php echo $player['tier']; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-primary"><?php echo $player['win_rate']; ?>%</div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                            <div class="bg-primary h-1.5 rounded-full" style="width: <?php echo $player['win_rate']; ?>%"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo $player['rating']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $player['wins']; ?>W / <?php echo $player['losses']; ?>L
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Tournaments Winners Table -->
                <div id="tournaments-leaderboard" class="leaderboard-table hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <span class="text-gray-500">Recent Tournament Champions</span>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <select class="magic-input border-gray-300 focus:border-primary focus:ring-primary rounded-md text-sm">
                                <option>All Tournaments</option>
                                <option>Championships</option>
                                <option>Weekly Cups</option>
                                <option>Special Events</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach($tournaments as $tournament): ?>
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                            <div class="bg-primary/10 p-4">
                                <h3 class="font-itim text-primary text-lg"><?php echo $tournament['name']; ?></h3>
                                <div class="text-sm text-gray-500"><?php echo $tournament['date']; ?></div>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 mr-4">
                                        <img class="h-12 w-12 rounded-full border-2 border-amber-400" src="<?php echo $tournament['winner']['avatar']; ?>" alt="">
                                        <div class="absolute -mt-2 ml-8">
                                            <i class="fas fa-crown text-amber-400"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900"><?php echo $tournament['winner']['name']; ?></div>
                                        <div class="text-xs text-gray-500">Champion</div>
                                    </div>
                                </div>
                                <div class="mt-2 space-y-2">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-500">Prize:</span>
                                        <span class="font-medium"><?php echo $tournament['winner']['prize']; ?></span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-500">Participants:</span>
                                        <span class="font-medium"><?php echo $tournament['participants']; ?></span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button class="w-full text-center text-sm bg-primary/10 hover:bg-primary/20 text-primary px-4 py-2 rounded transition-colors">
                                        View Tournament
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="flex justify-center mt-6">
                        <button class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary hover:bg-primary/20 rounded-md">
                            <i class="fas fa-calendar-alt mr-2"></i> View Tournament Schedule
                        </button>
                    </div>
                </div>
                
                <!-- Friends Leaderboard Table (example placeholder) -->
                <div id="friends-leaderboard" class="leaderboard-table hidden">
                    <div class="py-8 px-4 text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-primary/10 mb-4">
                            <i class="fas fa-user-friends text-3xl text-primary"></i>
                        </div>
                        <h3 class="font-itim text-xl text-primary mb-2">Friends Rankings</h3>
                        <p class="text-gray-600 mb-6">Connect with friends to see how you compare!</p>
                        <div class="flex justify-center">
                            <?php echo $theme->renderButton('Find Friends', 'primary', 'md', '', '', 'search'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Distribution and Stats Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
            <div class="magic-card">
                <h2 class="text-xl font-itim text-primary mb-4">Rating Distribution</h2>
                <div class="h-64">
                    <canvas id="ratingDistributionChart"></canvas>
                </div>
                <div class="grid grid-cols-5 gap-1 mt-4">
                    <div class="text-center">
                        <div class="h-3 bg-amber-700 rounded"></div>
                        <div class="text-xs mt-1">Bronze</div>
                        <div class="text-xs text-gray-500">12%</div>
                    </div>
                    <div class="text-center">
                        <div class="h-3 bg-gray-400 rounded"></div>
                        <div class="text-xs mt-1">Silver</div>
                        <div class="text-xs text-gray-500">23%</div>
                    </div>
                    <div class="text-center">
                        <div class="h-3 bg-amber-400 rounded"></div>
                        <div class="text-xs mt-1">Gold</div>
                        <div class="text-xs text-gray-500">32%</div>
                    </div>
                    <div class="text-center">
                        <div class="h-3 bg-cyan-500 rounded"></div>
                        <div class="text-xs mt-1">Platinum</div>
                        <div class="text-xs text-gray-500">18%</div>
                    </div>
                    <div class="text-center">
                        <div class="h-3 bg-blue-500 rounded"></div>
                        <div class="text-xs mt-1">Diamond</div>
                        <div class="text-xs text-gray-500">8%</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-1 mt-1">
                    <div class="text-center">
                        <div class="h-3 bg-red-600 rounded"></div>
                        <div class="text-xs mt-1">Master</div>
                        <div class="text-xs text-gray-500">5%</div>
                    </div>
                    <div class="text-center">
                        <div class="h-3 bg-purple-700 rounded"></div>
                        <div class="text-xs mt-1">Grandmaster</div>
                        <div class="text-xs text-gray-500">2%</div>
                    </div>
                </div>
            </div>
            
            <div class="magic-card">
                <h2 class="text-xl font-itim text-primary mb-4">Seasonal Statistics</h2>
                <div class="h-64">
                    <canvas id="seasonalStatsChart"></canvas>
                </div>
                <div class="grid grid-cols-3 gap-4 mt-6">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-500">Win Rate</div>
                        <div class="text-lg font-bold text-primary">68.4%</div>
                        <div class="text-xs text-green-500">+2.1% from last season</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-500">Avg. Rating</div>
                        <div class="text-lg font-bold text-primary">1,842</div>
                        <div class="text-xs text-green-500">+156 from last season</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-500">Matches</div>
                        <div class="text-lg font-bold text-primary">15,482</div>
                        <div class="text-xs text-green-500">+23% from last season</div>
                    </div>
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
                        <li><a href="cards.php" class="text-blue-100 hover:text-white">Card Collection</a></li>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabButtons = document.querySelectorAll('[role="tab"]');
            const tabContents = document.querySelectorAll('.leaderboard-table');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'border-primary', 'text-primary');
                        btn.classList.add('border-transparent');
                    });
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                        content.classList.remove('active');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.add('active', 'border-primary', 'text-primary');
                    this.classList.remove('border-transparent');
                    
                    // Show corresponding content
                    const targetId = this.getAttribute('data-target');
                    const targetContent = document.getElementById(targetId);
                    targetContent.classList.remove('hidden');
                    targetContent.classList.add('active');
                });
            });
            
            // Player Rating Chart
            const ratingData = <?php echo json_encode($playerRanking['history']); ?>;
            const ratingCtx = document.getElementById('playerRatingChart').getContext('2d');
            const ratingChart = new Chart(ratingCtx, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7'],
                    datasets: [{
                        label: 'Rating',
                        data: ratingData,
                        borderColor: 'rgba(255, 255, 255, 0.8)',
                        backgroundColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'rgba(255, 255, 255, 1)',
                        pointRadius: 3,
                        pointHoverRadius: 5
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
                            titleColor: 'rgba(255, 255, 255, 1)',
                            bodyColor: 'rgba(255, 255, 255, 0.8)',
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                display: true,
                                color: 'rgba(255, 255, 255, 0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)',
                                font: {
                                    size: 10
                                }
                            },
                            min: Math.min(...ratingData) - 20,
                            max: Math.max(...ratingData) + 20
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)',
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
            
            // Rating Distribution Chart
            const distributionCtx = document.getElementById('ratingDistributionChart').getContext('2d');
            const distributionChart = new Chart(distributionCtx, {
                type: 'bar',
                data: {
                    labels: ['Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond', 'Master', 'Grandmaster'],
                    datasets: [{
                        label: 'Players',
                        data: [12, 23, 32, 18, 8, 5, 2],
                        backgroundColor: [
                            '#b45309', // Bronze
                            '#9ca3af', // Silver
                            '#fbbf24', // Gold
                            '#06b6d4', // Platinum
                            '#3b82f6', // Diamond
                            '#dc2626', // Master
                            '#7e22ce'  // Grandmaster
                        ],
                        borderWidth: 0,
                        borderRadius: 4,
                        categoryPercentage: 0.7,
                        barPercentage: 0.8
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
                            callbacks: {
                                label: function(context) {
                                    return context.raw + '% of players';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 35,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Seasonal Stats Chart
            const statsCtx = document.getElementById('seasonalStatsChart').getContext('2d');
            const statsChart = new Chart(statsCtx, {
                type: 'line',
                data: {
                    labels: ['Season 1', 'Season 2', 'Season 3', 'Season 4', 'Season 5', 'Season 6', 'Season 7'],
                    datasets: [
                        {
                            label: 'Avg. Rating',
                            data: [1425, 1587, 1623, 1712, 1655, 1686, 1842],
                            borderColor: '#38bdf8',
                            backgroundColor: 'rgba(56, 189, 248, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Win Rate %',
                            data: [52, 56, 59, 62, 60, 66.3, 68.4],
                            borderColor: '#10b981',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            tension: 0.3,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (context.dataset.label === 'Win Rate %') {
                                        return context.dataset.label + ': ' + context.raw + '%';
                                    }
                                    return context.dataset.label + ': ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            min: 1400,
                            title: {
                                display: true,
                                text: 'Rating'
                            },
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            min: 50,
                            max: 70,
                            title: {
                                display: true,
                                text: 'Win Rate %'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
