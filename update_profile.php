<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
} else {
    $user_id = $_SESSION['login_user'];
}

require "db_connection.php"; // Establish the database connection

if (isset($_POST['update_profile'])) {
    // Get the updated values from the form
    $new_pharmacy_name = $_POST['pharmacy_name'];
    $new_email = $_POST['email'];
    $new_contact_number = $_POST['contact_number'];
    $new_username = $_POST['username'];

    // Construct and execute the SQL UPDATE statement
    $update_query = "UPDATE customers SET EMAIL='$new_email', CONTACT_NUMBER='$new_contact_number', NAME='$new_username' WHERE ID='$user_id'";
    
    if (mysqli_query($con, $update_query)) {
        // The update was successful
        echo "Profile updated successfully.";
    } else {
        // Handle any errors or display an error message
        echo "Error updating profile: " . mysqli_error($con);
    }
}

// Close the database connection and perform any other necessary actions
mysqli_close($con);
?>
