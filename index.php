<?php
require_once 'MagicalTheme.php';

// Initialize the theme with blue color scheme
$theme = new MagicalTheme('blue');

// Set custom navigation items for a card game
$navItems = [
    'Home' => [
        'url' => 'index.php',
        'icon' => 'fa-home',
        'active' => true
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
        'icon' => 'fa-user'
    ]
];
$theme->setNavItems($navItems);

// Sample card data for our game
$cards = [
    [
        'name' => 'Water Dragon',
        'power' => 8,
        'health' => 7,
        'mana' => 5,
        'rarity' => 'rare',
        'image' => 'https://placehold.co/150x150/88c3f9/ffffff?text=Dragon',
        'type' => 'creature'
    ],
    [
        'name' => 'Frost Nova',
        'power' => 3,
        'health' => null,
        'mana' => 4,
        'rarity' => 'uncommon',
        'image' => 'https://placehold.co/150x150/4baeff/ffffff?text=Frost+Nova',
        'type' => 'spell'
    ],
    [
        'name' => 'Ocean Guardian',
        'power' => 5,
        'health' => 9,
        'mana' => 6,
        'rarity' => 'epic',
        'image' => 'https://placehold.co/150x150/0c4a6e/ffffff?text=Guardian',
        'type' => 'creature'
    ],
    [
        'name' => 'Ice Shield',
        'power' => null,
        'health' => 4,
        'mana' => 2,
        'rarity' => 'common',
        'image' => 'https://placehold.co/150x150/bae6fd/000000?text=Shield',
        'type' => 'equipment'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azure Cards - Magical Card Game</title>
    <?php echo $theme->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to our custom CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <?php 
    // Include the navigation file
    include 'includes/nav.php'; 
    ?>
    
    <div class="container mx-auto px-4 py-6">
        <!-- Game Banner -->
        <div class="game-banner shadow-magical mb-10">
            <h1 class="text-4xl md:text-5xl font-itim text-white mb-2 text-shadow-[0_2px_5px_rgba(0,0,0,0.3)]">Azure Cards</h1>
            <p class="text-white text-xl md:text-2xl font-itim opacity-90">Unleash your strategic mastery in the world of elemental cards!</p>
            
            <div class="flex gap-4 mt-6">
                <?php echo $theme->renderButton('Start Playing', 'primary', 'lg', 'battle.php', '', 'gamepad-modern'); ?>
                <?php echo $theme->renderButton('Tutorial', 'secondary', 'lg', 'tutorial.php', '', 'book-open'); ?>
            </div>
            
            <div class="absolute top-5 right-5 animate-float">
                <div class="bg-white/10 backdrop-blur-sm p-3 rounded-lg shadow-lg">
                    <div class="text-white font-itim text-lg">Online Players: <span class="text-xl font-bold">1,342</span></div>
                </div>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            <!-- Featured Cards Section -->
            <div class="lg:col-span-2">
                <div class="magic-card">
                    <h2 class="text-2xl font-itim text-primary mb-6 flex items-center">
                        <i class="fas fa-crown mr-2 text-warning"></i> Featured Cards
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <?php foreach ($cards as $card): ?>
                        <div class="game-card magic-card-<?php echo $card['type'] === 'spell' ? 'secondary' : 'primary'; ?>">
                            <img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>" class="game-card-image">
                            <div class="p-3">
                                <h3 class="font-itim text-<?php echo $card['type'] === 'spell' ? 'secondary' : 'primary'; ?> text-lg"><?php echo $card['name']; ?></h3>
                                <p class="text-sm text-gray-600"><?php echo ucfirst($card['type']); ?></p>
                            </div>
                            
                            <div class="card-rarity rarity-<?php echo $card['rarity']; ?>"></div>
                            
                            <div class="card-stats">
                                <?php if ($card['power'] !== null): ?>
                                <div class="card-stat power-stat"><?php echo $card['power']; ?></div>
                                <?php endif; ?>
                                
                                <?php if ($card['health'] !== null): ?>
                                <div class="card-stat health-stat"><?php echo $card['health']; ?></div>
                                <?php endif; ?>
                                
                                <div class="card-stat mana-stat"><?php echo $card['mana']; ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="flex justify-center mt-8">
                        <?php echo $theme->renderButton('See All Cards', 'secondary', 'md', 'collection.php', '', 'cards'); ?>
                    </div>
                </div>
                
                <!-- Recent Matches -->
                <div class="magic-card mt-6">
                    <h2 class="text-2xl font-itim text-primary mb-4 flex items-center">
                        <i class="fas fa-trophy mr-2 text-warning"></i> Recent Battles
                    </h2>
                    
                    <div class="space-y-3">
                        <?php 
                        // Sample match data
                        $matches = [
                            ['player1' => 'IceWizard', 'player2' => 'FireKnight', 'result' => 'win', 'score' => '3-1'],
                            ['player1' => 'StormMage', 'player2' => 'IceWizard', 'result' => 'loss', 'score' => '2-3'],
                            ['player1' => 'IceWizard', 'player2' => 'ShadowAssassin', 'result' => 'win', 'score' => '3-0']
                        ];
                        
                        foreach ($matches as $match): 
                            $resultClass = $match['result'] === 'win' ? 'bg-success/20 text-success' : 'bg-danger/20 text-danger';
                        ?>
                        <div class="flex items-center justify-between p-3 rounded-lg <?php echo $resultClass; ?>">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center font-bold">
                                    <?php echo substr($match['player1'], 0, 1); ?>
                                </div>
                                <span class="mx-2 font-itim"><?php echo $match['player1']; ?></span>
                                <span class="font-bold">vs</span>
                                <span class="mx-2 font-itim"><?php echo $match['player2']; ?></span>
                                <div class="w-10 h-10 rounded-full bg-secondary/20 flex items-center justify-center font-bold">
                                    <?php echo substr($match['player2'], 0, 1); ?>
                                </div>
                            </div>
                            <div class="font-bold"><?php echo $match['score']; ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="flex justify-center mt-6">
                        <?php echo $theme->renderButton('Battle History', 'secondary', 'md', 'history.php', '', 'list'); ?>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Player Stats -->
                <div class="magic-card player-stats">
                    <h2 class="text-xl font-itim text-white mb-4">Your Profile</h2>
                    
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-white text-2xl font-bold">
                            I
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-itim text-white">IceWizard</h3>
                            <p class="text-blue-200">Rank: Diamond</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2 mt-6">
                        <div class="flex justify-between items-center">
                            <span class="text-blue-200">Wins:</span>
                            <span class="text-white font-bold">42</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-200">Losses:</span>
                            <span class="text-white font-bold">17</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-200">Win Rate:</span>
                            <span class="text-white font-bold">71%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-200">Cards Owned:</span>
                            <span class="text-white font-bold">78/120</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-200">Tournament Trophies:</span>
                            <span class="text-white font-bold">3</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <?php echo $theme->renderButton('View Full Profile', 'primary', 'md', 'profile.php', 'w-full', 'user'); ?>
                    </div>
                </div>
                
                <!-- Daily Quests -->
                <div class="magic-card">
                    <h2 class="text-xl font-itim text-primary mb-4">Daily Quests</h2>
                    
                    <div class="space-y-4">
                        <div class="p-3 daily-quest bg-blue-50 rounded-lg">
                            <h3 class="font-itim text-primary">Win 3 Matches</h3>
                            <div class="flex items-center mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full" style="width: 66%"></div>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">2/3</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Reward: 200 Crystals</p>
                        </div>
                        
                        <div class="p-3 daily-quest bg-blue-50 rounded-lg">
                            <h3 class="font-itim text-primary">Play 5 Water Cards</h3>
                            <div class="flex items-center mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full" style="width: 40%"></div>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">2/5</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Reward: 1 Card Pack</p>
                        </div>
                        
                        <div class="p-3 daily-quest bg-blue-50 rounded-lg">
                            <h3 class="font-itim text-primary">Collect 500 Mana</h3>
                            <div class="flex items-center mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-primary h-2.5 rounded-full" style="width: 80%"></div>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">400/500</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Reward: Rare Card</p>
                        </div>
                    </div>
                </div>
                
                <!-- News & Updates -->
                <div class="magic-card">
                    <h2 class="text-xl font-itim text-primary mb-4">News & Updates</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-itim text-secondary">New Card Pack: Oceanic Depths</h3>
                            <p class="text-sm text-gray-600">Explore the new underwater-themed cards with powerful wave abilities.</p>
                            <p class="text-xs text-gray-400 mt-1">2 days ago</p>
                        </div>
                        
                        <div>
                            <h3 class="font-itim text-secondary">Weekend Tournament</h3>
                            <p class="text-sm text-gray-600">Join our weekend tournament for a chance to win exclusive cards!</p>
                            <p class="text-xs text-gray-400 mt-1">5 days ago</p>
                        </div>
                        
                        <div>
                            <h3 class="font-itim text-secondary">Balance Update v3.2</h3>
                            <p class="text-sm text-gray-600">Check out our latest balance changes to keep gameplay fair and fun.</p>
                            <p class="text-xs text-gray-400 mt-1">1 week ago</p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <?php echo $theme->renderButton('All News', 'secondary', 'sm', 'news.php', 'w-full', 'newspaper'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Call to Action -->
        <div class="magic-card text-center my-10 py-8">
            <h2 class="text-2xl md:text-3xl font-itim text-primary mb-4">Ready to Challenge the Best?</h2>
            <p class="text-lg text-gray-600 mb-6">Join thousands of players in strategic card battles. Collect cards, build your deck, and rise to the top!</p>
            <div class="flex flex-wrap justify-center gap-4">
                <?php echo $theme->renderButton('Create Account', 'primary', 'lg', 'register.php', '', 'user-plus'); ?>
                <?php echo $theme->renderButton('How to Play', 'secondary', 'lg', 'tutorial.php', '', 'book'); ?>
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
    
    <!-- Add reference to our JavaScript file -->
    <script src="js/game.js"></script>
</body>
</html>
