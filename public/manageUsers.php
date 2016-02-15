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
        if($_SESSION["loggedin"] == false || $_SESSION["role"] != 'a' ){
          header("Location: login.php");
        }
        require("../php/dbinfo.php");

        $usernames = $_POST['usernames'];
        $firsts = $_POST['firsts'];
        $lasts = $_POST['lasts'];
        $roles = $_POST['roles'];
        $statuses = $_POST['statuses'];

        $temp = $_SESSION['companyName'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if (isset($_POST['Logout'])) {
              $_SESSION["loggedin"] = false;
              header("Location: login.php");
          }
          else if(isset($_POST['change'])){
            $query = "SELECT * FROM users where company_name='$temp'";
            $result1 = mysql_query($query);
            $i =0;
            while ($row = mysql_fetch_assoc($result1)){

              $temp2 = $firsts[$i];
              $temp3 = $lasts[$i];
              $temp4 = $roles[$i];
              $temp5 = $statuses[$i];
              $temp6 = $row['username'];

              $query = "UPDATE users SET first = '$temp2',
                      last = '$temp3',
                      role = '$temp4',
                      status =  '$temp5' WHERE username = '$temp6'";
              mysql_query($query) or die(mysql_error());

              $i++;
            }

          }
          // elseif(isset($_POST['addUser'])){
          //   header("Location: addItem.php");
          // }
        }
        $query = "SELECT * FROM users where company_name='$temp'";
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
                               <li><a href="inventoryUser.php">Manage Inventory</a></li>
                               <li class="active"><a href="manageUsers.php">Manage Users</a></li>
                           </ul>
                       </div>
                       <?php
                      }
                      ?>
                      <a class="navbar-brand">Inventory Management Application</a>
                  </div>
        </div>
      </div>
      <form action='manageUsers.php' method='post'>
        <h1 style="text-align:center;">USERS MANAGEMENT PAGE</h1>
        <h1 style="text-align:center;">Welcome administrator <?php echo ($_SESSION["fname"]. " ". $_SESSION["lname"] ); ?></h1>
        <h1 style="text-align:center;">You are the administrator for <?php echo ($_SESSION["companyName"]); ?></h1>
        <br>
        <br>

        <div class='container'>
          <div id="table-wrapper">
            <div id="table-scroll">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Username</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Role</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysql_fetch_assoc($result)){ ?>
                    <tr>
                        <td><input readonly style="min-width: 100px; width:100%;" class="EditText" name='usernames[]' value='<?php echo $row['username']; ?>'/></td>
                        <td><input style="min-width: 100px; width:100%;" class="EditText" name='firsts[]' value='<?php echo $row['first']; ?>'/></td>
                        <td><input style="min-width: 100px; width:100%;" class="EditText" name='lasts[]' value='<?php echo $row['last']; ?>'/></td>
                        <td><select class='GenDropDownMenu' name='roles[]' style="min-width: 100px; width:100%;" >
                            <option value='<?php echo $row['role']; ?>'>
                              <?php
                            if($row['role'] == 'a'){echo "Administrator";}
                            elseif($row['role'] == 'r'){echo "Readonly";}
                            elseif($row['role'] == 'w'){echo "Write";}
                             ?></option>
                            <option value='a'>Administrator</option>
                            <option value='r'>Readonly</option>
                            <option value='w'>Write</option>
                        </select></td>
                        <td><select class='GenDropDownMenu' name='statuses[]' style="min-width: 100px; width:100%;" >
                            <option value='<?php echo $row['status']; ?>'>
                              <?php
                            if($row['status'] == 'p'){echo "Pending";}
                            elseif($row['status'] == 'a'){echo "Active";}
                            elseif($row['status'] == 'd'){echo "Disactive";}
                             ?></option>
                            <option value='p'>Pending</option>
                            <option value='a'>Active</option>
                            <option value='d'>Disactive</option>
                        </select></td>

                    </tr>
                  <?php }
                   ?>
                </tbody>
              </table>
            </div>
          </div>
          <br>
          <br>

          <!-- <div style="text-align:center;">
              <input class='btn-primary' type='submit' value='Add User' name='addUser'/>
          </div>
          <br> -->
          <div style="text-align:center;">
            <input class='btn-primary' type='submit' value='Logout' name='Logout'/>
            <input class='btn-primary' type='submit' value='Make changes' name='change'/>
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
