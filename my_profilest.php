<?php
session_start();
// If the user is not logged in redirect to the login page...

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
} else {
    $user_id = $_SESSION['login_user'];
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Student   Profile</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/logo2.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/my_profilest.js"></script>
    <script src="js/validateFormst.js"></script>
    <script src="js/restrict.js"></script>
  </head>
  <body>
    <!-- including side navigations -->
    <?php include("sections/sidenavst.html"); ?>
    <div class="container-fluid">
      <div class="container">
        <!-- header section -->
        <?php
// Include necessary files and establish a database connection
require "php/headerst.php";
createHeader('user', 'Profile', 'Student Details');
require "db_connection.php";



    // Construct the SQL query to fetch the user's profile
    $query = "SELECT * FROM customers WHERE ID = '$user_id'";
    
    // Execute the query
    $query_run = mysqli_query($con, $query);

    // Check if the query was successful and fetched a user's profile
    if ($query_run && mysqli_num_rows($query_run) > 0) {
        // Fetch the user's profile data
        $student = mysqli_fetch_array($query_run);
        
        // Assign the fetched data to variables
        $pharmacy_name = $student['ID'];
        $email = $student['EMAIL'];
        $contact_number = $student['CONTACT_NUMBER'];
        $username = $student['NAME'];
        
        // Now you can use these variables to display the user's profile
    } else {
        // Handle the case where the user ID doesn't exist in the database
        echo "User not found.";
    }

?>

        <div class="row">
          <div class="row col col-md-6">
            
            <div class="row col col-md-12">
              <div class="col col-md-12 form-group">
                <label class="font-weight-bold" for="pharmacy_name">Student ID:</label>
                <input id="pharmacy_name" type="text" class="form-control" value="<?php echo $pharmacy_name; ?>" placeholder="Student Id"  disabled>
                <code class="text-danger small font-weight-bold float-right mb-2" id="pharmacy_name_error" style="display: none;"></code>
              </div>
            </div>

       

            <div class="row col col-md-12">
              <div class="col col-md-12 form-group">
                <label class="font-weight-bold" for="email">Email :</label>
                <input id="email" type="email" class="form-control" value="<?php echo $email; ?>" placeholder="email" onkeyup="notNull(this.value, 'email_error');" disabled>
                <code class="text-danger small font-weight-bold float-right mb-2" id="email_error" style="display: none;"></code>
              </div>
            </div>

            <div class="row col col-md-12">
              <div class="col col-md-12 form-group">
                <label class="font-weight-bold" for="contact_number">Contact Number :</label>
                <input id="contact_number" type="number" class="form-control" value="<?php echo $contact_number; ?>" placeholder="contact number" onkeyup="validateContactNumber(this.value, 'contact_number_error');" disabled>
                <code class="text-danger small font-weight-bold float-right mb-2" id="contact_number_error" style="display: none;"></code>
              </div>
            </div>

            <div class="row col col-md-12">
              <div class="col col-md-12 form-group">
                <label class="font-weight-bold" for="username">Username :</label>
                <input id="username" type="text" class="form-control" value="<?php echo $username; ?>" placeholder="username" onkeyup="notNull(this.value, 'username_error');" disabled>
                <code class="text-danger small font-weight-bold float-right mb-2" id="username_error" style="display: none;"></code>
              </div>
            </div>

            <!-- horizontal line -->
            <div class="col col-md-12">
              <hr class="col-md-12 float-left" style="padding: 0px; width: 95%; border-top: 2px solid  #02b6ff;">
            </div>

            <!-- form submit button -->
            <div class="row col col-md-12 m-auto" id="edit">
              <div class="col col-md-2 form-group float-right"></div>
              <div id="edit_button" class="col col-md-4 form-group float-right">
                <button class="btn btn-primary form-control font-weight-bold" onclick="edit();">EDIT</button>
              </div>
              <div id="password_button" class="col col-md-4 form-group float-right">
              <button type="button" onclick="window.location.href='change_passwordst.php'" class="btn btn-warning form-control font-weight-bold" >Change pass</button>
              </div>
            </div>

            <div class="row col col-md-12 m-auto" id="update_cancel" style="display: none;">
              <div class="col col-md-2 form-group float-right"></div>
              <div id="cancel_button" class="col col-md-4 form-group float-right">
                <button class="btn btn-danger form-control font-weight-bold" onclick="edit(true);">CANCEL</button>
              </div>
              <div id="update_button" class="col col-md-4 form-group float-right">
                <button class="btn btn-success form-control font-weight-bold" onclick="updateAdminDetails();">UPDATE</button>
              </div>
            </div>
            <!-- result message -->
            <div id="admin_acknowledgement" class="col-md-12 h5 text-success font-weight-bold text-center" style="font-family: sans-serif;"></div>
          </div>
        </div>
        <hr style="border-top: 2px solid #ff5252;">
      </div>
    </div>
  </body>
</html>
