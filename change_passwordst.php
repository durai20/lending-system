<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- ... (your existing head content) ... -->
    <meta charset="utf-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/logo2.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/validateFormst.js"></script>
    <script src="js/my_profilest.js"></script>
    <script src="js/restrict.js"></script>
  </head>
  <body>
    <!-- including side navigations -->
    <?php include("sections/sidenavst.html"); ?>
    <div class="container-fluid">
      <div class="container">
        <!-- header section -->
        <?php
          require "php/headerst.php";
          createHeader('key', 'Change Password', 'Set New Password');
          // header section end

        ?>
        <div class="row">
          <div class="row col col-md-6">
            <!-- Add a <form> element to wrap your form elements -->
            <form id="password-change-form"  method="POST">
              <div class="row col col-md-12">
                <div class="col col-md-12 form-group">
                  <label class="font-weight-bold" for="old_password">Old Password :</label>
                  <input id="old_password" name="old_password" type="text" class="form-control" placeholder="old password" required pattern=".{8,}" title="Password must be at least 8 characters long"> 
                  <code class="text-danger small font-weight-bold float-right mb-2" id="old_password_error" style="display: none;"></code>
                </div>
              </div>

              <div class="row col col-md-12">
                <div class="col col-md-12 form-group">
                  <label class="font-weight-bold" for="password">New Password :</label>
                  <input id="password" name="password" type="text" class="form-control" placeholder="password" style="max-height: 100px;" required pattern=".{8,}" title="Password must be at least 8 characters long">
                  <code class="text-danger small font-weight-bold float-right mb-2" id="password_error" style="display: none;"></code>
                </div>
              </div>

              <div class="row col col-md-12">
                <div class="col col-md-12 form-group">
                  <label class="font-weight-bold" for="confirm_password">Confirm New Password :</label>
                  <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="confirm password" required pattern=".{8,}" title="Password must be at least 8 characters long">
                  <code class="text-danger small font-weight-bold float-right mb-2" id="confirm_password_error" style="display: none;"></code>
                </div>
              </div>

              <div class="row col col-md-12 m-auto" id="change">
                <div class="col col-md-4 form-group float-right"></div>
                <div id="change_button" class="col col-md-4 form-group float-right">
                  <!-- Change the button type to "submit" to submit the form -->
                  <button type="submit" class="btn btn-warning   form-control font-weight-bold" style="width:70px;margin-right:70px;margin-left:10px; ">Reset </button>
                </div>
                <div id="password_button" class="col col-md-4 form-group float-right">
                  <a href="my_profilest.php" class="btn btn-primary form-control font-weight-bold" style="width:70px;">Profile</a>
                </div>
              </div>
            </form>
            <!-- End of form -->
          </div>
        </div>
        
        <hr style="border-top: 2px solid #ff5252;">
      </div>
    </div>
    <div id="customer_acknowledgement" class="col-md-12 h5 text-success font-weight-bold text-center" style="font-family:'Times New Roman', Times, serif;padding-top: 10%;"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
    <script>
      $(document).ready(function() {
    $("#password-change-form").submit(function(e) {
        e.preventDefault();

        // Get the input values
        const oldPassword = $("#old_password").val().trim();
        const newPassword = $("#password").val().trim();
        const confirmPassword = $("#confirm_password").val().trim();

        // Create a FormData object to send data to the PHP script
        const formData = new FormData();
        formData.append('old_password', oldPassword);
        formData.append('password', newPassword);
        formData.append('confirm_password', confirmPassword);
       
        // Send an AJAX request to the PHP script
        $.ajax({
            type: 'POST',
            url: 'password_change.php', // Update the path based on your directory structure
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              response = JSON.parse(response); 
                if (response.status === 'success') {
                    // Password updated successfully
                    const acknowledgement = document.getElementById('customer_acknowledgement');
                acknowledgement.textContent = "Password Updated Succesfully";
                } else {
                    // Error updating password
                    const acknowledgement = document.getElementById('customer_acknowledgement');
                acknowledgement.textContent = response.message;
                }
               
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during password change.'
                });
            }
        });

        // You can also reset the form fields after submission if needed
        $("#old_password").val('');
        $("#password").val('');
        $("#confirm_password").val('');
    });
});


    </script>
  </body>
</html>
