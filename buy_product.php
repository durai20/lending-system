<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Buy Product</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="" type="image/x-icon">
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
          createHeader('handshake', 'Buy Product', 'Purchase     Product');
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
                    <th style="width: 15%;">Total Price</th>

                    <th style="width: 15%;">Action  </th>
            			</tr>
            		</thead>
            		<tbody id="customers_div">
                  <?php
                    require 'php/buy_product.php';
                    showCustomers(0);
                  ?>
            		</tbody>
            	</table>
              <script>
       function addProduct(productId, productName, quantity, productPrice) {
    var confirmation = confirm('Do you want to Buy "' + productName + '" ?');

    if (confirmation) {
        $.ajax({
            type: 'POST',
            url: 'addProductToDatabase.php', // Use the correct URL to your PHP file.
            data: {
                productId: productId,
                productName: productName,
                quantity: quantity,
                productPrice: productPrice,
            },
            success: function(response) {
                // Handle the response from the server here if needed.
                response = JSON.parse(response); 
                  // Display the response from the PHP script
                  const acknowledgement = document.getElementById('customer_acknowledgement');
                  acknowledgement.textContent = response.message ;            },
            error: function(response) {
                // Handle any errors that occur during the AJAX request.
                response = JSON.parse(response); 
                  // Display the response from the PHP script
                  const acknowledgement = document.getElementById('customer_acknowledgement');
                  acknowledgement.textContent = response.message ;
            }
        });
    } else {
        // User clicked Cancel in the confirmation dialog, no action needed.
    }
}

    </script>
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
