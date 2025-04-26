<?php
// This file contains the navigation bar that can be included in multiple pages

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if $theme is set, otherwise create it
if (!isset($theme) || !($theme instanceof MagicalTheme)) {
    require_once __DIR__ . '/../MagicalTheme.php';
    $theme = new MagicalTheme('blue');
}

// Check if $navItems is not set, initialize with default nav structure
if (!isset($navItems)) {
    $navItems = [
        'Home' => [
            'url' => 'index.php',
            'icon' => 'fa-home'
        ],
        'Card Collection' => [
            'url' => 'collection.php',
            'icon' => 'fa-layer-group',
            'badge' => '<span class="bg-warning/90 text-dark text-xs py-0.5 px-2 rounded-full font-bold">New</span>'
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
    ];
    
    // Check if user is logged in (username exists in session)
    if (isset($_SESSION['username'])) {
        // Add Profile link for logged-in users
        $navItems[$_SESSION['username']] = [
            'url' => 'profile.php',
            'icon' => 'fa-user'
        ];
    } else {
        // Add Login and Register for guests
        $navItems['Login'] = [
            'url' => 'login.php',
            'icon' => 'fa-sign-in-alt'
        ];
        $navItems['Register'] = [
            'url' => 'register.php',
            'icon' => 'fa-user-plus'
        ];
    }
    
    // Set active page based on current file
    $currentFile = basename($_SERVER['PHP_SELF']);
    foreach ($navItems as $label => $item) {
        if (is_array($item) && isset($item['url']) && basename($item['url']) === $currentFile) {
            $navItems[$label]['active'] = true;
        }
    }
    
    $theme->setNavItems($navItems);
}

// Set website name if not provided
if (!isset($websiteName)) {
    $websiteName = 'Azure Cards';
}

// Render the navigation bar
echo $theme->renderNavbar(basename($_SERVER['PHP_SELF']), [], $websiteName);
?>
