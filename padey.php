<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="header">
        <h1>Bakery System Dashboard</h1>
        <div class="user-info">
            <span>Welcome,<br><b>NURIN IMAN</b></span>
            <img src="nurin.png" alt="User Icon">
        </div>
    </div>
    <div class="sidebar">     
        <h2><img src="logo.png" alt="Icon">
        DATOS <br>
        BAKERY SHOP
        </h2>
        <ul>
            <li>Dashboard</li>
            <li>Users</li>
            <li>Orders</li>
            <li>Menu</li>
            <li>Report</li>
            <li>Account</li>
        </ul>
        <div class="logout">
            <button onclick="logout()">Logout</button>
        </div>
    </div>
    <div class="content">
        <h2>Dashboard</h2>
        <p>Welcome to the Bakery System dashboard. Here you can manage orders, products, customers, view reports, and configure settings.</p>
    </div>

    <script>
        function logout() {
            window.location.href = 'logout.php'; // Adjust the URL to your logout script
        }
    </script>
</body>
</html>