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
        $image_id = isset($_REQUEST['image_id']) ? $_REQUEST['image_id'] : null;

        $insertSQL = "DELETE images FROM images WHERE image_id = $image_id";
	      $success = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));
        if($success === true){
          echo "Success, image deleted.";
        }else{
          echo "Error, not deleted.";
        }
        echo "<p><a href=\"staff.php\">Click here to go back</a></p>";

        mysqli_close($conn);
      ?>

    </div>

  </body>

</html>
