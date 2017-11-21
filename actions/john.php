<?php

function john($num) {
  global $userdata, $properties;
  for ($i=0; $i<$num; $i++) {
    print "You found a john!<br>";
    print "This john likes the following attributes:<br>";
    $attributes = array_keys($properties);
    $num_attributes = rand(1, sizeof($attributes));
    $chosen_attributes = 0;
    $my_attributes = array();
    $preferences = array();
    # Not very efficient but fuck it
    while ($chosen_attributes < $num_attributes) {
      $r = rand(0, sizeof($attributes) - 1);
      if (!in_array($attributes[$r], $my_attributes)) {
        array_push($my_attributes, $attributes[$r]);
        $chosen_attributes++;
      }
    } 
    print "<ul>";
    foreach ($my_attributes as $a) {
      $r = rand(0, sizeof($properties[$a]) - 1);
      print "<li>" . $a . ": " . $properties[$a][$r]->value . "</li>";
    }
    print "</ul>";
  }

  # TODO : Update johns / attributes table (need to create as well)
}

?>
