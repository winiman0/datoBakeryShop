<?php
##include db connection file 
include("dbconn.php");
	

##If the update button is clicked 
if(isset($_POST['update'])){
	
	##	capture values from HTML form 
    $custID = $_POST['custID'];
	$custPhoneNo = $_POST['custPhoneNo'];
	$custAddress = $_POST['custAddress'];
	$custState = $_POST['custState'];
	$custPostCode = $_POST['custPostCode'];
	

	# apply sql statement to verify the specified info first
	$sqlSel = "SELECT * FROM customer_info WHERE custID= '$custID'";
	$querySel = mysqli_query($dbconn, $sqlSel) or die ("Error: " . mysqli_error($dbconn));
	$rowSel = mysqli_num_rows($querySel);

	##checking if the record exist
	if($rowSel == 0){
			$sqlInsert = "INSERT INTO customer_info (custID, custPhoneNo, custAddress, custState, custPostCode) 
			VALUES ('" . mysqli_real_escape_string($dbconn, $custID) . "', 
					'" . mysqli_real_escape_string($dbconn, $custPhoneNo) . "', 
					'" . mysqli_real_escape_string($dbconn, $custAddress) . "', 
					'" . mysqli_real_escape_string($dbconn, $custState) . "', 
					'" . mysqli_real_escape_string($dbconn, $custPostCode) . "')";

		mysqli_query($dbconn, $sqlInsert) or die("Error: " . mysqli_error($dbconn));
	}
	else{
	##reenter everything back
	## execute SQL UPDATE command 
	$sqlUpdate = "UPDATE customer_info SET custPhoneNo = '" . $custPhoneNo . "',
	                                       custAddress= '" . $custAddress . "',
	                                       custState = '" . $custState . "',
                                           custPostCode = '" . $custPostCode . "' where custID = '" . $custID . "'";
	
	echo"<br>";

	mysqli_query($dbconn, $sqlUpdate) or die ("Error: " . mysqli_error($dbconn));
	/* display a message */

	## trouble shooot:
	## echo $sqlUpdate;
	##;
	##
	
	
	}
}
echo "<script>alert('Data have been updated.'); window.location = 'users.php';</script>";
echo '<button class="back-button" type="button" onclick="window.history.back();">Back</button>';
?>
