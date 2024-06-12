<?php 
$title = "Report";
include("adminNav.php");
include("dbconn.php");
include("font.php");

// Initialize query and filters
$sql = "SELECT p.transactionNo, p.paymentDate, c.custID, c.custName, o.dessertID, p.amount, o.orderStatus,
               o.serviceID, ci.custState, s.serviceName, o.orderID
        FROM sales_log p
        JOIN order_log o ON p.transactionNo = o.transactionNo
        LEFT JOIN order_cake oc ON o.orderID = oc.orderID
        LEFT JOIN order_pastry op ON o.orderID = op.orderID
        JOIN service s ON s.serviceID = o.serviceID
        JOIN customer c ON o.custID = c.custID
        JOIN customer_info ci ON c.custID = ci.custID";

$filters = [];
$start_date = $end_date = $custState = null;

// Handle form submission and add filters if needed
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $start_date = mysqli_real_escape_string($dbconn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($dbconn, $_POST['end_date']);
        
        // Add condition for date range
        $filters[] = "p.paymentDate BETWEEN '$start_date' AND '$end_date'";
    }
    if (!empty($_POST['custState'])) {
        $custState = mysqli_real_escape_string($dbconn, $_POST['custState']);
        
        // Add condition for state filter
        $filters[] = "ci.custState = '$custState'";
    }
}

// Add filters to the SQL query if there are any
if (!empty($filters)) {
    $sql .= " WHERE " . implode(" AND ", $filters);
}

// Execute the query
$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));

// Fetch data for chart
function getOrdersByMonth($dbconn, $start_date = null, $end_date = null, $state = null) {
    $sqlC = "SELECT COUNT(*) as orderCount, DATE_FORMAT(p.paymentDate, '%Y-%m') as month 
            FROM sales_log p
            JOIN order_log o ON p.transactionNo = o.transactionNo
            JOIN customer c ON o.custID = c.custID
            JOIN customer_info ci ON c.custID = ci.custID";
    $conditions = [];
    if ($start_date && $end_date) {
        $conditions[] = "p.paymentDate BETWEEN '$start_date' AND '$end_date'";
    }
    if ($state) {
        $conditions[] = "ci.custState = '$state'";
    }
    if (!empty($conditions)) {
        $sqlC .= " WHERE " . implode(" AND ", $conditions);
    }
    $sqlC .= " GROUP BY DATE_FORMAT(p.paymentDate, '%Y-%m')";
    $result = mysqli_query($dbconn, $sqlC) or die("Error: " . mysqli_error($dbconn));
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

$chartData = getOrdersByMonth($dbconn, $start_date, $end_date, $custState);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" type="text/css" href="report.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <main>
        <form action="" method="post">
            <div class="filter-container">
                <label for="start_date" class="josefin-sans-js">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">

                <label for="end_date" class="josefin-sans-js">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
            </div>
            <br><br>
            <div class="filter-container">
                <label for="state" class="josefin-sans-js">State:</label>
                <select id="state" name="custState">
                    <option value="" <?php if (empty($custState)) echo 'selected'; ?>>Select a state</option>
                </select>
                <button class="button-45" role="button" type="submit">Filter</button>
            </div>
            <br><br>
        </form>

        <div class="container">              
            <div class="chrt-container"> 
                <canvas id="myChart" width="100%" height="30%"></canvas>
            </div>  
            <div class="table-container">
                <table id="reportTable">
                    <thead>
                        <tr> 
                            <th>BIL</th>
                            <th>TRANSACTION NO</th>
                            <th>ORDER ID</th>
                            <th>NAME</th>
                            <th>STATE</th>
                            <th>TOTAL PRICE</th>
                            <th>PAYMENT DATE</th>
                            <th>SERVICE</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $index = 1;
                        while ($row = mysqli_fetch_assoc($query)): ?>
                            <tr class="data poppins-regular">
                                <td><?php echo $index++; ?></td>
                                <td><?php echo htmlspecialchars($row['transactionNo']);?></td>
                                <td><?php echo htmlspecialchars($row['orderID']);?></td>
                                <td><?php echo htmlspecialchars($row['custName']);?></td>
                                <td><?php echo htmlspecialchars($row['custState']); ?></td>
                                <td><?php echo 'RM ' . htmlspecialchars($row['amount']); ?></td>
                                <td><?php echo htmlspecialchars($row['paymentDate']); ?></td>
                                <td><?php echo htmlspecialchars($row['serviceName']);?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>  
        </div>      
        <div class="button-container">
            <button class="button-19" role="button" onclick="printPage()">Print Report</button>
        </div>
    </main>

    <script>

        
        function printPage() {
                // Hide the sidebar by adding a CSS class
                document.body.classList.add('hide-sidebar');
                // Print the page
                window.print();
                // Show the sidebar after printing by removing the CSS class
                document.body.classList.remove('hide-sidebar');
            }

        document.addEventListener('DOMContentLoaded', function() {
            const states = [
                "Johor", "Kedah", "Kelantan", "Malacca", "Negeri Sembilan",
                "Pahang", "Penang", "Perak", "Perlis", "Sabah",
                "Sarawak", "Selangor", "Terengganu", "WP Kuala Lumpur",
                "WP Labuan", "WP Putrajaya"
            ];

            const custState = "<?php echo $custState ?? ''; ?>";
            const stateSelect = document.getElementById('state');

            states.forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.text = state;
                if (state === custState) {
                    option.selected = true;
                }
                stateSelect.appendChild(option);
            });

            const ctx = document.getElementById('myChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_column($chartData, 'month')); ?>,
                    datasets: [{
                        label: 'Number of Orders',
                        data: <?php echo json_encode(array_column($chartData, 'orderCount')); ?>,
                        backgroundColor: '#A34351',
                        borderColor: '#A34351',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>
</body>
</html>

<?php
$dbconn->close();
?>
