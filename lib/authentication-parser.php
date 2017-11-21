<?php

  global $userdata;

  $db = mysqli_connect('localhost', 'imagerpg', 'password', 'imagerpg') or die();

  $username = null;
  if (
       isset($_POST['username']) &&
       isset($_POST['password']) &&
       (strlen($_POST['username']) > 1) &&
       (strlen($_POST['password']) > 1)) {
    $password = md5($_POST['password']);
    if ($result = mysqli_query($db, "SELECT username,password FROM imagerpg.users WHERE username='" . addslashes($_POST['username']) . "' LIMIT 1;")) {
      $row = $result->fetch_assoc();
      if ($row['password'] == $password) {
        $username = $_POST['username'];
        $session = md5($_POST['username'] . $_POST['password'] . time());
        mysqli_query($db, "UPDATE imagerpg.users SET session='" . addslashes($session) . "' WHERE username='" . addslashes($username) . "' LIMIT 1;");
        setcookie('imagerpg_username', $username, time() + (86400 * 30), "/"); # 30 days
        setcookie('imagerpg_session', $session, time() + (86400 * 30), "/");
	header("Location: /imagerpg");
        die();
      } else {
        if (isset($row['username'])) {
          echo "<meta http-equiv=\"refresh\" content=\"3\">";
          echo "<center><br><b><h3>INVALID PASSWORD</h3></b><br></center>";
          die();
        } else {
          # Create new user
          mysqli_query($db, "INSERT INTO imagerpg.users (id, username, password, session) VALUE ('', '" . addslashes($_POST['username']) . "', '" . addslashes($password) . "', '');");
          $username = $_POST['username'];
          $session = md5($_POST['username'] . $_POST['password'] . time());
          mysqli_query($db, "UPDATE imagerpg.users SET session='" . addslashes($session) . "' WHERE username='" . addslashes($username) . "' LIMIT 1;");
          setcookie('imagerpg_username', $username, time() + (86400 * 30), "/"); # 30 days
          setcookie('imagerpg_session', $session, time() + (86400 * 30), "/");
	  header("Location: /imagerpg");
          die();
        }
      }
    }
  }
  if (isset($_COOKIE['imagerpg_username'])) {
    if (isset($_COOKIE['imagerpg_session'])) {
      if ($result = mysqli_query($db, "SELECT session FROM imagerpg.users WHERE username='" . addslashes($_COOKIE['imagerpg_username']) . "' LIMIT 1;")) {
        $row = $result->fetch_assoc();
        if ($row['session'] == $_COOKIE['imagerpg_session']) {
          $username = $_COOKIE['imagerpg_username'];
         $session = $_COOKIE['imagerpg_session'];
        } else {
          echo "<meta http-equiv=\"refresh\" content=\"3\">";
          setcookie('imagerpg_username', "", time() - 3600, "/");
          setcookie('imagerpg_session', "", time() - 3600, "/");
          echo "<center><br><b><h3>INVALID SESSION DATA</h3></b><br></center>";
          die();
        }
      }
    }
  } else {
?>
<br><br><br>
<center>
<h1>Project imagerpg (BETA!)</h1>
<br><br>
<h2>Please login to play:</h2>
<h4><i>If you do not yet have an account, just pick a username and password.
Assuming nobody yet has an account with that name, one will automatically be created for you.</i></h4>
<form name="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
  <table border=0 cellpadding=2 cellspacing=2>
  <tr><td>Username:</td><td><input type="text" name="username" value=""></td></tr>
  <tr><td>Password:</td><td><input type="password" name="password" value=""></td></tr>
  <tr><td colspan=2 align=right><input type="submit" name="submit" value="Submit"></td></tr>
  </table>
</form>
</center>

<?php
    die();
  }

?>
