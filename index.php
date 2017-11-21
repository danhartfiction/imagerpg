<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Project ImageRPG</title>
  </head>
  <body id="body">
    <?php include 'lib/authentication-parser.php' ?>
    <?php include 'lib/initialization.php' ?>
    <?php include 'lib/doturn.php' ?>
    <?php include 'lib/saveplayer.php' ?>
    <?php include 'lib/display-cards.php' ?>
  </body>
</html>

<?php

# Overview
# * Gameplay is basically you have a hand of cards to use
# * Start game with 5 cards
# Each turn you can do one of a few options:
# * Rest (regain energy)
# * Use a card
# * Change location
#
# Turn Flow:
#   * Upkeep
#   * Draw a resource card
#   * Draw an event card
#   * Resolve event card
#
# State System:
#   * Start Turn -> Upkeep -> Event -> End Turn
#
# Resource Cards:
#   * Workers
#   * Status Changes
#   * 
#
# Worker Attributes:
#   * Bottem Level
#   * Top Level
#   * Happiness Level
#
# Events
#   * New John
#
# Database
#   * id
#   * username
#   * password
#   * turn
#   * status
#   * cards
#   * session

?>
