<?php
$title = "Profile";
include("dbconn.php");
include("adminNav.php");
include("font.php");

#receive values
#in the viewData.php
$custID = isset($_REQUEST['custID']) ? $_REQUEST['custID'] : ''; #receive from the link : updateUsers.php?custID=".$row["PARK_CODE"]

if ($custID == '') {
    die('Invalid customer ID.');
}

#escape and quote the custID
$custID = mysqli_real_escape_string($dbconn, $custID);

#initialize variables
$custName = '';
$custEmail = '';
$custUsername = '';
$custPhoneNo = '';
$custAddress = '';
$custState = '';
$custPostCode = '';

#create SQL statement to retrieve data from the customer table
$sql = "SELECT *
        FROM customer c
        JOIN customer_info ci ON c.custID = ci.custID
        WHERE c.custID = '$custID'";

#execute SQL statement that assigned to the $sql variable
$query = mysqli_query($dbconn, $sql) or die ("Error: " . mysqli_error($dbconn));

#get the number of records from the customer table
$row = mysqli_num_rows($query);

if($row == 0){
    echo "No record found";
}
else{ 
    #since the records exist in the table, 
    #then fetch the record of each column
    $r = mysqli_fetch_assoc($query);
    $custName = $r['custName'] ?? ''; #fetch a record value 
    $custEmail = $r['custEmail'] ?? ''; #fetch a record value
    $custUsername = $r['custUsername'] ?? ''; #fetch a record value 
    $custPhoneNo = $r['custPhoneNo'] ?? ''; #fetch a record value
    $custAddress = $r['custAddress'] ?? ''; #fetch a record value 
    $custState = $r['custState'] ?? ''; #fetch a record value 
    $custPostCode = $r['custPostCode'] ?? '';

    echo '<h2 class= "name montserrat-monty">Hi, ' . htmlspecialchars($custName) . '</h2>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Information</title>
    <link rel="stylesheet" type="text/css" href="updateUsers.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const states = [
                "Johor", "Kedah", "Kelantan", "Malacca", "Negeri Sembilan",
                "Pahang", "Penang", "Perak", "Perlis", "Sabah",
                "Sarawak", "Selangor", "Terengganu", "Kuala Lumpur",
                "Labuan", "Putrajaya"
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
        });
    </script>
</head>
<body>
    <main>
    <form action= "processUpd.php" method = "post">
    <input type="hidden" name="custID" value="<?php echo htmlspecialchars($custID); ?>">
    
    <table class="conUp">
        <tr>
            <th colspan=3>User Information</th>    
        </tr>
        <tr>
            <td>PHONE</td>
            <td>:</td>
            <td><input type="text" name="custPhoneNo" value="<?php echo htmlspecialchars($custPhoneNo); ?>"></td>
        </tr>
        <tr>
            <td>ADDRESS</td>
            <td>:</td>
            <td><input type="text" name="custAddress" value="<?php echo htmlspecialchars($custAddress); ?>"></td>
        </tr>
        <tr>
            <td>POSTCODE</td>
            <td>:</td>
            <td><input type="text" name="custPostCode" value="<?php echo htmlspecialchars($custPostCode); ?>"></td>
        </tr>
        <tr>
            <td><label for="state">STATE</label></td>
            <td>:</td>
            <td><select id="state" name="custState">
                        <option value="" <?php if (empty($custState)) echo 'selected'; ?>>Select a state</option>
            </select>
        </td>
        </tr>
        <tr>
            <td colspan=3 class="buttonUp">
            <button class="button-82-pushable" type="submit" name="update">
                <span class="button-82-shadow"></span>
                <span class="button-82-edge"></span>
                <span class="button-82-front text">Update</span>
            </button>
             </td>
        </tr>
    </table>
</form>  
</main>
</body>
</html>
