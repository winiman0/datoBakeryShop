<?php
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Meta tags for character set and viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title of the page -->
    <title>Sign In</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <!-- Header section -->
    <header>
        <!-- Logo section -->
        <div class="logo"><img src="image/logo.png" alt="Main Logo"></div>
        <!-- Navigation menu -->
        <nav>
            <ul>
                <li><a href="home.html"><b>Home</b></a></li>
                <li><a href="login.html"><b>Sign In</b></a></li>
                <li><a href="signup.html"><b>Sign Up</b></a></li>
                <li><a href="about.html"><b>About Us</b></a></li>
            </ul>
        </nav>
    </header>

    <!-- Main content section (Login form) -->
    <div class="login-container">
        <!-- Login form heading -->
        <h2>SIGN IN</h2>
        <!-- Login form -->
        <form name="form" method="post" action="loginSession.php" class="login">
            <table>
                <tr>
                    <!-- Username icon -->
                    <td><img src="username.png"></td>
                    <!-- Username input field -->
                    <td><input type="text" name="username" id="username" placeholder="Username" required></td>
                </tr>
                <tr>
                    <!-- Password icon -->
                    <td><img src="padlock.png"></td>
                    <!-- Password input field -->
                    <td><input type="password" name="password" id="password" placeholder="Password" required></td>
                </tr>
            </table>
            <!-- Submit button -->
            <input type="submit" name="Submit" value="Sign In">
        </form>
        <p style="font-size: 14px;">Don't have an account? <a href="signup.html"><b>Register</b></a></p>
    </div>

<div id="footer">&copy 2024 | Dato’s Bakery Ordering System</div> 

</body>
</html>