<?php 
    $title = "Receipt";
    include("custNav.php");
    include("dbconn.php");
    include("font.php");

    $transactionNo = isset($_GET['transactionNo']) ? $_GET['transactionNo'] : '';

    if ($transactionNo == '') {
        die('Invalid transaction number.');
    }

    // Check if transactionNo exists in order_log
    $sqlCheck = "SELECT COUNT(*) AS cnt FROM order_log WHERE transactionNo = ?";
    $stmtCheck = mysqli_prepare($dbconn, $sqlCheck);
    mysqli_stmt_bind_param($stmtCheck, "s", $transactionNo);
    mysqli_stmt_execute($stmtCheck);
    $resultCheck = mysqli_stmt_get_result($stmtCheck);
    $rowCheck = mysqli_fetch_assoc($resultCheck);

    if ($rowCheck['cnt'] == 0) {
        die('Error: No order details found for this transaction.');
    }

mysqli_stmt_close($stmtCheck);

    // Query the database for details related to the transaction
        $sql = "SELECT c.*, ci.*, ol.*, 
        oc.quantity AS cake_quantity, 
        op.quantity AS pastry_quantity, 
        op.*, oc.*, d.*, s.*, sl.*
        FROM customer c
        JOIN customer_info ci ON c.custID = ci.custID
        JOIN order_log ol ON c.custID = ol.custID
        LEFT JOIN order_cake oc ON ol.orderID = oc.orderID
        LEFT JOIN order_pastry op ON ol.orderID = op.orderID
        JOIN dessert d ON ol.dessertID = d.dessertID
        JOIN service s ON ol.serviceID = s.serviceID
        JOIN sales_log sl ON ol.transactionNo = sl.transactionNo
        WHERE ol.transactionNo = ?";

        $stmt = mysqli_prepare($dbconn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $transactionNo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result || mysqli_num_rows($result) == 0) {
        die('Transaction not found.');
        }

        $receiptDetails = [];
        while ($row = mysqli_fetch_assoc($result)) {
        $receiptDetails[] = $row;

        }
            mysqli_stmt_close($stmt);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="receipt.css">
    <title>Order Receipt</title>
    <style>
         .sidebar {
            display: none;
        }
        .sidebar main {
            margin-left: 0;
        }
         .user-info{
            display: none;
        }
        
            main {
                margin-left: 0;
                padding: 20px;
            }
        
    </style>
</head>
<body>
<div class="receipt-container">
        <div class="header">
            <img src="logo.png" alt="Company Logo" class="logo">
            <h1>Dato's Bakery Shop</h1>
        </div>
        <div class="details">
            <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transactionNo); ?></p>
            <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($receiptDetails[0]['custName']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($receiptDetails[0]['paymentDate']); ?></p>
        </div>
        <div class="order-details">
            <h3>Order Details</h3>
            <?php foreach ($receiptDetails as $details): ?>
                <?php if (strpos($details['dessertID'], 'CA') === 0): // If dessertID starts with 'CA', it's a cake ?>
                    <p>Dessert Name: <?php echo htmlspecialchars($details['dessertName']); ?></p>
                    <p>Shape: <?php echo htmlspecialchars($details['shapeReq']); ?></p>
                    <p>Decoration: <?php echo htmlspecialchars($details['decorationReq']); ?></p>
                    <p>Special Request: <?php echo htmlspecialchars($details['request']); ?></p>
                    <p>Quantity: <?php echo htmlspecialchars($details['cake_quantity']); ?></p>
                    <p>Price: RM <?php echo number_format($details['dessertPrice'], 2); ?></p>

                <?php elseif (strpos($details['dessertID'], 'PA') === 0): // If dessertID starts with 'PA', it's a pastry ?>
                    <p>Dessert Name: <?php echo htmlspecialchars($details['dessertName']); ?></p>
                    <p>Quantity per Box: <?php echo htmlspecialchars($details['qtyPerBoxReq']); ?></p>
                    <p>Additional Topping: <?php echo htmlspecialchars($details['addToppingReq']); ?></p>
                    <p>Quantity: <?php echo htmlspecialchars($details['pastry_quantity']); ?></p>
                    <p>Price: RM <?php echo number_format($details['dessertPrice'], 2); ?></p>
                <?php endif; ?>
                <hr>
            <?php endforeach; ?>
        </div>
        <div class="service-details">
            <h3>Service Details</h3>
            <p>Service: <?php echo htmlspecialchars($receiptDetails[0]['serviceName']); ?></p>
            <?php 
                if ($receiptDetails[0]['serviceName'] === "delivery") {
                    echo "<p>Delivery Address: " . htmlspecialchars($receiptDetails[0]['serviceDesc']) . "</p>";
                } else if ($receiptDetails[0]['serviceName'] === "pickup") {
                    echo "<p>Service Description: " . htmlspecialchars($receiptDetails[0]['serviceDesc']) . "</p>";
                }
            ?>
        </div>
        <div class="total-details">
            <h3>Total Orders</h3>
            <p>Total Price: RM <?php echo number_format($receiptDetails[0]['amount'], 2); ?></p>
        </div>
        <div class="buttons">
            <button class="button-19" onclick="printPage()">Print this page</button>

            <?php if(isset($_SESSION['username']) && $_SESSION['username'] != "Administrator"){ ?>
            <button class="button" type="button" onclick="window.location = 'product.php';">Done</button>

            <?php } else if(isset($_SESSION['username']) && $_SESSION['username'] == "Administrator"){ ?>
            <button class="back-button" type="button" onclick="window.history.back();">Back</button>
            <?php } ?>
        </div>
    </div>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>
</html>
