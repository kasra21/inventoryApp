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
        $_SESSION["fname"] = null;
        $_SESSION["lname"] = null;
        $_SESSION["companyName"] = null;
        $_SESSION["role"] = null;
        $_SESSION["username"] = null;
        $_SESSION["loggedin"] = false;
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
          elseif (isset($_POST['LogIn'])) {
            $user = $_POST['usernameField'];
            $pass = $_POST['PassField'];
            $compName = $_POST['compName'];

            //-------------------------------------------------------------------

            $query = "SELECT * FROM admin_users where username='$user'";
            $AdminUserResult = mysql_query($query);
            $row_num_Admin = mysql_num_rows($AdminUserResult);
            $query = "SELECT * FROM users where username='$user' and company_name='$compName' ";
            $UserResult = mysql_query($query);
            $row_num_User = mysql_num_rows($UserResult);


            if($pass != null && $user != null){

                if ($row_num_User > 0) {
                  $UserRow = mysql_fetch_assoc($UserResult);
                  if($UserRow['status'] == 'a' && $UserRow['role'] != 'p'){
                    if($UserRow['password'] == $pass){
                      $_SESSION["fname"] = $UserRow['first'];
                      $_SESSION["lname"] = $UserRow['last'];
                      $_SESSION["companyName"] = $UserRow['company_name'];
                      $_SESSION["role"] = $UserRow['role'];
                      $_SESSION["username"] = $UserRow['username'];
                      $_SESSION["loggedin"] = true;
                      header("Location: inventoryUser.php");
                    }
                    else{
                      echo "<script> alert('Worng user password'); </script>";
                    }
                  }
                  elseif($UserRow['status'] == 'p'){
                    echo "<script> alert('Your registration request has not been approaved yet, please wait for approaval'); </script>";
                  }
                  elseif($UserRow['status'] == 'd'){
                    echo "<script> alert('Your user has been deactivated, please contact the administrator'); </script>";
                  }
                }
                elseif($row_num_Admin > 0){
                  $UserRow = mysql_fetch_assoc($AdminUserResult);
                  if($UserRow['status'] == 'a'){
                    if($UserRow['password'] == $pass){
                      $_SESSION["username"] = $UserRow['username'];

                      $temp = $UserRow['owner_email'];
                      $query = "SELECT * FROM main_table where owner_email='$temp'";
                      $ResultUser = mysql_query($query);
                      $RowuserDetail = mysql_fetch_assoc($ResultUser);

                      $_SESSION["fname"] = $RowuserDetail['owner_first'];
                      $_SESSION["lname"] = $RowuserDetail['owner_last'];
                      $_SESSION["companyName"] = $RowuserDetail['company_name'];
                      $_SESSION["role"] = 'a';
                      $_SESSION["loggedin"] = true;
                      header("Location: inventoryUser.php");
                    }
                    else{
                      echo "<script> alert('Worng admin password'); </script>";
                    }
                  }
                  elseif($UserRow['status'] == 'p'){
                    echo "<script> alert('Your registration request has not been approaved yet, please wait for approaval'); </script>";
                  }
                  elseif($UserRow['status'] == 'd'){
                    echo "<script> alert('Your user has been deactivated'); </script>";
                  }
                }
            }
            else{
              echo "<script> alert('wrong username or password'); </script>";
            }


            //-------------------------------------------------------------------
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
                          <li class="active"><a href="login.php">Login</a></li>
                          <li><a href="registerCompany.php">Register Company</a></li>
                          <li><a href="registerUser.php">Register User</a></li>
                      </ul>
                  </div>
        </div>
      </div>
      <form action='login.php' method='post'>

        <h1 style="text-align:center;">LOGIN PAGE</h1>
        <br>

        <div class='container'>
          <div style="text-align:center;">
            <br>
            <h4>Company Name:</h4>
            <select class='GenDropDownMenu' id='compName' name='compName' style="width:250px;">
              <?php while ($row = mysql_fetch_assoc($result)) {
                if($row['company_name'] != null){
              ?>
                <option> <?php echo $row['company_name']; ?> </option>
              <?php } } ?>
            </select>

            <br>
            <h4> Username </h4>
            <input class="EditText"  name='usernameField' placeholder='Username'/>
            <br>
            <h4> Password </h4>
            <input class="EditText"  name='PassField' type='password' placeholder='Password'/>

            <br>
            <br>
            <a style="color:#fff;" href="registerUser.php">Sign up now</a>
            <br>
            <br>
            <input class='btn-primary' type='submit' value='Go Back' name='backBtn'/>
            <input class='btn-primary' type='submit' value='Log In' name='LogIn'/>
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
