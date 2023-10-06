<?php
// Include your database connection file (db_connection.php) if needed
include("config.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the action sent via POST to determine the operation
    $action = $_POST['action'];

    if ($action === 'addStudent') {
        // Handle student data insertion here
        $studentName = mysqli_real_escape_string($db, $_POST['studentName']);
        $studentID = mysqli_real_escape_string($db, $_POST['studentID']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        // Sanitize and validate data if necessary
        // ...

        // Perform the database insertion
        $query = "INSERT INTO customers (name, id, password) VALUES (?, ?, ?)";

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($db, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $studentName, $studentID, $password);

            if (mysqli_stmt_execute($stmt)) {
                $res = [
                    'status' => 200,
                    'message' => "Student $studentName added successfully!"
                ];
                echo json_encode($res);
                return;
            } else {
                $res = [
                    'status' => 300,
                    'message' => "Failed to add student: " . mysqli_error($db)
                ];
                echo json_encode($res);
                return;
            }

            mysqli_stmt_close($stmt);
        } else {
            $res = [
                'status' => 300,
                'message' => "Error in preparing SQL statement: " . mysqli_error($db)
            ];
            echo json_encode($res);
            return;
        }
    }
}
?>
