<?php
session_start();
## include db connection file 
include('dbconn.php');
if(isset($_POST['Submit'])){
	## capture values from HTML form 
	$username = $_POST['username'];
	$password = $_POST['password'];
        ## verify if the values of username and password are correct
        if($username == "NurinIman" && $password == "admin1234."){
            ## set the session’s username as administrator
            $_SESSION['username'] = "Administrator";
            ## directly call / open the page for menuAdmin 
            header("Location: adminDashboard.php");
            exit;
        }
        
        ##If the user is not an admin, then , call find the user’s information
        else{ 
            ## execute SQL command 
                $sql = "SELECT * FROM customer WHERE custUsername = '$username' AND custPassword = '$password'";
                $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
                $numRow = mysqli_num_rows($query);

                ##to verify the user’s information exist in the db
                if($numRow == 0){  ##if the user’s record is not exist
                    echo "<script>alert('Invalid Username or Password. Please try again.')
                    window.location = 'login.php';</script>";
                    exit;
                }else{
                    ##retrieve the user’s infor detail 
                    $record = mysqli_fetch_assoc($query);
                    
                    ##ser the session name with the current user’s info
                    $_SESSION['username'] = $record['custUsername'];
                    ##directly open the page menu 
                    header("Location: product.php");
                    
                }
        }
}
?>
