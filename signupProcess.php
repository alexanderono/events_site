<?php
  include 'database_conn.php';
  ini_set("session.save_path", "sessionData");
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sign up - The Great North East</title>
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
        error_reporting(0);
      	//Assign form values to PHP variables
      	$firstname = isset($_REQUEST['firstname']) ? $_REQUEST['firstname'] : null;
      	$surname = isset($_REQUEST['surname']) ? $_REQUEST['surname'] : null;
      	$username = isset($_REQUEST['username']) ? $_REQUEST['username'] : null;
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
      	$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
        $confirmpassword = isset($_REQUEST['confirmpassword']) ? $_REQUEST['confirmpassword'] : null;

      	//Checks that forename and surname has been filled in
      	if(empty($firstname)){
      		die("<p>You have not entered your first name. <a href=\"signup.php\">Go back</a></p>");
      	}
      	if(empty($surname)){
      		die("<p>You have not entered your surname. <a href=\"signup.php\">Go back</a></p>");
      	}
        if(empty($username)){
      		die("<p>You have not entered your username. <a href=\"signup.php\">Go back</a></p>");
      	}
        if(empty($password)){
      		die("<p>You have not entered your password. <a href=\"signup.php\">Go back</a></p>");
      	}
        if(empty($confirmpassword)){
      		die("<p>You have not confirmed your password. <a href=\"signup.php\">Go back</a></p>");
      	}
        if(empty($email)){
      		die("<p>You have not entered your email. <a href=\"signup.php\">Go back</a></p>");
      	}

      	if(strlen($password) < 8){
          die("<p>Password must be at least 8 characters long. <a href=\"signup.php\">Go back</a></p>");
        }
        if($password != $confirmpassword){
          die("<p>Passwords do not match. <a href=\"signup.php\">Go back</a></p>");
        }
        if(strlen($username) < 6 || (strlen($username)) > 50){
          die("<p>Username must be between 6 and 50 characters long. <a href=\"signup.php\">Go back</a></p>");
        }

        	//This stops any problems in SQL arising from names with apostrophes in them
      	$firstname = mysqli_escape_string($conn, $firstname);
      	$surname = mysqli_escape_string($conn, $surname);

        $passwordhash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT user_username FROM tgne_users WHERE user_username = '$username'";

        $queryresult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        while($row = mysqli_fetch_assoc($queryresult)){
          $user_username = $row['user_username'];
        }
        if($user_username === null){
          echo "<p>Username is available.</p>";
        }else{
          die("<p>Username already exists.<a href=\"signup.php\">Go back</a></p> ");
        }
      	//Sets up the SQL insert statement
      	$insertSQL = "insert into tgne_users (user_firstname, user_surname, user_username, user_hashpass, user_usertype, user_email) values ('$firstname', '$surname', '$username', '$passwordhash', 'user', '$email')";

      	//Executes the query, returns true if successful, false if unsuccessful
      	$success = mysqli_query($conn, $insertSQL) or die(mysqli_error($conn));

      	//Prints form details if query was successful, gives an error message if unsuccessful
      	if($success === true){
      		echo
      			"<br /><p> Success!, your information was recieved.</p>
      			<br />Name: $firstname $surname
            <br />Email: $email
      			<br />Username: $username</p>
            <br /><a href=\"home.php\">Go back</a>";
      	}
      	else{
      		echo "<p> Your information was not recieved. Please try again.</p>
      			<br /><a href=\"home.php\">Go home</a>";
      	}

            mysqli_close($conn);
      ?>
    </div>
    <div class="divider"></div>
    <div class="footer">
      <p>2017, Page designed and coded by Alexander Ono, Arwa Mhannhee, Matin Salali
        and Connor Clark</p>
    </div>
  </body>

</html>
