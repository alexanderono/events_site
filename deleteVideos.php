<?php
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Delete images - The Great North East</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="">
  </head>
  <body>
  <div id="bigdamnwrapper">

    <div id="topbar">
      <img src="img\banner.png"/>
    </div>
    <div class="divider"></div>
    <div class="blogpost">
      <?php
        $conn = mysqli_connect('localhost', 'unn_w15018333', 'Oaktree7', 'unn_w15018333');
        if (mysqli_connect_errno()) {
          echo "<p>Connection failed:".mysqli_connect_error()."</p>\n";
        }
        $event_url_id = isset($_REQUEST['event_url_id']) ? $_REQUEST['event_url_id'] : null;

        $insertSQL = "DELETE event_urls FROM event_urls WHERE event_url_id = $event_url_id";
	      $success = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
        if($success === true){
          echo "Success, video deleted.";
        }else{
          echo "Error, video not deleted.";
        }
        echo "<p><a href=\"staff.php\">Click here to go back</a></p>";

        mysqli_close($conn);
      ?>

    </div>

  </body>

</html>
