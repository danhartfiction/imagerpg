<?php

  $userdata['username'] = $username;
  if ($result = mysqli_query($db, "SELECT * FROM imagerpg.users WHERE username='" . addslashes($username) . "' LIMIT 1;")) {
    $row = $result->fetch_assoc();
    $userdata['turn'] = (is_numeric($row['turn']) && $row['turn'] >= 1 ? $row['turn'] : 1);
    $userdata['status'] = (is_array(unserialize($row['status'])) ? unserialize($row['status']) : array());
    $userdata['cards'] = (is_array(unserialize($row['cards'])) ? unserialize($row['cards']) : array());
  } else {
    die();    
  }
 
?>
