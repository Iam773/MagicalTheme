<?php
require_once 'MagicalTheme.php';
require_once 'game/GameManager.php';

// Initialize the theme with blue color scheme
$theme = new MagicalTheme('blue');

// User's current currency (in a real app, this would come from a database)
$userData = [
    'coins' => 3250,
    'gems' => 120,
    'points' => 850
];

// Shop categories
$categories = [
    'card-packs' => 'Card Packs',
    'accessories' => 'Accessories',
    'cosmetics' => 'Cosmetics',
    'specials' => 'Special Offers'
];

// Shop items
$items = [
    // Card Packs
    [
        'id' => 'pack1',
        'name' => 'Basic Pack',
        'category' => 'card-packs',
        'description' => '5 cards with at least 1 rare card guaranteed.',
        'price' => ['coins' => 500],
        'image' => 'https://placehold.co/400x500/0284c7/ffffff?text=Basic+Pack',
        'badges' => ['Popular'],
        'rarities' => ['Common' => '60%', 'Uncommon' => '30%', 'Rare' => '10%']
    ],
    [
        'id' => 'pack2',
        'name' => 'Element Pack',
        'category' => 'card-packs',
        'description' => '5 cards of a selected element with at least 1 rare card guaranteed.',
        'price' => ['coins' => 750],
        'image' => 'https://placehold.co/400x500/7dd3fc/000000?text=Element+Pack',
        'badges' => [],
        'rarities' => ['Common' => '50%', 'Uncommon' => '35%', 'Rare' => '13%', 'Epic' => '2%']
    ],
    [
        'id' => 'pack3',
        'name' => 'Premium Pack',
        'category' => 'card-packs',
        'description' => '5 cards with at least 1 epic card guaranteed.',
        'price' => ['coins' => 1200],
        'image' => 'https://placehold.co/400x500/9d8cff/ffffff?text=Premium+Pack',
        'badges' => ['Best Value'],
        'rarities' => ['Common' => '30%', 'Uncommon' => '40%', 'Rare' => '22%', 'Epic' => '7%', 'Legendary' => '1%']
    ],
    [
        'id' => 'pack4',
        'name' => 'Legendary Pack',
        'category' => 'card-packs',
        'description' => '5 cards with at least 1 legendary card guaranteed.',
        'price' => ['gems' => 100],
        'image' => 'https://placehold.co/400x500/fbbf24/ffffff?text=Legendary+Pack',
        'badges' => ['Limited'],
        'rarities' => ['Rare' => '40%', 'Epic' => '45%', 'Legendary' => '15%']
    ],
    
    // Accessories
    [
        'id' => 'accessory1',
        'name' => 'Card Sleeve: Crystal',
        'category' => 'accessories',
        'description' => 'A beautiful crystal-themed card sleeve for your deck.',
        'price' => ['coins' => 300],
        'image' => 'https://placehold.co/300x400/38bdf8/ffffff?text=Crystal+Sleeve',
        'badges' => ['New'],
    ],
    [
        'id' => 'accessory2',
        'name' => 'Card Sleeve: Fire',
        'category' => 'accessories',
        'description' => 'A fiery card sleeve to intimidate your opponents.',
        'price' => ['coins' => 300],
        'image' => 'https://placehold.co/300x400/f87171/ffffff?text=Fire+Sleeve',
        'badges' => [],
    ],
    [
        'id' => 'accessory3',
        'name' => 'Playmat: Azure',
        'category' => 'accessories',
        'description' => 'A premium playmat with the Azure Cards logo.',
        'price' => ['coins' => 800],
        'image' => 'https://placehold.co/300x200/0c4a6e/ffffff?text=Azure+Playmat',
        'badges' => [],
    ],
    
    // Cosmetics
    [
        'id' => 'cosmetic1',
        'name' => 'Avatar Frame: Gold',
        'category' => 'cosmetics',
        'description' => 'A golden frame for your profile avatar.',
        'price' => ['coins' => 400],
        'image' => 'https://placehold.co/150x150/fcd34d/ffffff?text=Gold+Frame',
        'badges' => [],
    ],
    [
        'id' => 'cosmetic2',
        'name' => 'Profile Banner: Lightning',
        'category' => 'cosmetics',
        'description' => 'An electrifying banner for your profile.',
        'price' => ['points' => 200],
        'image' => 'https://placehold.co/400x150/7e22ce/ffffff?text=Lightning+Banner',
        'badges' => [],
    ],
    [
        'id' => 'cosmetic3',
        'name' => 'Card Back: Dragon',
        'category' => 'cosmetics',
        'description' => 'A dragon-themed card back for your deck.',
        'price' => ['gems' => 30],
        'image' => 'https://placehold.co/300x400/075985/ffffff?text=Dragon+Card+Back',
        'badges' => ['Most Popular'],
    ],
    
    // Special Offers
    [
        'id' => 'special1',
        'name' => 'Starter Bundle',
        'category' => 'specials',
        'description' => 'Get 3 Basic Packs + 500 coins at a special price.',
        'price' => ['gems' => 50],
        'original_price' => ['gems' => 75],
        'image' => 'https://placehold.co/400x300/065f46/ffffff?text=Starter+Bundle',
        'badges' => ['33% Off'],
    ],
    [
        'id' => 'special2',
        'name' => 'Weekend Deal',
        'category' => 'specials',
        'description' => '1 Premium Pack + Crystal Card Sleeve',
        'price' => ['coins' => 1300],
        'original_price' => ['coins' => 1500],
        'image' => 'https://placehold.co/400x300/7e22ce/ffffff?text=Weekend+Deal',
        'badges' => ['Limited Time'],
        'expires_in' => '23:45:10',
    ],
];

// Get current category from query parameters or default to 'card-packs'
$currentCategory = $_GET['category'] ?? 'card-packs';

// Filter items by category
$filteredItems = array_filter($items, function($item) use ($currentCategory) {
    return $item['category'] === $currentCategory;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Shop - Azure Cards</title>
    <?php echo $theme->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Link to our custom CSS file -->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Shop specific styles */
        .game-banner {
            position: relative;
            background: linear-gradient(to right, #0c4a6e, #0284c7);
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
            color: white;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .game-banner::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.2;
        }
        
        .shop-category-tab {
            padding-left: 1rem;
            padding-right: 1rem;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            font-family: var(--primary-font);
            text-align: center;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }
        
        .shop-category-tab.active {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .shop-category-tab:not(.active) {
            background-color: white;
            color: #374151;
        }
        
        .shop-category-tab:not(.active):hover {
            background-color: #f3f4f6;
        }
        
        .shop-item-card {
            background-color: white;
            border-radius: 0.75rem;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
        }
        
        .shop-item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .shop-item-image {
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .currency-coin {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background-color: #fbbf24;
            color: #92400e;
            width: 1.25rem;
            height: 1.25rem;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .currency-gem {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background-color: #a78bfa;
            color: #5b21b6;
            width: 1.25rem;
            height: 1.25rem;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .currency-point {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background-color: #4ade80;
            color: #166534;
            width: 1.25rem;
            height: 1.25rem;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .shop-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background-color: var(--primary);
            color: white;
            font-size: 0.75rem;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            border-radius: 9999px;
        }
        
        .shop-badge.featured {
            background-color: var(--warning);
        }
        
        .rarity-bar {
            height: 8px;
            overflow: hidden;
            border-radius: 4px;
            display: flex;
        }
        
        /* Rarity colors */
        .rarity-common { background-color: #9ca3af; }
        .rarity-uncommon { background-color: #34d399; }
        .rarity-rare { background-color: #3b82f6; }
        .rarity-epic { background-color: #8b5cf6; }
        .rarity-legendary { background-color: #f59e0b; }
        
        /* Timer animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .timer-pulse {
            animation: pulse 1s infinite;
        }
        
        /* Currency display */
        .currency-display {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
            border-radius: 9999px;
            color: white;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .currency-coins {
            background-color: #eab308;
        }
        
        .currency-gems {
            background-color: #8b5cf6;
        }
        
        .currency-points {
            background-color: #22c55e;
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'includes/nav.php'; ?>
    
    <div class="container mx-auto px-4 py-6">
        <!-- Shop Banner -->
        <div class="game-banner shadow-magical mb-8">
            <div class="relative z-10">
                <h1 class="text-4xl md:text-5xl font-itim text-white mb-2 text-shadow-[0_2px_5px_rgba(0,0,0,0.3)]">Card Shop</h1>
                <p class="text-white text-xl md:text-2xl font-itim opacity-90">Expand your collection with new cards and accessories!</p>
                
                <!-- User Currency Display -->
                <div class="flex flex-wrap gap-3 mt-6">
                    <div class="currency-display currency-coins">
                        <i class="fas fa-coins"></i>
                        <span><?php echo number_format($userData['coins']); ?> Coins</span>
                    </div>
                    <div class="currency-display currency-gems">
                        <i class="fas fa-gem"></i>
                        <span><?php echo number_format($userData['gems']); ?> Gems</span>
                    </div>
                    <div class="currency-display currency-points">
                        <i class="fas fa-star"></i>
                        <span><?php echo number_format($userData['points']); ?> Points</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Shop Categories Tabs -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
            <?php foreach ($categories as $key => $name): ?>
                <a href="?category=<?php echo $key; ?>" class="shop-category-tab <?php echo $currentCategory === $key ? 'active' : ''; ?>">
                    <?php 
                    $icon = match($key) {
                        'card-packs' => 'fa-layer-group',
                        'accessories' => 'fa-wand-sparkles',
                        'cosmetics' => 'fa-palette',
                        'specials' => 'fa-gift',
                        default => 'fa-shopping-bag'
                    };
                    ?>
                    <i class="fas <?php echo $icon; ?> mr-2"></i>
                    <?php echo $name; ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <!-- Shop Items -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($filteredItems as $item): ?>
                <div class="shop-item-card">
                    <div class="shop-item-image">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-full h-full object-cover">
                        
                        <?php if (isset($item['badges']) && count($item['badges']) > 0): ?>
                            <?php foreach ($item['badges'] as $index => $badge): ?>
                                <div class="shop-badge <?php echo $badge === 'Limited' || $badge === 'Limited Time' || str_contains($badge, 'Off') ? 'featured' : ''; ?>" style="top: <?php echo (2 + $index * 26) ?>px;">
                                    <?php echo $badge; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="font-itim text-lg text-primary mb-1"><?php echo $item['name']; ?></h3>
                        <p class="text-sm text-gray-600 mb-3"><?php echo $item['description']; ?></p>
                        
                        <?php if (isset($item['rarities'])): ?>
                            <div class="mb-3">
                                <div class="text-xs text-gray-500 mb-1">Card Rarities</div>
                                <div class="rarity-bar mb-1">
                                    <?php 
                                    foreach ($item['rarities'] as $rarity => $percentage) {
                                        $width = intval($percentage);
                                        echo '<div class="rarity-' . strtolower($rarity) . '" style="width: ' . $width . '%"></div>';
                                    }
                                    ?>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500">
                                    <?php
                                    $rarityKeys = array_keys($item['rarities']);
                                    echo '<span>' . $rarityKeys[0] . '</span>';
                                    echo '<span>' . end($rarityKeys) . '</span>';
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($item['expires_in'])): ?>
                            <div class="mb-3">
                                <div class="text-xs text-gray-500 mb-1">Limited Offer</div>
                                <div class="text-warning font-mono font-bold timer-pulse">
                                    <i class="fas fa-clock mr-1"></i> <?php echo $item['expires_in']; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                <?php if (isset($item['original_price'])): ?>
                                    <div class="line-through text-gray-400 text-xs">
                                        <?php
                                        foreach ($item['original_price'] as $currency => $amount) {
                                            echo number_format($amount) . ' ' . ucfirst($currency);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="font-bold text-gray-800">
                                    <?php
                                    foreach ($item['price'] as $currency => $amount) {
                                        $icon = match($currency) {
                                            'coins' => '<div class="currency-coin mr-1"><i class="fas fa-coins text-[10px]"></i></div>',
                                            'gems' => '<div class="currency-gem mr-1"><i class="fas fa-gem text-[10px]"></i></div>',
                                            'points' => '<div class="currency-point mr-1"><i class="fas fa-star text-[10px]"></i></div>',
                                            default => ''
                                        };
                                        
                                        echo '<div class="flex items-center">' . $icon . number_format($amount) . '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <?php
                            // Determine if user can afford this item
                            $canAfford = true;
                            foreach ($item['price'] as $currency => $amount) {
                                if ($userData[$currency] < $amount) {
                                    $canAfford = false;
                                    break;
                                }
                            }
                            ?>
                            
                            <button type="button" 
                                   class="<?php echo $canAfford ? 'magic-button magic-button-primary' : 'bg-gray-300 text-gray-500 cursor-not-allowed px-3 py-1 rounded'; ?> text-sm"
                                   <?php echo !$canAfford ? 'disabled' : ''; ?>
                                   onclick="purchaseItem('<?php echo $item['id']; ?>')">
                                <?php echo $item['category'] === 'card-packs' ? 'Buy Pack' : 'Purchase'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (count($filteredItems) === 0): ?>
            <div class="text-center py-12">
                <div class="text-5xl mb-4">😢</div>
                <h3 class="font-itim text-xl text-primary mb-2">No items available</h3>
                <p class="text-gray-600">There are no items in this category at the moment. Please check back later!</p>
            </div>
        <?php endif; ?>
        
        <!-- Promotional Banner -->
        <div class="mt-12 bg-gradient-to-r from-primary/80 to-secondary/80 rounded-xl p-6 relative overflow-hidden shadow-magical">
            <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('https://placehold.co/1200x300')"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h3 class="font-itim text-2xl text-white mb-2">Get More Gems!</h3>
                    <p class="text-white/80">Use special code "AZURE25" for 25% bonus on your next gem purchase!</p>
                </div>
                <div>
                    <?php echo $theme->renderButton('Buy Gems', 'secondary', 'lg', 'gems.php', '', 'gem'); ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pack Opening Modal -->
    <div id="pack-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-80" id="pack-modal-overlay"></div>
        <div class="relative z-10 max-w-3xl w-full">
            <div class="bg-gradient-to-br from-primary/5 to-secondary/5 backdrop-blur-2xl p-6 rounded-2xl shadow-magical">
                <h2 class="font-itim text-3xl text-center text-primary mb-6">Pack Opening</h2>
                
                <div id="pack-cards-container" class="flex flex-wrap justify-center gap-4 py-4">
                    <!-- Cards will be inserted here by JavaScript -->
                </div>
                
                <div class="flex justify-center mt-6">
                    <button id="close-pack-btn" class="magic-button magic-button-primary">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Purchase Confirmation Modal -->
    <div id="purchase-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" id="purchase-modal-overlay"></div>
        <div class="relative z-10 max-w-md w-full">
            <div class="bg-white p-6 rounded-2xl shadow-magical border-t-4 border-primary">
                <h2 class="font-itim text-2xl text-primary mb-4">Confirm Purchase</h2>
                
                <div class="mb-4">
                    <p>Are you sure you want to purchase <span id="purchase-item-name" class="font-bold"></span>?</p>
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Price: <span id="purchase-item-price" class="font-bold"></span></p>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button id="cancel-purchase-btn" class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                        Cancel
                    </button>
                    <button id="confirm-purchase-btn" class="magic-button magic-button-primary">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add reference to our JavaScript file -->
    <script src="js/game.js"></script>
    
    <script>
        // Item data
        const shopItems = <?php echo json_encode($items); ?>;
        
        // User data
        let userData = <?php echo json_encode($userData); ?>;
        
        // Current selected item
        let selectedItem = null;
        
        // Purchase functionality
        function purchaseItem(itemId) {
            // Find the item
            selectedItem = shopItems.find(item => item.id === itemId);
            
            if (!selectedItem) return;
            
            // Update purchase modal with item details
            document.getElementById('purchase-item-name').textContent = selectedItem.name;
            
            // Format price display
            let priceText = '';
            for (const [currency, amount] of Object.entries(selectedItem.price)) {
                priceText += `${amount} ${currency.charAt(0).toUpperCase() + currency.slice(1)} `;
            }
            document.getElementById('purchase-item-price').textContent = priceText;
            
            // Show the purchase modal
            document.getElementById('purchase-modal').classList.remove('hidden');
        }
        
        // Sample card data for pack opening
        const cardPool = {
            common: [
                { name: "Water Elemental", rarity: "common", type: "creature", element: "water", image: "https://placehold.co/150x200/38bdf8/ffffff?text=Water+Elemental" },
                { name: "Flame Imp", rarity: "common", type: "creature", element: "fire", image: "https://placehold.co/150x200/dc2626/ffffff?text=Flame+Imp" },
                { name: "Stone Guard", rarity: "common", type: "creature", element: "earth", image: "https://placehold.co/150x200/84cc16/ffffff?text=Stone+Guard" },
                { name: "Air Sprite", rarity: "common", type: "creature", element: "air", image: "https://placehold.co/150x200/e0f2fe/000000?text=Air+Sprite" },
                { name: "Arcane Bolt", rarity: "common", type: "spell", element: "arcane", image: "https://placehold.co/150x200/a78bfa/ffffff?text=Arcane+Bolt" },
            ],
            uncommon: [
                { name: "Ice Shield", rarity: "uncommon", type: "spell", element: "water", image: "https://placehold.co/150x200/bae6fd/000000?text=Ice+Shield" },
                { name: "Fire Arrow", rarity: "uncommon", type: "spell", element: "fire", image: "https://placehold.co/150x200/f97316/ffffff?text=Fire+Arrow" },
                { name: "Earth Armor", rarity: "uncommon", type: "spell", element: "earth", image: "https://placehold.co/150x200/a3e635/000000?text=Earth+Armor" },
                { name: "Tornado", rarity: "uncommon", type: "spell", element: "air", image: "https://placehold.co/150x200/7dd3fc/000000?text=Tornado" },
            ],
            rare: [
                { name: "Ocean Guardian", rarity: "rare", type: "creature", element: "water", image: "https://placehold.co/150x200/0c4a6e/ffffff?text=Ocean+Guardian" },
                { name: "Fire Dragon", rarity: "rare", type: "creature", element: "fire", image: "https://placehold.co/150x200/b91c1c/ffffff?text=Fire+Dragon" },
                { name: "Mountain Giant", rarity: "rare", type: "creature", element: "earth", image: "https://placehold.co/150x200/65a30d/ffffff?text=Mountain+Giant" },
                { name: "Lightning Strike", rarity: "rare", type: "spell", element: "air", image: "https://placehold.co/150x200/7dd3fc/000000?text=Lightning" },
            ],
            epic: [
                { name: "Water Behemoth", rarity: "epic", type: "creature", element: "water", image: "https://placehold.co/150x200/0284c7/ffffff?text=Water+Behemoth" },
                { name: "Phoenix", rarity: "epic", type: "creature", element: "fire", image: "https://placehold.co/150x200/dc2626/ffffff?text=Phoenix" },
                { name: "Mystic Sage", rarity: "epic", type: "creature", element: "arcane", image: "https://placehold.co/150x200/a78bfa/ffffff?text=Sage" },
            ],
            legendary: [
                { name: "Poseidon", rarity: "legendary", type: "creature", element: "water", image: "https://placehold.co/150x200/1e3a8a/ffffff?text=Poseidon" },
                { name: "Fire Lord", rarity: "legendary", type: "creature", element: "fire", image: "https://placehold.co/150x200/991b1b/ffffff?text=Fire+Lord" },
                { name: "Reality Warp", rarity: "legendary", type: "spell", element: "arcane", image: "https://placehold.co/150x200/8b5cf6/ffffff?text=Reality+Warp" },
            ]
        };
        
        // Initialize when document is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Set up the purchase modal
            const purchaseModal = document.getElementById('purchase-modal');
            const purchaseModalOverlay = document.getElementById('purchase-modal-overlay');
            
            // Close modal when clicking overlay
            purchaseModalOverlay.addEventListener('click', () => {
                purchaseModal.classList.add('hidden');
            });
            
            // Cancel button
            document.getElementById('cancel-purchase-btn').addEventListener('click', () => {
                purchaseModal.classList.add('hidden');
            });
            
            // Confirm purchase button
            document.getElementById('confirm-purchase-btn').addEventListener('click', () => {
                if (!selectedItem) return;
                
                // Check if this is a card pack
                const isCardPack = selectedItem.category === 'card-packs';
                
                // Deduct currency
                let successfulPurchase = true;
                
                for (const [currency, amount] of Object.entries(selectedItem.price)) {
                    if (userData[currency] >= amount) {
                        userData[currency] -= amount;
                        // Update display
                        updateCurrencyDisplay(currency, userData[currency]);
                    } else {
                        successfulPurchase = false;
                        createMagicalAlert('error', `Not enough ${currency} to make this purchase.`);
                        break;
                    }
                }
                
                if (successfulPurchase) {
                    purchaseModal.classList.add('hidden');
                    
                    if (isCardPack) {
                        // Open the pack
                        openCardPack(selectedItem);
                    } else {
                        // Show success message for other items
                        createMagicalAlert('success', `Successfully purchased ${selectedItem.name}!`);
                    }
                }
            });
            
            // Set up the pack opening modal
            const packModal = document.getElementById('pack-modal');
            const packModalOverlay = document.getElementById('pack-modal-overlay');
            
            // Close pack modal when clicking overlay
            packModalOverlay.addEventListener('click', () => {
                packModal.classList.add('hidden');
            });
            
            // Close button for pack modal
            document.getElementById('close-pack-btn').addEventListener('click', () => {
                packModal.classList.add('hidden');
            });
            
            // Update timers for limited offers
            updateTimers();
            setInterval(updateTimers, 1000);
        });
        
        // Update currency displays
        function updateCurrencyDisplay(currency, newValue) {
            // Find all displays for this currency and update them
            const displays = document.querySelectorAll(`.currency-${currency}s span`);
            displays.forEach(display => {
                display.textContent = `${newValue.toLocaleString()} ${currency.charAt(0).toUpperCase() + currency.slice(1)}${newValue !== 1 ? 's' : ''}`;
            });
        }
        
        // Open a card pack and show the cards
        function openCardPack(packItem) {
            // Generate cards based on pack probabilities
            const cards = generatePackCards(packItem);
            
            // Get container for cards
            const cardsContainer = document.getElementById('pack-cards-container');
            cardsContainer.innerHTML = '';
            
            // Coin flip animation for each card
            setTimeout(() => {
                cards.forEach((card, index) => {
                    setTimeout(() => {
                        // Create card element
                        const cardElement = document.createElement('div');
                        cardElement.className = `w-[150px] h-[220px] perspective-500 card-flip`;
                        cardElement.innerHTML = `
                            <div class="relative w-full h-full transition-transform duration-1000 transform-style-3d">
                                <div class="absolute inset-0 backface-hidden bg-primary rounded-lg flex items-center justify-center text-white">
                                    <div class="text-3xl">?</div>
                                </div>
                                <div class="absolute inset-0 backface-hidden rotate-y-180 bg-white rounded-lg overflow-hidden shadow-lg">
                                    <img src="${card.image}" class="w-full h-3/4 object-cover" alt="${card.name}">
                                    <div class="p-2">
                                        <div class="text-xs font-bold truncate">${card.name}</div>
                                        <div class="text-xs rarity-${card.rarity} text-white px-1 rounded text-center mt-1">
                                            ${card.rarity.charAt(0).toUpperCase() + card.rarity.slice(1)}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        cardsContainer.appendChild(cardElement);
                        
                        // Start flip animation after a delay
                        setTimeout(() => {
                            cardElement.querySelector('.transition-transform').classList.add('rotate-y-180');
                        }, 200 * (index + 1)); // Stagger the animations
                    }, index * 300); // Add each card with a delay
                });
            }, 500); // Initial delay before starting
            
            // Show the pack modal
            document.getElementById('pack-modal').classList.remove('hidden');
            
            // Play sound effect
            // playSound('pack-open.mp3');
        }
        
        // Generate cards for a pack based on its probabilities
        function generatePackCards(packItem) {
            const cards = [];
            const count = 5; // Standard 5 cards per pack
            
            // Check if we have rarity information
            if (!packItem.rarities) {
                // Default distribution if no rarities specified
                for (let i = 0; i < count; i++) {
                    cards.push(getRandomCardByRarity('common'));
                }
                return cards;
            }
            
            // Check for guaranteed rarities
            let guaranteedRarity = null;
            
            if (packItem.id === 'pack1') {
                guaranteedRarity = 'rare';
            } else if (packItem.id === 'pack3') {
                guaranteedRarity = 'epic';
            } else if (packItem.id === 'pack4') {
                guaranteedRarity = 'legendary';
            }
            
            // Add guaranteed card first if applicable
            if (guaranteedRarity) {
                cards.push(getRandomCardByRarity(guaranteedRarity));
            }
            
            // Fill remaining slots based on probabilities
            const remainingSlots = count - cards.length;
            for (let i = 0; i < remainingSlots; i++) {
                const rarity = determineRarityByProbability(packItem.rarities);
                cards.push(getRandomCardByRarity(rarity));
            }
            
            return cards;
        }
        
        // Get a random card of a specific rarity
        function getRandomCardByRarity(rarity) {
            const pool = cardPool[rarity] || cardPool.common;
            return pool[Math.floor(Math.random() * pool.length)];
        }
        
        // Determine a card's rarity based on probabilities
        function determineRarityByProbability(rarities) {
            const roll = Math.random() * 100;
            let cumulativeChance = 0;
            
            for (const [rarity, chance] of Object.entries(rarities)) {
                cumulativeChance += parseFloat(chance);
                if (roll <= cumulativeChance) {
                    return rarity.toLowerCase();
                }
            }
            
            // Fallback to common
            return 'common';
        }
        
        // Update countdown timers for limited time offers
        function updateTimers() {
            document.querySelectorAll('[data-expires]').forEach(el => {
                const timeLeft = el.getAttribute('data-expires');
                // Parse time and subtract 1 second
                const [hours, minutes, seconds] = timeLeft.split(':').map(Number);
                
                let totalSeconds = hours * 3600 + minutes * 60 + seconds;
                if (totalSeconds > 0) {
                    totalSeconds--;
                    
                    const newHours = Math.floor(totalSeconds / 3600);
                    const newMinutes = Math.floor((totalSeconds % 3600) / 60);
                    const newSeconds = totalSeconds % 60;
                    
                    const formattedTime = `${String(newHours).padStart(2, '0')}:${String(newMinutes).padStart(2, '0')}:${String(newSeconds).padStart(2, '0')}`;
                    
                    el.setAttribute('data-expires', formattedTime);
                    el.textContent = formattedTime;
                } else {
                    el.textContent = 'Expired';
                    el.classList.remove('timer-pulse');
                }
            });
        }
    </script>
    
    <!-- Adding custom styles for card flip animation -->
    <style>
        .perspective-500 {
            perspective: 500px;
        }
        
        .transform-style-3d {
            transform-style: preserve-3d;
        }
        
        .backface-hidden {
            backface-visibility: hidden;
        }
        
        .rotate-y-180 {
            transform: rotateY(180deg);
        }
    </style>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-10 mt-20">
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
</body>
</html>
