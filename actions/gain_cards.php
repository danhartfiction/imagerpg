<?php

function gain_cards($num) {
  global $userdata, $resource_cards;
  for ($i=0; $i<$num; $i++) {
    if (sizeof($userdata['cards']) >= 15) {
      print "You have too many cards.  You must discard one or more before you can draw new ones.<br>";
    } else {
      $random_card = $resource_cards[rand(0, sizeof($resource_cards) - 1)];
      print "Drawing new card:  " . $random_card . "<br>";
      array_push($userdata['cards'], $random_card);
    }
  }
}

?>
