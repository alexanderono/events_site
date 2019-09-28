<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edit media - The Great North East</title>
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
        echo "<script type=\"text/javascript\">
              function confirmUser(){
              var ask=confirm(\"Are you sure?\");
              if(ask){
                window.location=\"/delete\";
              }
            }
            </script>";

        $event_id = isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : null;
        $count = 0;
        $thumb = false;

        $sql = "SELECT event_name, event_location, event_date, event_host, event_details, image_id, image_url, image_event FROM tgne_events LEFT JOIN images ON tgne_events.event_id = images.image_event WHERE event_id = $event_id";

        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));


        echo "<h2>Add/delete media</h2></div><div class=\"divider\"></div>
              <div class=\"blogpost\"><h1>Delete event videos/files/images</h1>";

        while($row = mysqli_fetch_assoc($queryresult)){
          $event_name = $row['event_name'];
          $event_location = $row['event_location'];
          $event_date = $row['event_date'];
          $event_host = $row['event_host'];
          $event_details = $row['event_details'];
          $image_url = $row['image_url'];
          $image_id = $row['image_id'];
          if($image_url === null){
            // nothing
          }else{
            echo "<h2><a href = \"deleteImage.php?image_id=$image_id&event_id=$event_id\" onclick=\"return confirm('Are you sure?')\">$image_id, $image_url</a></h2>";
            $count++;
          }
        }

        $sql = "SELECT event_url, event_url_id FROM event_urls WHERE event_ref = $event_id";
        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while($row = mysqli_fetch_assoc($queryresult)){
          $event_url_id = $row['event_url_id'];
          $event_url = $row['event_url'];
          if($event_url === null){
            // do nothing
          }else{
            echo "<h2><a href = \"deleteVideo.php?event_url_id=$event_url_id&event_id=$event_id\" onclick=\"return confirm('Are you sure?')\">$event_url_id, $event_url</a></h2>";
            $count++;
          }
        }

        $sql = "SELECT file_url, file_id, file_title FROM files WHERE file_event = $event_id";
        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while($row = mysqli_fetch_assoc($queryresult)){
          $file_url = $row['file_url'];
          $file_id = $row['file_id'];
          $file_title = $row['file_title'];
          if($file_url === null){
            // do nothing
          }else{
            echo "<h2><a href = \"deleteFile.php?file_id=$file_id&event_id=$event_id\" onclick=\"return confirm('Are you sure?')\">$file_id, $file_url" . "$file_title</a></h2>";
            $count++;
          }
        }

        $sql = "SELECT thumbnail_url, thumbnail_id FROM thumbnails WHERE thumbnail_event = $event_id";
        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while($row = mysqli_fetch_assoc($queryresult)){
          $thumbnail_url = $row['thumbnail_url'];
          $thumbnail_id = $row['thumbnail_id'];
          if($thumbnail_url === null){
            // do nothing
          }else{
            echo "<h2><a href = \"deleteThumbnail.php?thumbnail_id=$thumbnail_id&event_id=$event_id\" onclick=\"return confirm('Are you sure?')\">$thumbnail_id, $thumbnail_url</a></h2>";
            $count++;
            $thumb = true;
          }
        }

        if($count === 0){
          echo "<p>Nothing uploaded for this event.</p>";
        }else{
          echo "<p>Click to delete.</p>";
        }
        echo "</div><div class=\"divider\"></div>
              <div class=\"blogpost\">
              <h2>Add a youtube video for this event</h2>
              <form method=\"post\" action=\"addVideo.php\" onsubmit=\"return confirm('Are you sure?');\">
                <div><input type=\"hidden\" name=\"event_id\" value=\"$event_id\"></div>
                <div>Youtube URL: <input type=\"text\" name=\"youtube_url\" size=\"40\"><input type=\"submit\" value=\"Add video\"></div>
              </form>
              <p>Note: to properly upload a youtube video, get the embed url found by clicking the \"Share\" tab, then \"Embed\" then copying the src link.</p></div><div class=\"divider\"></div>";

        echo "<div class=\"blogpost\">
              <h2>Add a file for this event</h2>
              <form method=\"post\" action=\"addFile.php\" enctype=\"multipart/form-data\" onsubmit=\"return confirm('Are you sure?');\">
                <div><input type=\"hidden\" name=\"event_id\" value=\"$event_id\"></div>
                <label for=\"file\">Filename:</label>
                <input type=\"file\" name= \"file\"/><input type=\"submit\" name=\"submit\" value=\"Upload\" />
              </form></div><div class=\"divider\"></div>";

        echo "<div class=\"blogpost\">
              <h2>Add an image for this event</h2></br>
              <form action=\"uploadImage.php\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return confirm('Are you sure?');\">
                <div><input type=\"hidden\" name=\"event_id\" value=\"$event_id\"></div>
                <label for=\"file\">Filename:</label>
                <input type=\"file\" name= \"myfile\" id=\"myfile\" /><input type=\"submit\" name=\"submit\" value=\"Upload\" />
              </form></div><div class=\"divider\"></div>";

        echo "<div class=\"blogpost\">
              <h2>Add an thumbnail for this event</h2></br>";
        if($thumb === false){
        echo  "<form action=\"uploadThumbnail.php\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return confirm('Are you sure?');\">
                <div><input type=\"hidden\" name=\"event_id\" value=\"$event_id\"></div>
                <label for=\"file\">Filename:</label>
                <input type=\"file\" name= \"myfile\" id=\"myfile\" /><input type=\"submit\" name=\"submit\" value=\"Upload\" />
              </form></div><div class=\"divider\"></div>";
        }else{
        echo  "<p>You are only allowed one thumbnail per event. Delete your current one to upload a new one.</p>
              </div><div class=\"divider\"></div>";
        }


        echo "<div class=\"blogpost\"><p><a href=\"staff.php\">Click here to go back</a></p></div>";
      ?>
    <div class="divider"></div>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
