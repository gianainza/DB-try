<?php
session_start();
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../config/database.php';

// Simple authentication (for demo purposes)
$valid_users = [
    'admin' => ['pass' => 'admin123', 'name' => 'Admin User', 'role' => 'Administrator']
];

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']) && is_array($_SESSION['user']);

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /event_ticketing/');
    exit();
}

// Handle login POST
if (!$isLoggedIn && isPost() && isset($_POST['username']) && isset($_POST['password'])) {
    $username = post('username');
    $password = post('password');
    
    if (isset($valid_users[$username]) && $valid_users[$username]['pass'] === $password) {
        $_SESSION['user'] = [
            'username' => $username,
            'name' => $valid_users[$username]['name'],
            'role' => $valid_users[$username]['role']
        ];
        $isLoggedIn = true;
        header('Location: /event_ticketing/');
        exit();
    } else {
        $login_error = "Invalid username or password.";
    }
}

// Current script base name (may be 'index.php' in many directories)
$currentPage = basename($_SERVER['PHP_SELF']);
// Request path for more accurate matching (e.g. '/event_ticketing/' or '/event_ticketing/modules/events/')
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

// Get user info safely
$userName = '';
$userRole = '';
$userInitial = 'A';

if ($isLoggedIn && isset($_SESSION['user']['name'])) {
    $userName = $_SESSION['user']['name'];
    $userRole = isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'Administrator';
    $userInitial = strtoupper(substr($userName, 0, 1));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management & Ticketing — University System</title>
    <link rel="stylesheet" href="/event_ticketing/assets/css/style.css">
    <style>
        /* Login Screen Styles */
        #login-screen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--color-background-tertiary);
        }
        .login-card {
            background: var(--color-background-primary);
            border: 0.5px solid var(--color-border-tertiary);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            width: 100%;
            max-width: 360px;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .login-logo h2 {
            font-size: 16px;
            font-weight: 500;
            margin-top: 8px;
        }
        .login-logo p {
            font-size: 12px;
            color: var(--color-text-secondary);
        }
        #app-screen {
            display: <?php echo $isLoggedIn ? 'block' : 'none'; ?>;
        }
    </style>
</head>
<body>
<div id="root" style="position:relative;min-height:100vh">

<?php if (!$isLoggedIn): ?>
<!-- LOGIN SCREEN -->
<div id="login-screen">
    <div class="login-card">
        <div class="login-logo">
            <div style="width:48px;height:48px;border-radius:50%;background:#E6F1FB;display:flex;align-items:center;justify-content:center;margin:0 auto;font-size:20px">🎓</div>
            <h2>Event Management &amp; Ticketing</h2>
            <p>University System — Admin Portal</p>
        </div>
        <form method="POST">
            <div class="form-group" style="margin-bottom:10px">
                <label class="form-label">Username</label>
                <input type="text" name="username" id="login-user" placeholder="admin" value="admin">
            </div>
            <div class="form-group" style="margin-bottom:16px">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="login-pass" placeholder="password" value="admin123">
            </div>
            <?php if (isset($login_error)): ?>
                <div class="err-msg" style="display:block;margin-bottom:8px;color:#791F1F;"><?php echo h($login_error); ?></div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary" style="width:100%">Sign In</button>
            <p style="font-size:11px;color:var(--color-text-secondary);text-align:center;margin-top:10px">Credentials: admin / admin123</p>
        </form>
    </div>
</div>
<?php else: ?>
<!-- APP SCREEN -->
<div id="app-screen">
<div class="app">

<nav class="sidebar">
    <div class="sidebar-top">
        <h1>EventTicket</h1>
        <p>University System</p>
    </div>
    <div class="sidebar-user">
        <div class="user-avatar" id="user-avatar"><?php echo $userInitial; ?></div>
        <div style="min-width:0">
            <div style="font-size:12px;font-weight:500;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" id="user-name"><?php echo h($userName); ?></div>
            <div style="font-size:11px;color:var(--color-text-secondary)"><?php echo h($userRole); ?></div>
        </div>
    </div>

    <div class="sidebar-nav">
        <a href="/event_ticketing/index.php" class="nav-item <?php echo (strpos($requestPath, '/event_ticketing/index.php') !== false || rtrim($requestPath, '/') === '/event_ticketing') ? 'active' : ''; ?>">
            <span class="nav-icon">📊</span>Dashboard
        </a>
        <a href="/event_ticketing/modules/events/" class="nav-item <?php echo strpos($requestPath ?? '', '/modules/events/') !== false ? 'active' : ''; ?>">
            <span class="nav-icon">📅</span>Manage Events
        </a>
        <a href="/event_ticketing/modules/venues/" class="nav-item <?php echo strpos($requestPath ?? '', '/modules/venues/') !== false ? 'active' : ''; ?>">
            <span class="nav-icon">🏛️</span>Venues
        </a>
        <a href="/event_ticketing/modules/organizations/" class="nav-item <?php echo strpos($requestPath ?? '', '/modules/organizations/') !== false ? 'active' : ''; ?>">
            <span class="nav-icon">👥</span>Organizations
        </a>
        <a href="/event_ticketing/modules/categories/" class="nav-item <?php echo strpos($requestPath ?? '', '/modules/categories/') !== false ? 'active' : ''; ?>">
            <span class="nav-icon">🎫</span>Ticket Categories
        </a>
        <a href="/event_ticketing/modules/attendees/" class="nav-item <?php echo strpos($requestPath ?? '', '/modules/attendees/') !== false ? 'active' : ''; ?>">
            <span class="nav-icon">👤</span>Attendees
        </a>
        <a href="/event_ticketing/modules/tickets/" class="nav-item <?php echo (strpos($requestPath ?? '', '/modules/tickets/') !== false && strpos($requestPath ?? '', 'validate.php') === false) ? 'active' : ''; ?>">
            <span class="nav-icon">🎟️</span>Ticket Generation
        </a>
        <a href="/event_ticketing/modules/tickets/validate.php" class="nav-item <?php echo strpos($requestPath ?? '', 'validate.php') !== false ? 'active' : ''; ?>">
            <span class="nav-icon">✓</span>Ticket Validation
        </a>
    </div>

    <div class="sidebar-bottom">
        <a href="/event_ticketing/?logout=1" class="btn btn-sm" style="width:100%;display:block;text-align:center;text-decoration:none">Sign Out</a>
    </div>
</nav>

<main class="main">
<?php endif; ?>