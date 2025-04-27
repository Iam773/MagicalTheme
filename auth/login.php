<?php
require_once '../MagicalTheme.php';

include '../includes/nav.php';

// Initialize the theme with blue color scheme
$theme = new MagicalTheme('blue');

// Initialize variables
$email = '';
$password = '';
$errors = [];
$success = false;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Validate form data
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }
    
    // If no validation errors, attempt login
    if (empty($errors)) {
        // In a real application, you would check credentials against database
        // For demo purposes, we'll accept a simple test account
        if ($email === 'test@example.com' && $password === 'password123') {
            // Start session if not already started
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            // Set session variables
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = 'IceWizard';
            $_SESSION['email'] = $email;
            
            // If remember me is checked, set cookies
            if ($remember) {
                setcookie('user_email', $email, time() + (86400 * 30), '/'); // 30 days
            }
            
            // Redirect to dashboard/home page
            header('Location: ../index.php');
            exit;
        } else {
            $errors['login'] = 'Invalid email or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Azure Cards</title>
    <?php echo $theme->render(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">
    <?php 
    $websiteName = 'Azure Cards';
    renderNavbar();
    ?>
    
    <div class="container mx-auto px-4 py-10 min-h-screen">
        <div class="max-w-md mx-auto">
            <div class="magic-card shadow-magical">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-itim text-primary">Welcome Back</h1>
                    <p class="text-gray-600">Sign in to continue your magical journey</p>
                </div>
                
                <?php if (!empty($errors['login'])): ?>
                    <div class="bg-danger/10 border-l-4 border-danger text-danger p-4 mb-6 rounded">
                        <p><?php echo $errors['login']; ?></p>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="../api/action/login.php">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" 
                                   class="magic-input pl-10 block w-full rounded-md focus:ring-primary focus:border-primary"
                                   placeholder="you@example.com">
                        </div>
                        <?php if (!empty($errors['email'])): ?>
                            <p class="mt-1 text-sm text-danger"><?php echo $errors['email']; ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" 
                                   class="magic-input pl-10 block w-full rounded-md focus:ring-primary focus:border-primary"
                                   placeholder="Enter your password">
                        </div>
                        <?php if (!empty($errors['password'])): ?>
                            <p class="mt-1 text-sm text-danger"><?php echo $errors['password']; ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" 
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-primary hover:text-primary-dark">Forgot password?</a>
                    </div>
                    
                    <div class="mb-6">
                        <button type="submit" class="w-full magic-button magic-button-primary py-2 px-4 rounded-md">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </button>
                    </div>
                    
                    <div class="relative flex py-4 items-center">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="flex-shrink mx-3 text-gray-600 text-sm">or sign in with</span>
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
                    <p class="text-gray-600">Don't have an account? <a href="register.php" class="text-primary hover:text-primary-dark font-medium">Sign up</a></p>
                </div>
            </div>
            
            <div class="text-center mt-8 text-sm text-gray-600">
                <p>By logging in, you agree to our <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a></p>
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
</body>
</html>
