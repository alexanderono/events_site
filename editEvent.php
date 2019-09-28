<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edit event - The Great North East</title>
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
    <div class="divider"></div>
      <?php
        echo "<script type=\"text/javascript\">
              function confirmUser(){
              var ask=confirm(\"Are you sure?\");
              if(ask){
                window.location=\"/delete\";
              }
            }
            </script>";

        $event_id = isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : null;

        $sql = "SELECT event_id, event_name, event_location, event_date, event_host, event_details,
        image_id, image_url, event_url_id, event_url, file_id, file_url, file_title FROM tgne_events LEFT JOIN images ON
        tgne_events.event_id = images.image_event LEFT JOIN files ON tgne_events.event_id = files.file_event LEFT JOIN event_urls ON
        tgne_events.event_id = event_urls.event_ref WHERE event_id = $event_id";

        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        while($row = mysqli_fetch_assoc($queryresult)){
          $event_name = $row['event_name'];
          $event_location = $row['event_location'];
          $event_date = $row['event_date'];
          $event_host = $row['event_host'];
          $event_url_id = $row['event_url_id'];
          $event_url = $row['event_url'];
          $event_details = $row['event_details'];
          $file_id = $row['file_id'];
          $file_url = $row['file_url'];
          $file_title = $row['file_title'];
          $image_id = $row['image_id'];
          $image_url = $row['image_url'];

        }
        echo "<div class=\"blogpost\">
              <h1>Update details</h1>
              <form method=\"post\" action=\"updateEvent.php\" onsubmit=\"return confirm('Are you sure?');\" class=\"detailform\">
                <input type=\"hidden\" name=\"event_id\" value=\"$event_id\">
                <p>Name:</p> <input type=\"text\" name=\"event_name\" value=\"$event_name\"><br/>
                <p>Location:</p> <input type=\"text\" name=\"event_location\" value=\"$event_location\"><br/>
                <p>Date:</p> <input type=\"text\" name=\"event_date\" value=\"$event_date\"><br/>
                <p>Host:</p> <input type=\"text\" name=\"event_host\" value=\"$event_host\"><br/>
                <p>Details:</p> <input type=\"text\" value=\"$event_details\"><br/>
                <p></p><input type=\"submit\" value=\"Update\">
              </form></br>
              </div>
              <div class=\"divider\"></div>";

        echo "<div class=\"blogpost\"><p><a href=\"staff.php\">Click here to go back</a></p></div>";
      ?>
    <div class="divider"></div>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
