<?php 
    $title = "Cakes";
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
    <link rel="stylesheet" type="text/css" href="cakeDetails.css">
    <title>Choose Cake</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function addToCart(event) {
        event.preventDefault(); // Prevent form submission

        var formData = {
            dessertID: $("input[name='dessertID']").val(),
            shape: $("#shape").val(),
            decoration: $("#decoration").val(),
            quantity: $("#quantity").val(),
            specialRequest: $("#special-request").val(),
            dessertType: "cake" // Added this line
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
                <p>CAKES</p>
                <h1><?php echo htmlspecialchars($dessert['dessertName']); ?></h1>
                <h4 style="color:#8b0000;">RM <?php echo htmlspecialchars($dessert['dessertPrice']); ?></h4>
                <form id="addToCartForm" onsubmit="addToCart(event);">
                    <div class="form-group">
                        <label for="shape">Shape:</label>
                        <select id="shape" name="shape">
                            <option value="rectangle">Rectangle</option>
                            <option value="round">Round</option>
                            <option value="square">Square</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="decoration">Decoration:</label>
                        <select id="decoration" name="decoration">
                            <option value="wedding">Wedding</option>
                            <option value="birthday">Birthday</option>
                            <option value="party">Party</option>
                            <option value="ceremony">Ceremony</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1">
                    </div>
                    <div class="form-group">
                        <label for="special-request">Special Request:</label>
                        <textarea id="special-request" name="special-request" placeholder="Enter any special request here..."></textarea>
                    </div>
                    <div class="buttons">
                        <button class="back-button" type="button" onclick="window.history.back();">Back</button>
                        <input type="hidden" name="dessertID" value="<?php echo htmlspecialchars($dessert['dessertID']); ?>">
                        <input type="hidden" name="dessertType" value="cake"> <!-- Added this line -->
                        <button type="submit" class="add-to-cart-button">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>