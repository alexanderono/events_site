<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Update event - The Great North East</title>
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
        $event_name = isset($_REQUEST['event_name']) ? $_REQUEST['event_name'] : null;
        $event_location = isset($_REQUEST['event_location']) ? $_REQUEST['event_location'] : null;
        $event_date = isset($_REQUEST['event_date']) ? $_REQUEST['event_date'] : null;
        $event_host = isset($_REQUEST['event_host']) ? $_REQUEST['event_host'] : null;
        $event_details = isset($_REQUEST['event_details']) ? $_REQUEST['event_details'] : null;

        $event_name = mysqli_escape_string($conn, $event_name);
      	$event_location = mysqli_escape_string($conn, $event_location);
        $event_details = mysqli_escape_string($conn, $event_details);

        $insertSQL = "UPDATE tgne_events SET event_name = '$event_name', event_location = '$event_location', event_date = '$event_date', event_host = '$event_host', event_details = '$event_details' WHERE event_id = $event_id";

        $success = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
        if($success === true){
          echo "Success, event updated.";
        }else{
          echo "Error, event not updated.";
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
