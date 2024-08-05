<?php
$title = "Cart";
include("custNav.php");
include('font.php');

// Initialize grand total
$grandTotal = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store grand total in session
    $_SESSION['grandTotal'] = $_POST['grandTotal'];
    // Use meta refresh for redirection
    echo '<meta http-equiv="refresh" content="0;url=delivery.php">';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="cart.css">
    <title>Cart</title>
    <style>
        .content {
            margin-left: 500px;
            margin-top: 15px;
            padding: 20px;
        }
        .cart-container {
            width: 60%;
            margin-left: 450px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .total-row {
            font-weight: bold;
        }
        .remove-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .confirm-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            display: block;
            margin: 20px auto;
            text-align: center;
        }
    </style>
    <script>
        function removeItem(index) {
            if (confirm("Are you sure you want to remove this item from the cart?")) {
                window.location.href = 'removeFromCart.php?index=' + index;
            }
        }
    </script>
</head>
<body>
    <div class="cart-container">
        <h1>CHECKLIST</h1>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <h2>Cakes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Dessert ID</th>
                        <th>Shape</th>
                        <th>Decoration</th>
                        <th>Quantity</th>
                        <th>Special Request</th>
                        <th>Total Price (RM)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grandTotal = 0;
                    foreach ($_SESSION['cart'] as $index => $item):
                        if (isset($item['dessertType']) && $item['dessertType'] === 'cake'):
                            $grandTotal += $item['totalPrice'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['dessertID']); ?></td>
                            <td><?php echo htmlspecialchars($item['shape']); ?></td>
                            <td><?php echo htmlspecialchars($item['decoration']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($item['specialRequest']); ?></td>
                            <td><?php echo htmlspecialchars($item['totalPrice']); ?></td>
                            <td><button class="remove-button" onclick="removeItem(<?php echo $index; ?>)">Remove</button></td>
                        </tr>
                    <?php endif; endforeach; ?>
                </tbody>
            </table>

            <h2>Pastries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Dessert ID</th>
                        <th>Topping</th>
                        <th>Quantity Per Box</th>
                        <th>Quantity</th>
                        <th>Total Price (RM)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION['cart'] as $index => $item):
                        if (isset($item['dessertType']) && $item['dessertType'] === 'pastry'):
                            $grandTotal += $item['totalPrice'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['dessertID']); ?></td>
                            <td><?php echo htmlspecialchars($item['addTopping']); ?></td>
                            <td><?php echo htmlspecialchars($item['qtyPerBox']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($item['totalPrice']); ?></td>
                            <td><button class="remove-button" onclick="removeItem(<?php echo $index; ?>)">Remove</button></td>
                        </tr>
                    <?php endif; endforeach; ?>
                </tbody>
            </table>

            <table>
                <tr class="total-row">
                    <td colspan="5">Grand Total</td>
                    <td>RM <?php echo htmlspecialchars($grandTotal); ?></td>
                </tr>
            </table>
            <form method="post" action="">
                <input type="hidden" name="grandTotal" value="<?php echo htmlspecialchars($grandTotal); ?>">
                <button class="confirm-button" type="submit">Check Out</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>