<?php 
    $title = "Menu";
    include("custNav.php");
    include("dbconn.php");

    $sql = "SELECT * FROM dessert WHERE dessertID LIKE 'CA%' AND dessertStatus = 'AVAILABLE'";
	$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cakes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="viewCake.css">
    
</head>
<body>    
    <main>
        <h1 class="headP"> <b>CAKES </b></h1>
        <div class="container">
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <div class="box">
                        <a href="cakeDetails.php?dessertID=<?php echo htmlspecialchars($row['dessertID']); ?>">
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
                <div class="montserrat-monty" align= "center">
                    <p> COMING SOON... </p>
                </div>
            </div>
        </main>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.box').hover(function(){
                    // Store the original text content of .hover-text
                    $(this).data('original-text', $(this).find('.hover-text').text());
                    // Change the text content to 'Order Me!'
                    $(this).find('.hover-text').text('Order Me!');
                }, function(){
                    // Restore the original text content of .hover-text
                    $(this).find('.hover-text').text($(this).data('original-text'));
                });
            });
</script>
</body>
</html>

