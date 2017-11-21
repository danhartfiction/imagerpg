<?php

  print "<table border=0 cellpadding=5 cellspacing=2>";
  for ($r=0; $r<3; $r++) {
    print "<tr>";
    for ($c=0; $c<5; $c++) {
      $i = $r * 5 + $c;
      if (!isset($userdata['cards'][$i])) {
        print "<td width=200 height=200 bgcolor=#777777>&nbsp;</td>";
        continue;
      }
      list($width, $height, $type, $attr) = getimagesize($userdata['cards'][$i]);
      $scale_factor = 1;
      if ($height > $width) {
        if ($height > 200)
          $scale_factor = $height / 200;
      } else {
        if ($width > 200)
          $scale_factor = $width / 200;
      }
      $nh = $height / $scale_factor;
      $nw = $width / $scale_factor;
      print "<td width=200 height=200 bgcolor=#777777>";
      print "<img src=\"" . $userdata['cards'][$i] . "\" height=$nh width=$nw />";
      print "</td>";
    }
  }

?>
