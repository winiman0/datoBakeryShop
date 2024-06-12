<?php
ob_start();

$title = "Menu";

include("dbconn.php");
include("font.php");
include("adminNav.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = "Add New Menu";
$dessertID = "";
$dessertName = "";
$flavourDessert = "";
$dessertPrice = "";
$dessertStatus = "";
$filename = "";

// Check if dessertID is present
if (isset($_GET['dessertID'])) {
    $dessertID = htmlspecialchars($_GET['dessertID']);
    
    // Fetch the existing menu item details from the database
    $sql = "SELECT * FROM dessert WHERE dessertID = '$dessertID'";
    $result = mysqli_query($dbconn, $sql);
    $menuItem = mysqli_fetch_assoc($result);
    
    // If menu item is found, prepare to update
    if ($menuItem) {
        $action = "Update Menu";
        $dessertID = $menuItem['dessertID'];
        $dessertName = $menuItem['dessertName'];
        $flavourDessert = $menuItem['flavourDessert'];
        $dessertPrice = $menuItem['dessertPrice'];
        $dessertStatus = $menuItem['dessertStatus'];
        $filename = $menuItem['filename'];
    } else {
        // Handle case where dessertID is invalid
        echo "Invalid dessertID.";
        exit;
    }
}

// Handle AJAX request to check if dessert ID exists
if (isset($_GET['checkDessertID'])) {
    $dessertID = htmlspecialchars($_GET['checkDessertID']);
    $sql = "SELECT * FROM dessert WHERE dessertID = '$dessertID'";
    $result = mysqli_query($dbconn, $sql);
    echo mysqli_num_rows($result) > 0 ? 'exists' : 'not exists';
    exit;
}

// At the beginning of the HTML form
$error = "";
if (isset($_GET['error']) && $_GET['error'] == 'exists') {
    $error = "Dessert ID already exists, please choose a different one.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $action; ?></title>

    <link rel="stylesheet" type="text/css" href="updateMenu.css">
    <script>
        async function checkDessertID(dessertID) {
            const response = await fetch(`updateMenu.php?checkDessertID=${dessertID}`);
            const result = await response.text();
            return result === 'exists';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            const dessertIDInput = document.querySelector('input[name="dessertID"]');
            const errorDiv = document.createElement('div');
            errorDiv.style.color = 'red';
            errorDiv.id = 'error-message';
            dessertIDInput.parentNode.appendChild(errorDiv);

            form.addEventListener('submit', async (event) => {
                const dessertID = dessertIDInput.value;
                if (await checkDessertID(dessertID)) {
                    event.preventDefault();
                    errorDiv.textContent = 'Dessert ID already exists, please choose a different one.';
                } else {
                    errorDiv.textContent = '';
                }
            });
        });
    </script>
</head>
<body>
<main>
    <h2 class="hForm"><?php echo $action; ?></h2>
    <div class="fCont">
        <form action="processMenu.php" method="post" enctype="multipart/form-data">
            <div class="boxIm">
                <div class="dImg">
                    <img src="./image/<?php echo !empty($filename) ? htmlspecialchars($filename) : 'image-removebg-preview (8).png'; ?>" alt="Picture of <?php echo htmlspecialchars($dessertName); ?>">
                </div>
                <div class="buttonC">
                    <input class="input-file" type="file" name="uploadfile" id="uploadfile" />
                    <label class="button-45" for="uploadfile">Choose File</label>
                </div>
            </div>
            <div class="boxI">
                <table class="conUp">
                    <tr>
                        <td>DESSERT ID :</td>
                    </tr>
                    <tr>
                        <td><input type="text" name="dessertID" value="<?php echo $dessertID; ?>"></td>
                    </tr>
                    <tr>
                        <td><div id="error-message"><?php echo $error; ?></div></td>
                    </tr>
                    <tr>
                        <td>DESSERT NAME :</td>
                    </tr>
                    <tr>
                        <td><input type="text" name="dessertName" value="<?php echo $dessertName; ?>"></td>
                    </tr>
                    <tr>
                        <td>DESSERT FLAVOUR :</td>
                    </tr>
                    <tr>
                        <td><input type="text" name="flavourDessert" value="<?php echo $flavourDessert; ?>"></td>
                    </tr>
                    <tr>
                        <td>DESSERT PRICE :</td>
                    </tr>
                    <tr>
                        <td><input type="text" name="dessertPrice" value="<?php echo $dessertPrice; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="dessertStatus">STATUS :</label></td>
                    </tr>
                    <tr>
                        <td>
                            <select id="dessertStatus" name="dessertStatus">
                                <option value="AVAILABLE" <?php if ($dessertStatus == 'AVAILABLE') echo 'selected'; ?>>AVAILABLE</option>
                                <option value="UNAVAILABLE" <?php if ($dessertStatus == 'UNAVAILABLE') echo 'selected'; ?>>UNAVAILABLE</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=3 class="buttonUp" align=right>
                            <button class="button-19" type="submit" name="action" value="<?php echo $action; ?>"> <?php echo $action; ?></button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>  
    </div>
</main>
</body>
</html>
<?php
ob_end_flush();
?>
