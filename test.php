<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>


<!DOCTYPE html>
<html>
<head>
    <title>Display Dessert Images</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>

<div id="display-dessert-images" class="container mt-5">
    <div class="row">
        <?php
        // Establish database connection
        $db = mysqli_connect("localhost", "root", "", "copycat");
        if (!$db) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch and display dessert images
        $query = "SELECT (filename) FROM dessert WHERE (filename) IS NOT NULL";
        $result = mysqli_query($db, $query);

        while ($data = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-md-3">
                <img src="./image/<?php echo htmlspecialchars($data['filename']); ?>" class="img-thumbnail" alt="Dessert Image">
            </div>
            <?php
        }
        // Close database connection
        mysqli_close($db);
        ?>
    </div>
</div>

</body>
</html>
