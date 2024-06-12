<?php
include("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Capture values from HTML form
    $dessertID = $_POST['dessertID'];
    $flavourDessert = $_POST['flavourDessert'];
    $dessertName = $_POST['dessertName'];
    $dessertPrice = $_POST['dessertPrice'];
    $dessertStatus = $_POST['dessertStatus'];
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./image/" . $filename;
    $action = $_POST['action'];

    if ($action == "Update Menu") {
        $sqlSel = "SELECT * FROM dessert WHERE dessertID= '$dessertID'";
        $querySel = mysqli_query($dbconn, $sqlSel) or die ("Error: " . mysqli_error($dbconn));
        $rowSel = mysqli_fetch_assoc($querySel); // Fetch the row

        if (!$rowSel) {
            echo "<script>alert('Record does not exist.');</script>";
        } else {
            // Retain the existing image if no new image is uploaded
            if (empty($filename)) {
                $filename = $rowSel['filename']; // Retain existing filename
            }

            $sql = "UPDATE dessert 
                    SET dessertName = '$dessertName', 
                        dessertPrice = '$dessertPrice',
                        flavourDessert = '$flavourDessert', 
                        dessertStatus ='$dessertStatus',
                        filename = '$filename'
                    WHERE dessertID = '$dessertID'";

            if (mysqli_query($dbconn, $sql)) {
                echo "<script>alert('Menu item updated.');</script>";
                
                if (!empty($tempname)) {
                    if (move_uploaded_file($tempname, $folder)) {
                        echo "<script>alert('Image uploaded successfully!');</script>";
                    } else {
                        echo "<script>alert('Failed to upload image!');</script>";
                    }
                }
            } else {
                echo "<script>alert('Error: " . mysqli_error($dbconn) . "');</script>";
            }
        }
    } else if ($action == "Add New Menu") {
        $sqlCheck = "SELECT * FROM dessert WHERE dessertID= '$dessertID'";
        $queryCheck = mysqli_query($dbconn, $sqlCheck) or die ("Error: " . mysqli_error($dbconn));
        $rowCheck = mysqli_fetch_assoc($queryCheck);

        if ($rowCheck) {
            // Send back to the form with an error
            header("Location: updateMenu.php?error=exists&dessertID=$dessertID&dessertName=$dessertName&flavourDessert=$flavourDessert&dessertPrice=$dessertPrice&dessertStatus=$dessertStatus");
            exit;
        } else {
            if (empty($filename)) {
                $filename = "image-removebg-preview (8).png"; // Set your default image filename here
            }

            $sql = "INSERT INTO dessert (dessertID, flavourDessert, dessertName, dessertPrice, dessertStatus, filename) 
                    VALUES ('$dessertID', '$flavourDessert', '$dessertName', '$dessertPrice', '$dessertStatus', '$filename')";

            if (mysqli_query($dbconn, $sql)) {
                echo "<script>alert('New menu item added.');</script>";
                
                if (!empty($tempname) && move_uploaded_file($tempname, $folder)) {
                    echo "<script>alert('Image uploaded successfully!');</script>";
                } else if (!empty($tempname)) {
                    echo "<script>alert('Failed to upload image!');</script>";
                }
            } else {
                echo "<script>alert('Error: " . mysqli_error($dbconn) . "');</script>";
            }
        }
    }

    // Redirect back to the appropriate page after 2 seconds
    echo "<script>
            setTimeout(function() {
                window.location.href = '" . (substr($dessertID, 0, 2) === 'PA' ? "adminPastry.php" : (substr($dessertID, 0, 2) === 'CA' ? "adminCake.php" : "adminDashboard.php")) . "';
            }, 2000);
          </script>";

    exit;
}
?>
