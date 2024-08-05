<?php
    session_start();
    if (!isset($title)) {
        $title = "Sign Up";
    }
    include('header.php');
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Meta tags for character set and viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title of the page -->
    <title>Sign Up</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="singup.css">
</head>
<body>
    <!-- Main content section (Sign Up form) -->
    <div class="login-container">
        <!-- Sign Up form heading -->
        <h2>SIGN UP</h2>
        <!-- Sign Up form -->
        <form action=signupSession.php method=post class="signup">
            <table>
                <tr>
                    <!-- Username icon -->
                    <td><img src="username.png"></td>
                    <!-- Username input field -->
                    <td><input type="text" name="fullName" placeholder="Full Name" required></td>
                </tr>
                <tr>
                    <!-- Password icon -->
                    <td><img src="mail.png"></td>
                    <!-- Password input field -->
                    <td><input type="email" name="email" placeholder="Email Address" required></td>
                </tr>
                <tr>
                    <!-- Username icon -->
                    <td><img src="username.png"></td>
                    <!-- Username input field -->
                    <td><input type="text" name="username" placeholder="Username" required></td>
                </tr>
                <tr>
                    <!-- Username icon -->
                    <td><img src="padlock.png"></td>
                    <!-- Username input field -->
                    <td><input type="password" name="password" placeholder="Password" required></td>
                </tr>
            </table>
            <!-- Submit button -->
            <input type="submit" value="Sign Up">
        </form>
    </div>

<div id="footer">&copy 2024 | Dato’s Bakery Ordering System</div> 

</body>
</html>