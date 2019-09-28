<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edit report - The Great North East</title>
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
      <h1>Edit Report</h1>
      <?php
        $report_id= isset($_REQUEST['report_id']) ? $_REQUEST['report_id'] : null;
        $feedback_id= isset($_REQUEST['feedback_id']) ? $_REQUEST['feedback_id'] : null;

        $sql = "SELECT tgne_registrants.registrant_username, tgne_events.event_name, tgne_feedback.feedback_comments, tgne_feedback.feedback_rating FROM tgne_reports JOIN tgne_feedback ON tgne_reports.report_item = tgne_feedback.feedback_id JOIN tgne_registrants ON tgne_feedback.feedback_user = tgne_registrants.registrant_id JOIN tgne_events ON tgne_feedback.feedback_event = tgne_events.event_id WHERE report_id = $report_id";

        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        while($row = mysqli_fetch_assoc($queryresult)){
          $registrant_username = $row['registrant_username'];
          $event_name = $row['event_name'];
          $feedback_comments = $row['feedback_comments'];
          $feedback_rating = $row['feedback_rating'];

          echo "<p>#$report_id $registrant_username leaving feedback for $event_name</a></p>
                <p>\"$feedback_comments\", $feedback_rating/5</p></br>";
        }

        echo "<div class=\"divider\"></div><h1>Delete report</h1>
              <form method=\"post\" action=\"deleteReport.php\" onsubmit=\"return confirm('Are you sure?');\">
              <div><input type=\"hidden\" name=\"report_id\" value=\"$report_id\"></div>
              <div><input type=\"submit\" value=\"Delete\"></div>
              </form><div class=\"divider\"></div>";

        echo "<h1>Delete report and reported item</h1>
              <form method=\"post\" action=\"deleteItem.php\" onsubmit=\"return confirm('Are you sure?');\">
              <div><input type=\"hidden\" name=\"report_id\" value=\"$report_id\"></div>
              <div><input type=\"hidden\" name=\"feedback_id\" value=\"$feedback_id\"></div>
              <div><input type=\"submit\" value=\"Delete\"></div>
              </form><div class=\"divider\"></div>
              <p><a href=\"admin.php\">Click here to go back</a></p>";

        mysqli_free_result($queryresult);
        mysqli_close($conn);

      ?>
    </div>
    <div class="divider"></div>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>
