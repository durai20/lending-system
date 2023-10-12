<?php
require "db_connection.php";

if ($con) {
    if (isset($_GET["action"]) && $_GET["action"] == "delete") {
        $id = $_GET["id"];
        $query = "DELETE FROM product WHERE ID = $id";
        $result = mysqli_query($con, $query);
        if (!empty($result)) {
            showCustomers(0);
        }
    }

    if (isset($_GET["action"]) && $_GET["action"] == "edit") {
        $id = $_GET["id"];
        showCustomers($id);
    }

    if (isset($_GET["action"]) && $_GET["action"] == "update") {
        $id = $_GET["id"];
        $product_name = ucwords($_GET["product_name"]);
        $product_quantity = $_GET["product_quantity"];
        $price = $_GET["price"];

        updatePurchase($id, $product_name, $product_quantity, $price);
    }

    if (isset($_GET["action"]) && $_GET["action"] == "cancel") {
        showCustomers(0);
    }

    if (isset($_GET["action"]) && $_GET["action"] == "search") {
        searchPurchase(strtoupper($_GET["text"]));
    }
}

function showCustomers($id)
{
    require "db_connection.php";
    if ($con) {
        $seq_no = 0;
        $query = "SELECT * FROM purchase_history";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $seq_no++;
            if ($row['no'] == $id) {
                showEditOptionsRow($seq_no, $row);
            } else {
                showCustomerRow($seq_no, $row);
            }
        }
    }
}

function showCustomerRow($seq_no, $row)
{
    ?>
    <tr>
        <td><?php echo $row['no'] ?></td>
        
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['product_quantity']; ?></td>
        <td><?php echo $row['product_price']; ?></td>
        <td><?php echo $row['date']; ?></td>
       
        </td>
    </tr>
    <?php
}

   


function showEditOptionsRow($seq_no, $row)
{
    ?>
    <tr>
        <td><?php echo $seq_no; ?></td>
        <td><?php echo $row['ID'] ?></td>
        <td>
            <input type="text" class="form-control"
                   value="<?php echo $row['PRODUCT_NAME']; ?>"
                   placeholder="Product Name"
                   id="customer_name_<?php echo $row['ID']; ?>">
        </td>
        <td>
            <input type="number" class="form-control"
                   value="<?php echo $row['PRODUCT_QUANTITY']; ?>"
                   placeholder="Product Quantity"
                   id="customer_quantity_<?php echo $row['ID']; ?>">
        </td>
        <td>
            <input type="number" class="form-control"
                   value="<?php echo $row['PRICE']; ?>"
                   placeholder="Price"
                   id="customer_price_<?php echo $row['ID']; ?>">
        </td>
        <td>
            <button href="" class="btn btn-success btn-sm"
                    onclick="updateCustomer('<?php echo $row['ID'];?>');">
                <i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-danger btn-sm" onclick="cancel();">
                <i class="fa fa-close"></i>
            </button>
        </td>
    </tr>
    <?php
}

function updatePurchase($id, $product_name, $product_quantity, $price)
{
    require "db_connection.php";
    $stmt = mysqli_prepare($con, "UPDATE product SET PRODUCT_NAME = ?, PRODUCT_QUANTITY = ?, PRICE = ? WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "siii", $product_name, $product_quantity, $price, $id);
    $result = mysqli_stmt_execute($stmt);
    if (!empty($result)) {
        showCustomers(0);
    }
}


