<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Feedback - The Great North East</title>
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
      <h1>Feedback</h1>
      <p>Take a look at user's feedback for past events here. In the case of inappropriate content, please click an
      item of feedback to report it.</p></div>
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

        $sql = "SELECT tgne_feedback.feedback_id, tgne_feedback.feedback_event, tgne_users.user_username, tgne_events.event_name, tgne_feedback.feedback_rating, tgne_feedback.feedback_comments FROM tgne_feedback JOIN tgne_registrants ON tgne_feedback.feedback_user = tgne_registrants.registrant_id JOIN tgne_events ON tgne_feedback.feedback_event = tgne_events.event_id JOIN tgne_users ON tgne_registrants.registrant_username = tgne_users.user_username";
        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while($row = mysqli_fetch_assoc($queryresult)){
          $feedback_id = $row['feedback_id'];
          $username = $row['user_username'];
          $event_name = $row['event_name'];
          $rating = $row['feedback_rating'];
          $feedback = $row['feedback_comments'];
          $feedback_event = $row['feedback_event'];
          if($feedback_event !== 0){
              if(isset($_SESSION['uName'])){
                echo "<div class=\"blogpost\"><h2><a href = \"newReport.php?feedback_id=$feedback_id\" onclick=\"return confirm('Are you sure?')\">$username giving feedback for: $event_name</a></h2></br>
                      <p>\"$feedback\", $rating/5</p></div><div class=\"divider\"></div>";
              }else{
                echo "<div class=\"blogpost\"><h2>$username giving feedback for: $event_name/h2></br>
                      <p>\"$feedback\", $rating/5</p></div><div class=\"divider\"></div>";
              }

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
