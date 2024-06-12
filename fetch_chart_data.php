<?php
include("dbconn.php");

// Fetch and decode the input data
$input = json_decode(file_get_contents("php://input"), true);
$start_date = $input['start_date'] ?? null;
$end_date = $input['end_date'] ?? null;
$custState = $input['state'] ?? null;

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

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($chartData);
?>
