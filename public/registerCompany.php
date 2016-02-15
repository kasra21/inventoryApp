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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if (isset($_POST['backBtn'])) {
                header("Location: ../index.html");
          }
          elseif (isset($_POST['req'])) {
            $company = $_POST['companyField'];
            $first = $_POST['FirstField'];
            $last = $_POST['LastField'];
            $address = $_POST['locationField'];
            $webUrl = $_POST['url'];
            $companyType = $_POST['compType'];
            $emailAdd = $_POST['email'];
            $user = $_POST['usernameField'];
            $pass = $_POST['PassField'];
            $repass = $_POST['RePassField'];
            $status = 'p';

            if($pass === $repass){
              $query = "SELECT * FROM users where username = '$user' ";
              $query2 = "SELECT * FROM admin_users where username = '$user' ";
              $query3 = "SELECT * FROM main_table where company_name = '$company' ";
              $query4 = "SELECT * FROM admin_users where owner_email = '$emailAdd' ";
              $resultUsers = mysql_query($query);
              $resultUsers2 = mysql_query($query2);
              $resultUsers3 = mysql_query($query3);
              $resultUsers4 = mysql_query($query4);
              $row_num = mysql_num_rows($resultUsers);
              $row_num2 = mysql_num_rows($resultUsers2);
              $row_num3 = mysql_num_rows($resultUsers3);
              $row_num4 = mysql_num_rows($resultUsers4);
              if($row_num4 == 0){
                if($row_num3 == 0){
                  if($row_num == 0 && $row_num2 == 0){

                    $success = $resultQuery = mysql_query("INSERT INTO main_table
                      VALUES (
                          '$company',
                          '$emailAdd',
                          '$first',
                          '$last',
                          '$companyType',
                          '$webUrl',
                          '$address',
                          NOW( ) ,
                          '$status'
                         )");

                      $success1 = $resultQuery = mysql_query("INSERT INTO admin_users
                        VALUES (
                            '$emailAdd',
                            '$user',
                            '$pass',
                            '$status'
                          )");

                    if(!$success || !$success1){
                      echo "<script> alert('The username/email entered already exists'); </script>";
                    }
                    else{
                      echo "<script> alert('Your request was successfully submitted, please wait for approaval'); </script>";
                    }

                  }
                  else{
                    echo "<script> alert('user already exists'); </script>";
                  }
                }
                else{
                  echo "<script> alert('The company name already exists'); </script>";
                }
              }
              else{
                echo "<script> alert('The email address already exists'); </script>";
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
                          <li class="active"><a href="registerCompany.php">Register Company</a></li>
                          <li><a href="registerUser.php">Register User</a></li>
                      </ul>
                  </div>
        </div>
      </div>
      <form action='registerCompany.php' method='post'>

        <h1 style="text-align:center;">REGISTER A COMPANY</h1>
        <br>

        <div class='container'>
          <div style="text-align:center;">
            <br>
            <h4> Company Name: </h4>
            <input class="EditText"  name='companyField' placeholder='Company Name'/>
            <br>
            <h4> Company's location/Address: </h4>
            <input class="EditText"  name='locationField' placeholder='Address'/>
            <br>
            <h4> Type of Company </h4>
            <select class='GenDropDownMenu' id='compName' name='compType' style="width:250px;" >
                <option value='E'>Electronic</option>
                <option value='C'>Computer</option>
                <option value='M'>Mechanical</option>
                <option value='I'>Infrastructure</option>
                <option value='D'>Medical/Drugs</option>
                <option value='W'>clothing </option>
                <option value='S'>Services/Technology</option>
            </select>
            <br>
            <h4> Company website URL (Optional): </h4>
            <input class="EditText" type='url'  name='url' placeholder='http://example.com'/>
            <br>
            <h4> Your email: </h4>
            <input class="EditText" type='email'  name='email' placeholder='email@example.com'/>
            <br>
            <h4> First Name </h4>
            <input class="EditText"  name='FirstField' placeholder='First Name'/>
            <br>
            <h4> Last Name </h4>
            <input class="EditText"  name='LastField' placeholder='Last Name'/>
            <br>
            <h4> Username </h4>
            <input class="EditText"  name='usernameField' placeholder='Username'/>
            <br>
            <h4> Password </h4>
            <input class="EditText"  name='PassField' type='password' placeholder='Password'/>
            <br>
            <h4> Re-enter Password </h4>
            <input class="EditText"  name='RePassField' type='password' placeholder='Password'/>

            <br>
            <br>
            <br>
            <input class='btn-primary' type='submit' value='Go Back' name='backBtn'/>
            <input class='btn-primary' type='submit' value='Send Request' name='req'/>
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
