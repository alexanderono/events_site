<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Log in - The Great North East</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="">
  </head>
  <body>
  <div id="bigdamnwrapper">

    <div id="topbar">
      <img src="img\banner.png"/>
      <nav>
        <ul>
          <li>
            <a href="home.php">Home</a>
          </li>
          <li>
            <a href="signup.php">Sign up</a>
          </li>
          <li>
            <a href="currentEvents.php">Events</a>
          </li>
          <li>
            <a href="feedback.php">Feedback</a>
          </li>
          <?php
            if (isset($_SESSION['staff-logged-in'])){
              echo "<li><a href=\"registrations.php\">Registrations</a></li>
                    <li><a href=\"staff.php\">Staff</a></li>";
            }else if(isset($_SESSION['admin-logged-in'])){
              echo "<li><a href=\"registrations.php\">Registrations</a></li>
                    <li><a href=\"staff.php\">Staff</a></li>
                    <li><a href=\"admin.php\">Admin</a></li>";
            }else if(isset($_SESSION['user-logged-in'])){
              echo "<li><a href=\"registrations.php\">Registrations</a></li>";
            }
          ?>
        </ul>
        <?php
          if (isset($_SESSION['uName'])) {
            $username = $_SESSION['uName'];
            echo "<div><p>Logged in as: $username</p>
            <form method=\"post\" action=\"logoutProcess.php\">
            <input type=\"submit\" value=\"Logout\"></div>
            </form>";
          }else{
            echo "<div><form method=\"post\" action=\"loginProcess.php\">
                  <div>Username <input type=\"text\" name=\"username\">
                  Password <input type=\"password\" name=\"password\">
                  <input type=\"submit\" value=\"Login\"></div></form></div>
                  </form>";
          }
        ?>
      </nav>
    </div>
    <div class="blogpost">
      <?php
        error_reporting(0);
        $username = filter_has_var(INPUT_POST, 'username') ? $_POST['username']: null;
        $password  = filter_has_var(INPUT_POST, 'password') ? $_POST['password']: null;

        if(empty($username)){
          die("<p>You have not entered your username. <a href=\"loginForm.html\">Go back</a></p>");
        }
        if(empty($password)){
          die("<p>You have not entered your password. <a href=\"loginForm.html\">Go back</a></p>");
        }

        $sql = "SELECT user_hashpass, user_usertype FROM tgne_users WHERE user_username = '$username'";

      	$queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        while($row = mysqli_fetch_assoc($queryresult)){
          $passwordhash = $row['user_hashpass'];
          $comparison = $row['user_usertype'];
        }
        if($passwordhash === null){
          echo "<p>No user exists with that username. Please try again.</p>";
        }else{
          if(password_verify($password, $passwordhash)){
            echo "<p>Password is valid!</p>";
            echo "<p>Logged in as: $comparison</p>";
            if($comparison === 'user'){
              $_SESSION['user-logged-in'] = true;
              $_SESSION['uName'] = $username;
              echo '<script type="text/javascript">
                    window.location = "currentEvents.php"
                    </script>';
            }else if($comparison === 'staff'){
              $_SESSION['staff-logged-in'] = true;
              $_SESSION['uName'] = $username;
              echo '<script type="text/javascript">
                    window.location = "staff.php"
                    </script>';
            }else if($comparison === 'admin'){
              $_SESSION['admin-logged-in'] = true;
              $_SESSION['uName'] = $username;
              echo '<script type="text/javascript">
                    window.location = "admin.php"
                    </script>';
            }
          }else{
            echo "<p>Invalid username or password, please try again.</p>";
          }
        }

        mysqli_close($conn);

      ?>
    </div>
    <div class="divider"></div>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
