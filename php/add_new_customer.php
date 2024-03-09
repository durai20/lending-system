<?php
// Include your database connection file (config.php or similar)
include("config.php");

// Start a session if not already started
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data sent via POST
    $studentName = mysqli_real_escape_string($con, $_POST['studentName']);
    $studentID = mysqli_real_escape_string($con, $_POST['studentID']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $studentEmail = mysqli_real_escape_string($con, $_POST['studentEmail']); // Add email field
    $contactNumber = mysqli_real_escape_string($con, $_POST['contactNumber']); // Add contact number field

    // You can add additional validation and sanitization here if needed
    $studentName = ucfirst(strtolower($studentName));

    // Check if the student ID already exists in the database
    $checkQuery = "SELECT id FROM customers WHERE id = ?";
    $checkStmt = mysqli_prepare($con, $checkQuery);

    if ($checkStmt) {
        mysqli_stmt_bind_param($checkStmt, "s", $studentID);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            // Duplicate student ID found, handle accordingly (e.g., display an error message)
            $response = [
                'status' => 'error',
                'message' => 'Student ID already exists.'
            ];
        } else {
            // No duplicate found, proceed with insertion
            $query = "INSERT INTO customers (name, id, password, email, contact_number) VALUES (?, ?, ?, ?, ?)"; // Update the query to include email and contact number fields
            $stmt = mysqli_prepare($con, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssi", $studentName, $studentID, $password, $studentEmail, $contactNumber);

                if (mysqli_stmt_execute($stmt)) {
                    // Insertion was successful
                    $response = [
                        'status' => 'success',
                        'message' => 'Student added successfully.'
                    ];
                } else {
                    // Insertion failed
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to add student: ' . mysqli_error($con)
                    ];
                }

                mysqli_stmt_close($stmt);
            } else {
                // Statement preparation failed
                $response = [
                    'status' => 'error',
                    'message' => 'Error in preparing SQL statement: ' . mysqli_error($con)
                ];
            }
        }

        mysqli_stmt_close($checkStmt);
    } else {
        // Check statement preparation failed
        $response = [
            'status' => 'error',
            'message' => 'Error in preparing check statement: ' . mysqli_error($con)
        ];
    }

    // Send the JSON response
    echo json_encode($response);
}
?>