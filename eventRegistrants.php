<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Event registrants - The Great North East</title>
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
      if(isset($_SESSION['admin-logged-in'])){
      $bool = false;
      $count = 0;

      $event_id= isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : null;

      $sql = "SELECT tgne_events.event_name, tgne_users.user_username, tgne_users.user_firstname, tgne_users.user_surname, tgne_users.user_email FROM tgne_registrants JOIN tgne_users ON tgne_registrants.registrant_username = tgne_users.user_username JOIN tgne_events ON tgne_registrants.registrant_event = tgne_events.event_id WHERE tgne_registrants.registrant_event = $event_id";

      $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while($row = mysqli_fetch_assoc($queryresult)){
            $event_name = $row['event_name'];
            $user_username = $row['user_username'];
            $user_firstname = $row['user_firstname'];
            $user_surname = $row['user_surname'];
            $user_email = $row['user_email'];
              if($bool === false){
                echo "<h1>Registrants for $event_name</h1>
                <p>Take a look at registrants details here.</p>
                <a href=\"admin.php\">Click here to go back</a><br/></div>
                <div class=\"divider\"></div>";
                $bool = true;
              }
              echo "<div class=\"blogpost\"><h2>$user_username, $user_firstname $user_surname, $user_email</h2></div><div class=\"divider\"></div>";
              $count++;
            }
            if($count === 0){
              echo "<h1>No one has registered for this event.</h1>
              <a href=\"admin.php\">Click here to go back</a><br/></div><div class=\"divider\"></div>";
            }else{
              echo "<div class=\"blogpost\"><h2>Total registrants: $count</h2></div><div class=\"divider\"></div>";
            }
        mysqli_free_result($queryresult);
        mysqli_close($conn);
      }
      ?>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
