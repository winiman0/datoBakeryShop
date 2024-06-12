<?php
    session_start();
    if (!isset($title)) {
        $title = "Dashboard";
    }

    include('dbconn.php');

    // Fetch username from session
    if(isset($_SESSION['username']) && $_SESSION['username'] == "Administrator"){

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminNav.css">
</head>
<body>
    <div class="header">
        <h1><?php echo htmlspecialchars($title); ?></h1>
        <div class="user-info">
        <img src="user.jpeg" alt="User Icon">
            <span>Welcome,<br><b><?php echo $_SESSION['username']; ?></b></span>
    </div>
    </div>
    <div class="sidebar">     
        <h2><img src="logo.png" alt="Icon">
        DATO'S <br>
        BAKERY SHOP
        </h2>
        <ul>
            <li><a href="adminDashboard.php">Dashboard</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="adOrders.php">Orders</a></li>
            <li><a href="productAdmin.php">Products</a></li>
            <li><a href="report.php">Report</a></li> 
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
</body>
</html>
<?php
    }
    else {
        header("Location: login.php");
    }
