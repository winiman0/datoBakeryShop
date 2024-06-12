<?php
include("custNav.php");
include("dbconn.php");
include("font.php");
$custUsername = $_SESSION["username"];
$selectUser = "SELECT * FROM customer WHERE custUsername = '$custUsername'";
$executeUser = mysqli_query($dbconn, $selectUser);
$resultUser = mysqli_fetch_assoc($executeUser);

$userID = $resultUser["custID"];

// Initialize variables
$custName = '';
$custEmail = '';
$custPhoneNo = '';
$custAddress = '';
$custState = '';
$custPostcode = '';

// Fetch existing customer information
$sql = "SELECT *
        FROM customer c
        LEFT JOIN customer_info ci ON c.custID = ci.custID
        WHERE c.custID = '$userID'";

$query = mysqli_query($dbconn, $sql) or die ("Error: " . mysqli_error($dbconn));
$row_count = mysqli_num_rows($query);

if ($row_count == 0) {
    echo "No record found";
} else {
    $r = mysqli_fetch_assoc($query);
    $custName = $r['custName'] ?? '';
    $custEmail = $r['custEmail'] ?? '';
    $custPhoneNo = $r['custPhoneNo'] ?? '';
    $custAddress = $r['custAddress'] ?? '';
    $custState = $r['custState'] ?? '';
    $custPostcode = $r['custPostcode'] ?? '';
}

if (isset($_POST['update'])) {
    $custPhoneNo = $_POST['custPhoneNo'] ?? '';
    $custAddress = $_POST['custAddress'] ?? '';
    $custState = $_POST['custState'] ?? '';
    $custPostcode = $_POST['custPostcode'] ?? '';

    // Apply sql statement to verify the specified info first
    $sqlSel = "SELECT * FROM customer_info WHERE custID= '$userID'";
    $querySel = mysqli_query($dbconn, $sqlSel) or die ("Error: " . mysqli_error($dbconn));
    $rowSel = mysqli_num_rows($querySel);

    // Checking if the record exists
    if ($rowSel == 0) {
        $sqlInsert = "INSERT INTO customer_info (custID, custPhoneNo, custAddress, custState, custPostcode) 
                      VALUES ('" . mysqli_real_escape_string($dbconn, $userID) . "', 
                              '" . mysqli_real_escape_string($dbconn, $custPhoneNo) . "', 
                              '" . mysqli_real_escape_string($dbconn, $custAddress) . "', 
                              '" . mysqli_real_escape_string($dbconn, $custState) . "', 
                              '" . mysqli_real_escape_string($dbconn, $custPostcode) . "')";
        mysqli_query($dbconn, $sqlInsert) or die("Error: " . mysqli_error($dbconn));
    } else {
        // Execute SQL UPDATE command
        $sqlUpdate = "UPDATE customer_info SET custPhoneNo = '" . mysqli_real_escape_string($dbconn, $custPhoneNo) . "',
                                               custAddress= '" . mysqli_real_escape_string($dbconn, $custAddress) . "',
                                               custState = '" . mysqli_real_escape_string($dbconn, $custState) . "',
                                               custPostcode = '" . mysqli_real_escape_string($dbconn, $custPostcode) . "' 
                      WHERE custID = '" . mysqli_real_escape_string($dbconn, $userID) . "'";
        mysqli_query($dbconn, $sqlUpdate) or die ("Error: " . mysqli_error($dbconn));
    }
    echo "<script>alert('Data has been updated.'); window.location = 'profile.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <main>
        <h1>Hi, <?php echo htmlspecialchars($custUsername); ?>!</h1>
        <div class="container-fluid">
            <!-- First Column: Contact Details -->
            <div class="box-container">
                <p class="box-title">CONTACT DETAILS:</p>
                <div class="box">
                    <form action="" method="post">
                        <input type="hidden" name="custID" value="<?= htmlspecialchars($userID); ?>">
                        <div class="input-container">
                            <label for="phone" class="label">Phone:</label>
                            <input type="text" id="phone" name="custPhoneNo" value="<?php echo htmlspecialchars($custPhoneNo); ?>">
                        </div>
                        <div class="input-container">
                            <label for="address" class="label">Address:</label>
                            <input type="text" id="address" name="custAddress" value="<?php echo htmlspecialchars($custAddress); ?>">
                        </div>
                        <div class="input-container">
                            <label for="postCode" class="label">Postcode:</label>
                            <input type="text" id="postCode" name="custPostcode" value="<?php echo htmlspecialchars($custPostcode); ?>">
                        </div>
                        <div class="input-container">
                            <label for="state" class="label">State:</label>
                            <select id="state" name="custState">
                                <option value="" disabled>Select State</option>
                                <?php
                                $states = array("Johor", "Kedah", "Kelantan", "Malacca", "Negeri Sembilan", "Pahang", "Perak", "Perlis", "Penang", "Sabah", "Sarawak", "Selangor", "Terengganu", "WP Kuala Lumpur", "WP Labuan", "WP Putrajaya");
                                foreach ($states as $state) {
                                    echo "<option value='$state' " . ($custState == $state ? "selected" : "") . ">$state</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="update" class="button-19">Update</button>
                    </form>
                </div>
            </div>

            <!-- Second Column: Account and Contact Details -->
            <div class="box-container">
                <p class="box-title">ACCOUNT DETAILS:</p>
                <div class="box box-contact">
                    <label class="label">Username : <?= htmlspecialchars($custUsername); ?></label>
                    <label class="label">Full Name : <?= htmlspecialchars($custName); ?></label>
                    <label class="label">Email : <?= htmlspecialchars($custEmail); ?></label>
                </div>

                <p class="box-title">CONTACT DETAILS:</p>
                <div class="box box-contact">
                    <label class="label">Phone : <?= htmlspecialchars($custPhoneNo); ?></label>
                    <label class="label">Address: <?= htmlspecialchars($custAddress); ?></label>
                    <label class="label">Post Code: <?= htmlspecialchars($custPostcode); ?></label>
                    <label class="label">State : <?= htmlspecialchars($custState); ?></label>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<?php
// Close database connection
$dbconn->close();
?>