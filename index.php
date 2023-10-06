


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Lending System- Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="card m-auto p-2">
        <div class="card-body">
          <form id="login-form" class="login-form"  >
            <div class="logo">
        			<img src="images/prof.jpg" class="profile"/>
        			<h1 class="logo-caption"><span class="tweak">L</span>ogin</h1>
        		</div> <!-- logo class -->
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user text-white"></i></span>
              </div>
              <input name="username" id="username" type="text" class="form-control" placeholder="username" required>
            </div> <!--input-group class -->
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key text-white"></i></span>
              </div>
              <input name="password" type="password" id="password"class="form-control" placeholder="password"  required>
            </div> <!-- input-group class -->
            <div class="form-group">
              <button class="btn btn-default btn-block btn-custom" type="submit">Login</button>
            </div>
          </form><!-- form close -->
        </div>
      
        <div class="card-footer">
          <div class="text-center">
            <a class="text-light" href="change_password.php">Forgot password?</a>
</div>
        </div> <!-- cord-footer class -->
      </div> <!-- card class -->
    </div> <!-- container class -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
	<script>
$(document).ready(function() {
    $("#login-form").submit(function(e) {
        e.preventDefault();
        
        var username = $("#username").val();
        var password = $("#password").val();
        console.log(username);

        $.ajax({
            type: "POST",
            url: "log.php", // Update the path based on your directory structure
            data: {
                username: username,
                password: password
            },
            success: function(response) {
                response = JSON.parse(response); // Parse the JSON response
                //console.log("djhk");
                if (response.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Login Successful'
                    }).then(function() {
                        window.location.href = "home.php";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',  
                        title: 'Error',
                        text: 'Invalid username or password. '
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during login.'
                });
            }
        });
    });
});
</script>
  </body>
</html>

	