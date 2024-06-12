<?php

// Include your database connection file if not already included
include("dbconn.php");

function searchRecords($table, $columns, $searchTerm) {
    global $dbconn;

    // Construct the SQL query dynamically
    $sql = "SELECT * FROM $table WHERE ";

    // Add conditions for each column to search
    $conditions = [];
    foreach ($columns as $column) {
        $conditions[] = "$column LIKE '%$searchTerm%'";
    }

    // Join the conditions with OR
    $sql .= implode(" OR ", $conditions);

    // Execute the query
    $query = mysqli_query($dbconn, $sql) or die("Error: " . mysqli_error($dbconn));

    // Fetch and return the results
    $results = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $results[] = $row;
    }
    return $results;
}

// Check if the search term is provided
if (isset($_GET['search'])) {
    // Get the search term
    $searchTerm = $_GET['search'];

    // Check if the table name and columns are provided
    if (isset($_GET['table']) && isset($_GET['columns'])) {
        // Call the searchRecords function with the provided table name, columns, and search term
        $table = $_GET['table'];
        $columns = explode(',', $_GET['columns']); // Convert comma-separated string to an array
        $searchResults = searchRecords($table, $columns, $searchTerm);

        // Output the search results
        if (!empty($searchResults)) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            foreach (array_keys($searchResults[0]) as $column) {
                echo "<th>$column</th>";
            }
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($searchResults as $result) {
                echo '<tr>';
                foreach ($result as $value) {
                    echo "<td>$value</td>";
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo "No results found.";
        }
    } else {
        echo "Table name and columns are required.";
    }
}
?>
