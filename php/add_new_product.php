<?php
// Include your database connection file (config.php or similar)
include("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data sent via POST
    $product_name = mysqli_real_escape_string($con, $_POST['product_name']);
    $product_quantity = mysqli_real_escape_string($con, $_POST['product_quantity']);
    $product_price = mysqli_real_escape_string($con, $_POST['product_price']);

    // Calculate the total price
    $total_price = $product_quantity * $product_price;

    // Convert product name to uppercase
    $product_name = strtoupper($product_name);

    // Check if the product already exists in the database
    $checkQuery = "SELECT product_name FROM product WHERE product_name = ?";
    $stmt = mysqli_prepare($con, $checkQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $product_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Product with the same name already exists
            $response = [
                'status' => 'error',
                'message' => 'Product with the same name already exists in the database.'
            ];
        } else {
            // Insert product data into the database
            $insertQuery = "INSERT INTO product (product_name, product_quantity, product_price, total_price) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insertQuery);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "siii", $product_name, $product_quantity, $product_price, $total_price);
            
                if (mysqli_stmt_execute($stmt)) {
                    // Insertion of product data was successful
                    $response = [
                        'status' => 'success',
                        'message' => 'Product added successfully.'
                    ];
                } else {
                    // Insertion of product data failed
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to add product: ' . mysqli_error($con)
                    ];
                }
            } else {
                // Statement preparation for product data insertion failed
                $response = [
                    'status' => 'error',
                    'message' => 'Error in preparing SQL statement for product insertion: ' . mysqli_error($con)
                ];
            }
        }
    } else {
        // Statement preparation for checking duplicates failed
        $response = [
            'status' => 'error',
            'message' => 'Error in preparing SQL statement for checking duplicates: ' . mysqli_error($con)
        ];
    }

    // Send the JSON response
    echo json_encode($response);
}
?>
