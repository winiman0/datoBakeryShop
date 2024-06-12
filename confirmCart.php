<?php
    $title = 'Confirm Order';
    include('custNav.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Cart</title>
    <style>
        /* Style adjustments to prevent table from being behind custNav.php */
        .content {
        margin-left: 1500px;
        margin-top: 15px;
        padding: 20px;
        }
        .cart-container {
            width: 60%;
            margin-left: 450px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #white;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Header content from custNav.php -->
    </div>
    <h1>Confirm Your Order</h1>
    <form action="confrimOrder.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Dessert ID</th>
                    <th>Shape</th>
                    <th>Decoration</th>
                    <th>Special Request</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $index => $item) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($item['dessertID']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['shape']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['decoration']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['specialRequest']) . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <button type="submit">Confirm ---------------------------------------------------------------------------------Order</button>
    </form>
    <form action="clearCart.php" method="post">
        <button type="submit">Clear-----------------------------------------------------------------------------Cart</button>
    </form>
</body>
</html>
