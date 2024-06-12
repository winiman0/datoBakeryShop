<?php 
    include("adminNav.php");
    include("dbconn.php");
    include("font.php");

    $sqlDes = "SELECT * FROM dessert WHERE dessertStatus = 'AVAILABLE'";
	$queryDes = mysqli_query($dbconn, $sqlDes) or die("Error: " . mysqli_error($dbconn));
    $numDessert = mysqli_num_rows($queryDes);

    $sqlOrder = "SELECT * FROM order_log";
	$queryOr = mysqli_query($dbconn, $sqlOrder) or die("Error: " . mysqli_error($dbconn));
    $numOrders = mysqli_num_rows($queryOr);

    $sqlSales = "SELECT SUM(amount) AS totalSales FROM sales_log";
	$querySales = mysqli_query($dbconn, $sqlSales) or die("Error: " . mysqli_error($dbconn));
    $rowS = mysqli_fetch_assoc($querySales);
    $totalSales = $rowS['totalSales'];

    // Fetch data from the database
    $sql = "SELECT c.custID, p.transactionNo, o.orderStatus, p.amount, p.paymentDate, p.paymentMethod
            FROM order_log o 
            JOIN customer c ON c.custID = o.custID
            JOIN sales_log p ON p.transactionNo = o.transactionNo
            LIMIT 5";
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="adminDashboard.css">
</head>
<body>
    <main>
        <div class="container"> 
            <div class="box">
                <a href="adOrders.php">
                <img src = "image/image-removebg-preview (1).png" alt="Icon for Orders" class="icon">
                <div class="text-content">
                <h2 class="tl montserrat-monty">ORDERS</h2>
                <p class="desc"><?php echo htmlspecialchars($numOrders);?> </p></div>
                </a>
                  
            </div>
            <div class="box">
                <a href="productAdmin.php">
                <img src = "image/image-removebg-preview (6).png"  alt="Icon for Available Products" class="icon">
                <div class="text-content">
                <h2 class="tl montserrat-monty">PRODUCT<br>AVAILABLE</h2>
                <p class="desc"> <?php echo htmlspecialchars($numDessert);?> </p>
                </div>
                </a>
            </div>
            <div class="box">
                <a href="report.php">
                <img src = "image/image-removebg-preview (7).png"  alt="Icon for Income" class="icon">
                <div class="text-content">
                <h2 class="tl montserrat-monty">INCOME</h2>
                <p class="desc"><?php echo 'RM ' . htmlspecialchars($totalSales);?></p>
                </div>
                </a>
            </div>
            <br><br>
        </div>
        <div class="container1">
            <h1 class="headee tenor-sans-regular">TRANSACTION</h1><br>
            <div class="table-container">
                <table id="transTable">
                    <thead>
                        <tr> 
                            <th>CUSTOMER ID</th>
                            <th>TRANSACTION NO</th>
                            <th>STATUS</th>
                            <th>TOTAL</th>
                            <th>METHOD</th>
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
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <a href="transaction.php" class="link"> See more >> </a>
            </div>
        </div>
    </main> 
</body>
</html>