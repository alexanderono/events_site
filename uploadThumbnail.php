<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Upload thumbnail - The Great North East</title>
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
      $name = isset($_FILES["myfile"]["name"]) ? $_FILES["myfile"]["name"] : null;
      $type = isset($_FILES["myfile"]["type"]) ? $_FILES["myfile"]["type"] : null;
      $size = isset($_FILES["myfile"]["size"]) ? ($_FILES["myfile"]["size"] / 1024) : null;
      $tmp_name = isset($_FILES["myfile"]["tmp_name"]) ? $_FILES["myfile"]["tmp_name"] : null;

      if ($_FILES["myfile"]["error"] > 0)  {
		      echo "Error: " . $_FILES["myfile"]["error"] . "<br />";
	    }
	    else
	    {
	       echo "<p> Filename: $name, type: $type, size: $size, temp name: $tmp_name</p><br />";
      }


      $upload_url = "thumbnails/" . $_FILES["myfile"]["name"];

      $filename = $_FILES["myfile"]["name"];

      move_uploaded_file($_FILES["myfile"]["tmp_name"], $upload_url);

      $sql = "INSERT INTO thumbnails (thumbnail_url, thumbnail_title, thumbnail_event) VALUES ('$upload_url','$filename', '$event_id') ";

      $imageresults = mysqli_query( $conn,$sql );

      echo "<p>Thumbnail uploaded!</p><br /><a><p><a href=\"editMedia.php?event_id=$event_id\">Click here to go back</a></p>";

?>

    </div>
    <div class="divider"></div>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
