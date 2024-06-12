<?php 
// Include your necessary files
$title="Users";
include("adminNav.php");
include("dbconn.php");
include("font.php");

// Fetch data from the database using LEFT JOIN
$sql = "SELECT c.custID, c.custName, c.custUsername, c.custEmail, ci.custPhoneNo, ci.custAddress, ci.custState
        FROM customer c
        LEFT JOIN customer_info ci ON c.custID = ci.custID";
$query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" type="text/css" href="users.css">
</head>
<body>
    <main>
        <h1 class="head1 montserrat-monty">
            <?php 
                $numRow = mysqli_num_rows($query); 
                echo $numRow . " Users Recorded"; 
            ?>
        </h1>
        <div class="container">
            <div class="table-container">
                <table id="usersTable">
                    <thead>
                        <tr> 
                            <th>BIL</th>
                            <th>USERNAME</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>ADDRESS</th>
                            <th>STATE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $index = 1;
                        
                        while ($row = mysqli_fetch_assoc($query)): ?>
                            <tr class="data poppins-regular">
                                <td><?php echo $index++; ?></td>
                                <td><?php echo htmlspecialchars($row['custUsername']) ?: 'N/A'; ?></td>
                                <td><?php echo htmlspecialchars($row['custName']) ?: 'N/A'; ?></td>
                                <td><?php echo htmlspecialchars($row['custEmail']) ?: 'N/A'; ?></td>
                                <td><?php echo !empty($row['custPhoneNo']) ? '+6' . htmlspecialchars($row['custPhoneNo']) : 'N/A'; ?></td>
                                <td><?php echo htmlspecialchars($row['custAddress']) ?: 'N/A'; ?></td>
                                <td><?php echo htmlspecialchars($row['custState']) ?: 'N/A'; ?></td>
                                <td>
                                    <button class="button-82-pushable" onclick="updateUser('<?php echo $row['custID']; ?>')">
                                        <span class="button-82-shadow"></span>
                                        <span class="button-82-edge"></span>
                                        <span class="button-82-front text">Update</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        function updateUser(custID) {
            window.location.href = 'updateUsers.php?custID=' + custID;
        }
    </script>
</body>
</html>
