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
      <h1>Past Events</h1>
      <p>Take a look at past events here.</p>
      <a href ="currentEvents.php">Check out current events here</a></br>
    </div>
      <div class="divider"></div>
        <?php

              $sql = "SELECT event_id, event_name, event_location, event_date, event_host, event_details, thumbnail_title, thumbnail_url, thumbnail_event FROM tgne_events LEFT JOIN thumbnails ON tgne_events.event_id = thumbnails.thumbnail_event ORDER BY event_date ASC";

          $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

          /*
          try{
            $sql = "SELECT image_url, image_title, image_event from images";

	          if ($imageresults = mysqli_query( $conn, $sql )) {
              while ( $currentimage = mysqli_fetch_assoc($imageresults ) ) {
                if($currentimage['image_event'] === 0){
                  echo "<p>empty entry</p>";
                }else{
                  echo "<div><img src= '" . $currentimage['image_url'] . "'
                  width='200' height='200'/><br/>" .
 		              $currentimage['image_title']  . "</div>";
                }
              }
            }
              } catch( Exception $e ) {
		                          echo $e->getMessage();
                            } */

         while($row = mysqli_fetch_assoc($queryresult)){
              $date = date("Y-m-d");
          		$event_id = $row['event_id'];
          		$event_name = $row['event_name'];
          		$event_location = $row['event_location'];
              $event_date = $row['event_date'];
              $event_details = $row['event_details'];
              $thumbnail_title = $row['thumbnail_title'];
              $thumbnail_url = $row['thumbnail_url'];
              $thumbnail_event = $row['thumbnail_event'];
              if(strtotime($event_date) < strtotime($date)){
                if($thumbnail_event === null){
                  echo "<div class=\"blogpost\">";
                  echo "<h2><a href = \"event.php?event_id=$event_id&current=no\">$event_name, $event_location, $event_date</a></h2>";
                  echo "</div><div class=\"divider\"></div>";
                }else{
                  echo "<div class=\"blogpost\">";
                  echo "<img src= '" . $thumbnail_url . "'
                        width='200' height='200'/><br/>";
                  echo "<h2><a href = \"event.php?event_id=$event_id&current=no\">$event_name, $event_location, $event_date</a></h2>";
                  echo "</div><div class=\"divider\"></div>";
              }
            }else{
                  //don't print if it's a current event
                }
              }

          	mysqli_free_result($queryresult);
              mysqli_close($conn);
        ?>
        <div class="footer">
          <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
            and Connor Clark</p>
        </div>
  </body>

</html>
