<?php
require_once '../MagicalTheme.php';


include '../includes/nav.php';


// Initialize the theme with blue color scheme
$theme = new MagicalTheme('blue');

// Initialize variables
$username = '';
$email = '';
$errors = [];
$success = false;
$errorMessage = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $agree_terms = isset($_POST['agree_terms']);
    
    // Validate form data
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($username) < 3 || strlen($username) > 20) {
        $errors['username'] = 'Username must be between 3 and 20 characters';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors['username'] = 'Username can only contain letters, numbers, and underscores';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
    }
    
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
        $errorMessage = 'Passwords do not match. Please try again.';
    }
    
    if (!$agree_terms) {
        $errors['agree_terms'] = 'You must agree to the Terms of Service and Privacy Policy';
    }
    
    // If no validation errors, register the user
    if (empty($errors)) {
        // In a real application, you would save user data to database
        // For demo purposes, we'll just show a success message
        $success = true;
        
        // Clear form data
        $username = '';
        $email = '';
        
        // Redirect to login page
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Azure Cards</title>
    <?php echo $theme->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Magical required field styles */
        .required-field::after {
            content: "✨";
            margin-left: 5px;
            color: var(--primary);
            animation: sparkle 1.5s infinite;
            opacity: 0.8;
            font-size: 0.8em;
        }
        
        @keyframes sparkle {
            0%, 100% { opacity: 0.5; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2) rotate(10deg); }
        }
        
        .magic-input:required:invalid:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.3), 0 0 10px rgba(var(--primary-rgb), 0.2);
            background-image: linear-gradient(to right, rgba(var(--primary-rgb), 0.05), transparent);
        }
    </style>
</head>
<body class="bg-light">
    <?php 
    renderNavbar();
    $websiteName = 'Azure Cards';
    
    // Show popup if passwords do not match
    if (!empty($errors['confirm_password'])) {
        echo $theme->renderPopup($errorMessage, 'error', 300, 5000);
    }
    ?>
    
    <div class="container mx-auto px-4 py-10 min-h-screen">
        <div class="max-w-lg mx-auto">
            <div class="magic-card shadow-magical">
                <?php if ($success): ?>
                    <div class="text-center py-8">
                        <div class="inline-block p-4 rounded-full bg-success/20 text-success mb-4">
                            <i class="fas fa-check-circle text-4xl"></i>
                        </div>
                        <h2 class="text-2xl font-itim text-primary mb-2">Registration Successful!</h2>
                        <p class="text-gray-600 mb-6">Your account has been created successfully.</p>
                        <div class="flex justify-center space-x-4">
                            <a href="login.php" class="magic-button magic-button-primary">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login Now
                            </a>
                            <a href="../index.php" class="magic-button magic-button-secondary">
                                <i class="fas fa-home mr-2"></i> Homepage
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-itim text-primary">Create Your Account</h1>
                        <p class="text-gray-600">Join the magical world of Azure Cards</p>
                    </div>
                    
                    <form method="POST" action="../api/action/register.php">
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1 required-field">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" 
                                       class="magic-input pl-10 block w-full rounded-md focus:ring-primary focus:border-primary"
                                       placeholder="Choose a username" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none opacity-50">
                                    <i class="fas fa-magic text-primary hidden magic-required-icon"></i>
                                </div>
                            </div>
                            <?php if (!empty($errors['username'])): ?>
                                <p class="mt-1 text-sm text-danger"><?php echo $errors['username']; ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1 required-field">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i> 
                                </div>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" 
                                       class="magic-input pl-10 block w-full rounded-md focus:ring-primary focus:border-primary"
                                       placeholder="you@example.com" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none opacity-50">
                                    <i class="fas fa-magic text-primary hidden magic-required-icon"></i>
                                </div>
                            </div>
                            <?php if (!empty($errors['email'])): ?>
                                <p class="mt-1 text-sm text-danger"><?php echo $errors['email']; ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1 required-field">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password" 
                                       class="magic-input pl-10 block w-full rounded-md focus:ring-primary focus:border-primary"
                                       placeholder="Create a password">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 cursor-pointer toggle-password"></i>
                                </div>
                            </div>
                            <?php if (!empty($errors['password'])): ?>
                                <p class="mt-1 text-sm text-danger"><?php echo $errors['password']; ?></p>
                            <?php else: ?>
                                <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-6">
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1 required-field">Confirm Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="confirm_password" name="confirm_password" 
                                       class="magic-input pl-10 block w-full rounded-md focus:ring-primary focus:border-primary"
                                       placeholder="Confirm your password" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none opacity-50">
                                    <i class="fas fa-magic text-primary hidden magic-required-icon"></i>
                                </div>
                            </div>
                            <?php if (!empty($errors['confirm_password'])): ?>
                                <p class="mt-1 text-sm text-danger"><?php echo $errors['confirm_password']; ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" id="agree_terms" name="agree_terms" 
                                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="agree_terms" class="text-gray-700 required-field">
                                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and 
                                        <a href="#" class="text-primary">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                            <?php if (!empty($errors['agree_terms'])): ?>
                                <p class="mt-1 text-sm text-danger"><?php echo $errors['agree_terms']; ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-6">
                            <button type="submit" class="w-full magic-button magic-button-primary py-2 px-4 rounded-md">
                                <i class="fas fa-user-plus mr-2"></i> Create Account
                            </button>
                        </div>
                        
                        <div class="relative flex py-4 items-center">
                            <div class="flex-grow border-t border-gray-300"></div>
                            <span class="flex-shrink mx-3 text-gray-600 text-sm">or sign up with</span>
                            <div class="flex-grow border-t border-gray-300"></div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <button type="button" class="w-full bg-[#1877F2] text-white py-2 px-4 rounded-md flex items-center justify-center">
                                <i class="fab fa-facebook-f mr-2"></i> Facebook
                            </button>
                            <button type="button" class="w-full bg-[#4285F4] text-white py-2 px-4 rounded-md flex items-center justify-center">
                                <i class="fab fa-google mr-2"></i> Google
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-gray-600">Already have an account? <a href="login.php" class="text-primary hover:text-primary-dark font-medium">Sign in</a></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (!$success): ?>
                <div class="text-center mt-8 text-sm text-gray-600">
                    <p>By creating an account, you agree to our <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-itim mb-4 text-blue-300">Azure Cards</h3>
                    <p class="text-blue-100 mb-4">The ultimate magical card game with stunning visuals and strategic gameplay.</p>
                </div>
                
                <div>
                    <h3 class="text-xl font-itim mb-4 text-blue-300">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="../index.php" class="text-blue-100 hover:text-white">Home</a></li>
                        <li><a href="../collection.php" class="text-blue-100 hover:text-white">Card Collection</a></li>
                        <li><a href="../battle.php" class="text-blue-100 hover:text-white">Battle Arena</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-itim mb-4 text-blue-300">Contact</h3>
                    <p class="text-blue-100"><i class="fas fa-envelope mr-2"></i> support@azurecards.com</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="../js/game.js"></script>
    <script src="../assets/js/MagicalUI.js"></script>
    <script>
        // Password visibility toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Example 1: Basic usage with default path
            MagicalUI.setThemeColorsFromPHP('../get-theme-colors.php')
                .then(colors => {
                    console.log('Theme colors loaded successfully:', colors);
                    // Now the UI will automatically update with these colors
                })
                .catch(error => {
                    console.error('Error loading theme colors:', error);
                });
                
            // Example 2: Specify custom path to the get-theme-colors.php file
            // MagicalUI.setThemeColorsFromPHP('../get-theme-colors.php')
            //     .then(colors => {
            //         console.log('Theme colors loaded from custom path:', colors);
            //     })
            //     .catch(error => {
            //         console.error('Error loading theme colors:', error);
            //     });
                
            // Example 3: Explicitly disable using color script (data attribute)
            // MagicalUI.setThemeColorsFromPHP(false, '../get-theme-colors.php')
            //     .then(colors => {
            //         console.log('Theme colors loaded with options:', colors);
            //     })
            //     .catch(error => {
            //         console.error('Error loading theme colors:', error);
            //     });
            
            // You can also manually update colors after other operations
            // MagicalUI.setThemeColors({
            //     primary: '#ff00ff',
            //     secondary: '#00ffff'
            // });
            
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            
            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    // Toggle password visibility
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Toggle icon
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
            
            // Show magical icon when required field is empty
            const requiredInputs = document.querySelectorAll('input[required]');
            
            requiredInputs.forEach(input => {
                if(input.type === 'checkbox') return; // Skip checkboxes
                const magicIcon = input.parentNode.querySelector('.magic-required-icon');
                if(!magicIcon) return;
                
                // Check validity on blur
                input.addEventListener('blur', function() {
                    if (!this.validity.valid) {
                        magicIcon.classList.remove('hidden');
                        magicIcon.classList.add('animate-ping-slow');
                    } else {
                        magicIcon.classList.add('hidden');
                        magicIcon.classList.remove('animate-ping-slow');
                    }
                });
                
                // Check validity on input
                input.addEventListener('input', function() {
                    if (this.validity.valid) {
                        magicIcon.classList.add('hidden');
                        magicIcon.classList.remove('animate-ping-slow');
                    }
                });
            });
            
            // Password matching validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirm_password').value;
                    
                    if (password !== confirmPassword) {
                        e.preventDefault(); // Prevent form submission
                        
                        // Example 1: Basic usage with type and message
                        MagicalUI.renderPopup(
                            "Passwords do not match. Please make sure both passwords are the same.", 
                            "error"
                        );
                        
                        // Example 2: With custom title and button text
                        // MagicalUI.renderPopup(
                        //     "Passwords do not match. Please make sure both passwords are the same.", 
                        //     "error", 
                        //     {
                        //         title: "Password Mismatch",
                        //         confirmText: "Try Again"
                        //     }
                        // );
                        
                        // Example 3: With callback function when confirmed
                        // MagicalUI.renderPopup(
                        //     "Passwords do not match. Please make sure both passwords are the same.", 
                        //     "error", 
                        //     {
                        //         title: "Password Mismatch",
                        //         confirmText: "I'll Fix It",
                        //         onConfirm: function() {
                        //             document.getElementById('confirm_password').focus();
                        //         }
                        //     }
                        // );
                        
                        // Example 4: With auto-close timing options
                        // MagicalUI.renderPopup(
                        //     "Passwords do not match. Please make sure both passwords are the same.", 
                        //     "error", 
                        //     {
                        //         afterTime: 500,  // Delay showing by 500ms
                        //         showTime: 5000,  // Auto-close after 5 seconds
                        //         title: "Password Error"
                        //     }
                        // );
                        
                        // Focus on confirm password field
                        document.getElementById('confirm_password').focus();
                    }
                });
            }
            
            // Helper function to create alert container if it doesn't exist
            function createAlertContainer() {
                const container = document.createElement('div');
                container.id = 'alert-container';
                container.className = 'container mx-auto px-4 max-w-lg mb-4';
                
                // Insert at the beginning of the form
                const formElement = document.querySelector('form');
                formElement.parentNode.insertBefore(container, formElement);
                
                return container;
            }
            
          
        });
    </script>
</body>
</html>
