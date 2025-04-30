<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $config = json_decode(file_get_contents("../../database/db/config.json"), true);
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $config['admin']['username'] && 
        $password === $config['admin']['password']) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../assets/js/MagicalUI.js"></script>
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #1e40af;
            --primary-light: #93c5fd;
            --text-primary: #1e40af;
            --blue-800: #1e40af;
        }
        
        body {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(29, 78, 216, 0.1));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Itim', cursive;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(29, 78, 216, 0.25);
            width: 100%;
            max-width: 360px;
            border-top: 4px solid var(--primary);
        }
        .login-title {
            text-align: center;
            color: var(--primary);
            margin-bottom: 2rem;
            font-size: 2rem;
            position: relative;
        }
        .login-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border-radius: 2px;
        }
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        .input-group input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--blue-200);
            border-radius: 0.5rem;
            background: white;
            outline: none;
            transition: all 0.3s;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .input-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            opacity: 0.5;
        }
        .magic-button {
            width: 100%;
            padding: 0.75rem;
            font-size: 1.1rem;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .magic-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
        }
        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            text-align: center;
            border-left: 4px solid #dc2626;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">
            <i class="fas fa-hat-wizard"></i>
            Admin Login
        </h1>
        
        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateForm(event)">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <button type="submit" class="magic-button">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
    </div>

    <script>
        function validateForm(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (!username || !password) {
                MagicalUI.renderAlert('error', 'Please fill in all fields');
                return false;
            }

            event.target.submit();
            return true;
        }

        <?php if (isset($error)): ?>
        window.onload = function() {
            MagicalUI.renderAlert('error', '<?php echo $error; ?>');
        }
        <?php endif; ?>
    </script>
</body>
</html>
