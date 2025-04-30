<?php
session_start();
require_once '../../MagicalTheme.php';
$theme = new MagicalTheme('blue');
include '../../includes/nav.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Card - Azure Cards Admin</title>
    <?php echo $theme->render(); ?>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../assets/js/MagicalUI.js"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .dashboard {
            background: white;
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(29, 78, 216, 0.25);
            overflow: hidden;
            padding: 0 1.5rem;
        }

        .header {
            padding: 2rem 0;
            margin: 0 -1.5rem;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .content {
            padding: 2rem 0;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--blue-800);
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    </style>
</head>
<body class="bg-light">
    <?php 
    $websiteName = 'Azure Cards';
    renderNavbar();
    ?>

    <div class="container">
        <div class="dashboard">
            <div class="header flex justify-between items-center">
                <h1><i class="fas fa-plus-circle"></i> Add New Card</h1>
                <a href="index.php" class="magic-button magic-button-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Cards
                </a>
            </div>

            <div class="content">
                <form method="POST" action="../../api/backend/addcard.php" class="space-y-6">
                    <div class="form-group">
                        <label class="form-label">Card Name</label>
                        <input type="text" name="name" class="form-input" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <select name="type" id="cardType" class="form-select" required>
                                <option value="creature">Creature</option>
                                <option value="spell">Spell</option>
                                <option value="trap">Trap</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Element</label>
                            <select name="element" class="form-select" required>
                                <option value="Water">Water</option>
                                <option value="Fire">Fire</option>
                                <option value="Earth">Earth</option>
                                <option value="Air">Air</option>
                                <option value="Arcane">Arcane</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Rarity</label>
                            <select name="rarity" class="form-select" required>
                                <option value="Common">Common</option>
                                <option value="Uncommon">Uncommon</option>
                                <option value="Rare">Rare</option>
                                <option value="Epic">Epic</option>
                                <option value="Legendary">Legendary</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mana Cost (0-10)</label>
                            <input type="number" name="mana_cost" class="form-input" min="0" max="10" required>
                        </div>
                    </div>

                    <div id="creatureStats" class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Attack</label>
                            <input type="number" name="attack" class="form-input" min="0" value="0" 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Defense</label>
                            <input type="number" name="defense" class="form-input" min="0" value="0"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Effect Description</label>
                        <textarea name="effect" class="form-input" rows="4"></textarea>
                    </div>

                    <button type="submit" class="magic-button magic-button-primary w-full">
                        <i class="fas fa-save mr-2"></i> Save Card
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const type = document.getElementById('cardType').value;
            const formData = new FormData(e.target);
            
            // Validate numbers
            const mana = parseInt(formData.get('mana_cost'));
            if (isNaN(mana) || mana < 0 || mana > 10) {
                MagicalUI.renderAlert('error', 'Mana cost must be between 0 and 10');
                return;
            }

            if (type === 'creature') {
                const attack = parseInt(formData.get('attack'));
                const defense = parseInt(formData.get('defense'));
                if (isNaN(attack) || attack < 0 || isNaN(defense) || defense < 0) {
                    MagicalUI.renderAlert('error', 'Attack and Defense must be valid positive numbers');
                    return;
                }
            }

            try {
                const response = await fetch('../../api/backend/addcard.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                
                if (result.success) {
                    MagicalUI.renderAlert('success', result.message);
                    e.target.reset();
                } else {
                    MagicalUI.renderAlert('error', result.message);
                }
            } catch (error) {
                MagicalUI.renderAlert('error', 'Failed to add card');
            }
        });

        // Show/hide creature stats based on card type
        document.getElementById('cardType').addEventListener('change', function() {
            const creatureStats = document.getElementById('creatureStats');
            creatureStats.style.display = this.value === 'creature' ? 'grid' : 'none';
        });
    </script>
</body>
</html>
