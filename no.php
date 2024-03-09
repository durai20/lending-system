<?php
// Include the database connection configuration
require "db_connection.php";

// Function to sanitize user input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags($input));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted for editing
    if (isset($_POST['edit_customer'])) {
        $customer_id = sanitizeInput($_POST['customer_id']);
        $new_customer_name = sanitizeInput($_POST['new_customer_name']);
        
        // Perform the update query (you should use prepared statements for security)
        $sql = "UPDATE customers SET customer_name = ? WHERE ID = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $new_customer_name, $customer_id);
        
        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        
        // Close the prepared statement
        $stmt->close();
    } elseif (isset($_POST['delete_customer'])) {
        $customer_id = sanitizeInput($_POST['customer_id']);
        
        // Perform the delete query (you should use prepared statements for security)
        $sql = "DELETE FROM customers WHERE ID = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        
        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
        
        // Close the prepared statement
        $stmt->close();
    }
}

// Get the search text from the GET request
$searchText = $_GET['text'];

// Perform the database query (you may want to use prepared statements for security)
$sql = "SELECT * FROM customers WHERE ID LIKE '%$searchText%'";
$result = $con->query($sql);
$count = 1;

if ($result->num_rows > 0) {
    // Fetch the first row (you can also use $result->fetch_assoc() if you prefer associative arrays)
    $row = $result->fetch_row();

    // Output data of the first row
    echo '<table border="1">';
    echo '<tr>';
    echo '<td>' . $count . '</td>';
    echo '<td>' . $row[0] . '</td>';
    echo '<td>' . $row[1] . '</td>';
    echo '<td>' . $row[2] . '</td>';
    echo '<td>';
    echo '<button class="btn btn-info btn-sm" onclick="editCustomer(\'' . $row[0] . '\', \'' . $row[1] . '\')">Edit</button>';
    echo '<button class="btn btn-danger btn-sm" onclick="deleteCustomer(\'' . $row[0] . '\')">Delete</button>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';

    // Edit Form
    echo '<div id="editForm" style="display:none;">';
    echo '<form method="POST" action="">';
    echo '<input type="hidden" name="customer_id" id="customer_id" value="">';
    echo 'New Customer Name: <input type="text" name="new_customer_name" id="new_customer_name">';
    echo '<input type="submit" name="edit_customer" value="Save">';
    echo '</form>';
    echo '</div>';
    echo '<div id="deleteForm" style="display:none;">';
echo '<form method="POST" action="">';
echo '<input type="hidden" name="customer_id" id="customer_id" value="">';
echo '<input type="submit" name="delete_customer" value="Delete">';
echo '</form>';
echo '</div>';

} else {
    echo "No results found";
}
?>

<script>
function editCustomer(customerId, customerName) {
    document.getElementById('customer_id').value = customerId;
    document.getElementById('new_customer_name').value = customerName;
    document.getElementById('editForm').style.display = 'block';
}

function deleteCustomer(customerId) {
    if (confirm("Are you sure you want to delete this customer?")) {
        document.getElementById('customer_id').value = customerId;
        document.getElementById('deleteForm').submit();
    }
}
</script>
