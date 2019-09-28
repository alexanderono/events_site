<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Delete event - The Great North East</title>
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
          <input type=\"submit\" value=\"Logout\">
          </form></div>";
        }else{
          echo "<div><form method=\"post\" action=\"loginProcess.php\">
                Username <input type=\"text\" name=\"username\">
                Password <input type=\"password\" name=\"password\">
                <input type=\"submit\" value=\"Login\"></form>
                <a href=\"home.php\">Forgotten your password?</a></div>";
        }
        ?>
      </nav>
    </div>
    <div class="divider"></div>
    <div class="blogpost">
      <?php
        $event_id = isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : null;
        $insertSQL = "DELETE FROM tgne_events WHERE event_id = $event_id";
	       $success = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
        if($success === true){
          echo "Success, event deleted.";
        }else{
          echo "Error, event not deleted.";
        }
        echo "<p><a href=\"staff.php\">Click here to go back</a></p>";
      ?>
    </div>
    <div class="divider"></div>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
