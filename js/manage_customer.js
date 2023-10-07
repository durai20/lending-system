function deleteCustomer(id) {
  var confirmation = confirm("Are you sure?");
  if(confirmation) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if(xhttp.readyState === 4 && xhttp.status == 200)
        document.getElementById('customers_div').innerHTML = xhttp.responseText;
    };
    xhttp.open("GET", "php/manage_customer.php?action=delete&id='" + id + "'", true);
    xhttp.send();
  }
}

function editCustomer(id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState === 4 && xhttp.status === 200) {
      document.getElementById('customers_div').innerHTML = xhttp.responseText;
    }
  };
  xhttp.open("GET", "php/manage_customer.php?action=edit&id=" + id, true);
  xhttp.send();
}


function updateCustomer(id) {
  var customer_name = document.getElementById("customer_name_" + id);
  var customer_password = document.getElementById("customer_password_" + id);
  
  if (customer_name !== null && customer_password !== null) {
    if (!validateName(customer_name.value, "name_error_" + id)) {
      customer_name.focus();
    } else if (!validatePassword(customer_password.value, "password_error_" + id)) {
      customer_password.focus();
    } else {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (xhttp.readyState === 4 && xhttp.status === 200) {
          document.getElementById('customers_div').innerHTML = xhttp.responseText;
        }
      };
      xhttp.open("GET", "php/manage_customer.php?action=update&id=" + id + "&name=" + customer_name.value + "&password=" + customer_password.value, true);
      xhttp.send();
    }
  } else {
    // Handle the case where the elements are not found
    console.error("Elements 'customer_name_" + id + "' and/or 'customer_password_" + id + "' not found.");
  }
}



function cancel() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      document.getElementById('customers_div').innerHTML = xhttp.responseText;
  };
  xhttp.open("GET", "php/manage_customer.php?action=cancel", true);
  xhttp.send();
}

function searchCustomer(text) {
  var xhttp = new XMLHttpRequest();
  var searchText = document.getElementById("searchInput").value;
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById('customers_div').innerHTML = xhttp.responseText;
    }
  };
  xhttp.open("GET", "search_customer.php?action=search&text=" + searchText, true);
  xhttp.send();
}
