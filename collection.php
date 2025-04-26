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
        'active' => true,
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

// Sample card data with expanded collection
$cards = [
    // Water Cards
    [
        'name' => 'Water Dragon',
        'power' => 8,
        'health' => 7,
        'mana' => 5,
        'rarity' => 'rare',
        'image' => 'https://placehold.co/150x150/88c3f9/ffffff?text=Dragon',
        'type' => 'creature',
        'element' => 'water',
        'description' => 'A mighty dragon that commands the oceans.'
    ],
    [
        'name' => 'Frost Nova',
        'power' => 3,
        'health' => null,
        'mana' => 4,
        'rarity' => 'uncommon',
        'image' => 'https://placehold.co/150x150/4baeff/ffffff?text=Frost+Nova',
        'type' => 'spell',
        'element' => 'water',
        'description' => 'Freezes all enemies for one turn.'
    ],
    [
        'name' => 'Ocean Guardian',
        'power' => 5,
        'health' => 9,
        'mana' => 6,
        'rarity' => 'epic',
        'image' => 'https://placehold.co/150x150/0c4a6e/ffffff?text=Guardian',
        'type' => 'creature',
        'element' => 'water',
        'description' => 'Protects allies with barriers of water.'
    ],
    [
        'name' => 'Ice Shield',
        'power' => null,
        'health' => 4,
        'mana' => 2,
        'rarity' => 'common',
        'image' => 'https://placehold.co/150x150/bae6fd/000000?text=Shield',
        'type' => 'equipment',
        'element' => 'water',
        'description' => 'Provides an icy barrier against attacks.'
    ],
    [
        'name' => 'Whirlpool',
        'power' => 6,
        'health' => null,
        'mana' => 5,
        'rarity' => 'uncommon',
        'image' => 'https://placehold.co/150x150/0284c7/ffffff?text=Whirlpool',
        'type' => 'spell',
        'element' => 'water',
        'description' => 'Creates a vortex that pulls enemies in.'
    ],
    
    // Fire Cards
    [
        'name' => 'Fire Elemental',
        'power' => 7,
        'health' => 5,
        'mana' => 5,
        'rarity' => 'rare',
        'image' => 'https://placehold.co/150x150/ef4444/ffffff?text=Elemental',
        'type' => 'creature',
        'element' => 'fire',
        'description' => 'A blazing entity born from pure flames.'
    ],
    [
        'name' => 'Inferno',
        'power' => 10,
        'health' => null,
        'mana' => 8,
        'rarity' => 'epic',
        'image' => 'https://placehold.co/150x150/b91c1c/ffffff?text=Inferno',
        'type' => 'spell',
        'element' => 'fire',
        'description' => 'Engulfs the battlefield in flames.'
    ],
    [
        'name' => 'Flame Dagger',
        'power' => 3,
        'health' => null,
        'mana' => 2,
        'rarity' => 'common',
        'image' => 'https://placehold.co/150x150/f97316/ffffff?text=Dagger',
        'type' => 'equipment',
        'element' => 'fire',
        'description' => 'A dagger forged in eternal flame.'
    ],
    
    // Earth Cards
    [
        'name' => 'Mountain Giant',
        'power' => 6,
        'health' => 12,
        'mana' => 7,
        'rarity' => 'rare',
        'image' => 'https://placehold.co/150x150/84cc16/ffffff?text=Giant',
        'type' => 'creature',
        'element' => 'earth',
        'description' => 'A colossal being made of living stone.'
    ],
    [
        'name' => 'Earthquake',
        'power' => 7,
        'health' => null,
        'mana' => 6,
        'rarity' => 'rare',
        'image' => 'https://placehold.co/150x150/65a30d/ffffff?text=Earthquake',
        'type' => 'spell',
        'element' => 'earth',
        'description' => 'Shakes the ground, damaging all creatures.'
    ],
    [
        'name' => 'Stone Armor',
        'power' => null,
        'health' => 7,
        'mana' => 3,
        'rarity' => 'uncommon',
        'image' => 'https://placehold.co/150x150/a3e635/000000?text=Armor',
        'type' => 'equipment',
        'element' => 'earth',
        'description' => 'Protective armor carved from enchanted stone.'
    ],
    
    // Air Cards
    [
        'name' => 'Wind Sprite',
        'power' => 4,
        'health' => 4,
        'mana' => 3,
        'rarity' => 'common',
        'image' => 'https://placehold.co/150x150/e0f2fe/000000?text=Sprite',
        'type' => 'creature',
        'element' => 'air',
        'description' => 'A playful spirit of the winds.'
    ],
    [
        'name' => 'Lightning Strike',
        'power' => 9,
        'health' => null,
        'mana' => 6,
        'rarity' => 'rare',
        'image' => 'https://placehold.co/150x150/7dd3fc/000000?text=Lightning',
        'type' => 'spell',
        'element' => 'air',
        'description' => 'Calls down lightning from storm clouds.'
    ],
    [
        'name' => 'Feather Cloak',
        'power' => null,
        'health' => 2,
        'mana' => 1,
        'rarity' => 'common',
        'image' => 'https://placehold.co/150x150/bae6fd/000000?text=Cloak',
        'type' => 'equipment',
        'element' => 'air',
        'description' => 'Grants swiftness and agility to the wearer.'
    ],
    
    // Arcane Cards
    [
        'name' => 'Mystic Sage',
        'power' => 5,
        'health' => 5,
        'mana' => 5,
        'rarity' => 'epic',
        'image' => 'https://placehold.co/150x150/a78bfa/ffffff?text=Sage',
        'type' => 'creature',
        'element' => 'arcane',
        'description' => 'A master of arcane knowledge and power.'
    ],
    [
        'name' => 'Reality Warp',
        'power' => null,
        'health' => null,
        'mana' => 10,
        'rarity' => 'legendary',
        'image' => 'https://placehold.co/150x150/8b5cf6/ffffff?text=Reality+Warp',
        'type' => 'spell',
        'element' => 'arcane',
        'description' => 'Bends the fabric of reality itself.'
    ],
    [
        'name' => 'Staff of Wisdom',
        'power' => 2,
        'health' => 2,
        'mana' => 3,
        'rarity' => 'rare',
        'image' => 'https://placehold.co/150x150/c4b5fd/000000?text=Staff',
        'type' => 'equipment',
        'element' => 'arcane',
        'description' => 'Ancient staff that amplifies magical abilities.'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Collection - Azure Cards</title>
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
        <div class="game-banner shadow-magical mb-10">
            <h1 class="text-4xl md:text-5xl font-itim text-white mb-2 text-shadow-[0_2px_5px_rgba(0,0,0,0.3)]">Your Collection</h1>
            <p class="text-white text-xl md:text-2xl font-itim opacity-90">Manage and customize your card arsenal</p>
            
            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center gap-2">
                    <div class="bg-white/10 backdrop-blur-sm py-1 px-3 rounded-full text-white">
                        <span class="font-bold">42</span> Cards
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm py-1 px-3 rounded-full text-white">
                        <span class="font-bold">65%</span> Completion
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <?php echo $theme->renderButton('Create Deck', 'primary', 'md', 'create-deck.php', '', 'layer-group'); ?>
                    <?php echo $theme->renderButton('Card Shop', 'secondary', 'md', 'shop.php', '', 'store'); ?>
                </div>
            </div>
        </div>
        
        <!-- Collection Interface -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Filters Sidebar -->
            <div class="md:col-span-1">
                <div class="magic-card sticky top-20">
                    <h2 class="text-xl font-itim text-primary mb-6 flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filters
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label for="card-search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <input type="text" id="card-search" 
                                       class="magic-input block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                       placeholder="Card name...">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Element Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Element</label>
                            <div class="space-y-1">
                                <div class="flex items-center">
                                    <input type="checkbox" id="element-water" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="element-water" class="ml-2 text-sm text-gray-700">Water</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="element-fire" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="element-fire" class="ml-2 text-sm text-gray-700">Fire</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="element-earth" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="element-earth" class="ml-2 text-sm text-gray-700">Earth</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="element-air" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="element-air" class="ml-2 text-sm text-gray-700">Air</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="element-arcane" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="element-arcane" class="ml-2 text-sm text-gray-700">Arcane</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Card Type</label>
                            <div class="space-y-1">
                                <div class="flex items-center">
                                    <input type="checkbox" id="type-creature" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="type-creature" class="ml-2 text-sm text-gray-700">Creature</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="type-spell" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="type-spell" class="ml-2 text-sm text-gray-700">Spell</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="type-equipment" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="type-equipment" class="ml-2 text-sm text-gray-700">Equipment</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Rarity Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rarity</label>
                            <div class="space-y-1">
                                <div class="flex items-center">
                                    <input type="checkbox" id="rarity-common" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="rarity-common" class="ml-2 text-sm text-gray-700">Common</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="rarity-uncommon" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="rarity-uncommon" class="ml-2 text-sm text-gray-700">Uncommon</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="rarity-rare" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="rarity-rare" class="ml-2 text-sm text-gray-700">Rare</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="rarity-epic" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="rarity-epic" class="ml-2 text-sm text-gray-700">Epic</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="rarity-legendary" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                    <label for="rarity-legendary" class="ml-2 text-sm text-gray-700">Legendary</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mana Cost Filter -->
                        <div>
                            <label for="mana-range" class="block text-sm font-medium text-gray-700 mb-2">
                                Mana Cost: <span id="mana-value">0-10</span>
                            </label>
                            <input type="range" id="mana-range" min="0" max="10" value="10" 
                                  class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" 
                                  oninput="document.getElementById('mana-value').textContent = '0-' + this.value">
                        </div>
                        
                        <!-- Reset Filters -->
                        <div class="pt-4">
                            <button type="button" class="w-full px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cards Grid -->
            <div class="md:col-span-3">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-itim text-primary">All Cards</h2>
                    
                    <div class="flex items-center space-x-3">
                        <label for="sort-by" class="text-sm font-medium text-gray-700">Sort by:</label>
                        <select id="sort-by" class="magic-input border-gray-300 rounded-md focus:ring-primary focus:border-primary px-3 py-1 text-sm">
                            <option value="name">Name</option>
                            <option value="element">Element</option>
                            <option value="rarity">Rarity</option>
                            <option value="mana">Mana Cost</option>
                            <option value="power">Power</option>
                        </select>
                        
                        <button type="button" class="grid-view-btn bg-primary/10 text-primary p-2 rounded-lg" title="Grid View">
                            <i class="fas fa-th"></i>
                        </button>
                        <button type="button" class="list-view-btn bg-white p-2 rounded-lg" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Cards Grid View - Changed from grid-cols-3 to grid-cols-4 for large screens -->
                <div id="cards-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php foreach ($cards as $card): ?>
                    <div class="game-card magic-card-<?php echo $card['type'] === 'spell' ? 'secondary' : 'primary'; ?>" 
                         data-element="<?php echo $card['element']; ?>"
                         data-type="<?php echo $card['type']; ?>"
                         data-rarity="<?php echo $card['rarity']; ?>"
                         data-mana="<?php echo $card['mana']; ?>">
                        <div class="card-element-badge absolute top-3 left-3 w-8 h-8 rounded-full flex items-center justify-center"
                             style="background-color: <?php echo getElementColor($card['element']); ?>; border: 2px solid white;">
                            <i class="fas <?php echo getElementIcon($card['element']); ?> text-white"></i>
                        </div>
                        <img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>" class="game-card-image">
                        <div class="p-3">
                            <h3 class="font-itim text-<?php echo $card['type'] === 'spell' ? 'secondary' : 'primary'; ?> text-lg"><?php echo $card['name']; ?></h3>
                            <p class="text-sm text-gray-600"><?php echo ucfirst($card['type']); ?></p>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2"><?php echo $card['description']; ?></p>
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
                        
                        <div class="absolute inset-0 bg-black/70 opacity-0 hover:opacity-100 transition-opacity duration-200 flex items-center justify-center space-x-2">
                            <button class="magic-button magic-button-primary px-3 py-1" onclick="viewCardDetails('<?php echo htmlspecialchars(json_encode($card), ENT_QUOTES, 'UTF-8'); ?>')">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="magic-button magic-button-secondary px-3 py-1" onclick="addToDeck('<?php echo $card['name']; ?>')">
                                <i class="fas fa-plus"></i> Add to Deck
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Cards List View (Hidden by default) -->
                <div id="cards-list" class="hidden space-y-3">
                    <?php foreach ($cards as $card): ?>
                    <div class="flex border rounded-lg overflow-hidden bg-white shadow-sm hover:shadow-md transition-shadow" 
                         data-element="<?php echo $card['element']; ?>"
                         data-type="<?php echo $card['type']; ?>"
                         data-rarity="<?php echo $card['rarity']; ?>"
                         data-mana="<?php echo $card['mana']; ?>">
                        <div class="w-[100px] h-[100px] flex-shrink-0">
                            <img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 p-4 flex justify-between">
                            <div>
                                <div class="flex items-center">
                                    <h3 class="font-itim text-primary text-lg"><?php echo $card['name']; ?></h3>
                                    <div class="ml-2 w-3 h-3 rounded-full rarity-<?php echo $card['rarity']; ?>"></div>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mb-1">
                                    <span class="mr-3"><?php echo ucfirst($card['type']); ?></span>
                                    <span class="capitalize"><?php echo $card['element']; ?></span>
                                </div>
                                <p class="text-xs text-gray-600 line-clamp-2"><?php echo $card['description']; ?></p>
                            </div>
                            <div class="flex flex-col justify-between items-end">
                                <div class="flex space-x-1">
                                    <?php if ($card['power'] !== null): ?>
                                    <div class="flex items-center text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded">
                                        <i class="fas fa-fire-alt mr-1"></i> <?php echo $card['power']; ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($card['health'] !== null): ?>
                                    <div class="flex items-center text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded">
                                        <i class="fas fa-heart mr-1"></i> <?php echo $card['health']; ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex items-center text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded">
                                        <i class="fas fa-tint mr-1"></i> <?php echo $card['mana']; ?>
                                    </div>
                                </div>
                                <div class="flex space-x-1 mt-2">
                                    <button class="text-xs bg-primary/10 text-primary px-2 py-1 rounded" onclick="viewCardDetails('<?php echo htmlspecialchars(json_encode($card), ENT_QUOTES, 'UTF-8'); ?>')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="text-xs bg-secondary/10 text-secondary px-2 py-1 rounded" onclick="addToDeck('<?php echo $card['name']; ?>')">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center space-x-1">
                        <a href="#" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="#" class="px-3 py-2 rounded-md bg-primary text-white font-medium">1</a>
                        <a href="#" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                        <a href="#" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                        <span class="px-2 py-2 text-gray-500">...</span>
                        <a href="#" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">8</a>
                        <a href="#" class="px-3 py-2 rounded-md bg-white border border-gray-300 text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Detail Modal -->
    <div id="card-detail-modal" class="fixed inset-0 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            
            <div class="relative bg-white rounded-xl shadow-magical overflow-hidden w-full max-w-2xl transform transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="text-2xl font-itim text-primary" id="modal-card-name"></h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeCardModal()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="flex justify-center">
                            <div class="relative w-[250px] h-[350px] transform transition duration-500 hover:scale-105 hover:rotate-1">
                                <img id="modal-card-image" src="" alt="" class="rounded-lg w-full h-full object-cover shadow-lg">
                                <div id="modal-card-rarity" class="absolute top-4 right-4 w-5 h-5 rounded-full"></div>
                                <div id="modal-card-element" class="absolute top-4 left-4 w-8 h-8 rounded-full flex items-center justify-center"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="mb-4">
                                <span class="text-sm font-itim text-gray-500" id="modal-card-type"></span>
                                <h4 class="text-xl font-itim text-primary" id="modal-card-name-2"></h4>
                            </div>
                            
                            <p class="text-gray-600 mb-4" id="modal-card-description"></p>
                            
                            <div class="grid grid-cols-3 gap-3 mb-6">
                                <div class="bg-red-100 p-3 rounded-lg text-center" id="modal-card-power-container">
                                    <div class="text-xs text-gray-500">Power</div>
                                    <div class="text-lg font-bold text-red-600" id="modal-card-power"></div>
                                </div>
                                <div class="bg-green-100 p-3 rounded-lg text-center" id="modal-card-health-container">
                                    <div class="text-xs text-gray-500">Health</div>
                                    <div class="text-lg font-bold text-green-600" id="modal-card-health"></div>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-lg text-center">
                                    <div class="text-xs text-gray-500">Mana</div>
                                    <div class="text-lg font-bold text-blue-600" id="modal-card-mana"></div>
                                </div>
                            </div>
                            
                            <div class="flex space-x-3">
                                <button class="flex-1 magic-button magic-button-secondary py-2" onclick="addToDeck(document.getElementById('modal-card-name').textContent)">
                                    <i class="fas fa-plus mr-2"></i> Add to Deck
                                </button>
                                <button class="magic-button magic-button-primary py-2 px-4">
                                    <i class="fas fa-brush"></i>
                                </button>
                                <button class="magic-button magic-button-primary py-2 px-4">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Statistics -->
                    <div class="mt-8 border-t pt-6">
                        <h4 class="font-itim text-lg text-primary mb-4">Card Statistics</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-xs text-gray-500">Play Rate</div>
                                <div class="text-lg font-bold text-gray-700">68%</div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-xs text-gray-500">Win Rate</div>
                                <div class="text-lg font-bold text-gray-700">52%</div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-xs text-gray-500">Popularity</div>
                                <div class="text-lg font-bold text-gray-700">Top 25%</div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <div class="text-xs text-gray-500">Obtained</div>
                                <div class="text-lg font-bold text-gray-700">2023-09-15</div>
                            </div>
                        </div>
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
    
    <!-- Add reference to our JavaScript file -->
    <script src="js/game.js"></script>
    
    <script>
        // Helper functions for card elements
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
        
        function getElementIcon(element) {
            switch(element) {
                case 'water': return 'fa-water';
                case 'fire': return 'fa-fire';
                case 'earth': return 'fa-mountain';
                case 'air': return 'fa-wind';
                case 'arcane': return 'fa-hat-wizard';
                default: return 'fa-question';
            }
        }
        
        // View toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const gridView = document.getElementById('cards-grid');
            const listView = document.getElementById('cards-list');
            const gridViewBtn = document.querySelector('.grid-view-btn');
            const listViewBtn = document.querySelector('.list-view-btn');
            
            gridViewBtn.addEventListener('click', function() {
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
                gridViewBtn.classList.add('bg-primary/10', 'text-primary');
                gridViewBtn.classList.remove('bg-white');
                listViewBtn.classList.add('bg-white');
                listViewBtn.classList.remove('bg-primary/10', 'text-primary');
            });
            
            listViewBtn.addEventListener('click', function() {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
                listViewBtn.classList.add('bg-primary/10', 'text-primary');
                listViewBtn.classList.remove('bg-white');
                gridViewBtn.classList.add('bg-white');
                gridViewBtn.classList.remove('bg-primary/10', 'text-primary');
            });
            
            // Filter functionality
            document.getElementById('card-search').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                filterCards('search', searchTerm);
            });
            
            // Mana filter
            document.getElementById('mana-range').addEventListener('input', function(e) {
                const maxMana = parseInt(e.target.value);
                filterCards('mana', maxMana);
            });
            
            // Element filters
            document.querySelectorAll('[id^="element-"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    applyFilters();
                });
            });
            
            // Type filters
            document.querySelectorAll('[id^="type-"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    applyFilters();
                });
            });
            
            // Rarity filters
            document.querySelectorAll('[id^="rarity-"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    applyFilters();
                });
            });
            
            // Sort functionality
            document.getElementById('sort-by').addEventListener('change', function(e) {
                const sortBy = e.target.value;
                sortCards(sortBy);
            });
        });
        
        function filterCards(filterType, value) {
            // Combined filter function
            applyFilters();
        }
        
        function applyFilters() {
            // Get all filter values
            const searchTerm = document.getElementById('card-search').value.toLowerCase();
            const maxMana = parseInt(document.getElementById('mana-range').value);
            
            // Get selected elements
            const elements = Array.from(document.querySelectorAll('[id^="element-"]:checked')).map(cb => cb.id.replace('element-', ''));
            
            // Get selected card types
            const types = Array.from(document.querySelectorAll('[id^="type-"]:checked')).map(cb => cb.id.replace('type-', ''));
            
            // Get selected rarities
            const rarities = Array.from(document.querySelectorAll('[id^="rarity-"]:checked')).map(cb => cb.id.replace('rarity-', ''));
            
            // Apply filters to grid and list views
            const cards = document.querySelectorAll('#cards-grid .game-card, #cards-list > div');
            cards.forEach(card => {
                const cardName = card.querySelector('h3').textContent.toLowerCase();
                const cardElement = card.dataset.element;
                const cardType = card.dataset.type;
                const cardRarity = card.dataset.rarity;
                const cardMana = parseInt(card.dataset.mana);
                
                // Check if card matches all filters
                const matchesSearch = searchTerm === '' || cardName.includes(searchTerm);
                const matchesMana = cardMana <= maxMana;
                const matchesElement = elements.length === 0 || elements.includes(cardElement);
                const matchesType = types.length === 0 || types.includes(cardType);
                const matchesRarity = rarities.length === 0 || rarities.includes(cardRarity);
                
                // Show/hide card based on filter matches
                if (matchesSearch && matchesMana && matchesElement && matchesType && matchesRarity) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        function sortCards(sortBy) {
            // Sort functionality
            const gridContainer = document.getElementById('cards-grid');
            const listContainer = document.getElementById('cards-list');
            
            const gridCards = Array.from(gridContainer.children);
            const listCards = Array.from(listContainer.children);
            
            // Sort grid cards
            gridCards.sort((a, b) => {
                switch(sortBy) {
                    case 'name':
                        return a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent);
                    case 'element':
                        return a.dataset.element.localeCompare(b.dataset.element);
                    case 'rarity':
                        return getRarityValue(a.dataset.rarity) - getRarityValue(b.dataset.rarity);
                    case 'mana':
                        return parseInt(a.dataset.mana) - parseInt(b.dataset.mana);
                    case 'power':
                        const powerA = a.querySelector('.power-stat')?.textContent || '0';
                        const powerB = b.querySelector('.power-stat')?.textContent || '0';
                        return parseInt(powerA) - parseInt(powerB);
                    default:
                        return 0;
                }
            });
            
            // Re-append in sorted order
            gridCards.forEach(card => gridContainer.appendChild(card));
            
            // Sort list cards
            listCards.sort((a, b) => {
                switch(sortBy) {
                    case 'name':
                        return a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent);
                    case 'element':
                        return a.dataset.element.localeCompare(b.dataset.element);
                    case 'rarity':
                        return getRarityValue(a.dataset.rarity) - getRarityValue(b.dataset.rarity);
                    case 'mana':
                        return parseInt(a.dataset.mana) - parseInt(b.dataset.mana);
                    case 'power':
                        // Find power value in list view
                        const powerTextA = Array.from(a.querySelectorAll('.flex.items-center.text-xs')).find(el => el.innerHTML.includes('fa-fire-alt'))?.textContent.trim() || '0';
                        const powerTextB = Array.from(b.querySelectorAll('.flex.items-center.text-xs')).find(el => el.innerHTML.includes('fa-fire-alt'))?.textContent.trim() || '0';
                        return parseInt(powerTextA) - parseInt(powerTextB);
                    default:
                        return 0;
                }
            });
            
            // Re-append in sorted order
            listCards.forEach(card => listContainer.appendChild(card));
        }
        
        function getRarityValue(rarity) {
            switch(rarity) {
                case 'common': return 1;
                case 'uncommon': return 2;
                case 'rare': return 3;
                case 'epic': return 4;
                case 'legendary': return 5;
                default: return 0;
            }
        }
        
        function viewCardDetails(cardJson) {
            const card = JSON.parse(cardJson);
            const modal = document.getElementById('card-detail-modal');
            
            // Populate modal with card details
            document.getElementById('modal-card-name').textContent = card.name;
            document.getElementById('modal-card-name-2').textContent = card.name;
            document.getElementById('modal-card-image').src = card.image;
            document.getElementById('modal-card-type').textContent = ucfirst(card.type) + ' • ' + ucfirst(card.element);
            document.getElementById('modal-card-description').textContent = card.description;
            document.getElementById('modal-card-mana').textContent = card.mana;
            
            // Handle power/health which might be null
            const powerContainer = document.getElementById('modal-card-power-container');
            const healthContainer = document.getElementById('modal-card-health-container');
            
            if (card.power !== null) {
                document.getElementById('modal-card-power').textContent = card.power;
                powerContainer.classList.remove('hidden');
            } else {
                powerContainer.classList.add('hidden');
            }
            
            if (card.health !== null) {
                document.getElementById('modal-card-health').textContent = card.health;
                healthContainer.classList.remove('hidden');
            } else {
                healthContainer.classList.add('hidden');
            }
            
            // Set rarity indicator
            const rarityEl = document.getElementById('modal-card-rarity');
            rarityEl.className = 'absolute top-4 right-4 w-5 h-5 rounded-full rarity-' + card.rarity;
            
            // Set element indicator
            const elementEl = document.getElementById('modal-card-element');
            elementEl.style.backgroundColor = getElementColor(card.element);
            elementEl.style.border = '2px solid white';
            elementEl.innerHTML = '<i class="fas ' + getElementIcon(card.element) + ' text-white"></i>';
            
            // Show modal
            modal.classList.remove('hidden');
        }
        
        function closeCardModal() {
            document.getElementById('card-detail-modal').classList.add('hidden');
        }
        
        function addToDeck(cardName) {
            createMagicalAlert('success', `Added "${cardName}" to your deck!`);
        }
        
        function ucfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
</body>
</html>
<?php
// Helper functions
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

function getElementIcon($element) {
    switch($element) {
        case 'water': return 'fa-water';
        case 'fire': return 'fa-fire';
        case 'earth': return 'fa-mountain';
        case 'air': return 'fa-wind';
        case 'arcane': return 'fa-hat-wizard';
        default: return 'fa-question';
    }
}
?>
