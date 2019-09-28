<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registrations - The Great North East</title>
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

    <div class="blogpost">
      <?php
      if (null !== $_SESSION['uName']){
        echo "<h1>Your registrations</h1>
              <p>Here you'll find all the events you have registered for. You may leave feedback or
              unregister by clicking a registration.</p></div>
              <div class=\"divider\"></div>";
        $username = $_SESSION['uName'];
        $sql = "SELECT tgne_registrants.registrant_id, tgne_events.event_id, tgne_events.event_name, tgne_events.event_location, tgne_events.event_date FROM tgne_registrants INNER JOIN tgne_events ON tgne_registrants.registrant_event = tgne_events.event_id WHERE registrant_username = '$username'";

        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        while($row = mysqli_fetch_assoc($queryresult)){
          $date = date("Y-m-d");
          $event_id = $row['event_id'];
          $registrant_id = $row['registrant_id'];
          $event_name = $row['event_name'];
          $event_location = $row['event_location'];
          $event_date = $row['event_date'];
          if($registrant_id !== 0){
            if(strtotime($event_date) < strtotime($date)){
              echo "<div class=\"blogpost\"><h2><a href = \"editRegistration2.php?registrant_id=$registrant_id&event_id=$event_id\">$event_name, $event_location, $event_date</a></h2></div>
                    <div class=\"divider\"></div>";
            }else{
              echo "<div class=\"blogpost\"><h2><a href = \"editRegistration.php?registrant_id=$registrant_id&event_id=$event_id\">$event_name, $event_location, $event_date</a></h2></div>
                    <div class=\"divider\"></div>";
            }
        }
      }
        mysqli_free_result($queryresult);
          mysqli_close($conn);
      }else{
        echo "<p>Please log in to access this page.</p>";
      }
      ?>

    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
