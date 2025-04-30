<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: auth/login.php");
    exit();
}

require_once '../MagicalTheme.php';
$theme = new MagicalTheme('blue');
include '../includes/nav.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <?php echo $theme->render(); ?>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../assets/js/MagicalUI.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            min-height: 100vh;
            font-family: 'Itim', cursive;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(29, 78, 216, 0.1));
        }

        :root {
            --primary: #3b82f6;
            --primary-dark: #1d4ed8;
            --blue-100: #dbeafe;
            --blue-200: #bfdbfe;
            --blue-800: #1e40af;
        }
        
        .container {
            max-width: 1400px; /* เพิ่มขนาดจาก 1200px */
            margin: 0 auto;
            padding: 4rem 1rem;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-brand {
            font-size: 1.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-menu {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-link {
            color: var(--blue-800);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }

        .nav-link:hover {
            background: var(--blue-100);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: var(--primary);
            color: white;
        }

        .dashboard {
            background: white;
            max-width: 1200px; /* เพิ่มขนาดจาก 1000px */
            margin: 0 auto;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(29, 78, 216, 0.25);
            overflow: hidden;
        }
        .header {
            background: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid var(--primary);
        }
        .content {
            padding: 2rem;
            background: white;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* เพิ่มขนาดจาก 200px */
            gap: 2rem; /* เพิ่มระยะห่างจาก 1.5rem */
            margin-bottom: 2rem;
            padding: 1rem;
        }
        .stat-card {
            background: white;
            padding: 2rem; /* เพิ่มขนาดจาก 1.5rem */
            border-radius: 0.75rem;
            border: 1px solid var(--blue-100);
            transition: transform 0.3s;
            text-align: center;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);
        }
        .stat-card h3 {
            color: var(--blue-800);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        .stat-card i {
            color: var(--primary);
            margin-right: 0.5rem;
        }
        h1 {
            color: var(--blue-800);
            margin: 0;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        h1 i {
            color: var(--primary);
        }
        .welcome-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid var(--blue-100);
        }
        .welcome-card h2 {
            color: var(--blue-800);
            margin-top: 0;
        }
        .magic-button-danger {
            background: linear-gradient(to right, #ef4444, #dc2626);
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }
        .magic-button-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.4);
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar">
        <div class="navbar-content">
            <a href="../index.php" class="nav-brand">
                <i class="fas fa-hat-wizard"></i>
                Azure Cards
            </a>
            <div class="nav-menu">
                <a href="../index.php" class="nav-link">Home</a>
                <a href="../cards.php" class="nav-link">Cards</a>
                <a href="../shop.php" class="nav-link">Shop</a>
                <a href="../battle.php" class="nav-link">Battle</a>
                <a href="index.php" class="nav-link active">Admin</a>
                <button onclick="handleLogout()" class="magic-button magic-button-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard">
            <div class="header">
                <h1><i class="fas fa-hat-wizard"></i> Admin Dashboard</h1>
            </div>
            <div class="content">
                <!-- Add menu grid before stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <a href="cards/index.php" class="magic-button magic-button-primary flex items-center justify-center gap-2">
                        <i class="fas fa-cards"></i> Manage Cards
                    </a>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <h3><i class="fas fa-users"></i> Total Users</h3>
                        <p style="font-size: 2rem; margin: 0; color: var(--primary);">150</p>
                    </div>
                    <div class="stat-card">
                        <h3><i class="fas fa-star"></i> Reviews</h3>
                        <p style="font-size: 2rem; margin: 0; color: var(--primary);">4.8</p>
                    </div>
                    <div class="stat-card">
                        <h3><i class="fas fa-chart-line"></i> Growth</h3>
                        <p style="font-size: 2rem; margin: 0; color: var(--primary);">+25%</p>
                    </div>
                </div>
                <div class="welcome-card">
                    <h2>Welcome to Dashboard</h2>
                    <p style="color: #4b5563;">Select an option from the menu above to manage your site.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleLogout() {
            MagicalUI.renderPopup('Are you sure you want to logout?', 'warning', {
                title: 'Confirm Logout',
                confirmText: 'Yes, Logout',
                showTime: 0,
                onConfirm: () => {
                    window.location.href = 'auth/logout.php';
                }
            });
        }
    </script>
</body>
</html>
