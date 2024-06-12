<?php
session_start();
include('dbconn.php');

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Assuming the user logs in and their username is fetched from the database
    if (isset($_SESSION['username'])) {
        $custUsername = $_SESSION['username'];

        $sql = "SELECT custID FROM customer WHERE custUsername = '$custUsername'";
        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("s", $custUsername);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $custID = $row['custID'];
        }
    }

    // Generate a unique orderID for order_cake
    $orderID_cake = uniqid('CAKE');

    foreach ($_SESSION['cart'] as $item) {
        $dessertID = $item['dessertID'];
        $shape = $item['shape'];
        $decoration = $item['decoration'];
        $specialRequest = $item['specialRequest'];
        $orderDate = date('Y-m-d'); // Current date

        // Insert into order_cake
        $sqlCake = "INSERT INTO order_cake (orderID, dessertID, shapeReq, decorationReq, request) VALUES ('$orderID_cake', '$dessertID', '$shape', '$decoration', '$specialRequest')";
        $stmtCake = mysqli_prepare($dbconn, $sqlCake);
        mysqli_stmt_bind_param($stmtCake, "sssss", $orderID_cake, $dessertID, $shape, $decoration, $specialRequest);
        mysqli_stmt_execute($stmtCake);

        // Insert into order_log
        // Use the same $orderID_cake generated for order_cake
        $serviceID = 'S001'; // Replace with the actual service ID
        $transactionNo = 'T001'; // Replace with the actual transaction number
        $quantity = 1; // Replace with the actual quantity

        $sqlLog = "INSERT INTO order_log (custID, dessertID, orderID, orderDate, orderStatus, serviceID, transactionNo, quantity) VALUES (?, ?, ?, ?, 'Pending', ?, ?, ?)";
        $stmtLog = mysqli_prepare($dbconn, $sqlLog);
        mysqli_stmt_bind_param($stmtLog, "ssssssi", $custID, $dessertID, $orderID_cake, $orderDate, $serviceID, $transactionNo, $quantity);
        mysqli_stmt_execute($stmtLog);
    }

    // Clear the session cart
    unset($_SESSION['cart']);

    // Redirect to a success page
    header("Location: product.php");
    exit();
} else {
    // Redirect to an error page
    header("Location: error.php");
    exit();
}
?>