<?php
/**
 * Magical Theme System
 * 
 * An enhanced object-oriented magical girl theme system
 * using Tailwind CSS 4 with Itim font
 * 
 * @version 3.1
 */

class MagicalTheme {
    // Theme colors - updated with more vibrant palette
    private $colors = [
        'primary' => '#ff6ec7',    // Brighter Pink
        'secondary' => '#a78bfa',  // Lavender Purple
        'accent' => '#ffc8dd',     // Soft Pink
        'success' => '#4ade80',    // Emerald Green
        'warning' => '#fbbf24',    // Amber
        'danger' => '#f87171',     // Red
        'light' => '#fff1f9',      // Light Pink background
        'dark' => '#4e2a5a'        // Rich Purple
    ];
    
    // Theme variations
    private $themeColorSets = [
        'pink' => [
            'primary' => '#ff6ec7',    // Brighter Pink
            'secondary' => '#a78bfa',  // Lavender Purple
            'accent' => '#ffc8dd',     // Soft Pink
            'light' => '#fff1f9',      // Light Pink background
            'dark' => '#4e2a5a'        // Rich Purple
        ],
        'blue' => [
            'primary' => '#38bdf8',    // Sky Blue
            'secondary' => '#818cf8',  // Indigo
            'accent' => '#bae6fd',     // Light Blue
            'light' => '#f0f9ff',      // Light Blue background
            'dark' => '#0c4a6e'        // Dark Blue
        ],
        'purple' => [
            'primary' => '#9d8cff',    // Pastel Purple-Blue
            'secondary' => '#c8a2ff',  // Light Lavender
            'accent' => '#d6d4fe',     // Very Light Pastel Purple
            'light' => '#f5f4ff',      // Soft Purple-Blue background
            'dark' => '#5a4fad'        // Darker Purple-Blue
        ]
    ];
    
    // Theme fonts - updated to use Itim as primary font
    private $fonts = [
        'primary' => "'Itim', cursive",
        'secondary' => "'Poppins', sans-serif"
    ];
    
    // Current theme name
    private $currentTheme = 'pink';
    
    // Default navigation items
    public $navItems = [];
    
    /**
     * Renders a magical-themed button with various style options
     * 
     * @param string $text The button text
     * @param string $type Button type (primary, secondary, success, warning, danger)
     * @param string $size Button size (sm, md, lg)
     * @param string|null $url URL for anchor tag buttons, null for regular buttons
     * @param string $additionalClasses Additional CSS classes
     * @param string|null $icon Font Awesome icon class (without the "fa-" prefix)
     * @param bool $iconRight Position icon to the right of text
     * @param bool $animate Whether to add hover animation effects
     * @param string|null $id Button ID attribute
     * @param array $attributes Additional HTML attributes as key-value pairs
     * @return string HTML for the button
     */
    public function renderButton($text, $type = 'primary', $size = 'md', $url = null, $additionalClasses = '', 
                                $icon = null, $iconRight = false, $animate = true, $id = null, $attributes = []) {
        // Get button classes based on type
        $typeClasses = '';
        switch ($type) {
            case 'primary':
                $typeClasses = 'magic-button-primary';
                break;
            case 'secondary':
                $typeClasses = 'magic-button-secondary';
                break;
            case 'success':
                $typeClasses = 'magic-button-success';
                break;
            case 'warning':
                $typeClasses = 'magic-button-warning';
                break;
            case 'danger':
                $typeClasses = 'magic-button-danger';
                break;
            default:
                $typeClasses = 'magic-button-primary';
        }
        
        // Get button size classes
        $sizeClasses = '';
        switch ($size) {
            case 'sm':
                $sizeClasses = 'px-3 py-1 text-sm';
                break;
            case 'md':
                $sizeClasses = 'px-5 py-2';
                break;
            case 'lg':
                $sizeClasses = 'px-8 py-3 text-lg';
                break;
            default:
                $sizeClasses = 'px-5 py-2';
        }
        
        // Add animation class if requested
        $animationClass = $animate ? 'transform transition-all duration-300 hover:-translate-y-1 hover:shadow-magical-lg' : '';
        
        // Process icon if provided
        $iconHtml = '';
        if ($icon) {
            $iconClass = strpos($icon, 'fa-') === 0 ? $icon : 'fa-' . $icon;
            $iconHtml = '<i class="fas ' . $iconClass . '"></i>';
        }
        
        // Set spacing between icon and text
        $spacer = $icon ? ($iconRight ? 'ml-2' : 'mr-2') : '';
        
        // Combine all classes
        $classes = 'magic-button ' . $typeClasses . ' ' . $sizeClasses . ' ' . $animationClass . ' ' . $additionalClasses;
        
        // Process additional attributes
        $attributesString = '';
        foreach ($attributes as $attr => $value) {
            $attributesString .= ' ' . $attr . '="' . htmlspecialchars($value) . '"';
        }
        
        // Add ID if provided
        $idAttribute = $id ? ' id="' . htmlspecialchars($id) . '"' : '';
        
        // Create button or anchor tag
        if ($url) {
            // Create anchor tag
            return '<a href="' . htmlspecialchars($url) . '" class="' . $classes . '"' . $idAttribute . $attributesString . '>' .
                   ($icon && !$iconRight ? $iconHtml . ' ' : '') .
                   '<span class="' . $spacer . '">' . htmlspecialchars($text) . '</span>' .
                   ($icon && $iconRight ? ' ' . $iconHtml : '') .
                   '</a>';
        } else {
            // Create button tag
            return '<button type="button" class="' . $classes . '"' . $idAttribute . $attributesString . '>' .
                   ($icon && !$iconRight ? $iconHtml . ' ' : '') .
                   '<span class="' . ($icon && $iconRight ? 'mr-2' : '') . '">' . htmlspecialchars($text) . '</span>' .
                   ($icon && $iconRight ? ' ' . $iconHtml : '') .
                   '</button>';
        }
    }
    
    /**
     * Constructor - initializes the theme
     * 
     * @param string $theme The theme color set to use (pink, blue, purple)
     */
    public function __construct($theme = 'pink') {
        $this->setTheme($theme);
    }
    
    /**
     * Set the theme by name
     *
     * @param string $theme The theme name (pink, blue, purple)
     * @return MagicalTheme For method chaining
     */
    public function setTheme($theme = 'pink') {
        // Check if theme exists
        if (isset($this->themeColorSets[$theme])) {
            $this->currentTheme = $theme;
            
            // Update colors with theme-specific values
            foreach ($this->themeColorSets[$theme] as $key => $color) {
                $this->colors[$key] = $color;
            }
        }
        
        return $this;
    }
    
    /**
     * Renders a magical card with various style options
     * 
     * @param string $content The HTML content inside the card
     * @param string $type Card type/color scheme (primary, secondary, success, warning, danger)
     * @param string $title Optional card title
     * @param string $additionalClasses Additional CSS classes
     * @param string|null $id Card ID attribute
     * @param array $attributes Additional HTML attributes as key-value pairs
     * @param boolean $floating Whether to add floating animation
     * @param boolean $hoverEffect Whether to add hover transform effect
     * @return string HTML for the card
     */
    public function renderCard($content, $type = 'primary', $title = null, $additionalClasses = '', 
                              $id = null, $attributes = [], $floating = false, $hoverEffect = true) {
        // Get type-specific classes
        $typeClass = '';
        switch ($type) {
            case 'primary':
                $typeClass = 'magic-card-primary';
                $titleClass = 'text-primary';
                break;
            case 'secondary':
                $typeClass = 'magic-card-secondary';
                $titleClass = 'text-secondary';
                break;
            case 'success':
                $typeClass = 'magic-card-success';
                $titleClass = 'text-success';
                break;
            case 'warning':
                $typeClass = 'magic-card-warning';
                $titleClass = 'text-warning';
                break;
            case 'danger':
                $typeClass = 'magic-card-danger';
                $titleClass = 'text-danger';
                break;
            default:
                $typeClass = 'magic-card-primary';
                $titleClass = 'text-primary';
        }
        
        // Add animation classes
        $animationClasses = '';
        if ($floating) {
            $animationClasses .= ' animate-float';
        }
        if (!$hoverEffect) {
            $animationClasses .= ' hover:transform-none hover:shadow-magical';
        }
        
        // Process additional attributes
        $attributesString = '';
        foreach ($attributes as $attr => $value) {
            $attributesString .= ' ' . $attr . '="' . htmlspecialchars($value) . '"';
        }
        
        // Add ID if provided
        $idAttribute = $id ? ' id="' . htmlspecialchars($id) . '"' : '';
        
        // Combine all classes - adding 'relative' by default
        $classes = 'magic-card relative ' . $typeClass . ' ' . $additionalClasses . $animationClasses;
        
        // Build the card HTML
        $html = '<div class="' . $classes . '"' . $idAttribute . $attributesString . '>';
        
        // Add title if provided
        if ($title) {
            $html .= '<h3 class="font-itim text-lg font-bold mb-4 ' . $titleClass . '">' . htmlspecialchars($title) . '</h3>';
        }
        
        // Add content
        $html .= $content;
        
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Get current theme name
     *
     * @return string The current theme name
     */
    public function getTheme() {
        return $this->currentTheme;
    }
    
    /**
     * Get all available themes
     *
     * @return array List of available theme names
     */
    public function getAvailableThemes() {
        return array_keys($this->themeColorSets);
    }
    
    /**
     * Get a theme color by name
     * 
     * @param string $name The color name
     * @return string The color hex code
     */
    public function getColor($name) {
        return $this->colors[$name] ?? $this->colors['primary'];
    }
    
    /**
     * Get all theme colors
     * 
     * @return array Array of all theme colors
     */
    public function getAllColors() {
        return $this->colors;
    }
    
    /**
     * Get a font by name
     * 
     * @param string $name The font name
     * @return string The font family
     */
    public function getFont($name) {
        return $this->fonts[$name] ?? $this->fonts['primary'];
    }
    
    /**
     * Include Tailwind CSS CDN and set up fonts
     * 
     * @return string Tailwind CSS CDN include tag and font imports
     */
    public function includeTailwindCSS() {
        return '
        <!-- Google Fonts - Itim and Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Itim&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Tailwind CSS v4 CDN -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
        
        <!-- Configure Tailwind with our theme colors and fonts -->
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: "' . $this->colors['primary'] . '",
                            secondary: "' . $this->colors['secondary'] . '",
                            accent: "' . $this->colors['accent'] . '",
                            success: "' . $this->colors['success'] . '",
                            warning: "' . $this->colors['warning'] . '",
                            danger: "' . $this->colors['danger'] . '",
                            light: "' . $this->colors['light'] . '",
                            dark: "' . $this->colors['dark'] . '"
                        },
                        fontFamily: {
                            itim: ["Itim", "cursive"],
                            poppins: ["Poppins", "sans-serif"],
                        },
                        animation: {
                            "float": "float 3s ease-in-out infinite",
                            "sparkle": "sparkle 2s infinite",
                            "spin-slow": "spin 6s linear infinite",
                            "ping-slow": "ping 3s cubic-bezier(0, 0, 0.2, 1) infinite"
                        },
                        boxShadow: {
                            "magical": "0 10px 25px -5px rgba(255, 110, 199, 0.5)",
                            "magical-lg": "0 20px 35px -10px rgba(255, 110, 199, 0.6)"
                        },
                        backgroundImage: {
                            "magic-gradient": "linear-gradient(to right, ' . $this->colors['primary'] . ', ' . $this->colors['secondary'] . ')",
                            "magic-gradient-soft": "linear-gradient(to right, ' . $this->colors['accent'] . ', ' . $this->colors['secondary'] . '50)",
                        }
                    }
                }
            }
        </script>';
    }
    
    /**
     * Render the CSS variables for the theme (for backward compatibility)
     * 
     * @return string The CSS variables
     */
    public function renderThemeVariables() {
        $output = "<style>\n";
        $output .= "    :root {\n";
        
        foreach ($this->colors as $name => $value) {
            $output .= "        --{$name}: {$value};\n";
            // Add RGB variables for use in rgba functions
            $rgb = $this->hexToRgb($value);
            $output .= "        --{$name}-rgb: {$rgb};\n";
        }
        
        // Add font variables
        $output .= "        --primary-font: {$this->fonts['primary']};\n";
        $output .= "        --secondary-font: {$this->fonts['secondary']};\n";
        
        $output .= "    }\n";
        $output .= "</style>";
        
        return $output;
    }
    
    /**
     * Render utility classes for Tailwind magic components
     * 
     * @return string The CSS utility classes
     */
    public function renderUtilityClasses() {
        return '<style>
        /* Base styles */
        body {
            background-color: var(--light);
            font-family: var(--primary-font);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--primary-font);
        }
        
        p, span, div {
            font-family: var(--primary-font);
        }
        
        /* Magical cards with enhanced styling */
        .magic-card {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(255, 110, 199, 0.5);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 500ms;
            border-top-width: 6px;
            border-top-style: solid;
            border-top-color: var(--primary);
        }
        
        .magic-card:hover {
            transform: translateY(-0.5rem);
            box-shadow: 0 20px 35px -10px rgba(255, 110, 199, 0.6);
        }
        
        .magic-card::before {
            content: "";
            position: absolute;
            top: -5rem;
            right: -5rem;
            width: 10rem;
            height: 10rem;
            border-radius: 9999px;
            background: linear-gradient(to right, rgba(var(--primary-rgb), 0.1), transparent);
            opacity: 0.7;
        }
        
        .magic-card::after {
            content: "";
            position: absolute;
            bottom: -5rem;
            left: -5rem;
            width: 10rem;
            height: 10rem;
            border-radius: 9999px;
            background: linear-gradient(to right, rgba(var(--secondary-rgb), 0.1), transparent);
            opacity: 0.7;
        }
        
        .magic-card-primary {
            border-top-color: var(--primary);
        }
        
        .magic-card-secondary {
            border-top-color: var(--secondary);
        }
        
        .magic-card-success {
            border-top-color: var(--success);
        }
        
        .magic-card-warning {
            border-top-color: var(--warning);
        }
        
        .magic-card-danger {
            border-top-color: var(--danger);
        }
        
        /* Enhanced magical buttons */
        .magic-button {
            display: inline-block;
            background-image: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            font-family: var(--primary-font);
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            transition: all 300ms;
            box-shadow: 0 10px 25px -5px rgba(255, 110, 199, 0.5);
            transform: translateY(0);
            position: relative;
            overflow: hidden;
        }
        
        .magic-button:hover {
            transform: translateY(-0.25rem);
            box-shadow: 0 20px 35px -10px rgba(255, 110, 199, 0.6);
        }
        
        .magic-button::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(255, 255, 255, 0.2);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 300ms ease-out;
        }
        
        .magic-button:hover::before {
            transform: scaleX(1);
        }
        
        /* Additional variants */
        .magic-button-primary {
            background-image: linear-gradient(to right, var(--primary), rgba(var(--primary-rgb), 0.8));
        }
        
        .magic-button-secondary {
            background-image: linear-gradient(to right, var(--secondary), rgba(var(--secondary-rgb), 0.8));
        }
        
        .magic-button-success {
            background-image: linear-gradient(to right, var(--success), #4ade80);
        }
        
        .magic-button-warning {
            background-image: linear-gradient(to right, var(--warning), #fbbf24);
        }
        
        .magic-button-danger {
            background-image: linear-gradient(to right, var(--danger), #f87171);
        }
        
        /* Form elements */
        .magic-input {
            font-family: "Poppins", sans-serif;
            border-radius: 0.75rem;
            border-color: #e5e7eb;
            transition: all 300ms;
        }
        
        .magic-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.2);
        }
        
        .magic-form {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(255, 110, 199, 0.5);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .magic-form::before {
            content: "";
            position: absolute;
            top: -5rem;
            left: -5rem;
            width: 10rem;
            height: 10rem;
            border-radius: 9999px;
            background-color: rgba(var(--accent-rgb), 0.3);
            filter: blur(1rem);
        }
        
        .magic-form::after {
            content: "";
            position: absolute;
            bottom: -5rem;
            right: -5rem;
            width: 10rem;
            height: 10rem;
            border-radius: 9999px;
            background-color: rgba(var(--secondary-rgb), 0.3);
            filter: blur(1rem);
        }
        
        /* Sparkle animation */
        .sparkle {
            position: relative;
        }
        
        .sparkle::before {
            content: "✨";
            position: absolute;
            animation: sparkle 2s infinite;
            opacity: 0;
        }
        
        /* Layout helpers */
        .page-container {
            min-height: calc(100vh - 76px);
        }
        
        /* Z-index control */
        .above-stars {
            position: relative;
            z-index: 10;
        }
        
        /* Magic badge */
        .magic-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
            font-family: "Poppins", sans-serif;
            font-weight: 500;
            border-radius: 9999px;
        }
        
        .magic-badge-primary {
            background-color: rgba(var(--primary-rgb), 0.2);
            color: var(--primary);
        }
        
        .magic-badge-secondary {
            background-color: rgba(var(--secondary-rgb), 0.2);
            color: var(--secondary);
        }
        
        /* Animation keyframes */
        @keyframes sparkle {
            0% { transform: translate(-50px, 0) rotate(0deg); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translate(50px, -50px) rotate(360deg); opacity: 0; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        /* Navbar styling */
        .magical-navbar {
            background-image: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 10px 25px -5px rgba(255, 110, 199, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
        }
        
        .magical-nav-link {
            padding: 0.5rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            transition: color 300ms;
            position: relative;
            font-family: var(--primary-font);
        }
        
        .magical-nav-link:hover {
            color: white;
        }
        
        .magical-nav-link.active::after {
            content: "";
            position: absolute;
            height: 0.25rem;
            width: 2rem;
            background-color: white;
            border-radius: 9999px;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        </style>';
    }
    
    /**
     * Render the star animation styles
     * 
     * @return string The CSS styles for stars
     */
    public function renderStarStyles() {
        return '<style>
        /* Improved Realistic Shooting Stars Animation */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
            background: transparent;
        }
        
        /* Background static stars */
        .background-star {
            position: absolute;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 0 3px 1px rgba(255, 255, 255, 0.4);
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(0.7); }
            50% { opacity: 1; transform: scale(1); }
        }
        
        /* Shooting stars */
        .shooting-star {
            position: absolute;
            z-index: 1;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            pointer-events: none;
        }
        
        /* Star color variants */
        .pink-star {
            background: var(--primary);
            box-shadow: 
                0 0 0 4px rgba(255, 105, 180, 0.1),
                0 0 10px 2px rgba(255, 105, 180, 0.7);
        }
        
        .blue-star {
            background: #1e90ff;
            box-shadow: 
                0 0 0 4px rgba(30, 144, 255, 0.1),
                0 0 10px 2px rgba(30, 144, 255, 0.7);
        }
        
        .gold-star {
            background: #ffd700;
            box-shadow: 
                0 0 0 4px rgba(255, 215, 0, 0.1),
                0 0 10px 2px rgba(255, 215, 0, 0.7);
        }
        
        /* Star tails */
        .star-tail {
            position: absolute;
            top: 50%;
            right: 0;
            width: 100px;
            height: 2px;
            transform: translateY(-50%);
            transform-origin: right;
        }
        
        .pink-tail {
            background: linear-gradient(90deg, rgba(255, 105, 180, 0.9), transparent);
        }
        
        .blue-tail {
            background: linear-gradient(90deg, rgba(30, 144, 255, 0.9), transparent);
        }
        
        .gold-tail {
            background: linear-gradient(90deg, rgba(255, 215, 0, 0.9), transparent);
        }
        </style>';
    }
    
    /**
     * Render the shooting stars JavaScript
     * 
     * @return string The JavaScript for shooting stars animation
     */
    public function renderStarAnimation() {
        return '<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the stars container
            const starsContainer = document.querySelector(".stars");
            if (!starsContainer) return;
            
            // Clear existing stars
            starsContainer.innerHTML = "";
            
            // Add static background stars
            createBackgroundStars(starsContainer, 75);
            
            // Start the shooting stars animation
            setInterval(createShootingStar, 400);
            
            // Also create some initial stars immediately
            for (let i = 0; i < 5; i++) {
                setTimeout(() => createShootingStar(), i * 200);
            }
            
            /**
             * Creates tiny static background stars
             */
            function createBackgroundStars(container, count) {
                for (let i = 0; i < count; i++) {
                    const star = document.createElement("div");
                    star.classList.add("background-star");
                    
                    // Random position
                    star.style.top = `${Math.random() * 100}%`;
                    star.style.left = `${Math.random() * 100}%`;
                    
                    // Random size (tiny)
                    const size = Math.random() * 2 + 1;
                    star.style.width = `${size}px`;
                    star.style.height = `${size}px`;
                    
                    // Random twinkle animation
                    const duration = Math.random() * 3 + 2;
                    star.style.animation = `twinkle ${duration}s infinite ease-in-out ${Math.random() * 5}s`;
                    
                    container.appendChild(star);
                }
            }
            
            /**
             * Creates and animates a single shooting star
             */
            function createShootingStar() {
                // Don\'t create too many stars at once
                if (document.querySelectorAll(".shooting-star").length > 8) return;
                
                const star = document.createElement("div");
                star.classList.add("shooting-star");
                
                // Randomize the type of star (pink, blue, or gold)
                const starTypes = ["pink-star", "blue-star", "gold-star"];
                const randomType = starTypes[Math.floor(Math.random() * starTypes.length)];
                star.classList.add(randomType);
                
                // Make stars appear from all edges of the screen, not just top-right
                let startX, startY, angle, distance;
                
                // Randomly select which edge the star comes from
                const edge = Math.floor(Math.random() * 4);
                
                switch(edge) {
                    case 0: // Top edge
                        startX = Math.random() * 100;
                        startY = -5;
                        angle = Math.random() * 20 + 70; // 70-90 degrees
                        distance = 120 + Math.random() * 50;
                        break;
                    case 1: // Right edge
                        startX = 105;
                        startY = Math.random() * 100;
                        angle = Math.random() * 20 + 130; // 130-150 degrees
                        distance = 120 + Math.random() * 50;
                        break;
                    case 2: // Bottom edge (fewer stars from bottom)
                        if (Math.random() > 0.7) { // Only 30% chance for bottom edge
                            startX = Math.random() * 100;
                            startY = 105;
                            angle = Math.random() * 20 + 250; // 250-270 degrees
                            distance = 120 + Math.random() * 50;
                        } else {
                            // Fallback to top edge if we don\'t use bottom
                            startX = Math.random() * 100;
                            startY = -5;
                            angle = Math.random() * 20 + 70; // 70-90 degrees
                            distance = 120 + Math.random() * 50;
                        }
                        break;
                    case 3: // Left edge
                        startX = -5;
                        startY = Math.random() * 100;
                        angle = Math.random() * 20 + 310; // 310-330 degrees
                        distance = 120 + Math.random() * 50;
                        break;
                }
                
                star.style.top = `${startY}%`;
                star.style.left = `${startX}%`;
                
                // Set random speed
                const duration = Math.random() * 1.5 + 1; // 1-2.5 seconds (faster stars)
                
                // Create the tail element
                const tail = document.createElement("div");
                tail.classList.add("star-tail");
                
                // Adjust tail size based on star type
                if (randomType === "pink-star") {
                    tail.classList.add("pink-tail");
                } else if (randomType === "blue-star") {
                    tail.classList.add("blue-tail");
                } else {
                    tail.classList.add("gold-tail");
                }
                
                star.appendChild(tail);
                starsContainer.appendChild(star);
                
                // Apply the animation
                star.animate([
                    { transform: `rotate(${angle}deg) translateX(0)`, opacity: 1 },
                    { transform: `rotate(${angle}deg) translateX(${distance}vw)`, opacity: 0 }
                ], {
                    duration: duration * 1000,
                    easing: "cubic-bezier(0.25, 0.1, 0.25, 1)",
                    fill: "forwards"
                }).onfinish = () => {
                    star.remove(); // Remove the star when animation completes
                };
            }
        });
        </script>';
    }
    
    /**
     * Creates the stars container if it doesn't exist
     * 
     * @return string JavaScript to ensure stars container exists
     */
    public function ensureStarsContainer() {
        return '<script>
        document.addEventListener("DOMContentLoaded", function() {
            if (!document.querySelector(".stars")) {
                const starsContainer = document.createElement("div");
                starsContainer.className = "stars";
                document.body.insertBefore(starsContainer, document.body.firstChild);
            }
        });
        </script>';
    }
    
    /**
     * Renders the magical preloader HTML and CSS
     * 
     * @return string The preloader HTML and CSS with Tailwind classes
     */
    public function renderPreloader() {
        return '<!-- Magical Preloader with Tailwind -->
<div id="magical-preloader" class="fixed inset-0 flex flex-col items-center justify-center z-[9999] bg-gradient-to-br from-accent to-light transition-opacity duration-700 ease-in-out">
    <div class="relative w-32 h-32 mb-8 animate-float">
        <div class="magic-wand absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 -rotate-45 origin-[70%_50%]" style="animation: castSpell 4s ease-in-out infinite;">
            <div class="wand-handle w-[60px] h-2 bg-gradient-to-r from-accent to-primary rounded-md shadow-[0_0_10px_rgba(255,182,193,0.7)]"></div>
            <div class="wand-star absolute top-1/2 right-[-15px] transform -translate-y-1/2 w-[25px] h-[25px] bg-gradient-to-br from-[#fffacd] to-[#ffd700] shadow-[0_0_15px_#ffd700] z-[2]"
                 style="clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%); animation: glowStar 2s ease-in-out infinite;">
                <div class="star-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full shadow-[0_0_5px_white]"></div>
            </div>
        </div>
    </div>
    
    <div class="magic-circle w-[120px] h-[120px] rounded-full border-2 border-primary/30 absolute animate-spin-slow">
        <div class="absolute inset-[-2px] rounded-full border-4 border-transparent border-t-primary animate-spin-slow"></div>
        <div class="absolute inset-[6px] rounded-full border-4 border-transparent border-b-secondary animate-[spin_4s_linear_infinite_reverse]"></div>
    </div>
    
    <div class="sparkles absolute w-40 h-40">
        <div class="sparkle absolute w-2 h-2 rounded-full bg-primary shadow-[0_0_10px] shadow-primary top-[20%] left-[70%]" 
             style="animation: moveSparkle 3s ease-in-out infinite 0.2s; opacity: 0;"></div>
        <div class="sparkle absolute w-2 h-2 rounded-full bg-secondary shadow-[0_0_10px] shadow-secondary top-[70%] left-[30%]"
             style="animation: moveSparkle 2.5s ease-in-out infinite 0.5s; opacity: 0;"></div>
        <div class="sparkle absolute w-2 h-2 rounded-full bg-[#ffd700] shadow-[0_0_10px] shadow-[#ffd700] top-[40%] left-[20%]"
             style="animation: moveSparkle 3.5s ease-in-out infinite 1s; opacity: 0;"></div>
        <div class="sparkle absolute w-2 h-2 rounded-full bg-[#87cefa] shadow-[0_0_10px] shadow-[#87cefa] top-[30%] left-[80%]"
             style="animation: moveSparkle 3s ease-in-out infinite 1.5s; opacity: 0;"></div>
        <div class="sparkle absolute w-2 h-2 rounded-full bg-[#98fb98] shadow-[0_0_10px] shadow-[#98fb98] top-[80%] left-[60%]"
             style="animation: moveSparkle 4s ease-in-out infinite 0.7s; opacity: 0;"></div>
    </div>
    
    <p class="mt-12 font-itim text-lg font-semibold text-primary tracking-wider text-shadow-[0_0_5px_rgba(255,105,180,0.5)]">
        Casting <span class="dot-animation inline-block w-7" style="animation: dotAnimation 1.4s infinite;">...</span>
    </p>
</div>

<style>
    @keyframes castSpell {
        0%, 100% { transform: translate(-50%, -50%) rotate(-45deg); }
        25% { transform: translate(-50%, -50%) rotate(-30deg); }
        50% { transform: translate(-50%, -50%) rotate(-60deg); }
        75% { transform: translate(-50%, -50%) rotate(-30deg); }
    }
    
    @keyframes glowStar {
        0%, 100% { box-shadow: 0 0 15px #ffd700; }
        50% { box-shadow: 0 0 25px #ffd700, 0 0 40px #ffa500; }
    }
    
    @keyframes moveSparkle {
        0% { transform: translateY(0) scale(0); opacity: 0; }
        20% { opacity: 1; }
        50% { transform: translateY(-20px) scale(1); opacity: 1; }
        80% { opacity: 0.5; }
        100% { transform: translateY(-40px) scale(0); opacity: 0; }
    }
    
    @keyframes dotAnimation {
        0% { content: "."; }
        33% { content: ".."; }
        66% { content: "..."; }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Show preloader
        const preloader = document.getElementById("magical-preloader");
        
        // Hide preloader when page is loaded
        window.addEventListener("load", function() {
            setTimeout(function() {
                preloader.classList.add("opacity-0");
                
                // Remove preloader from DOM after fade out
                setTimeout(function() {
                    preloader.style.display = "none";
                }, 700);
            }, 1000); // Wait 1 second before hiding
        });
    });
</script>';
    }
    
    /**
     * Renders all necessary theme components including preloader
     * 
     * @param bool $includePreloader Whether to include the preloader
     * @param bool $includeMagicalCursor Whether to include the magical cursor
     * @return string Complete theme HTML and CSS
     */
    public function render($includePreloader = true, $includeMagicalCursor = true) {
        $output = $this->includeTailwindCSS();
        $output .= $this->renderThemeVariables();
        $output .= $this->renderUtilityClasses();
        $output .= $this->renderStarStyles();
        $output .= $this->ensureStarsContainer();
        $output .= $this->renderStarAnimation();
        $output .= $this->ensureAlertContainer();
        
        if ($includePreloader) {
            $output .= $this->renderPreloader();
        }
        
        if ($includeMagicalCursor) {
            $output .= $this->renderMagicalCursor();
        }
        
        return $output;
    }
    
    /**
     * Creates the alert container if it doesn't exist
     * 
     * @return string JavaScript to ensure alert container exists
     */
    public function ensureAlertContainer() {
        return '<div id="alert-container" class="fixed top-20 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50 px-4"></div>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ensure the alert container is properly positioned
            const alertContainer = document.getElementById("alert-container");
            if (alertContainer) {
                // Check if the container already has contents (for dynamic messages)
                if (alertContainer.childNodes.length > 0) {
                    // If there are alerts, make sure they display properly
                    setTimeout(function() {
                        alertContainer.childNodes.forEach(node => {
                            if (node.style && node.style.opacity !== "1") {
                                node.style.opacity = "1";
                            }
                        });
                    }, 100);
                }
            }
        });
        </script>';
    }
    
    /**
     * Renders an alert with the enhanced magical theme using Tailwind
     * 
     * @param string $type Alert type (success, error, warning, info)
     * @param string $message Message to display
     * @return string HTML for the alert
     */
    public function renderAlert($type, $message) {
        static $hasRenderedFunctions = false;
        
        // Define alert icon and color based on type
        $icon = '';
        $bg = '';
        $border = '';
        $text = '';
        $title = '';
        
        switch ($type) {
            case 'success':
                $icon = 'fa-wand-magic-sparkles';
                $bg = 'bg-success/10';
                $border = 'border-l-4 border-success';
                $text = 'text-success';
                $title = 'Magical Success!';
                break;
            case 'error':
                $icon = 'fa-ghost';
                $bg = 'bg-danger/10';
                $border = 'border-l-4 border-danger';
                $text = 'text-danger';
                $title = 'Magical Mishap!';
                break;
            case 'warning':
                $icon = 'fa-hat-wizard';
                $bg = 'bg-warning/10';
                $border = 'border-l-4 border-warning';
                $text = 'text-warning';
                $title = 'Magical Warning!';
                break;
            case 'info':
                $icon = 'fa-crystal-ball';
                $bg = 'bg-primary/10';
                $border = 'border-l-4 border-primary';
                $text = 'text-primary';
                $title = 'Magic Insight!';
                break;
            default:
                $icon = 'fa-stars';
                $bg = 'bg-secondary/10';
                $border = 'border-l-4 border-secondary';
                $text = 'text-secondary';
                $title = 'Magic Notice!';
        }
        
        // Generate a unique ID for this alert
        $alertId = 'magical-alert-' . uniqid();
        
        // The HTML for this specific alert
        $alertHtml = '<div id="' . $alertId . '" class="' . $bg . ' ' . $border . ' rounded-xl shadow-magical mb-5 overflow-hidden relative backdrop-blur-sm transition-all duration-500 ease-in-out">
            <div class="absolute left-0 inset-y-0 flex items-center justify-center w-14 ' . $text . ' text-lg">
                <i class="fas ' . $icon . '"></i>
            </div>
            <div class="pl-16 pr-12 py-4">
                <h5 class="font-itim text-base font-semibold mb-1 ' . $text . '">' . $title . '</h5>
                <p class="font-itim text-sm text-gray-600">' . $message . '</p>
            </div>
            <button type="button" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none" onclick="closeAlert(\'' . $alertId . '\')">
                <i class="fas fa-times"></i>
            </button>
            <div class="absolute top-1 right-4 animate-ping-slow opacity-50">✨</div>
            <div class="absolute bottom-1 left-16 animate-ping-slow opacity-30" style="animation-delay: 1s;">✨</div>
        </div>';
        
        // Only add the JavaScript functions once per page load
        if (!$hasRenderedFunctions) {
            // Set the flag to true so we don't add functions again
            $hasRenderedFunctions = true;
            
            // Add script tag with functions
            $alertHtml .= $this->renderAlertFunctions();
        }
        
        return $alertHtml;
    }
    
    /**
     * Renders the JavaScript functions needed for alerts
     * This is separated to ensure functions are only defined once
     * 
     * @return string JavaScript functions for alerts
     */
    private function renderAlertFunctions() {
        return '<script>
            // Only define these functions if they don\'t already exist
            if (typeof window.closeAlert !== "function") {
                window.closeAlert = function(alertId) {
                    const alertElement = document.getElementById(alertId);
                    if (alertElement) {
                        // Animate opacity and height
                        alertElement.style.opacity = "0";
                        alertElement.style.maxHeight = alertElement.offsetHeight + "px";
                        
                        // Start animation
                        setTimeout(() => {
                            alertElement.style.maxHeight = "0px";
                            alertElement.style.marginBottom = "0px";
                            alertElement.style.paddingTop = "0px";
                            alertElement.style.paddingBottom = "0px";
                            
                            // Remove from DOM after animation completes
                            setTimeout(() => {
                                alertElement.remove();
                            }, 500); // Wait for transition to complete
                        }, 100);
                    }
                }
            }
            
            // Define a global function to create magical alerts via JavaScript
            if (typeof window.createMagicalAlert !== "function") {
                window.createMagicalAlert = function(type, message, containerId = null) {
                    // Default types and their properties
                    const alertTypes = {
                        success: {
                            icon: "fa-wand-magic-sparkles",
                            bg: "bg-success/10",
                            border: "border-l-4 border-success",
                            text: "text-success",
                            title: "Magical Success!"
                        },
                        error: {
                            icon: "fa-ghost",
                            bg: "bg-danger/10",
                            border: "border-l-4 border-danger",
                            text: "text-danger",
                            title: "Magical Mishap!"
                        },
                        warning: {
                            icon: "fa-hat-wizard",
                            bg: "bg-warning/10",
                            border: "border-l-4 border-warning",
                            text: "text-warning",
                            title: "Magical Warning!"
                        },
                        info: {
                            icon: "fa-crystal-ball",
                            bg: "bg-primary/10",
                            border: "border-l-4 border-primary",
                            text: "text-primary",
                            title: "Magic Insight!"
                        }
                    };
                    
                    // Use default if type is not found
                    const alertSettings = alertTypes[type] || {
                        icon: "fa-stars",
                        bg: "bg-secondary/10",
                        border: "border-l-4 border-secondary",
                        text: "text-secondary",
                        title: "Magic Notice!"
                    };
                    
                    // Generate unique ID for this alert
                    const alertId = "magical-alert-" + new Date().getTime() + Math.floor(Math.random() * 1000);
                    
                    // Create alert HTML
                    const alertHTML = `
                        <div id="${alertId}" class="${alertSettings.bg} ${alertSettings.border} rounded-xl shadow-magical mb-5 overflow-hidden relative backdrop-blur-sm transition-all duration-500 ease-in-out">
                            <div class="absolute left-0 inset-y-0 flex items-center justify-center w-14 ${alertSettings.text} text-lg">
                                <i class="fas ${alertSettings.icon}"></i>
                            </div>
                            <div class="pl-16 pr-12 py-4">
                                <h5 class="font-itim text-base font-semibold mb-1 ${alertSettings.text}">${alertSettings.title}</h5>
                                <p class="font-itim text-sm text-gray-600">${message}</p>
                            </div>
                            <button type="button" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none" onclick="closeAlert(\'${alertId}\')">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="absolute top-1 right-4 animate-ping-slow opacity-50">✨</div>
                            <div class="absolute bottom-1 left-16 animate-ping-slow opacity-30" style="animation-delay: 1s;">✨</div>
                        </div>
                    `;
                    
                    // Determine where to insert the alert
                    let container;
                    if (containerId) {
                        container = document.getElementById(containerId);
                    } else {
                        // Check for common alert container IDs
                        const commonContainers = ["alert-container", "alerts", "notifications", "message-container"];
                        for (let id of commonContainers) {
                            const element = document.getElementById(id);
                            if (element) {
                                container = element;
                                break;
                            }
                        }
                        
                        // If no container found, create one at the top of the body
                        if (!container) {
                            container = document.createElement("div");
                            container.id = "alert-container";
                            container.className = "fixed top-4 left-1/2 transform -translate-x-1/2 w-full max-w-md z-50 px-4";
                            document.body.prepend(container);
                        }
                    }
                    
                    // Insert the alert
                    const alertElement = document.createElement("div");
                    alertElement.innerHTML = alertHTML;
                    container.appendChild(alertElement.firstElementChild);
                    
                    // Optional: Auto-close after 5 seconds
                    setTimeout(() => {
                        closeAlert(alertId);
                    }, 5000);
                    
                    // Return the alert ID for reference
                    return alertId;
                }
            }
        </script>';
    }
    
    /**
     * Convert hex color to RGB
     * 
     * @param string $hex Hex color code
     * @return string RGB color values
     */
    private function hexToRgb($hex) {
        // Remove # if present
        $hex = ltrim($hex, '#');
        
        // Convert to RGB
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        
        // Return RGB values as string
        return "$r, $g, $b";
    }

    /**
     * Set custom navigation items
     * 
     * @param array $items Navigation items in format [label => [url, icon, active, badge, submenu]]
     * @return MagicalTheme For method chaining
     */
    public function setNavItems(array $items) {
        // Reset the current navigation items
        $this->navItems = [];
        
        // Add each item with proper structure
        foreach ($items as $label => $item) {
            // If the item is just a string URL
            if (is_string($item)) {
                $this->navItems[$label] = [
                    'url' => $item,
                    'icon' => null,
                    'active' => false,
                    'badge' => null,
                    'submenu' => []
                ];
            } 
            // If the item is an array with properties
            else if (is_array($item)) {
                $this->navItems[$label] = [
                    'url' => $item['url'] ?? '#',
                    'icon' => $item['icon'] ?? null,
                    'active' => $item['active'] ?? false,
                    'badge' => $item['badge'] ?? null,
                    'submenu' => $item['submenu'] ?? []
                ];
            }
        }
        
        return $this;
    }
    
    /**
     * Add a single navigation item
     * 
     * @param string $label The navigation label
     * @param string|array $item The navigation URL or item configuration
     * @return MagicalTheme For method chaining
     */
    public function addNavItem($label, $item) {
        if (is_string($item)) {
            $this->navItems[$label] = [
                'url' => $item,
                'icon' => null,
                'active' => false,
                'badge' => null,
                'submenu' => []
            ];
        } else if (is_array($item)) {
            $this->navItems[$label] = [
                'url' => $item['url'] ?? '#',
                'icon' => $item['icon'] ?? null,
                'active' => $item['active'] ?? false,
                'badge' => $item['badge'] ?? null,
                'submenu' => $item['submenu'] ?? []
            ];
        }
        
        return $this;
    }
    
    /**
     * Adds multiple navigation items
     * 
     * @param array $items Navigation items to add
     * @return MagicalTheme For method chaining
     */
    public function addNavItems(array $items) {
        foreach ($items as $label => $item) {
            $this->addNavItem($label, $item);
        }
        
        return $this;
    }
    
    /**
     * Get all navigation items
     * 
     * @return array The navigation items
     */
    public function getNavItems() {
        return $this->navItems;
    }
    
    /**
     * Renders the magical navigation bar
     * 
     * @param string $currentPage The current page filename (e.g., 'dashboard.php')
     * @param array $customNavItems Optional additional nav items as [label => url] or [label => [url, icon, active, badge, submenu]]
     * @param string $websiteName The name of the website to display in the navbar
     * @return string HTML for the navigation bar
     */
    public function renderNavbar($currentPage = '', $customNavItems = [], $websiteName = 'Magical Wetget') {
        // Set active state based on current page
        foreach ($this->navItems as $label => $item) {
            if ($item['url'] === $currentPage) {
                $this->navItems[$label]['active'] = true;
            }
        }
        
        // Merge custom items if provided
        if (!empty($customNavItems)) {
            $this->setNavItems(array_merge($this->navItems, $customNavItems));
        }
        // Build the navigation HTML with Tailwind classes
        $html = '
        <!-- Magical Navbar -->
        <nav class="bg-gradient-to-r from-primary to-secondary shadow-lg fixed top-0 w-full z-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <a href="index.php" class="flex items-center space-x-2 group">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center 
                                            transition-transform group-hover:scale-110">
                                    <span class="text-white text-xl">✨</span>
                                </div>
                                <div class="absolute inset-0 rounded-full bg-white/10 animate-ping opacity-75 
                                            group-hover:opacity-100 duration-700"></div>
                            </div>
                            <span class="font-itim text-xl text-white tracking-wide">' . htmlspecialchars($websiteName) . '</span>
                        </a>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="flex items-center lg:hidden">
                        <button id="mobile-menu-button" class="text-white p-2 rounded-lg hover:bg-white/10 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-2">
                        <div class="flex items-center space-x-1">';
        
        // Generate navigation links
        foreach ($this->navItems as $label => $item) {
            $isActive = $item['active'] || ($currentPage === $item['url']);
            $icon = !empty($item['icon']) ? '<i class="fas ' . $item['icon'] . ' mr-2"></i>' : '';
            $badge = !empty($item['badge']) ? '<span class="ml-2 magic-badge magic-badge-primary text-xs py-0.5 px-2">' . $item['badge'] . '</span>' : '';
            $hasSubmenu = !empty($item['submenu']);
            
            if ($hasSubmenu) {
                $html .= '
                            <div class="relative dropdown-menu group">
                                <a href="' . $item['url'] . '" class="relative flex items-center font-itim px-4 py-2 text-white/90 hover:text-white 
                                       hover:bg-white/10 rounded-lg transition-all duration-300' . ($isActive ? ' active' : '') . '">
                                    ' . $icon . $label . $badge . '
                                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    ' . ($isActive ? '<span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-5 h-1 bg-white rounded-full"></span>' : '') . '
                                </a>
                                <div class="submenu opacity-0 invisible group-hover:opacity-100 group-hover:visible absolute left-0 mt-1 w-48 bg-white rounded-xl shadow-magical
                                            border-t-2 border-primary py-2 z-50 transition-all duration-300"
                                     style="transform: translateY(-10px); transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;">';
                                
                foreach ($item['submenu'] as $subLabel => $subItem) {
                    $subUrl = is_array($subItem) ? $subItem['url'] : $subItem;
                    $subIcon = is_array($subItem) && !empty($subItem['icon']) ? '<i class="fas ' . $subItem['icon'] . ' mr-2"></i>' : '';
                    $subActive = is_array($subItem) && isset($subItem['active']) ? $subItem['active'] : ($currentPage === $subUrl);
                    $subBadge = is_array($subItem) && !empty($subItem['badge']) ? '<span class="ml-auto magic-badge bg-primary/20 text-primary text-xs py-0.5 px-2">' . $subItem['badge'] . '</span>' : '';
                    
                    $html .= '
                                    <a href="' . $subUrl . '" class="flex items-center justify-between px-4 py-2 font-itim text-dark hover:bg-primary/10 hover:text-primary rounded-lg mx-2' . 
                                       ($subActive ? ' text-primary bg-primary/5' : '') . '">
                                        <span>' . $subIcon . $subLabel . '</span>' . $subBadge . '
                                    </a>';
                }
                
                $html .= '
                                </div>
                            </div>';
            } else {
                $html .= '
                            <a href="' . $item['url'] . '" class="relative flex items-center font-itim px-4 py-2 text-white/90 hover:text-white 
                                       hover:bg-white/10 rounded-lg transition-all duration-300' . ($isActive ? ' active' : '') . '">
                                ' . $icon . $label . $badge . '
                                ' . ($isActive ? '<span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-5 h-1 bg-white rounded-full"></span>' : '') . '
                            </a>';
            }
        }
        
        // User dropdown
        $html .= '
                        </div>
                      
                    </div>
                </div>
            </div>
            
            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="hidden lg:hidden bg-white/5 backdrop-blur-md pb-4 border-t border-white/10">
                <div class="px-2 pt-2 pb-3 space-y-1">';
        
        // Generate mobile navigation links
        foreach ($this->navItems as $label => $item) {
            $isActive = $item['active'] || ($currentPage === $item['url']);
            $icon = !empty($item['icon']) ? '<i class="fas ' . $item['icon'] . ' mr-2"></i>' : '';
            $badge = !empty($item['badge']) ? '<span class="float-right magic-badge magic-badge-primary text-xs py-0.5 px-2">' . $item['badge'] . '</span>' : '';
            $hasSubmenu = !empty($item['submenu']);
            
            if ($hasSubmenu) {
                $html .= '
                    <div class="block px-3 py-2 rounded-lg font-itim ' . 
                       ($isActive ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white') . ' mobile-dropdown">
                        ' . $icon . $label . $badge . '
                        <i class="fas fa-chevron-down ml-1 text-xs mobile-dropdown-icon"></i>
                    </div>
                    <div class="pl-4 hidden mobile-submenu">';
                
                foreach ($item['submenu'] as $subLabel => $subItem) {
                    $subUrl = is_array($subItem) ? $subItem['url'] : $subItem;
                    $subIcon = is_array($subItem) && !empty($subItem['icon']) ? '<i class="fas ' . $subItem['icon'] . ' mr-2"></i>' : '';
                    $subBadge = is_array($subItem) && !empty($subItem['badge']) ? '<span class="float-right magic-badge bg-white/20 text-white text-xs py-0.5 px-2">' . $subItem['badge'] . '</span>' : '';
                    
                    $html .= '
                        <a href="' . $subUrl . '" class="block px-3 py-2 rounded-lg font-itim text-white/70 hover:bg-white/10 hover:text-white">
                            ' . $subIcon . $subLabel . $subBadge . '
                        </a>';
                }
                
                $html .= '</div>';
            } else {
                $html .= '
                    <a href="' . $item['url'] . '" class="block px-3 py-2 rounded-lg font-itim ' . 
                       ($isActive ? 'bg-white/20 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white') . '">
                        ' . $icon . $label . $badge . '
                    </a>';
            }
        }
        
        $html .= '
                    <div class="border-t border-white/10 my-2"></div>
                    <a href="profile.php" class="block px-3 py-2 rounded-lg font-itim text-white/80 hover:bg-white/10 hover:text-white">
                        <i class="fas fa-user-circle mr-2"></i> My Profile
                    </a>
                    <a href="../controllers/logout.php" class="block px-3 py-2 rounded-lg font-itim text-white/80 hover:bg-white/10 hover:text-white">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Spacer for fixed navbar -->
        <div class="h-16"></div>
        
        <style>
        /* Dropdown menu hover animations */
        .dropdown-menu .submenu {
            pointer-events: none;
            transform: translateY(-20px);
            transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s;
        }
        
        .dropdown-menu:hover .submenu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        /* Add a dropdown triangle indicator */
        .dropdown-menu .submenu::before {
            content: "";
            position: absolute;
            top: -8px;
            left: 20px;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid ' . $this->colors['primary'] . ';
        }
        </style>
        
        <script>
            // Mobile menu toggle
            document.addEventListener("DOMContentLoaded", function() {
                const mobileMenuButton = document.getElementById("mobile-menu-button");
                const mobileMenu = document.getElementById("mobile-menu");
                
                if (mobileMenuButton && mobileMenu) {
                    mobileMenuButton.addEventListener("click", function() {
                        mobileMenu.classList.toggle("hidden");
                    });
                }
                
                // Mobile dropdown toggles
                const mobileDropdowns = document.querySelectorAll(".mobile-dropdown");
                mobileDropdowns.forEach(dropdown => {
                    dropdown.addEventListener("click", function() {
                        const submenu = this.nextElementSibling;
                        const icon = this.querySelector(".mobile-dropdown-icon");
                        
                        if (submenu && submenu.classList.contains("mobile-submenu")) {
                            submenu.classList.toggle("hidden");
                            
                            // Toggle icon rotation
                            if (icon) {
                                if (submenu.classList.contains("hidden")) {
                                    icon.classList.remove("fa-chevron-up");
                                    icon.classList.add("fa-chevron-down");
                                } else {
                                    icon.classList.remove("fa-chevron-down");
                                    icon.classList.add("fa-chevron-up");
                                }
                            }
                        }
                    });
                });
            });
        </script>';
        
        return $html;
    }

    /**
     * Renders magical girl-themed cursor styles
     * 
     * @param bool $enabled Whether to enable the magical cursor by default
     * @return string The CSS and JavaScript for magical cursors
     */
    public function renderMagicalCursor($enabled = true) {
        // Get color values without the hash to prevent JavaScript errors
        $primaryColor = ltrim($this->colors['primary'], '#');
        $secondaryColor = ltrim($this->colors['secondary'], '#');
        $accentColor = ltrim($this->colors['accent'], '#');
        
        return '<style id="magical-cursor-styles">
        /* Magical cursor styles */
        body.magical-cursor-enabled {
            cursor: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' fill=\'none\'%3E%3Ccircle cx=\'20\' cy=\'20\' r=\'18\' fill=\'%23ffffff\' opacity=\'0.2\'/%3E%3Ccircle cx=\'20\' cy=\'20\' r=\'12\' fill=\'%23' . $primaryColor . '\' opacity=\'0.7\'/%3E%3Cpath d=\'M20 12L22 20L30 20L23.5 24.5L26 32L20 27L14 32L16.5 24.5L10 20L18 20L20 12Z\' fill=\'white\' opacity=\'0.9\'/%3E%3C/svg%3E") 20 20, auto;
        }
        
        body.magical-cursor-enabled a,
        body.magical-cursor-enabled button,
        body.magical-cursor-enabled [role="button"],
        body.magical-cursor-enabled .cursor-pointer {
            cursor: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'44\' height=\'44\' viewBox=\'0 0 44 44\' fill=\'none\'%3E%3Ccircle cx=\'22\' cy=\'22\' r=\'20\' fill=\'%23' . $secondaryColor . '\' opacity=\'0.3\'/%3E%3Cpath d=\'M22 6L24.2 17.8H36.7L26.8 25.1L30 36.9L22 29.6L14 36.9L17.2 25.1L7.3 17.8H19.8L22 6Z\' fill=\'%23' . $secondaryColor . '\' opacity=\'0.9\'/%3E%3Cpath d=\'M22 13L23 19H29L24 23L26 29L22 25L18 29L20 23L15 19H21L22 13Z\' fill=\'white\' opacity=\'0.9\'/%3E%3C/svg%3E") 22 22, pointer;
        }
        
        body.magical-cursor-enabled input,
        body.magical-cursor-enabled textarea,
        body.magical-cursor-enabled select,
        body.magical-cursor-enabled [contenteditable] {
            cursor: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' fill=\'none\'%3E%3Ccircle cx=\'20\' cy=\'20\' r=\'18\' fill=\'%23' . $accentColor . '\' opacity=\'0.3\'/%3E%3Cpath d=\'M14 10L26 20L14 30\' stroke=\'%23' . $accentColor . '\' stroke-width=\'4\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/%3E%3Cpath d=\'M14 10L26 20L14 30\' stroke=\'white\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/%3E%3C/svg%3E") 20 20, text;
        }

        /* Special cursors for different interactions */
        body.magical-cursor-enabled img,
        body.magical-cursor-enabled video,
        body.magical-cursor-enabled .media-element {
            cursor: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'42\' height=\'42\' viewBox=\'0 0 42 42\' fill=\'none\'%3E%3Ccircle cx=\'21\' cy=\'21\' r=\'19\' fill=\'%234ade80\' opacity=\'0.3\'/%3E%3Ccircle cx=\'21\' cy=\'21\' r=\'10\' stroke=\'%234ade80\' stroke-width=\'2\'/%3E%3Ccircle cx=\'21\' cy=\'21\' r=\'5\' fill=\'white\' opacity=\'0.9\'/%3E%3Cpath d=\'M14 7L17 11M28 7L25 11M13 28L16 25M29 28L26 25\' stroke=\'%234ade80\' stroke-width=\'2\' stroke-linecap=\'round\'/%3E%3C/svg%3E") 21 21, zoom-in;
        }
        
        body.magical-cursor-enabled [draggable="true"] {
            cursor: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'44\' height=\'44\' viewBox=\'0 0 44 44\' fill=\'none\'%3E%3Ccircle cx=\'22\' cy=\'22\' r=\'20\' fill=\'%23fbbf24\' opacity=\'0.3\'/%3E%3Cpath d=\'M22 10V34M16 16L22 10L28 16M16 28L22 34L28 28\' stroke=\'%23fbbf24\' stroke-width=\'3\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/%3E%3Cpath d=\'M14 22H30\' stroke=\'%23fbbf24\' stroke-width=\'3\' stroke-linecap=\'round\'/%3E%3C/svg%3E") 22 22, move;
        }
        
        /* Cursor trail with magical wand effect */
        .magical-cursor-trail {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transform: translate(-50%, -50%);
            mix-blend-mode: screen;
            transition: width 0.2s, height 0.2s;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }

        /* Main cursor aura */
        .cursor-aura {
            position: fixed;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(' . $this->hexToRgb($this->colors['primary']) . ',0.2) 0%, rgba(' . $this->hexToRgb($this->colors['primary']) . ',0) 70%);
            pointer-events: none;
            z-index: 9998;
            transform: translate(-50%, -50%);
            transition: width 0.3s, height 0.3s, opacity 0.3s;
        }

        /* Magic particles that appear around cursor */
        .magic-particle {
            position: fixed;
            width: 8px;
            height: 8px;
            pointer-events: none;
            z-index: 9997;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }

        /* Cursor toggle button */
        .cursor-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: ' . $this->colors['primary'] . ';
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 12px rgba(0,0,0,0.15), 0 5px 20px rgba(' . $this->hexToRgb($this->colors['primary']) . ',0.3);
            z-index: 999;
            transition: all 0.3s ease;
            border: 2px solid white;
        }
        
        .cursor-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2), 0 8px 25px rgba(' . $this->hexToRgb($this->colors['primary']) . ',0.4);
        }
        
        .cursor-toggle-icon {
            font-size: 22px;
            color: white;
        }

        /* Wand sparkle animation */
        .wand-sparkle {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0) 70%);
            opacity: 0;
            animation: wandSparkle 2s infinite;
        }

        @keyframes wandSparkle {
            0%, 100% { opacity: 0; transform: scale(0.8); }
            50% { opacity: 0.7; transform: scale(1.1); }
        }
        </style>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize DOM elements first
            const cursorAura = document.createElement("div");
            cursorAura.className = "cursor-aura";
            cursorAura.style.display = "none";
            document.body.appendChild(cursorAura);
            
            // Create cursor trails elements - now using images for magical effect
            const trailImages = [
                "data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\'%3E%3Cpath d=\'M12 2L14.5 9H22L16 13.5L18.5 20.5L12 16L5.5 20.5L8 13.5L2 9H9.5L12 2Z\' fill=\'%23' . $primaryColor . '\' fill-opacity=\'0.7\'/%3E%3C/svg%3E",
                "data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' viewBox=\'0 0 24 24\' fill=\'none\'%3E%3Cpath d=\'M12 2L14.5 9H22L16 13.5L18.5 20.5L12 16L5.5 20.5L8 13.5L2 9H9.5L12 2Z\' fill=\'%23ffffff\' fill-opacity=\'0.6\'/%3E%3C/svg%3E",
                "data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 24 24\' fill=\'none\'%3E%3Ccircle cx=\'12\' cy=\'12\' r=\'8\' fill=\'%23' . $secondaryColor . '\' fill-opacity=\'0.7\'/%3E%3C/svg%3E",
                "data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 24 24\' fill=\'none\'%3E%3Ccircle cx=\'12\' cy=\'12\' r=\'8\' fill=\'%23' . $accentColor . '\' fill-opacity=\'0.7\'/%3E%3C/svg%3E",
                "data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'10\' height=\'10\' viewBox=\'0 0 24 24\' fill=\'none\'%3E%3Ccircle cx=\'12\' cy=\'12\' r=\'8\' fill=\'%23ffffff\' fill-opacity=\'0.5\'/%3E%3C/svg%3E"
            ];

            const maxTrails = 8;
            const trails = [];
            
            for (let i = 0; i < maxTrails; i++) {
                const trail = document.createElement("div");
                trail.className = "magical-cursor-trail";
                
                // Randomize size and image for more magical effect
                const imgIndex = i % trailImages.length;
                const baseSize = Math.floor((maxTrails - i) * 3) + 4; // Larger to smaller
                trail.style.width = baseSize + "px";
                trail.style.height = baseSize + "px";
                trail.style.backgroundImage = `url("${trailImages[imgIndex]}")`;
                trail.style.display = "none";
                trail.style.opacity = (1 - (i / maxTrails)) * 0.9;
                
                document.body.appendChild(trail);
                trails.push(trail);
            }
            
            // Create particles container
            const particlesContainer = document.createElement("div");
            particlesContainer.style.position = "fixed";
            particlesContainer.style.top = "0";
            particlesContainer.style.left = "0";
            particlesContainer.style.width = "100%";
            particlesContainer.style.height = "100%";
            particlesContainer.style.pointerEvents = "none";
            particlesContainer.style.zIndex = "9997";
            particlesContainer.style.overflow = "hidden";
            document.body.appendChild(particlesContainer);
            
            // Create cursor toggle button last
            const toggleBtn = document.createElement("div");
            toggleBtn.className = "cursor-toggle";
            toggleBtn.innerHTML = "<div class=\"cursor-toggle-icon\">✨</div><div class=\"wand-sparkle\"></div>";
            document.body.appendChild(toggleBtn);
            
            // Initialize state variables
            let mouseX = 0, mouseY = 0;
            let lastMouseMove = Date.now();
            let isMouseMoving = false;
            let particleCounter = 0;
            const positions = Array(maxTrails).fill({x: 0, y: 0});
            
            // Initialize state
            const isMagicalCursorEnabled = ' . ($enabled ? 'true' : 'false') . ';
            
            // Particle emojis for random selection
            const particleEmojis = ["✨", "⭐", "🌟", "💫", "🌠", "✦"];
            
            // Set initial state
            if (isMagicalCursorEnabled) {
                enableMagicalCursor();
            }
            
            // Handle toggle click
            toggleBtn.addEventListener("click", function() {
                if (document.body.classList.contains("magical-cursor-enabled")) {
                    disableMagicalCursor();
                } else {
                    enableMagicalCursor();
                }
            });
            
            // Track mouse movement
            document.addEventListener("mousemove", function(e) {
                if (!document.body.classList.contains("magical-cursor-enabled")) {
                    return;
                }
                
                mouseX = e.clientX;
                mouseY = e.clientY;
                
                // Update aura position
                cursorAura.style.left = mouseX + "px";
                cursorAura.style.top = mouseY + "px";
                
                // Check if mouse is moving actively
                const now = Date.now();
                isMouseMoving = true;
                
                // Only create trails and particles during active movement
                if (now - lastMouseMove > 10) { // Throttle updates
                    lastMouseMove = now;
                    
                    // Update positions array
                    positions.pop();
                    positions.unshift({x: mouseX, y: mouseY});
                    
                    // Update trail positions with delay effect
                    trails.forEach((trail, index) => {
                        const pos = positions[index];
                        if (pos) {
                            trail.style.left = pos.x + "px";
                            trail.style.top = pos.y + "px";
                        }
                    });
                    
                    // Occasionally emit particles while moving (every ~5 movements)
                    particleCounter++;
                    if (particleCounter % 5 === 0 && Math.random() > 0.7) {
                        createParticle(mouseX, mouseY);
                    }
                }
                
                // Reset inactivity timer
                clearTimeout(window.mouseMoveTimeout);
                window.mouseMoveTimeout = setTimeout(() => {
                    isMouseMoving = false;
                }, 100);
            });
            
            // Create sparkle particles at random intervals
            function createParticle(x, y) {
                if (!document.body.classList.contains("magical-cursor-enabled")) {
                    return;
                }
                
                const particle = document.createElement("div");
                particle.className = "magic-particle";
                
                // Random position near cursor
                const offsetX = (Math.random() - 0.5) * 20;
                const offsetY = (Math.random() - 0.5) * 20;
                
                particle.style.left = (x + offsetX) + "px";
                particle.style.top = (y + offsetY) + "px";
                
                // Random size and rotation
                const size = Math.random() * 15 + 5;
                particle.style.width = size + "px";
                particle.style.height = size + "px";
                particle.style.fontSize = size + "px";
                particle.style.lineHeight = 1;
                particle.style.transform = `rotate(${Math.random() * 360}deg)`;
                
                // Random emoji or star shape
                const useEmoji = Math.random() > 0.3;
                if (useEmoji) {
                    const emoji = particleEmojis[Math.floor(Math.random() * particleEmojis.length)];
                    particle.innerHTML = emoji;
                } else {
                    // Safe color string formatting to avoid the # issue
                    const colorChoice = Math.random() > 0.5 ? "' . $primaryColor . '" : "' . $secondaryColor . '";
                    particle.style.backgroundImage = `url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' fill=\'none\'%3E%3Cpath d=\'M10 1L12 7H19L13 11L15 17L10 13L5 17L7 11L1 7H8L10 1Z\' fill=\'%23${colorChoice}\' fill-opacity=\'0.8\'/%3E%3C/svg%3E")`;
                }
                
                // Animation
                particle.animate([
                    { opacity: 0.8, transform: `scale(0.5) rotate(${Math.random() * 360}deg)` },
                    { opacity: 0, transform: `scale(1.5) rotate(${Math.random() * 360 + 180}deg) translate(${(Math.random() - 0.5) * 50}px, ${(Math.random() - 0.5) * 50}px)` }
                ], {
                    duration: 1000 + Math.random() * 1000,
                    easing: "cubic-bezier(0.1, 0.8, 0.3, 1)"
                }).onfinish = () => particle.remove();
                
                particlesContainer.appendChild(particle);
            }
            
            // Click effect with wand magic
            document.addEventListener("click", function(e) {
                if (!document.body.classList.contains("magical-cursor-enabled")) {
                    return;
                }
                
                // Create magical wand effect container
                const wandEffect = document.createElement("div");
                wandEffect.style.position = "fixed";
                wandEffect.style.left = e.clientX + "px";
                wandEffect.style.top = e.clientY + "px";
                wandEffect.style.transform = "translate(-50%, -50%)";
                wandEffect.style.pointerEvents = "none";
                wandEffect.style.zIndex = "9999";
                
                // Add magical circle burst effect
                const burst = document.createElement("div");
                burst.style.position = "absolute";
                burst.style.width = "5px";
                burst.style.height = "5px";
                burst.style.borderRadius = "50%";
                burst.style.backgroundColor = "white";
                burst.style.boxShadow = `0 0 15px ' . $this->colors['primary'] . '`;
                burst.style.top = "0";
                burst.style.left = "0";
                burst.style.transform = "translate(-50%, -50%)";
                
                // Animate burst
                burst.animate([
                    { transform: "translate(-50%, -50%) scale(1)", opacity: 1 },
                    { transform: "translate(-50%, -50%) scale(30)", opacity: 0 }
                ], {
                    duration: 700,
                    easing: "cubic-bezier(0.1, 0.8, 0.3, 1)"
                });
                
                wandEffect.appendChild(burst);
                
                // Add star burst animation
                for (let i = 0; i < 10; i++) {
                    createParticle(e.clientX, e.clientY);
                    
                    // Additional magical stars with delay
                    if (i < 5) {
                        setTimeout(() => {
                            createParticle(e.clientX, e.clientY);
                        }, i * 50);
                    }
                }
                
                document.body.appendChild(wandEffect);
                
                // Remove after animation
                setTimeout(() => {
                    wandEffect.remove();
                }, 1000);
            });
            
            // When hovering buttons/links, make cursor aura larger and change color
            document.addEventListener("mouseover", function(e) {
                if (!document.body.classList.contains("magical-cursor-enabled")) {
                    return;
                }
                
                if (e.target.tagName === "A" || e.target.tagName === "BUTTON" || e.target.classList.contains("cursor-pointer")) {
                    cursorAura.style.width = "90px";
                    cursorAura.style.height = "90px";
                    cursorAura.style.background = "radial-gradient(circle, rgba(' . $this->hexToRgb($this->colors['secondary']) . ', 0.3) 0%, rgba(' . $this->hexToRgb($this->colors['secondary']) . ', 0) 70%)";
                } else if (e.target.tagName === "INPUT" || e.target.tagName === "TEXTAREA") {
                    cursorAura.style.width = "70px";
                    cursorAura.style.height = "70px";
                    cursorAura.style.background = "radial-gradient(circle, rgba(' . $this->hexToRgb($this->colors['accent']) . ', 0.3) 0%, rgba(' . $this->hexToRgb($this->colors['accent']) . ', 0) 70%)";
                }
            });
            
            document.addEventListener("mouseout", function(e) {
                if (!document.body.classList.contains("magical-cursor-enabled")) {
                    return;
                }
                
                if (e.target.tagName === "A" || e.target.tagName === "BUTTON" || e.target.classList.contains("cursor-pointer") || e.target.tagName === "INPUT" || e.target.tagName === "TEXTAREA") {
                    cursorAura.style.width = "60px";
                    cursorAura.style.height = "60px";
                    cursorAura.style.background = "radial-gradient(circle, rgba(' . $this->hexToRgb($this->colors['primary']) . ', 0.2) 0%, rgba(' . $this->hexToRgb($this->colors['primary']) . ', 0) 70%)";
                }
            });
            
            // Helper functions
            function enableMagicalCursor() {
                document.body.classList.add("magical-cursor-enabled");
                toggleBtn.querySelector(".cursor-toggle-icon").textContent = "✨";
                
                // Show aura and trails
                cursorAura.style.display = "block";
                trails.forEach(trail => {
                    trail.style.display = "block";
                });
                
                // Add initial position effect
                if (mouseX === 0 && mouseY === 0) {
                    // Get center position if no mouse movement yet
                    mouseX = window.innerWidth / 2;
                    mouseY = window.innerHeight / 2;
                }
                
                // Create initial position for aura and trails
                cursorAura.style.left = mouseX + "px";
                cursorAura.style.top = mouseY + "px";
                
                // Initial particle burst
                for (let i = 0; i < 5; i++) {
                    setTimeout(() => {
                        createParticle(mouseX, mouseY);
                    }, i * 100);
                }
                
                // Save preference
                localStorage.setItem("magicalCursorEnabled", "true");
            }
            
            function disableMagicalCursor() {
                document.body.classList.remove("magical-cursor-enabled");
                toggleBtn.querySelector(".cursor-toggle-icon").textContent = "🖱️";
                
                // Hide aura and trails
                cursorAura.style.display = "none";
                trails.forEach(trail => {
                    trail.style.display = "none";
                });
                
                // Remove any existing particles
                particlesContainer.innerHTML = "";
                
                // Save preference
                localStorage.setItem("magicalCursorEnabled", "false");
            }
            
            // Check for saved preference
            const savedPreference = localStorage.getItem("magicalCursorEnabled");
            if (savedPreference === "true") {
                enableMagicalCursor();
            } else if (savedPreference === "false") {
                disableMagicalCursor();
            }
            
            // Check for mobile/touch devices
            function isTouchDevice() {
                return "ontouchstart" in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
            }
            
            if (isTouchDevice()) {
                disableMagicalCursor();
                toggleBtn.style.display = "none"; // Hide toggle on touch devices
            }
        });
        </script>';
    }

    /**
     * Renders a SweetAlert-like popup notification and shows it immediately
     * 
     * @param string $message The message to display
     * @param string $type The type of notification (success, error, warning, info)
     * @param int $afterTime Delay in milliseconds before showing the popup (0 for immediate)
     * @param int $showtime Duration in milliseconds to show the popup (0 for manual close only)
     * @return string HTML and JavaScript for the popup that executes immediately
     */
    public function renderPopup($message = '', $type = 'success', $afterTime = 0, $showtime = 3000) {
        // Generate a unique ID for this popup
        $popupId = 'magical-popup-' . uniqid();
        
        // Define icons, colors, and titles based on type
        $icon = '';
        $bgColor = '';
        $titleColor = '';
        $title = '';
        $borderColor = '';
        $bgGlow = '';
        
        switch ($type) {
            case 'success':
                $icon = '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                $bgColor = 'from-success/10 to-success/5';
                $titleColor = 'text-success';
                $title = 'Success!';
                $borderColor = 'border-success';
                $bgGlow = 'rgba(74, 222, 128, 0.2)';
                break;
            case 'error':
                $icon = '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                $bgColor = 'from-danger/10 to-danger/5';
                $titleColor = 'text-danger';
                $title = 'Error!';
                $borderColor = 'border-danger';
                $bgGlow = 'rgba(248, 113, 113, 0.2)';
                break;
            case 'warning':
                $icon = '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
                $bgColor = 'from-warning/10 to-warning/5';
                $titleColor = 'text-warning';
                $title = 'Warning!';
                $borderColor = 'border-warning';
                $bgGlow = 'rgba(251, 191, 36, 0.2)';
                break;
            case 'info':
            default:
                $icon = '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                $bgColor = 'from-primary/10 to-primary/5';
                $titleColor = 'text-primary';
                $title = 'Information';
                $borderColor = 'border-primary';
                $bgGlow = 'rgba(255, 110, 199, 0.2)';
                break;
        }
        
        // Escape the message for JavaScript
        $jsMessage = htmlspecialchars($message, ENT_QUOTES);
        
        // Return the HTML and JavaScript that executes immediately
        echo '<style>
        @keyframes popup-sparkle {
            0%, 100% { opacity: 0; transform: scale(0); }
            50% { opacity: 1; transform: scale(1); }
        }
        </style>';
        
        echo '<script>
        (function() {
            // Create popup container
            const popupId = "' . $popupId . '";
            
            // Remove any existing popup with same ID
            const existingPopup = document.getElementById(popupId);
            if (existingPopup) {
                existingPopup.remove();
            }
            
            // Create the popup elements
            const popup = document.createElement("div");
            popup.id = popupId;
            popup.className = "magical-popup fixed inset-0 flex items-center justify-center z-[9999] opacity-0 pointer-events-none transition-opacity duration-300";
            
            // Popup HTML structure
            popup.innerHTML = `
                <div class="magical-popup-backdrop absolute inset-0 bg-dark/20 backdrop-blur-sm"></div>
                <div class="magical-popup-content w-[90%] max-w-md transform scale-90 transition-transform duration-300 relative z-10">
                    <div class="bg-gradient-to-br ' . $bgColor . ' backdrop-blur-xl border-t-2 ' . $borderColor . ' rounded-xl p-6 shadow-2xl flex flex-col items-center text-center">
                        <div class="magical-popup-icon ' . $titleColor . ' mb-2 animate-bounce">
                            ' . $icon . '
                        </div>
                        <div class="magical-popup-sparkles absolute inset-0 pointer-events-none overflow-hidden rounded-xl"></div>
                        <h3 class="font-itim text-xl ' . $titleColor . ' mb-2">' . $title . '</h3>
                        <p class="text-gray-700 font-itim">
                            ' . $jsMessage . '
                        </p>
                        <button type="button" class="magic-button mt-5 px-8 py-2" onclick="closePopup(\'' . $popupId . '\')">
                            OK
                        </button>
                    </div>
                </div>
            `;
            
            // Append popup to body
            document.body.appendChild(popup);
            
            // Helper function to create sparkles
            function createSparkles() {
                const sparklesContainer = popup.querySelector(".magical-popup-sparkles");
                
                // Create sparkle elements
                for (let i = 0; i < 7; i++) {
                    const sparkle = document.createElement("div");
                    sparkle.classList.add("absolute");
                    
                    // Random position
                    const top = Math.random() * 100;
                    const left = Math.random() * 100;
                    sparkle.style.top = `${top}%`;
                    sparkle.style.left = `${left}%`;
                    
                    // Random size
                    const size = Math.random() * 10 + 5;
                    sparkle.style.width = `${size}px`;
                    sparkle.style.height = `${size}px`;
                    
                    // Visual effect
                    sparkle.style.background = "white";
                    sparkle.style.boxShadow = "0 0 10px ' . $bgGlow . '";
                    sparkle.style.borderRadius = "50%";
                    
                    // Animation
                    const delay = Math.random() * 3;
                    const duration = 2 + Math.random() * 2;
                    sparkle.style.animation = `popup-sparkle ${duration}s infinite ${delay}s`;
                    
                    sparklesContainer.appendChild(sparkle);
                }
            }
            
            // Define global closePopup function if not already defined
            if (typeof window.closePopup !== "function") {
                window.closePopup = function(popupId) {
                    const popup = document.getElementById(popupId);
                    if (!popup) return;
                    
                    const content = popup.querySelector(".magical-popup-content");
                    
                    // Hide with animation
                    content.classList.remove("scale-100");
                    content.classList.add("scale-90");
                    popup.classList.remove("opacity-100");
                    popup.classList.add("opacity-0", "pointer-events-none");
                    
                    // Remove from DOM after animation
                    setTimeout(() => {
                        popup.remove();
                    }, 300);
                };
            }
            
            // Show the popup with animation after the specified delay
            setTimeout(() => {
                popup.classList.remove("opacity-0", "pointer-events-none");
                popup.classList.add("opacity-100");
                const content = popup.querySelector(".magical-popup-content");
                content.classList.remove("scale-90");
                content.classList.add("scale-100");
                
                // Add sparkle elements
                createSparkles();
                
                // Auto-close if showtime is provided and greater than 0
                if (' . $showtime . ' > 0) {
                    setTimeout(() => {
                        closePopup("' . $popupId . '");
                    }, ' . $showtime . ');
                }
            }, ' . $afterTime . ');
        })();
        </script>';
        
        // Return empty string as the actual output has been echoed directly
        return '';
    }

    public function renderUserNav($username){
        echo '  <div class="relative ml-4 group" id="user-menu">
                            <button class="flex items-center space-x-1 text-white px-3 py-2 rounded-lg hover:bg-white/10 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <span class="text-white">' . substr($username, 0, 1) . '</span>
                                </div>
                                <span class="font-itim">' . $username . '</span>
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="hidden group-hover:block absolute right-0 mt-1 w-48 bg-white rounded-xl shadow-magical
                                        border-t-2 border-primary py-2 z-50">
                                <a href="profile.php" class="block px-4 py-2 font-itim text-dark hover:bg-primary/10 hover:text-primary rounded-lg mx-2">
                                    <i class="fas fa-user-circle mr-2"></i> My Profile
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="../controllers/logout.php" class="block px-4 py-2 font-itim text-dark hover:bg-danger/10 hover:text-danger rounded-lg mx-2">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>';
    }

    /**
     * Outputs a script tag with theme colors as a data attribute for JavaScript
     * 
     * @return string HTML script tag with theme colors data
     */
    public function outputThemeColorsForJS() {
        $colors = json_encode($this->colors);
        return '<script id="magical-theme-colors" type="application/json" data-colors=\'' . $colors . '\'></script>';
    }
}