<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Staff - The Great North East</title>
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
      echo "<script type=\"text/javascript\">
            function confirmUser(){
            var ask=confirm(\"Are you sure?\");
            if(ask){
              window.location=\"/delete\";
            }
          }
          </script>";
      if (isset($_SESSION['staff-logged-in']) || isset($_SESSION['admin-logged-in']) ){
        echo "<h1>Add a new event</h1>";
        echo "<form action=\"newEvent.php\" method=\"post\" class=\"detailform\">
              <p>Name:</p> <input type=\"text\" name=\"event_name\"><br/>
              <p>Location:</p> <input type=\"text\" name=\"event_location\"><br/>
              <p>Date (YYYY-MM-DD):</p> <input type=\"text\" name=\"event_date\"><br/>
              <p>Host:</p> <input type=\"text\" name=\"event_host\"><br/>
              <p>Event details:</p> <input type=\"text\" name=\"event_details\" size=\"100\"><br/>
              <p></p><input type=\"submit\" value=\"Go\" />
              </form></div>
              <div class=\"divider\"></div>";
        echo "<div class=\"blogpost\"><h1>Recorded events</h1>
              <p>You can edit/delete records by clicking on their names first.</p></div><div class=\"divider\"></div>";

        $sql = "SELECT event_id, event_name, event_location, event_date, event_host, event_details FROM tgne_events";

        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        while($row = mysqli_fetch_assoc($queryresult)){
          $event_id = $row['event_id'];
          $event_name = $row['event_name'];
          $event_location = $row['event_location'];
          $event_date = $row['event_date'];
          $event_details = $row['event_details'];

          echo "<div class=\"blogpost\">
                  <p>$event_name, $event_location, $event_date</p>
                  <p>$event_details</p>
                  <form method=\"post\" action=\"deleteEvent.php\" onsubmit=\"return confirm('Are you sure?');\">
                    <div><input type=\"hidden\" name=\"event_id\" value=\"$event_id\"></div>
                    <div><input type=\"submit\" value=\"Delete\"></div>
                  </form>
                  <form method=\"post\" action=\"editEvent.php\">
                    <div><input type=\"hidden\" name=\"event_id\" value=\"$event_id\"></div>
                    <div><input type=\"submit\" value=\"Update details\"></div>
                  </form>
                  <form method=\"post\" action=\"editMedia.php\">
                    <div><input type=\"hidden\" name=\"event_id\" value=\"$event_id\"></div>
                    <div><input type=\"submit\" value=\"Add/delete media\"></div>
                  </form></div><div class=\"divider\"></div>";

        }
        mysqli_free_result($queryresult);
          mysqli_close($conn);
      }
      ?>

    <div class="divider"></div>
    <div class="footer">
      <p><em>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</em></p>
    </div>
  </div>
  </body>

</html>
