<?php 
session_start();
include("dbconn.php");

// Function to generate a random order ID starting with "C000"
function generateOrderID() {
    return 'OR' . mt_rand(0001, 9999);
}

// Retrieve dessert details from the submitted form
$dessertID = isset($_POST['dessertID']) ? $_POST['dessertID'] : '';
$dessertType = isset($_POST['dessertType']) ? $_POST['dessertType'] : '';
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
$totalPrice = 0;
$orderID = generateOrderID();

if ($dessertType === 'cake') {
    $shape = isset($_POST['shape']) ? $_POST['shape'] : '';
    $decoration = isset($_POST['decoration']) ? $_POST['decoration'] : '';
    $specialRequest = isset($_POST['specialRequest']) ? $_POST['specialRequest'] : '';

    // Fetch the price of the dessert from the database
    $sql = "SELECT dessertPrice FROM dessert WHERE dessertID = ?";
    $stmt = mysqli_prepare($dbconn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $dessertID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $dessertPrice = $row ? $row['dessertPrice'] : 0;

    // Calculate the total price
    $totalPrice = number_format($dessertPrice * $quantity, 2);

    // Store the data in a session array
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the new set of data to the session array
    $_SESSION['cart'][] = [
        'orderID' => $orderID,
        'dessertID' => $dessertID,
        'shape' => $shape,
        'decoration' => $decoration,
        'quantity' => $quantity,
        'specialRequest' => $specialRequest,
        'dessertType' => 'cake',
        'totalPrice' => $totalPrice
    ];
} elseif ($dessertType === 'pastry') {
    $qtyPerBox = isset($_POST['qtyPerBox']) ? $_POST['qtyPerBox'] : '';
    $addTopping = isset($_POST['addTopping']) ? $_POST['addTopping'] : '';

    // Fetch the price of the dessert from the database
    $sql = "SELECT dessertPrice FROM dessert WHERE dessertID = ?";
    $stmt = mysqli_prepare($dbconn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $dessertID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $dessertPrice = $row ? $row['dessertPrice'] : 0;

    // Calculate the total price
    $totalPrice = number_format($dessertPrice * $quantity * $qtyPerBox, 2);

    // Store the data in a session array
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the new set of data to the session array
    $_SESSION['cart'][] = [
        'orderID' => $orderID,
        'dessertID' => $dessertID,
        'qtyPerBox' => $qtyPerBox,
        'addTopping' => $addTopping,
        'quantity' => $quantity,
        'dessertType' => 'pastry',
        'totalPrice' => $totalPrice
    ];
} else {
    echo json_encode(["status" => "error", "message" => "Invalid dessert type."]);
    exit();
}

// Calculate and store the grand total in session
$grandTotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $grandTotal += $item['totalPrice'];
}
$_SESSION['grandTotal'] = $grandTotal;

// Return a success response with the order ID
echo json_encode(["status" => "success", "message" => "Item added to cart", "orderID" => $orderID, "grandTotal" => $grandTotal]);
exit();
?>