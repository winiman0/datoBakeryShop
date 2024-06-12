<?php 
$title="Orders";
include("adminNav.php");
include("dbconn.php");
include("font.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateStatus'])) {
    $custID = $_POST['custID'];
    $orderID = $_POST['orderID'];
    $dessertID = $_POST['dessertID'];
    $newStatus = $_POST['status'];
    $paymentDate = $_POST['date'];
    $transactionNo = $_POST['transactionNo'];

    $sql = "UPDATE order_log o
    JOIN customer c ON o.custID = c.custID
    LEFT JOIN order_cake oc ON o.orderID = oc.orderID
    LEFT JOIN order_pastry op ON o.orderID = op.orderID
    JOIN sales_log p ON p.transactionNo = o.transactionNo
    SET o.orderStatus = '$newStatus'
    WHERE c.custID = '$custID' AND o.orderID = '$orderID' AND p.transactionNo = '$transactionNo'";

    if (mysqli_query($dbconn, $sql)) {
        echo "Order status updated successfully.";
    } else {
        echo "Error updating record: " . mysqli_error($dbconn);
    }
}

$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($dbconn, $_GET['search']);
}

$sql = "SELECT p.transactionNo, p.paymentDate, c.custID, c.custName, o.orderID, o.dessertID, p.amount, o.orderStatus
        FROM sales_log p
        JOIN order_log o ON p.transactionNo = o.transactionNo
        LEFT JOIN order_cake oc ON o.orderID = oc.orderID
        LEFT JOIN order_pastry op ON o.orderID = op.orderID
        JOIN customer c ON o.custID = c.custID
        WHERE p.transactionNo LIKE '%$search%' 
        OR o.orderID LIKE '%$search%' 
        OR c.custName LIKE '%$search%'
        ORDER BY 
            CASE 
                WHEN o.orderStatus = 'pending' THEN 1
                WHEN o.orderStatus = 'progress' THEN 2
                WHEN o.orderStatus = 'delivered' THEN 3
                ELSE 4
            END, 
            p.transactionNo, o.orderID";
$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" type="text/css" href="adOrders.css">
</head>
<body>
    <main>
        <h1 class="head1 montserrat-monty">
            <?php 
                $numRow = mysqli_num_rows($query); 
                echo $numRow . " Orders Recorded"; 
            ?>
        </h1>
        <div class="search-container">
        <form method="get" action="">
            <div><input type="text" id="search" name="search" placeholder="Search by Transaction No, Order ID, or Name" value="<?php echo htmlspecialchars($search); ?>"></div>
            <div><button class="button-45" type="submit">Search</button></div>
        </form>
        </div>
        <div class="container">
            <div class="table-container">
                <table id="orderTable">
                    <thead>
                        <tr> 
                            <th>BIL</th>
                            <th>TRANSACTION NO</th>
                            <th>ORDER ID</th>
                            <th>NAME</th>
                            <th>TOTAL PRICE</th>
                            <th colspan=2><label for="status"></label>STATUS</th>
                            <th>RECEIPT</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $index = 1;
                        
                        while ($row = mysqli_fetch_assoc($query)): 
                            // Apply class based on status
                            $statusClass = '';
                            switch ($row['orderStatus']) {
                                case 'pending':
                                    $statusClass = 'status-pending';
                                    break;
                                case 'progress':
                                    $statusClass = 'status-progress';
                                    break;
                                case 'delivered':
                                    $statusClass = 'status-delivered';
                                    break;
                            }
                            // Debugging output
                            //echo "<script>console.log('Order ID: " . htmlspecialchars($row['orderID']) . " - Status Class: " . $statusClass . "');</script>";
                    ?>
                            <tr class="data poppins-regular <?php echo $statusClass; ?>" style="background-color: <?php echo ($statusClass == 'status-pending') ? '#F7DBD2' : (($statusClass == 'status-progress') ? '#f3cabc' : '#efb8a7'); ?>;">
                                <td><?php echo $index++; ?></td>
                                <td><?php echo htmlspecialchars($row['transactionNo']);?></td>
                                <td><?php echo htmlspecialchars($row['orderID']); ?></td>
                                <td><?php echo htmlspecialchars($row['custName']);?></td>
                                <td><?php echo 'RM ' . htmlspecialchars($row['amount']); ?></td>
                                <td><form method="post" action="">
                                    <select id="status" name="status">
                                        <option value="progress" <?php echo htmlspecialchars($row['orderStatus']=='progress') ? 'selected' : ''; ?>>In-Progress</option>
                                        <option value="pending" <?php echo htmlspecialchars($row['orderStatus']=='pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="delivered" <?php echo htmlspecialchars($row['orderStatus']=='delivered') ? 'selected' : ''; ?>>Delivered</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="custID" value="<?php echo htmlspecialchars($row['custID']); ?>">
                                    <input type="hidden" name="dessertID" value="<?php echo htmlspecialchars($row['dessertID']); ?>">
                                    <input type="hidden" name="date" value="<?php echo htmlspecialchars($row['paymentDate']); ?>">
                                    <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($row['orderID']); ?>">
                                    <input type="hidden" name="transactionNo" value="<?php echo htmlspecialchars($row['transactionNo']); ?>">
                                    <button class="button-82-pushable" type="submit" name="updateStatus">
                                    <span class="button-82-shadow"></span>
                                    <span class="button-82-edge"></span>
                                    <span class="button-82-front text">Update</span>
                                </button>
                                </form></td>
                                <td>
                                    <button class="button-82-pushable" onclick="receipt('<?php echo $row['transactionNo']; ?>')">
                                        <span class="button-82-shadow"></span>
                                        <span class="button-82-edge"></span>
                                        <span class="button-82-front text">View</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        function receipt(transactionNo) {
            window.location.href = 'receipt.php?transactionNo=' + transactionNo;
        }
    </script>
</body>
</html>
