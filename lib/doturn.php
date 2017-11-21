<?php

  print "Name: " . $userdata['username'] . "<br>";
  print "Turn Number: " . $userdata['turn'] . "<br>";
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
  require_once('actions/gain_cards.php');
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
    require_once('actions/' . $action->type . '.php');
    call_user_func($action->type, $action->value);
  }

  # Resolve Event Card  


?>
