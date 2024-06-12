<?php
session_start();
include("dbconn.php");

// Retrieve the updated grand total from the session
$grandTotal = $_SESSION['grandTotal'] ?? 0.00;
$amount = $_SESSION['amount'] ?? 0.00;

// Function to generate a unique order ID
function generateOrderID($dbconn) {
    do {
        $orderID = 'OR' . mt_rand(1000, 9999);
        $sql = "SELECT orderID FROM order_log WHERE orderID = ?";
        $stmt = mysqli_prepare($dbconn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $orderID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    } while (mysqli_stmt_num_rows($stmt) > 0);
    
    mysqli_stmt_close($stmt);
    return $orderID;
}

// Retrieve customer ID from session or custNav.php
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

// Retrieve cart data from session
$cart = $_SESSION['cart'] ?? [];
$serviceData = $_SESSION['serviceData'] ?? [];

// Generate a unique transaction number
function generateTransactionNo() {
    return 'T' . mt_rand(100000, 999999);
}

$transactionNo = generateTransactionNo();
$orderDate = date('Y-m-d');
$orderStatus = "pending";
$paymentType = isset($_POST['paymentType']) ? $_POST['paymentType'] : '';

// Insert into service
$serviceID = 'S' . mt_rand(1000, 9999);

// Check if the session data exists
if (isset($_SESSION['serviceData'])) {
    $serviceData = $_SESSION['serviceData'];

    // Retrieve each variable
    $service = $serviceData['service'];
    $serviceDesc = isset($serviceData['serviceDesc']) ? $serviceData['serviceDesc'] : '';
    $serviceCharge = $serviceData['serviceCharge'];
} else {
    echo 'No data of service';
    exit();
}

$sqlSer = "INSERT INTO service (serviceID, serviceName, serviceDesc) VALUES ('$serviceID', '$service', '$serviceDesc')";

// Execute the query
if ($dbconn->query($sqlSer) === TRUE) {
    echo "Service inserted successfully!";
} else {
    echo "Error: " . $sqlSer . "<br>" . $dbconn->error;
}

if ($service == "delivery") {
    $amount = $_SESSION['amount'] ?? 0.00;
} else if ($service == "pickup") {
    $amount = $_SESSION['grandTotal'] ?? 0.00;
}

// Insert into sales_log
$sqlP = "INSERT INTO sales_log (transactionNo, paymentMethod, paymentDate, amount) VALUES (?, ?, ?, ?)";
$stmtP = mysqli_prepare($dbconn, $sqlP);
mysqli_stmt_bind_param($stmtP, "sssd", $transactionNo, $paymentType, $orderDate, $amount);
mysqli_stmt_execute($stmtP);

// Process each cart item and store in database
foreach ($cart as $item) {
    $orderID = generateOrderID($dbconn); // Ensure unique orderID
    $dessertID = $item['dessertID'];
    $dessertType = $item['dessertType'];
    $quantity = $item['quantity'];
    $totalPrice = $item['totalPrice'];

    if ($dessertType == 'cake') {
        $shape = $item['shape'];
        $decoration = $item['decoration'];
        $specialRequest = $item['specialRequest'];

        // Insert into orders_cake
        $sqlC = "INSERT INTO order_cake (orderID, dessertID, shapeReq, decorationReq, request, quantity) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtC = mysqli_prepare($dbconn, $sqlC);
        mysqli_stmt_bind_param($stmtC, "sssssi", $orderID, $dessertID, $shape, $decoration, $specialRequest, $quantity);
        if (!mysqli_stmt_execute($stmtC)) {
            die("Error inserting into order_cake: " . mysqli_stmt_error($stmtC));
        }
        
    } elseif ($dessertType == 'pastry') {
        $qtyPerBox = $item['qtyPerBox'];
        $addTopping = $item['addTopping'];

        // Insert into orders_pastry
        $sqlP = "INSERT INTO order_pastry (orderID, dessertID, qtyPerBoxReq, addToppingReq, quantity) VALUES (?, ?, ?, ?, ?)";
        $stmtP = mysqli_prepare($dbconn, $sqlP);
        mysqli_stmt_bind_param($stmtP, "ssssi", $orderID, $dessertID, $qtyPerBox, $addTopping, $quantity);
        if (!mysqli_stmt_execute($stmtP)) {
            die("Error inserting into order_pastry: " . mysqli_stmt_error($stmtP));
        }
    }

    // Insert into order_log
    $sqlO = "INSERT INTO order_log (custID, dessertID, orderID, orderDate, orderStatus, transactionNo, serviceID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtO = mysqli_prepare($dbconn, $sqlO);
    mysqli_stmt_bind_param($stmtO, "sssssss", $custID, $dessertID, $orderID, $orderDate, $orderStatus, $transactionNo, $serviceID);
    if (!mysqli_stmt_execute($stmtO)) {
        die("Error inserting into order_log: " . mysqli_stmt_error($stmtO));
    }
}

// Clear cart session
unset($_SESSION['cart']);

// Redirect to product page with appropriate message
if ($paymentType === "transfer") {
    // Redirect to receipt page with transaction number
    echo "<script>
        alert('Transfer successful. Redirecting to receipt page...');
        window.location.href = 'receipt2.php?transactionNo={$transactionNo}';
    </script>";
} else if ($paymentType === "cash") {
    // Cash payment message
    echo "<script>
        alert('Please make payment at counter cafe/our delivery man. Redirecting to receipt page...');
        window.location.href = 'receipt2.php?transactionNo={$transactionNo}';
    </script>";
}
exit();
?>