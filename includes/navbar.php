<?php 

$theme->addNavItem('Home', [
    'url' => 'index.php',
    'icon' => 'fa-home'
]);
$theme->addNavItem('Card Collection', [
    'url' => 'collection.php',
    'icon' => 'fa-layer-group',
    'badge' => '<span class="bg-warning/90 text-dark text-xs py-0.5 px-2 rounded-full font-bold">New</span>'
]);
$theme->addNavItem('Battle Arena', [
    'url' => 'battle.php',
    'icon' => 'fa-swords',
    'submenu' => [
        'PvP Matches' => 'pvp.php',
        'Tournament' => 'tournament.php',
        'Practice Mode' => 'practice.php'
    ]
]);
$theme->addNavItem('Shop', [
    'url' => 'shop.php',
    'icon' => 'fa-store',
    'badge' => '<span class="bg-warning/90 text-dark text-xs py-0.5 px-2 rounded-full font-bold">New</span>'
]);

$theme->addNavItem('Leaderboard', 'leaderboard.php');

// var_dump( $_SESSION['user']);
?>