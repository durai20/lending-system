
<?php
   include("db_connection.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($con,$_POST['username']);
      $mypassword = mysqli_real_escape_string($con,$_POST['password']); 
      
      $sql = "SELECT * FROM admin_credentials   WHERE  USERNAME = '$myusername' and PASSWORD = '$mypassword'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      //$active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
        // session_register("myusername");
		 $_SESSION['loggedin'] = TRUE;
         $_SESSION['login_user'] = $myusername;
         $res = [
            'status' => 200,
            'message' => 'Login Successfull'
        ];
        echo json_encode($res);
        return $res;
	}
	  else if($count == 0)
	  {
      $res = [
         'status' => 300,
         'message' => 'Failed'
     ];
     echo json_encode($res);
     return;
      }
   }	


?>