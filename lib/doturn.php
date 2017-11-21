<?php

  print "Name: " . $userdata['username'] . "<br>";
  print "Turn Number: " . $userdata['turn'] . "<br>";
  print "Current Card Inventory: " . implode(", ", $userdata['cards']) . "<br>"; 
  print "<hr>";

  # Upkeep
  $userdata['turn']++;

  # Draw a Resource Card
  global $resource_cards;
  $resource_cards = array();
  $resource_directory = new RecursiveDirectoryIterator('resource_cards');
  $resource_iterator = new RecursiveIteratorIterator($resource_directory);
  foreach ($resource_iterator as $it) {
    switch (strtolower(pathinfo($it)['extension'])) {
      case 'jpg':
      case 'bmp':
      case 'gif':
      case 'jpeg':
      case 'png':
        array_push($resource_cards, $it->getPathname());
        break;
    }
  } 
  gain_cards(1);

  # Draw an Event Card
  $event_cards = array();
  $event_directory = new RecursiveDirectoryIterator('event_cards');
  $event_iterator = new RecursiveIteratorIterator($event_directory);
  foreach ($event_iterator as $it) {
    if (strtolower(pathinfo($it)['extension']) == 'json')
      array_push($event_cards, $it->getPathname());
  }
  $random_card = $event_cards[rand(0, sizeof($event_cards) - 1)];
  print "Drawing event card:  " . $random_card . "<br>";
  $raw_event = file_get_contents($random_card);
  $event = json_decode($raw_event);
  print "Event: " . $event->title . "<br>";
  print "Subject: " . $event->subject . "<br>";
  foreach ($event->actions as $action) {
    switch ($action->type) {
      case 'lose_cards':
        remove_cards($action->value);
        break;
      case 'gain_cards':
        gain_cards($action->value);
        break;
      default:
        print "<hr>UNKNOWN ACTION TYPE: " . $action->type . "<hr>";
    }
  }

  # Resolve Event Card  


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

function remove_cards($num) {
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
