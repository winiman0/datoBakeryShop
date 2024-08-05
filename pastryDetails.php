<?php 
    $title = "Pastry";
    include("custNav.php");
    include("dbconn.php");
    include("font.php");

    // Fetch dessert details based on dessertID
    $dessertID = isset($_GET['dessertID']) ? $_GET['dessertID'] : '';
    $sql = "SELECT * FROM dessert WHERE dessertID = ?";
    $stmt = mysqli_prepare($dbconn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $dessertID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dessert = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="pastryDetails.css">
    <title>Choose Pastry</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function addToCart(event) {
        event.preventDefault(); // Prevent form submission

        var formData = {
            dessertID: $("input[name='dessertID']").val(),
            qtyPerBox: $("#quantityPerBox").val(),
            addTopping: $("#flavour").val(),
            quantity: $("#quantity").val(),
            dessertType: "pastry" // Added this line
        };

        $.ajax({
            type: "POST",
            url: "addToCart.php",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    alert(response.message + "\nOrder ID: " + response.orderID);
                    // Redirect to product page
                    window.location.href = 'product.php';
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Failed to add item to cart. Error: ' + error);
            }
        });
    }
    </script>
</head>
<body>
    <div class="content">
        <div class="image-section">
            <img src="./image/<?php echo !empty($dessert['filename']) ? htmlspecialchars($dessert['filename']) : 'default-image.png'; ?>" alt="<?php echo htmlspecialchars($dessert['dessertName']); ?>">
            <div class="image-title">
                <p>PASTRIES</p>
                <h1><?php echo htmlspecialchars($dessert['dessertName']); ?></h1>
                <h4 style="color:#8b0000;">RM <?php echo htmlspecialchars($dessert['dessertPrice']); ?></h4>
                <form id="addToCartForm" onsubmit="addToCart(event);">
                    <div class="form-group">
                        <label for="flavour">Topping:</label>
                        <select id="flavour" name="flavour">
                            <option value="chocolateRice">Chocolate Rice</option>
                            <option value="creamCheese">Cream Cheese</option>
                            <option value="whippingCream">Whipping Cream</option>
                            <option value="rainbowRiceChoco">Rainbow Rice Chocolate</option>
                            <option value="almond">Almond</option>
                            <option value="gratedCheese">Grated Cheese</option>
                            <option value="mixFruit">Mix Fruits</option>
                            <option value="nutella">Nutella</option>
                            <option value="cornflakes">Cornflakes</option>
                            <option value="sugar">Sugar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantityPerBox">Quantity Per Box:</label>
                        <select id="quantityPerBox" name="quantityPerBox">
                            <option value="2">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1">
                    </div>
                    <div class="buttons">
                        <button class="back-button" type="button" onclick="window.history.back();">Back</button>
                        <input type="hidden" name="dessertID" value="<?php echo htmlspecialchars($dessert['dessertID']); ?>">
                        <input type="hidden" name="dessertType" value="pastry"> <!-- Added this line -->
                        <button type="submit" class="add-to-cart-button">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>