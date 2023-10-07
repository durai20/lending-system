<?php
  require "db_connection.php";

  if($con) {
    if(isset($_GET["action"]) && $_GET["action"] == "delete") {
      $id = $_GET["id"];
      $query = "DELETE FROM customers WHERE ID = $id";
      $result = mysqli_query($con, $query);
      if(!empty($result))
    		showCustomers(0);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
      $id = $_GET["id"];
      showCustomers($id);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "update") {
      $id = $_GET["id"];
      $name = ucwords($_GET["name"]);
      $password = ucwords($_GET["password"]);
      
      updateCustomer($id, $name, $password);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "cancel")
      showCustomers(0);

    if(isset($_GET["action"]) && $_GET["action"] == "search")
      searchCustomer(strtoupper($_GET["text"]));
  }

  function showCustomers($id) {
    require "db_connection.php";
    if($con) {
      $seq_no = 0;
      $query = "SELECT * FROM customers";
      $result = mysqli_query($con, $query);
      while($row = mysqli_fetch_array($result)) {
        $seq_no++;
        if($row['ID'] == $id)
          showEditOptionsRow($seq_no, $row);
        else
          showCustomerRow($seq_no, $row);
      }
    }
  }

  function showCustomerRow($seq_no, $row) {
    ?>
    <tr>
      <td><?php echo $seq_no; ?></td>
      <td><?php echo $row['ID'] ?></td>
      <td><?php echo $row['NAME']; ?></td>
      <td><?php echo $row['PASSWORD']; ?></td>
      
      <td>
        <button href="" class="btn btn-info btn-sm" onclick="editCustomer('<?php echo $row['ID']; ?>');">
          <i class="fa fa-pencil"></i>
        </button>
        <button class="btn btn-danger btn-sm" onclick="deleteCustomer('<?php echo $row['ID']; ?>');">
          <i class="fa fa-trash"></i>
        </button>
      </td>
    </tr>
    <?php
  }

  function showEditOptionsRow($seq_no, $row) {
    ?>
    <tr>
      <td><?php echo $seq_no; ?></td>
      <td><?php echo $row['ID'] ?></td>
      <td>
        <input type="text" class="form-control" value="<?php echo $row['NAME']; ?>" placeholder="Name" id="customer_name_<?php echo $row['ID']; ?>" onkeyup="validateName(this.value, 'name_error_<?php echo $row['ID']; ?>');">
        <code class="text-danger small font-weight-bold float-right" id="name_error_<?php echo $row['ID']; ?>" style="display: none;"></code>
      </td>
      <td>
        <input type="text" class="form-control" value="<?php echo $row['PASSWORD']; ?>" placeholder="password" id="customer_password_<?php echo $row['ID']; ?>" onkeyup="validatePassword(this.value, 'password_error_<?php echo $row['ID']; ?>');">
        <code class="text-danger small font-weight-bold float-right" id="password_error_<?php echo $row['ID']; ?>" style="display: none;"></code>
      </td>
     
      <td>
        <button href="" class="btn btn-success btn-sm" onclick="updateCustomer('<?php echo $row['ID']; ?>');">
          <i class="fa fa-edit"></i>
        </button>
        <button class="btn btn-danger btn-sm" onclick="cancel();">
          <i class="fa fa-close"></i>
        </button>
      </td>
    </tr>
    <?php
  }
  
function updateCustomer($id, $name, $password) {
  require "db_connection.php";
  $stmt = mysqli_prepare($con, "UPDATE customers SET NAME = ?, PASSWORD = ? WHERE ID = ?");
  mysqli_stmt_bind_param($stmt, "sss", $name, $password, $id);
  $result = mysqli_stmt_execute($stmt);
  if(!empty($result))
    showCustomers(0);
}

function searchCustomer($text) {
  require "db_connection.php";
  if($con) {
    $seq_no = 0;
    $query = "SELECT * FROM customers WHERE UPPER(NAME) LIKE '%$text%'";
    $result = mysqli_query($con, $query);
    while($row = mysqli_fetch_array($result)) {
      $seq_no++;
      showCustomerRow($seq_no, $row);
    }
  }
}

?>

