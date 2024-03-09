<?php
// Include your database connection file (config.php or similar)
require "db_connection.php";

// Start the session before any output


function showCustomers($studentId) {
    global $con;

    // Query to retrieve the purchase history for a specific student
    $query = "SELECT product_name, product_quantity, product_price, date FROM purchase_history WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $studentId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $count = 1;
            mysqli_stmt_bind_result($stmt, $productName, $quantity, $productPrice, $date);

            while (mysqli_stmt_fetch($stmt)) {
                echo '<tr>';
                echo '<td>' . $count . '</td>';
                echo '<td>' . $productName . '</td>';
                echo '<td>' . $quantity . '</td>';
                echo '<td>' . $productPrice . '</td>';
                echo '<td>' . $date . '</td>';
                echo '</tr>';
                $count++;
            }
        } else {
            echo '<tr><td colspan="5">No purchase history found for this student.</td></tr>';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo '<tr><td colspan="5">Error in preparing SQL statement: ' . mysqli_error($con) . '</td></tr>';
    }
}

// Get the student ID from the session or request, replace with your logic

?>
