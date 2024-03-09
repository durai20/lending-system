<?php
// Include your database connection file (config.php or similar)
require "db_connection.php";
session_start();
// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
} else {
    $user_id = $_SESSION['login_user'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data sent via POST
    $productId = mysqli_real_escape_string($con, $_POST['productId']);
    $productName = mysqli_real_escape_string($con, $_POST['productName']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $productPrice = mysqli_real_escape_string($con, $_POST['productPrice']);
    $purchaseDate = date("Y-m-d"); // Get the current date and time

    // Fetch the student's name based on their student_id
    $fetchStudentNameQuery = "SELECT NAME FROM customers WHERE ID = ?";
    $fetchStudentNameStmt = mysqli_prepare($con, $fetchStudentNameQuery);

    if ($fetchStudentNameStmt) {
        mysqli_stmt_bind_param($fetchStudentNameStmt, "s", $user_id);
        mysqli_stmt_execute($fetchStudentNameStmt);
        mysqli_stmt_store_result($fetchStudentNameStmt);

        if (mysqli_stmt_num_rows($fetchStudentNameStmt) > 0) {
            mysqli_stmt_bind_result($fetchStudentNameStmt, $studentName);
            mysqli_stmt_fetch($fetchStudentNameStmt);

            // Start a transaction
            mysqli_begin_transaction($con);

            // Decrease the product_quantity by 1
            $newQuantity = $quantity - 1;

            // Calculate the new total_price
            $newTotalPrice = $newQuantity * $productPrice;

            // Update the product_quantity and total_price in the products table
            $updateProductQuery = "UPDATE product SET product_quantity = ?, total_price = ? WHERE id = ?";
            $updateProductStmt = mysqli_prepare($con, $updateProductQuery);

            if ($updateProductStmt) {
                mysqli_stmt_bind_param($updateProductStmt, "iii", $newQuantity, $newTotalPrice, $productId);
                mysqli_stmt_execute($updateProductStmt);
            }
                        $quantity = 1;

            // Insert the purchase history with the student's name
            $insertPurchaseQuery = "INSERT INTO purchase_history (id, name, product_name, product_quantity, product_price, date) VALUES (?, ?, ?, ?, ?, ?)";
            $insertPurchaseStmt = mysqli_prepare($con, $insertPurchaseQuery);

            if ($insertPurchaseStmt) {
                mysqli_stmt_bind_param($insertPurchaseStmt, "sssiis", $user_id, $studentName, $productName, $quantity, $productPrice, $purchaseDate);

                if (mysqli_stmt_execute($insertPurchaseStmt)) {
                    // Commit the transaction
                    mysqli_commit($con);

                    // Insertion was successful
                    $response = [
                        'status' => 'success',
                        'message' => 'Product added successfully.'
                    ];
                } else {
                    // Rollback the transaction
                    mysqli_rollback($con);

                    // Insertion failed
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to add the product: ' . mysqli_error($con)
                    ];
                }

                mysqli_stmt_close($insertPurchaseStmt);
                mysqli_stmt_close($updateProductStmt);
            } else {
                // Statement preparation failed
                $response = [
                    'status' => 'error',
                    'message' => 'Error in preparing SQL statement: ' . mysqli_error($con)
                ];
            }
        } else {
            // Student not found with the given ID
            $response = [
                'status' => 'error',
                'message' => 'Student not found with the given ID.'
            ];
        }

        mysqli_stmt_close($fetchStudentNameStmt);
    } else {
        // Fetch student name statement preparation failed
        $response = [
            'status' => 'error',
            'message' => 'Error in preparing student name retrieval statement: ' . mysqli_error($con)
        ];
    }

    // Send the JSON response
    echo json_encode($response);
}
?>
