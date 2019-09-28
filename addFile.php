<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Upload file - The Great North East</title>
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
    <div class="blogpost">
      <?php
        $target_dir = "files/";
        $title = $_FILES["file"]["name"];
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $event_id = isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : null;

        // Check if file already exists
        if (file_exists($target_file)) {
          echo "Sorry, file already exists.";
          $uploadOk = 0;
        }

        if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
        } else {
          if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";

            $sql = "INSERT INTO files (file_url, file_title, file_event) VALUES ('$target_dir','$title', '$event_id') ";
            $success = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            if($success === true){
              echo "<br /><p> Information stored on database.</p>";
            }
            else{
              echo "<p> Your information was not recieved. Please try again.</p>";
            }

            echo "<a><p><a href=\"editMedia.php?event_id=$event_id\">Click here to go back</a></p>";

            mysqli_close($conn);
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
        }



        ?>


    </div>
    <div class="divider"></div>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>
