<?php 
    $title = "Receipt";
    include("custNav.php");
    include("dbconn.php");
    include("font.php");

    $transactionNo = isset($_GET['transactionNo']) ? $_GET['transactionNo'] : '';

    if ($transactionNo == '') {
        die('Invalid transaction number.');
    }

    // Query the database for details related to the transaction
    $sql = "SELECT c.*, ci.*, ol.*, op.*, oc.*, d.*, s.*, sl.*
            FROM customer c
            JOIN customer_info ci ON c.custID = ci.custID
            JOIN order_log ol ON c.custID = ol.custID
            LEFT JOIN order_pastry op ON ol.orderID = op.orderID AND ol.dessertID = op.dessertID
            LEFT JOIN order_cake oc ON ol.orderID = oc.orderID AND ol.dessertID = oc.dessertID
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
        .button-19 {
            /* Button styling */
        }
        .hide-sidebar .sidebar {
            display: none;
        }
        .hide-sidebar main {
            margin-left: 0;
        }
        .hide-sidebar .user-info{
            display: none;
        }
        @media print {
            @page {
                size: portrait;
            }
            .sidebar {
                display: none;
            }
            main {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Order Receipt</h2>
        <div class="order-details">
            <h3>Order Details</h3>
            <p>Customer Name: <?php echo htmlspecialchars($receiptDetails[0]['custName']); ?></p>
            <?php foreach ($receiptDetails as $details): 
                ?>
                <p>Dessert Name: <?php echo htmlspecialchars($details['dessertName']); ?></p>
                <p>Shape: <?php echo htmlspecialchars($details['shapeReq']); ?></p>
                <p>Decoration: <?php echo htmlspecialchars($details['decorationReq']); ?></p>
                <p>Special Request: <?php echo htmlspecialchars($details['request']); ?></p>
                <p>Price: RM <?php echo number_format($details['dessertPrice'], 2); ?></p>
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
        <div class="transaction-details">
            <h3>Transaction Details</h3>
            <p>Transaction No: <?php echo htmlspecialchars($transactionNo); ?></p>
        </div>
        <div class="total-details">
            <h3>Total Details</h3>
            <p>Total Price: RM <?php echo number_format($receiptDetails[0]['amount'], 2); ?></p>
        </div>
        <div class="buttons">
            <button class="back-button" type="button" onclick="window.history.back();">Back</button>
            <button class="button-19" onclick="printPage()">Print this page</button>
        </div>
    </div>
    <script>
        function printPage() {
            document.body.classList.add('hide-sidebar');
            window.print();
            document.body.classList.remove('hide-sidebar');
        }
    </script>
</body>
</html>
