<?php
session_start();

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
} else {
    $userId = $_SESSION['login_user'];
}

// Include your database connection code here
require "db_connection.php";

// ... (previous PHP code)

$response = []; // Initialize an empty array to store the response data



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    // Check if the old password matches the one stored in the database for the current user
    $query = "SELECT PASSWORD FROM customers WHERE ID = '$userId'";
    $result = mysqli_query($con, $query);
    if ($result) {
      
    } else {
       
    }
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['PASSWORD'];

        if ($storedPassword == $oldPassword) {
            if ($newPassword == $confirmPassword) {
                // Update the password
                $updateQuery = "UPDATE customers SET PASSWORD = '$newPassword' WHERE ID = '$userId'";
                $updateResult = mysqli_query($con, $updateQuery);
                
                if ($updateResult) {
                    
                    $response['status'] = 'success';
                    $response['message'] = 'Password updated successfully.';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error updating password: ' . mysqli_error($con);
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'New password and confirmation do not match.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Old password is incorrect.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error retrieving user data.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Return the response as JSON
echo json_encode($response);
exit;
