<?php
  
  global $properites;
  $properties = array();

  # Init user
  $userdata['username'] = $username;
  if ($result = mysqli_query($db, "SELECT * FROM imagerpg.users WHERE username='" . addslashes($username) . "' LIMIT 1;")) {
    $row = $result->fetch_assoc();
    $userdata['turn'] = (is_numeric($row['turn']) && $row['turn'] >= 1 ? $row['turn'] : 1);
    $userdata['status'] = (is_array(unserialize($row['status'])) ? unserialize($row['status']) : array());
    $userdata['cards'] = (is_array(unserialize($row['cards'])) ? unserialize($row['cards']) : array());
  } else {
    die();    
  }

  # Init Resources
  $raw_resource_properties = file_get_contents('resource_cards/resource_attributes.json');
  $resource_properties = json_decode($raw_resource_properties);
  foreach ($resource_properties as $p) {
    switch ($p->type) {
      case 'multi':
        foreach ($p->values as $v) {
          $properties[$p->name] = (isset($properties[$p->name]) ? $properties[$p->name] : array());
          array_push($properties[$p->name], $v);
        }
        break;
      default:
        print "Unknown property type: " . $p->type;
        die();
    }
  } 

?>
