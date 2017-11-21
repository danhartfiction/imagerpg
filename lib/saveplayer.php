<?php

/*  print "<hr><pre>";
  print_r($userdata);
  print "</pre><hr>"; */

  mysqli_query($db, "UPDATE imagerpg.users SET turn='" . $userdata['turn'] . "', status='" . serialize($userdata['status']) . "', cards='" . serialize($userdata['cards']) . "' WHERE username='" . addslashes($username) . "' LIMIT 1;");

?>
