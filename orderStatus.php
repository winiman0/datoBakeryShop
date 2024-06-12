<?php 
$title = "Order Status";
include("custNav.php");
include("dbconn.php");
$custUsername = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

if ($custUsername !== 'Guest') {
    // Prepare the SQL query to get the custID
    $sql = "SELECT custID FROM customer WHERE custUsername = ?";
    $stmt = mysqli_prepare($dbconn, $sql);
    if ($stmt) {
        // Bind the custUsername parameter to the SQL query
        mysqli_stmt_bind_param($stmt, "s", $custUsername);
        
        // Execute the query
        mysqli_stmt_execute($stmt);
        
        // Bind the result to a variable
        mysqli_stmt_bind_result($stmt, $custID);
        
        // Fetch the result
        if (mysqli_stmt_fetch($stmt)) {
            // Successfully retrieved custID
            $_SESSION['custID'] = $custID;
        } else {
            // Handle the case where the user is not found
            die("Error: User not found.");
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle query preparation error
        die("Error preparing query: " . mysqli_error($dbconn));
    }
} else {
    // Handle the case where the user is a guest
    die("Error: Guest users cannot place orders.");
}

// Fetch all orders sorted by custID and orderStatus
$sql = "SELECT ol.*, d.dessertName, d.filename, d.dessertPrice, oc.shapeReq, oc.decorationReq, oc.request, 
               op.qtyPerBoxReq, op.addToppingReq, oc.quantity AS cake_quantity, op.quantity AS pastry_quantity
        FROM order_log ol
        INNER JOIN dessert d ON ol.dessertID = d.dessertID
        LEFT JOIN order_cake oc ON ol.orderID = oc.orderID
        LEFT JOIN order_pastry op ON ol.orderID = op.orderID
        WHERE ol.custID = ?
        ORDER BY ol.orderStatus";
       
$stmt = mysqli_prepare($dbconn, $sql);
if ($stmt) {
    // Bind the custID parameter to the SQL query
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['custID']);
    
    // Execute the query
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $status = strtolower($row['orderStatus']); // Normalize the case
        $orders[$status][] = $row;
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="orderStatus.css">
    <title>Order Status</title>
</head>
<body>
    <div class="content">
        <h1>ORDER STATUS</h1>
        <p class="order-date"><?php echo date("d/m/Y"); ?></p>
        
        <?php 
        // Define statuses in lowercase
        $statuses = ["pending", "progress", "delivered"];
        foreach ($statuses as $status) : 
        ?>
            <?php if (!empty($orders[$status])) : ?>
                <div class="order-section">
                    <h2><?php echo strtoupper($status); ?></h2>

                    <?php
                    $cakeOrders = array_filter($orders[$status], function($order) {
                        return isset($order['shapeReq']);
                    });

                    $pastryOrders = array_filter($orders[$status], function($order) {
                        return isset($order['qtyPerBoxReq']);
                    });
                    ?>

                    <?php if (!empty($cakeOrders)) : ?>
                        <div class="order-type">
                            <h3>Cake Orders</h3>
                            <?php foreach ($cakeOrders as $order) : ?>
                                <div class="order">
                                    <div class="order-item">
                                        <img src="./image/<?php echo htmlspecialchars($order['filename']); ?>" alt="<?php echo htmlspecialchars($order['dessertName']); ?>">
                                        <div class="order-item-text">
                                            <p class="product-name"><?php echo htmlspecialchars($order['dessertName']); ?></p>
                                            <p>RM <?php echo htmlspecialchars($order['dessertPrice']); ?></p>
                                            <p>Shape: <?php echo htmlspecialchars($order['shapeReq']); ?></p>
                                            <p>Decoration: <?php echo htmlspecialchars($order['decorationReq']); ?></p>
                                            <p>Special Request: <?php echo htmlspecialchars($order['request']); ?></p>
                                            <p>Quantity: <?php echo htmlspecialchars($order['cake_quantity']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($pastryOrders)) : ?>
                        <div class="order-type">
                            <h3>Pastry Orders</h3>
                            <?php foreach ($pastryOrders as $order) : ?>
                                <div class="order">
                                    <div class="order-item">
                                        <img src="./image/<?php echo htmlspecialchars($order['filename']); ?>" alt="<?php echo htmlspecialchars($order['dessertName']); ?>">
                                        <div class="order-item-text">
                                            <p class="product-name"><?php echo htmlspecialchars($order['dessertName']); ?></p>
                                            <p>RM <?php echo htmlspecialchars($order['dessertPrice']); ?></p>
                                            <p>Quantity Per Box: <?php echo htmlspecialchars($order['qtyPerBoxReq']); ?></p>
                                            <p>Add Topping: <?php echo htmlspecialchars($order['addToppingReq']); ?></p>
                                            <p>Quantity: <?php echo htmlspecialchars($order['pastry_quantity']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <?php if (empty($orders['pending']) && empty($orders['progress']) && empty($orders['delivered'])) : ?>
            <p>No pending orders.</p>
        <?php endif; ?>
        
        <!-- Other sections of the order status page can be added below -->
    </div>
</body>
</html>
