<?php 
$title = "Menu";
include("adminNav.php");
include("dbconn.php");
include("font.php");

$sql = "SELECT * FROM dessert WHERE dessertID LIKE 'CA%' AND dessertStatus = 'AVAILABLE'";
$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));

$sql2 = "SELECT * FROM dessert WHERE dessertID LIKE 'CA%' AND dessertStatus = 'UNAVAILABLE'";
$query2 = mysqli_query($dbconn, $sql2) or die("Error: " . mysqli_error($dbconn));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake</title>
    <link rel="stylesheet" type="text/css" href="adminCake.css">
</head>
<body>
    <main>
        <h1 class="headP"><b>CAKES</b></h1>
        <div class="container">
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <div class="box">
                    <a href="updateMenu.php?dessertID=<?php echo htmlspecialchars($row['dessertID']); ?>">
                        <div>
                            <img src="./image/<?php echo !empty($row['filename']) ? htmlspecialchars($row['filename']) : 'image-removebg-preview (8).png'; ?>" class="cakeImage" alt="Picture of <?php echo htmlspecialchars($row['dessertName']); ?>">
                        </div>
                        <div class="cakeContent montserrat-monty">
                            <p class="hover-text"><?php echo htmlspecialchars($row['dessertName']); ?></p>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>

            <div class="box">
                <div class="montserrat-monty" align="center">
                    <a href="updateMenu.php">
                        <p>+ ADD NEW MENU</p>
                    </a>
                </div>
            </div>
            <?php while ($row = mysqli_fetch_assoc($query2)): ?>
                <div class="unavailable">
                    <a href="updateMenu.php?dessertID=<?php echo htmlspecialchars($row['dessertID']); ?>">
                        <div>
                            <img src="./image/<?php echo !empty($row['filename']) ? htmlspecialchars($row['filename']) : 'image-removebg-preview (8).png'; ?>" class="cakeImage" alt="Picture of <?php echo htmlspecialchars($row['dessertName']); ?>">
                        </div>
                        <div class="cakeContentUn montserrat-monty">
                            <p class="hover-text"><?php echo htmlspecialchars($row['dessertName']); ?></p>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.box').hover(function(){
                $(this).data('original-text', $(this).find('.hover-text').text());
                $(this).find('.hover-text').text('Update Me!');
            }, function(){
                $(this).find('.hover-text').text($(this).data('original-text'));
            });
        });
    </script>
</body>
</html>
