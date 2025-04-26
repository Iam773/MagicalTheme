<?php
// This file contains the navigation bar that can be included in multiple pages

// Ensure no output has been sent before starting the session
if (session_status() == PHP_SESSION_NONE && !headers_sent()) {
    session_start();
} 

// Check if $theme is set, otherwise create it
if (!isset($theme) || !($theme instanceof MagicalTheme)) {
    require_once __DIR__ . '/../MagicalTheme.php';
    $theme = new MagicalTheme('blue');
}
// Set website name if not provided
if (!isset($websiteName)) {
    $websiteName = 'Azure Cards';
}

// IMPORTANT CHANGE: Don't render the navbar here!
// Instead, provide a function that can be called after potential item additions
function renderNavbar() {
    global $theme, $websiteName;
    echo $theme->renderNavbar(basename($_SERVER['PHP_SELF']), [], $websiteName);
}


?>
