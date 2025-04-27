<?php
/**
 * API endpoint to get theme colors from MagicalTheme
 * Returns colors as JSON for use in JavaScript
 */

// Include the MagicalTheme class
require_once 'MagicalTheme.php';

// Set the content type to JSON
header('Content-Type: application/json');

// Get the current theme from query parameter or use the default
$themeName = $_GET['theme'] ?? 'blue'; // Default to 'blue' if not specified

// Instantiate MagicalTheme with the specified theme
$theme = new MagicalTheme($themeName);

// Get all colors from the theme
$colors = $theme->getAllColors();

// Output colors as JSON
echo json_encode($colors);
