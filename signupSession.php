<?php
include('dbconn.php');

function generateCustomID() {
    return 'C' . mt_rand(0001, 9999); // Generate 4 random digits and prefix with 'C'
}

function isCustIDUnique($custID, $dbconn) {
    $sql = "SELECT custID FROM customer WHERE custID = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $custID);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    
    return $num_rows === 0;
}

if(isset($_POST["username"])) {
    // Generate unique custID
    do {
        $custID = generateCustomID();
    } while (!isCustIDUnique($custID, $dbconn));
    
    $custName = ucwords(strtoupper($_POST['fullName'])); // Autocapitalize fullName properly
    $custEmail = $_POST['email'];
    $custUsername = $_POST['username'];
    $custPassword = $_POST['password'];
    
    // Insert data into database with the generated ID
    $sql = "INSERT INTO customer (custID, custName, custEmail, custUsername, custPassword) VALUES (?, ?, ?, ?, ?)";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("sssss", $custID, $custName, $custEmail, $custUsername, $custPassword);
    $result = $stmt->execute();
    
    if($result) {
        echo "<script>alert('Successfully Registered')</script>";
    } else {
        echo "<script>alert('Unsuccessfully Registered')</script>";
    }
    
    $stmt->close();
    $dbconn->close();
    
    echo "<script>window.location= 'login.php'</script>";
}
?>
