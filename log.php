<?php
include("db_connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $myusername = mysqli_real_escape_string($con, $_POST['username']);
    $mypassword = mysqli_real_escape_string($con, $_POST['password']);

    // Check if the user is an admin
    $admin_sql = "SELECT * FROM admin_credentials WHERE USERNAME = '$myusername' AND PASSWORD = '$mypassword'";
    $admin_result = mysqli_query($con, $admin_sql);
    $admin_count = mysqli_num_rows($admin_result);

    // Check if the user is a customer
    $customer_sql = "SELECT * FROM customers WHERE ID = '$myusername' AND PASSWORD = '$mypassword'";
    $customer_result = mysqli_query($con, $customer_sql);
    $customer_count = mysqli_num_rows($customer_result);

    if ($admin_count == 1) {
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['user_type'] = 'admin';
        $_SESSION['login_user'] = $myusername;
        $res = [
            'status' => 200,
            'message' => 'Admin Login Successful'
        ];
        echo json_encode($res);
        return $res;
    } elseif ($customer_count == 1) {
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['user_type'] = 'customer';
        $_SESSION['login_user'] = $myusername;
        $res = [
            'status' => 300,
            'message' => 'Customer Login Successful'
        ];
        echo json_encode($res);
        return $res;
    } else {
        $res = [
            'status' => 400,
            'message' => 'Invalid username or password'
        ];
        echo json_encode($res);
        return;
    }
}
?>
