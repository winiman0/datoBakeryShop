<?php 
    $title = "Products";
    include("adminNav.php");
    include("dbconn.php");
    include("font.php");

    $sql = "SELECT * FROM dessert";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="product.css">
</head>
<body>
    <div class="contentor">
            <h2>PRODUCTS</h2>
    </div>
    <div class="content">
        <div class="box-container">
            <div class="box">
            <a href="adminCake.php">
                <img src="cakeImage.jpg" alt="boxCake">
                <p><b>CAKES</b></p>
            </div>
            <div class="box">
                <a href="adminPastry.php">
                <img src="pastryImage.jpg" alt="boxPastry">
                <p><b>PASTRIES</b></p>
            </div>
        </div>
    </div>
</body>
</html>