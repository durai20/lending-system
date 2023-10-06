<?php
// Include the database connection configuration
require "db_connection.php";

// Get the search text from the GET request
$searchText = $_GET['text'];

// Perform the database query (you may want to use prepared statements for security)
$sql = "SELECT * FROM customers WHERE NAME LIKE '%$searchText%'";
$result = $con->query($sql);
$count=1;
if ($result->num_rows > 0) {
    // Output data of each row
    echo '<table border="1">';
        while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' .$count  . '</td>';
        echo '<td>' . $row['ID'] . '</td>';
        echo '<td>' . $row['NAME'] . '</td>';
        echo '<td>' . $row['PASSWORD'] . '</td>';
      echo '<td>';
echo '<button class="btn btn-info btn-sm" onclick="updateCustomer(' . $row['ID'] . ');">';
echo '<i class="fa fa-pencil"></i>';
echo '</button>';
echo '<button style="margin-left:5px;" class="btn btn-danger btn-sm" onclick="cancel();">';
echo '   <i class="fa fa-trash"></i>';
echo '</button>';
echo '</td>';
        echo '</tr>';
        $count=$count+1;
    }
    echo '</table>';
} else {
    echo "No results found";
}
?>
