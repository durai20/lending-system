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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Purchase-History</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/logo2.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
    <script src="js/validateFormst.js"></script>
    <script src="js/restrictst.js"></script>
  </head>
  <body style="max-height: 100%;">
    <!-- including side navigations -->
    <?php include("sections/sidenavst.html"); ?>

    <div class="container-fluid">
      <div class="container">

        <!-- header section -->
        <?php
          require "php/headerst.php";
          createHeader('book', 'Purchase', 'Show History');
        ?>
        <!-- header section end -->

        <!-- form content -->
        <div class="row">

  

          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
          </div>

          <div class="col col-md-12 table-responsive">
            <div class="table-responsive">
            	<table class="table table-bordered table-striped table-hover">
            		<thead>
            			<tr>
            				<th style="width: 2%;">SL.</th>
            		
            			
            		<th style="width: 13%;">Product Name</th>
                    <th style="width: 13%;">Quantity</th>
                    <th style="width: 15%;">Product Price</th>
                    <th style="width: 15%;">Date</th>
            			</tr>
            		</thead>
            		<tbody id="customers_div">
                  <?php
                    require 'php/student_sales.php';
                    showCustomers($user_id);
                  ?>
            		</tbody>
            	</table>
      

            </div>
          </div>

        </div>
        <!-- form content end -->
        <hr style="border-top: 2px solid #000000;">
      </div>
    </div>
    <div id="customer_acknowledgement" class="col-md-12 h5 text-success font-weight-bold text-center" style="font-family:'Times New Roman', Times, serif;padding-top: 10%;"></div>

  </body>
</html>
