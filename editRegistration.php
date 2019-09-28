<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edit registration - The Great North East</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
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
    <div class="divider"></div>
    <div class="blogpost">
      <?php
        $registrant_id= isset($_REQUEST['registrant_id']) ? $_REQUEST['registrant_id'] : null;
        $event_id= isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : null;

        $sql = "SELECT tgne_registrants.registrant_id, tgne_events.event_name FROM tgne_registrants INNER JOIN tgne_events ON tgne_registrants.registrant_event = tgne_events.event_id WHERE registrant_id = '$registrant_id'";

        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        while($row = mysqli_fetch_assoc($queryresult)){
          $event_name = $row['event_name'];
          echo "<h1>Unregister</h1>
                  <form method=\"post\" action=\"deleteRegistration.php\" onsubmit=\"return confirm('Are you sure?');\">
                    <div><input type=\"hidden\" name=\"registrant_id\" value=\"$registrant_id\"></div>
                    <div><input type=\"submit\" value=\"Unregister\"></div>
                  </form>";
          echo "<div class=\"divider\"></div>
            <p><a href=\"registrations.php\">Click here to go back</a></p>";

        }
        mysqli_free_result($queryresult);
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
