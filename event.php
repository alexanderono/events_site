<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Events - The Great North East</title>
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

        $event_id = isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : null;
        $current = isset($_REQUEST['current']) ? $_REQUEST['current'] : null;
        $width = 0;
        $height = 0;
        $imagecount = 0;
        $result = "bleh";

        $sql = "SELECT event_name, event_location, event_date, event_host, event_details, image_title, image_url, image_event FROM tgne_events LEFT JOIN images ON tgne_events.event_id = images.image_event WHERE event_id = $event_id";

        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        echo "<div class=\"mediabox\">";

        while($row = mysqli_fetch_assoc($queryresult)){

          $event_name = $row['event_name'];
          $event_location = $row['event_location'];
          $event_date = $row['event_date'];
          $event_host = $row['event_host'];
          $event_details = $row['event_details'];
          $image_title = $row['image_title'];
          $image_url = $row['image_url'];
          $image_event = $row['image_event'];
          $sql = "SELECT COUNT(image_url) as total FROM images WHERE image_event = $event_id";
          $result = mysqli_query($conn, $sql);
          $data = mysqli_fetch_assoc($result);
          $total = $data['total'];
          switch($total){
            case 1:
              $width = 400;
              $height = 400;
              break;
            case 2:
              $width = 300;
              $height = 300;
              break;
            case 3:
              $width = 250;
              $height = 250;
              break;
            case 4:
              $width = 200;
              $height = 200;
              break;
            default:
              $width = 0;
              $height = 0;
              break;
          }
          if($image_event === null){
            // do nothing
          }else{
            echo "<img src= '" . $image_url . "'
                  width='$width' height='$height'/><br/>";
          }
        }

        echo "</div><br/>";
        echo "<div class=\"mediabox\">";

          $sql = "SELECT event_url FROM event_urls WHERE event_ref = $event_id";
          $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
          while($row = mysqli_fetch_assoc($queryresult)){
            $event_url = $row['event_url'];
            if($event_url === null){
              // do nothing
            }else{
              echo  "<iframe width=\"420\" height=\"315\" src=\"$event_url\"></iframe><br/>";
            }
          }
        echo"</div><br/>";
        echo "<div class=\"mediabox\">";
          $sql = "SELECT file_title, file_url FROM files WHERE file_event = $event_id";
          $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
          while($row = mysqli_fetch_assoc($queryresult)){
            $file_url = $row['file_url'];
            $file_title = $row['file_title'];
            if($file_url === null){
              // do nothing
            }else{
              echo "<h2><a href=\"$file_url" . "$file_title\">$file_title</a></h2><br/>";
            }
          }
        echo"</div><br/>";



        echo "<br/><h1>$event_name, $event_location, $event_date</a></h1>";
        echo "<h2>$event_details</h2></br>";


        echo "<h1>Register for this event</h1></br>";
        if(isset($_SESSION['uName'])){
          if($current === 'yes'){
            echo "<form method=\"post\" action=\"register.php\">
                    <div><input type=\"hidden\" name=\"event_id\" value=\"$event_id\"></div>
                    <div>Click here to register: <input type=\"submit\" value=\"Register\"></div>
                  </form></br>";
          }else{
            echo "<p>You can no longer register for this event.</br>";
          }
        }else{
          echo "<p>You need to be logged in to do that.</p>";
        }
        if($current === 'yes'){
          echo "<div class=\"divider\"></div>
                <p><a href=\"currentEvents.php\">Click here to go back</a></p>";
        }else if($current === 'no'){
          echo "<div class=\"divider\"></div>
                <p><a href=\"pastEvents.php\">Click here to go back</a></p>";
        }

      ?>
    </div>
    <div class="divider"></div>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
