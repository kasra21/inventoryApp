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
        $_SESSION["username"];
        $_SESSION["loggedin"];
        if($_SESSION["loggedin"] == false){
          header("Location: login.php");
        }
        require("../php/dbinfo.php");

        $partNames = $_POST['partName'];
        $qtys = $_POST['quantity'];
        $prices = $_POST['itemPrice'];
        $descriptions = $_POST['desc'];

        $temp = $_SESSION['companyName'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if (isset($_POST['Logout'])) {
              $_SESSION["loggedin"] = false;
              header("Location: login.php");
          }
          else if(isset($_POST['change'])){
            $query = "SELECT * FROM inventory where company_name='$temp'";
            $result1 = mysql_query($query);
            $i =0;
            while ($row = mysql_fetch_assoc($result1)){

              $temp2 = $partNames[$i];
              $temp3 = $qtys[$i];
              $temp4 = $prices[$i];
              $temp5 = $descriptions[$i];
              $temp6 = $row['PKEY'];

              $query = "UPDATE inventory SET pkey = '$temp $temp2',
                      part_name = '$temp2',
                      qty = $temp3,
                      price = $temp4,
                      description =  '$temp5',
                      time_stamp = NOW() WHERE pkey = '$temp6'";
              mysql_query($query) or die(mysql_error());
              $i++;
            }

          }
          elseif(isset($_POST['addR'])){
            header("Location: addItem.php");
          }
          else{
            $i =0;
            $query = "SELECT * FROM inventory where company_name='$temp'";
            $result2 = mysql_query($query);
            while($row = mysql_fetch_assoc($result2)){
              $remove = $_POST['Remove'.$i];
              if(isset($remove)){
                $tempPkey = $row['PKEY'];
                $sql = "DELETE FROM inventory where pkey = '$tempPkey'";
                $success = mysql_query($sql);
                if(!$success){
                  echo SQLerror;
                }
              }
              $i++;
            }
          }
        }
        $query = "SELECT * FROM inventory where company_name='$temp'";
        $result = mysql_query($query);

     ?>
      <div class="container">
        <div class="navbar navbar-default">
                  <div class="navbar-header">
                    <?php
                      if($_SESSION["role"] == 'a'){ ?>
                          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                          </button>
                       <div class="collapse navbar-collapse">
                           <ul class="nav navbar-nav">
                               <li class="active"><a href="inventoryUser.php">Manage Inventory</a></li>
                               <li><a href="manageUsers.php">Manage Users</a></li>
                           </ul>
                       </div>
                       <?php
                      }
                      ?>
                      <a class="navbar-brand">Inventory Management Application</a>
                  </div>
        </div>
      </div>
      <form action='inventoryUser.php' method='post'>
        <h1 style="text-align:center;">INVENTORY MANAGEMENT PAGE</h1>
        <h1 style="text-align:center;">Welcome <?php echo ($_SESSION["fname"]. " ". $_SESSION["lname"] ); ?></h1>
        <br>
        <br>

        <div class='container'>
          <div id="table-wrapper">
            <div id="table-scroll">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Part name</th>
                    <th>QTY</th>
                    <th>Price ($)</th>
                    <th>Description</th>
                    <?php   if($_SESSION["role"] == 'w' || $_SESSION["role"] == 'a'){ ?>
                      <th>Action</th>
                      <?php
                     }
                      ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                   while ($row = mysql_fetch_assoc($result)){ ?>
                    <tr>
                      <?php
                      if($_SESSION["role"] == 'w' || $_SESSION["role"] == 'a'){?>
                        <td><input style="min-width: 125px; width:100%;" class="EditText"  name='partName[]' value='<?php echo $row['part_name']; ?>'/></td>
                        <td><input style="width:100%;" class="EditText" type="number" name='quantity[]' value='<?php echo $row['qty']; ?>'/></td>
                        <td><input style="width:100%;" class="EditText" type="number" step="any" name='itemPrice[]' value='<?php echo $row['price']; ?>'/></td>
                        <td><input style="min-width: 150px; width:100%;" class="EditText"  name='desc[]' value='<?php echo $row['description']; ?>'/></td>
                        <td><input class='btn-primary' type='submit' value='Remove' name='Remove<?php echo($i); ?>'/></td>
                      <?php
                      }elseif($_SESSION["role"] == 'r'){
                        ?>
                        <td><?php echo $row['part_name']; ?></td>
                        <td><?php echo $row['qty']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                      <?php
                    }
                    ?>
                    </tr>
                  <?php
                  $i++;
                 }
                   ?>
                </tbody>
              </table>
            </div>
          </div>
          <br>
          <br>

          <div style="text-align:center;">
            <?php
              if($_SESSION["role"] == 'w' || $_SESSION["role"] == 'a'){
                echo("<input class='btn-primary' type='submit' value='Add Item' name='addR'/>");
              }
             ?>
          </div>
          <br>
          <div style="text-align:center;">
            <input class='btn-primary' type='submit' value='Logout' name='Logout'/>
            <?php
              if($_SESSION["role"] == 'w' || $_SESSION["role"] == 'a'){
                echo("<input class='btn-primary' type='submit' value='Make changes' name='change'/>");
              }
             ?>
          </div>
          <br>
          <br>

        </div>
      </form>

      <script src="../jQuery/jquery-2.1.4.min.js"></script>
      <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
      <script src="../js/controller.js"></script>
  </body>

</html>
