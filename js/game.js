// Card game interactive functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effect to game cards
    const gameCards = document.querySelectorAll('.game-card');
    gameCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            // Add a magical sparkle effect when hovering
            createMagicalAlert('info', 'Card selected: ' + this.querySelector('h3').textContent);
        });
    });
    
    // Function to create magical alerts
    window.createMagicalAlert = function(type, message) {
        // Check if the function exists (provided by MagicalTheme)
        if (typeof magicalAlert === 'function') {
            magicalAlert(type, message);
        } else {
            console.log(`[${type}] ${message}`);
        }
    };
});
