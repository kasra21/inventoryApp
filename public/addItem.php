<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="IE=10" name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory App</title>
    <link rel="shortcut icon" type="image/x-icon" href="../ressources/images/icon.png" />
    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' type='css' href="../css/index.css">
    <link rel='stylesheet' type='css' href="../css/table.css">
  </head>

  <body>
    <?php
        session_start();
        $_SESSION["fname"];
        $_SESSION["lname"];
        $_SESSION["companyName"];
        $_SESSION["role"];
        $_SESSION["loggedin"];
        if($_SESSION["loggedin"] == false || $_SESSION["role"] == 'r'){
          header("Location: login.php");
        }
        require("../php/dbinfo.php");

        $partName = $_POST['partName'];
        $qty = $_POST['quantity'];
        $price = $_POST['itemPrice'];
        $description = $_POST['desc'];

        $temp = $_SESSION['companyName'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if (isset($_POST['Logout'])) {
              $_SESSION["loggedin"] = false;
              header("Location: login.php");
          }
          elseif (isset($_POST['cancel'])) {
              header("Location: inventoryUser.php");
          }
          elseif(isset($_POST['add'])){
            $query = "SELECT * FROM inventory where company_name='$temp' and pkey = '$temp $partName'";
            $result = mysql_query($query);
            $row_num = mysql_num_rows($result);
            if($row_num > 0){
              echo "<script> alert('This part name already exists'); </script>";
            }
            else{
              $success = $resultQuery = mysql_query("INSERT INTO inventory
                VALUES (
                    '$temp $partName',
                    '$partName',
                    '$temp',
                    $qty,
                    $price,
                    '$description',
                    NOW( )
                   )");
              if($success){
                header("Location: inventoryUser.php");
              }
              else{
                echo "<script> alert('There has been an error, try again.'); </script>";
              }
            }
          }
        }

     ?>
     <form action='addItem.php' method='post'>
      <div class="container">
        <div class="navbar navbar-default">
                  <div class="navbar-header">
                      <a class="navbar-brand">Inventory Management Application</a>
                  </div>
        </div>
      </div>
      <input class='btn-primary' type='submit' value='Logout' name='Logout'/>
        <h1 style="text-align:center;">ADD ITEM PAGE</h1>
        <h1 style="text-align:center;">Welcome <?php echo ($_SESSION["fname"]. " ". $_SESSION["lname"] ); ?></h1>
        <br>
        <br>

        <div class='container' style="text-align:center;">
          <h4> Part Name </h4>
          <input class="EditText"  name='partName' placeholder='Part Name'/>
          <br>
          <h4> Quantity </h4>
          <input class="EditText" type="number" name='quantity' placeholder='Quantity'/>
          <br>
          <h4> Price ($) </h4>
          <input class="EditText" type="number" step="any" name='itemPrice' placeholder='Price ($)'/>
          <br>
          <h4> Description </h4>
          <input class="EditText"  name='desc' placeholder='Description'/>
          <br>
          <br>
          <input class='btn-primary' type='submit' value='Cancel' name='cancel'/>
          <input class='btn-primary' type='submit' value='Add Item' name='add'/>
          <br>
          <br>

        </div>
      </form>

      <script src="../jQuery/jquery-2.1.4.min.js"></script>
      <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
      <script src="../js/controller.js"></script>
  </body>

</html>
