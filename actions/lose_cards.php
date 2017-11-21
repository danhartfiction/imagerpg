<?php

function lose_cards($num) {
  global $userdata;
  for ($i=0; $i<$num; $i++) {
    if (sizeof($userdata['cards']) > 0) {
      $random_index = rand(0, sizeof($userdata['cards']) - 1);
      print "You have lost card: " . $userdata['cards'][$random_index] . "<br>";
      unset($userdata['cards'][$random_index]);
      $userdata['cards'] = array_values($userdata['cards']);
    } else {
      print "You do not have any cards to lose.<br>";
    }
  }
}

?>
