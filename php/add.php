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
<!-- customer details content -->
<!-- customer name control -->

  
<form id="lform">
<div class="row col col-md-12">
  <div class="col col-md-12 form-group">
    <label class="font-weight-bold" for="customer_id">Student ID:</label>
    <input type="text" class="form-control" placeholder="id" id="customer_id" style="width:150%;" required >
    <code class="text-danger small font-weight-bold float-right" id="id_error" style="display: none;"></code>
  </div>
</div>

<div class="row col col-md-12">
  <div class="col col-md-12 form-group">
    <label class="font-weight-bold" for="customer_name">Student Name :</label>
    <input type="text" class="form-control" placeholder="Name" id="customer_name" style="width:150%;" required>
    <code class="text-danger small font-weight-bold float-right" id="name_error" style="display: none;"></code>
  </div>
</div>




<div class="row col col-md-12">
  <div class="col col-md-12 form-group">
    <label class="font-weight-bold" for="customer_password">Password :</label>
    <input type="password" class="form-control" placeholder="Password" id="password" style="width:150%;" required  pattern=".{8,}" title="Password must have at least 8 characters.">
    <code class="text-danger small font-weight-bold float-right" id="password_error" style="display: none;"></code>
  </div>    
</div>

<div class="row col col-md-12">
  <div class="col col-md-12 form-group">
    <label class="font-weight-bold" for="student_email">Student Email ID :</label>
    <input type="email" class="form-control" placeholder="Email ID" id="student_email" style="width:150%;" required>
    <code class="text-danger small font-weight-bold float-right" id="student_email_error" style="display: none;"></code>
  </div>
</div>

<div class="row col col-md-12">
  <div class="col col-md-12 form-group">
    <label class="font-weight-bold" for="contact_number">Contact Number :</label>
    <input type="tel" class="form-control" placeholder="Contact Number" id="contact_number" style="width:150%;" required>
    <code class="text-danger small font-weight-bold float-right" id="contact_number_error" style="display: none;"></code>
  </div>
</div>

<!-- customer contact number control -->
<script>

  function validatePassword(password, error) {
  var result = document.getElementById(error);
  result.style.display = "block";
  if (password.length < 8) {
    result.innerHTML = "Password must contain at least 8 characters!";
    return false;
  } else {
    result.style.display = "none";
    return true;
  }
}
</script>


<!-- customes's doctor name -->

<!-- customer details content end -->

<!-- horizontal line -->
<div >
  <hr class="col-md-12 float-left" style="margin-left: 17px; width: 100%; border-top: 2px solid  #02b6ff;">
</div>

<!-- form submit button -->
<div class="row col col-md-12">
  &emsp;
  <div class="form-group m-auto">
    <button class="btn btn-primary" type="submit" style="margin-left: 50px;">ADD</button>
  </div>
  <!--
  &emsp;
  <div class="form-group">
    <button class="btn btn-success form-control">Save and Add Another</button>
  </div>
  -->
</div>
</form>

<!-- result message -->
<div id="customer_acknowledgement" class="col-md-12 h5 text-success font-weight-bold text-center" style="font-family:'Times New Roman', Times, serif;padding-top: 10%;"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
<script>
$(document).ready(function() {
    $("#lform").submit(function(e) {
        e.preventDefault();

        // Get the input values, including email and contact number
        const studentName = $("#customer_name").val().trim();
        const studentID = $("#customer_id").val().trim();
        const password = $("#password").val().trim();
        const studentEmail = $("#student_email").val().trim();
        const contactNumber = $("#contact_number").val().trim();

        // Create a FormData object to send data to the PHP script
        const formData = new FormData();
        formData.append('studentName', studentName);
        formData.append('studentID', studentID);
        formData.append('password', password);
        formData.append('studentEmail', studentEmail); // Include email
        formData.append('contactNumber', contactNumber); // Include contact number

        // Send an AJAX request to the PHP script
        $.ajax({
            type: 'POST',
            url: 'php/add_new_customer.php', // Update the path based on your directory structure
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Display the response from the PHP script
                const acknowledgement = document.getElementById('customer_acknowledgement');
                acknowledgement.textContent = "Student Added Succesfully";
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during student addition.'
                });
            }
        });

        // You can also reset the form fields after submission if needed
        $("#customer_id").val('');
        $("#customer_name").val('');
        $("#password").val('');
        $("#student_email").val('');
        $("#contact_number").val('');
    });
});

</script>

