<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reports - The Great North East</title>
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
      <h1>Reports</h1>
      <div class="divider"></div>
      <?php
        if(isset($_SESSION['admin-logged-in'])){
          echo "<p>Here you can view user submitted reports of inappopriate content.
          Click a report to remove it or remove it and the reported content.</p>
          <a href=\"admin.php\">Click here to go back</a></div><div class=\"divider\"></div>";
            $sql = "SELECT tgne_reports.report_id, tgne_events.event_name, tgne_registrants.registrant_username, tgne_feedback.feedback_id,
            tgne_feedback.feedback_user, tgne_feedback.feedback_event, tgne_feedback.feedback_comments,
            tgne_feedback.feedback_rating FROM tgne_reports JOIN tgne_feedback ON tgne_reports.report_item = tgne_feedback.feedback_id
            JOIN tgne_events ON tgne_feedback.feedback_event = tgne_events.event_id JOIN tgne_registrants ON tgne_feedback.feedback_user = tgne_registrants.registrant_id";

            $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            while($row = mysqli_fetch_assoc($queryresult)){
              $feedback_id = $row['feedback_id'];
              $report_id = $row['report_id'];
              $registrant_username = $row['registrant_username'];
              $event_name = $row['event_name'];
              $feedback_comments = $row['feedback_comments'];
              $feedback_rating = $row['feedback_rating'];

              echo "<div class=\"blogpost\"><p>#$report_id <a href = \"editReport.php?report_id=$report_id&feedback_id=$feedback_id\">$registrant_username leaving feedback for $event_name</a></p>
                    <p>\"$feedback_comments\", $feedback_rating/5</p></div><div class=\"divider\"></div>";
            }
            mysqli_free_result($queryresult);
            mysqli_close($conn);

        }else{
          echo "<p>You must have admin permissions to access this information.</p>";
        }


      ?>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
