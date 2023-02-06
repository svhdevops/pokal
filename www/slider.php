<?php

/**
 * Automatically flip through all result listings. Each result page is shown for 
 * a specific amount of time. All pages are periodically refreshed. Purpose is to 
 * show this to the visitors on a large screen or beamer.
 */

include( "db_func.php" );
init_globals();

// configurable settings
$screen_lines = 20; // number of lines in result tables
$milliSecondsPerPage = 6000; // milli seconds before the next table page is shown
$secondsRefresh = 30; // seconds after which the whole page is reloaded

// code goes here
echo '<html>
<head>
 <title>Dorfpokal - Schützenverein Hailfingen e.V.</title>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="'.$secondsRefresh.'">
  <link rel="stylesheet" href="style.css">
</head>

<body>
';
  printSingleResultTableForSlider(2, 'Einzelwertung Damenklasse');
  printSingleResultTableForSlider(1, 'Einzelwertung Schützenklasse');

  printTeamResultsForSlider(2, 'Mannschaftswertung Damenklasse');
  printTeamResultsForSlider(1, 'Mannschaftswertung Schützenklasse');

  printOverviewForSlider();

  echo '
<script>
var slideIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("slide");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > x.length) {slideIndex = 1}
  x[slideIndex-1].style.display = "block";
  setTimeout(carousel, '.$milliSecondsPerPage.');
}
</script>

</body>
</html>
';
?>
