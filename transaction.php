<?php 
$title="Transaction";
// Include your necessary files
include("adminNav.php");
include("dbconn.php");
include("font.php");


// Fetch data from the database
$sql = "SELECT c.custID, p.transactionNo, o.orderStatus, p.amount, p.paymentDate, p.paymentMethod
        FROM order_log o 
        JOIN customer c ON c.custID = o.custID
        JOIN sales_log p ON p.transactionNo = o.transactionNo";
$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <link rel="stylesheet" type="text/css" href="transaction.css">
</head>
<body>
    <main>
        <h1 class="head1 montserrat-monty">
            <?php 
                $numRow = mysqli_num_rows($query); 
                echo $numRow . " Transactions Recorded"; 
            ?>
        </h1>
         <div class="container">
            <div class="table-container">
                <table id="usersTable">
                    <thead>
                        <tr> 
                            <th>CUSTOMER ID</th>
                            <th>TRANSACTION NO</th>
                            <th>STATUS</th>
                            <th>TOTAL</th>
                            <th>METHOD</th>
                            <th>RECEIPT</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                       while ($row = mysqli_fetch_assoc($query)): ?>
                            <tr class="data poppins-regular">
                                <td><?php echo htmlspecialchars($row['custID']) ?: 'N/A'; ?></td>
                                <td><?php echo htmlspecialchars($row['transactionNo']) ?: 'N/A'; ?></td>
                                <td><?php echo htmlspecialchars($row['orderStatus']) ?: 'N/A'; ?></td>
                                <td><?php echo 'RM ' . htmlspecialchars($row['amount']); ?></td>
                                <td><?php echo htmlspecialchars($row['paymentMethod']) ?: 'N/A'; ?></td>
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
