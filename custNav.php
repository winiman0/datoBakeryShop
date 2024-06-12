<?php
    session_start();
    if (!isset($title)) {
        $title = "Dashboard";
    }

    include('dbconn.php');

    // Fetch username from session
    $custUsername = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="custNav.css">
</head>
<body>
    <div class="header">
        <h1><?php echo htmlspecialchars($title); ?></h1>
        <div class="user-info">
        <img src="user.jpeg" alt="User Icon">
            <span>Welcome,<br><b><?php echo htmlspecialchars($custUsername); ?></b></span>
    </div>
    </div>
    <div class="sidebar">     
        <h2><img src="logo.png" alt="Icon">
        DATO'S <br>
        BAKERY SHOP
        </h2>
        <ul>
            <li><a href="product.php">Menu</a></li>
            <li><a href="displayCart.php">Cart</a></li>
            <li><a href="orderStatus.php">Orders</a></li>
            <li><a href="profile.php">Account</a></li>
        </ul>
        <div class="logout">
            <button onclick="logout()">Logout</button>
        </div>
    </div>


    <script>
        function logout() {
            window.location.href = 'logout.php'; // Adjust the URL to your logout script
        }
    </script>
    <!-- ===== WHATSAPP WIDGET ===== -->
    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
    <div class="elfsight-app-d6c6b41e-a159-405d-9665-436e4766aa6e" data-elfsight-app-lazy></div>
</body>
</html>
