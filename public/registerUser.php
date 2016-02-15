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
  </head>

  <body>
    <?php
        session_start();
        require("../php/dbinfo.php");

        $query = "SELECT * FROM main_table where status='a'";
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        $row_num = mysql_num_rows($result);
        $col_num = mysql_num_fields($result);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if (isset($_POST['backBtn'])) {
                header("Location: ../index.html");
          }
          elseif (isset($_POST['Req'])) {
            $company = $_POST['compName'];
            $first = $_POST['FirstField'];
            $last = $_POST['LastField'];
            $user = $_POST['usernameField'];
            $pass = $_POST['PassField'];
            $repass = $_POST['RePassField'];
            $status = 'p';
            $role = 'p';

            if($pass === $repass){
              $query = "SELECT * FROM users where username = '$user' ";
              $resultUsers = mysql_query($query);
              $row_num_User = mysql_num_rows($resultUsers);
              $query = "SELECT * FROM admin_users where username = '$user' ";
              $resultUsers = mysql_query($query);
              $row_num_Admin = mysql_num_rows($resultUsers);
              if($row_num_User == 0 && $row_num_Admin == 0){

                $success = $resultQuery = mysql_query("INSERT INTO users
                  VALUES (
                      '$company',
                      '$user',
                      '$pass',
                      '$first',
                      '$last',
                      '$role',
                      '$status'
                     )");

                if(!$success){
                  echo "<script> alert('The username entered already exists, try another username'); </script>";
                }
                else{
                  echo "<script> alert('Your request was successfully submitted, please wait for approaval'); </script>";
                }

              }
              else{
                echo "<script> alert('The username entered already exists, try another username'); </script>";
              }
            }
            else{
              echo "<script> alert('New Password and Re-enter Password field need to match'); </script>";
            }
          }
        }
     ?>


      <div class="container">
        <div class="navbar navbar-default">
                  <div class="navbar-header">
                      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand">Inventory Management Application</a>
                  </div>
                  <div class="collapse navbar-collapse">
                      <ul class="nav navbar-nav">
                        <li><a href="login.php">Login</a></li>
                        <li><a href="registerCompany.php">Register Company</a></li>
                        <li class="active"><a href="registerUser.php">Register User</a></li>
                      </ul>
                  </div>
        </div>
      </div>
      <form action='registerUser.php' method='post'>

        <h1 style="text-align:center;">REGISTER AS A USER FOR A COMPANY</h1>
        <br>

        <div class='container'>
          <div style="text-align:center;">
            <br>
            <h4>Company Name:</h4>
            <select class='GenDropDownMenu' id='compName' name='compName' style="width:250px;" >
              <?php while ($row = mysql_fetch_assoc($result)) {
                if($row['company_name'] != null){
              ?>
                <option> <?php echo $row['company_name']; ?> </option>
              <?php } } ?>
            </select>

            <br>
            <h4> First Name </h4>
            <input class="EditText" name='FirstField' placeholder='First Name'/>
            <br>
            <h4> Last Name </h4>
            <input class="EditText"  name='LastField' placeholder='Last Name'/>
            <br>
            <h4> Username </h4>
            <input class="EditText"  name='usernameField' placeholder='Username'/>
            <br>
            <h4> New Password </h4>
            <input class="EditText"  name='PassField' type='password' placeholder='Password'/>
            <br>
            <h4> Re-enter Password </h4>
            <input class="EditText"  name='RePassField' type='password' placeholder='Password'/>

            <br>
            <br>
            <br>
            <input class='btn-primary' type='submit' value='Go Back' name='backBtn'/>
            <input class='btn-primary' type='submit' value='Send Request' name='Req'/>
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
