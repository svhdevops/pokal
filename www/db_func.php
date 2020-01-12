<?php

Function init_globals()
{
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    ini_set('html_errors', TRUE);
}

Function createDbConnection()
{
    $dbuser = "pokal";
    $dbpwd  = "svhpokal";
    $dbname = "pokal";
    $dbhost = "pokal_db"; // "127.0.0.1";

    return mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname);
}

Function getAllShootersByClass($klasse)
{
    $dbconn = createDbConnection() or die('Could not connect: ' . mysqli_connect_error());

    $result = mysqli_query($dbconn, "select m.Verein,s.Name,s.Serie1+s.Serie2 as Erg,s.Schuss11,s.Schuss12,s.Schuss13
        from dorfpokal_mannschaft as m,
             dorfpokal_schuetze as s
        where m.MannschaftsID=s.MannschaftsID and s.KlassenID=".$klasse."
        order by Erg desc,s.Schuss11 desc,s.Schuss12 desc,s.Schuss13 desc;");
    if($result === FALSE){
        echo "Query failed:<br>" . $dbconn->error . "<br>";
    }
    mysqli_close($dbconn);

    return $result;
}

Function getAllShooters()
{
    $dbconn = createDbConnection() or die('Could not connect: ' . mysqli_connect_error());

    $result = mysqli_query($dbconn, "select m.Verein,s.Name
        from dorfpokal_mannschaft as m,
             dorfpokal_schuetze as s
        where m.MannschaftsID=s.MannschaftsID
        order by s.Name;");
    if($result === FALSE){
        echo "Query failed:<br>" . $dbconn->error . "<br>";
    }
    mysqli_close($dbconn);

    return $result;
}

Function getAllShootersByTeam()
{
    $dbconn = createDbConnection() or die('Could not connect: ' . mysqli_connect_error());

    $result = mysqli_query($dbconn, "select m.Verein,s.Name,s.Serie1+s.Serie2 as Erg
        from dorfpokal_mannschaft as m,
             dorfpokal_schuetze as s
        where m.MannschaftsID=s.MannschaftsID
        order by m.Verein, s.Name;");
    if($result === FALSE){
        echo "Query failed:<br>" . $dbconn->error . "<br>";
    }
    mysqli_close($dbconn);

    return $result;
}

Function getTeamResults($klasse)
{
      $dbconn = createDbConnection() or die('Could not connect: ' . mysqli_connect_error());
      $result = mysqli_query($dbconn, "
          SELECT m.Verein, sum(s.Erg) from dorfpokal_mannschaft as m
          JOIN ( SELECT n, MannschaftsID, Name, Erg FROM
            ( SELECT  @prev := '', @n := 0 ) init
          JOIN
            ( SELECT  @n := if(MannschaftsID != @prev, 1, @n + 1) AS n,
                      @prev := MannschaftsID,
                      MannschaftsID, Name, Serie1+Serie2 as Erg
                  FROM  dorfpokal_schuetze as s
                  ORDER BY MannschaftsID ASC, Erg DESC
            ) x
          WHERE  n <= 4 ) as s where m.MannschaftsID=s.MannschaftsID and m.KlassenID='".$klasse."'
          GROUP BY m.Verein
          ORDER BY sum(s.Erg) DESC;
          ");
          if($result === FALSE){
              echo "Query failed:<br>" . $dbconn->error . "<br>";
          }
      mysqli_close($dbconn);

      return $result;
}

Function printPageHeader()
{
  echo '<html>
    <head>
    <title>Dorfpokal - Schützenverein Hailfingen e.V.</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    </head>';
}

Function printSingleResultTable($klasse)
{
  echo '<table>
    <tr> <th></th> <th> Name </th> <th>Verein </th> <th>Ergebnis</th></tr>
    ';

  $result = getAllShootersByClass($klasse);
  $idx = 1;

  while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
      print ('<tr> <td> '.$idx.'. </td> <td>'.$res["Name"].'</td> <td> '.$res["Verein"].'</td> <td class="cell-result"> <span title="'
      . $res["Schuss11"] . ',' . $res["Schuss12"] . ',' . $res["Schuss13"] . '" >' . $res["Erg"]
      . ' </span> </td> </tr>
      ');
      $idx++;
  }

  echo '</table>';
}

Function printSliderPageTitle($pageTitle)
{
  echo '<h3>'.$pageTitle.'</h3>';
}

Function printSingleResultTableForSlider($klasse, $pageTitle)
{
  echo '<div class="slide">';
  printSliderPageTitle($pageTitle);
  echo '<div class="pagerow">
  <div class="pagecolumn"><table>
    <!-- tr> <th></th> <th> Name </th> <th>Verein </th> <th>Ergebnis</th></tr -->
    ';

  $result = getAllShootersByClass($klasse);
  $idx = 0;
  $idx_show = 1;

  while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
      if( ($idx > 0) && ( ($idx % $GLOBALS["screen_lines"]) == 0) )
      {
        if($idx % ($GLOBALS["screen_lines"]*2) == 0)
        {
          switchSliderPage($pageTitle);
        }
        else {
          switchColumn();
        }
      }
      print ('<tr> <td class="cell-place"> '.$idx_show.'. </td> <td class="cell-shootername">'.$res["Name"].'</td> <td> '.$res["Verein"].'</td> <td class="cell-result"> <span title="'
      . $res["Schuss11"] . ',' . $res["Schuss12"] . ',' . $res["Schuss13"] . '" >' . $res["Erg"]
      . ' </span> </td> </tr>
      ');
      $idx++;
      $idx_show++;
  }

  echo '</table></div></div></div>';
}

Function printTeamResults($klasse)
{
  $result = getTeamResults($klasse);
  $counter = 1;
  print('<table>');
  while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
      print ('<tr><td>'.$counter.'.</td><td>'.$res["Verein"].'</td><td class="cell-result">'.$res["sum(s.Erg)"] . '</td></tr>
      ');
      $counter++;
  }

  echo '</table>';
}

Function printTeamResultsForSlider($klasse, $pageTitle)
{
  echo '<div class="slide">';
  printSliderPageTitle($pageTitle);
  echo '<div class="pagerow">
  <div class="pagecolumn"><table>
    <!-- tr> <th></th> <th> Name </th> <th>Verein </th> <th>Ergebnis</th></tr -->
    ';
  $result = getTeamResults($klasse);
  $counter = 1;
  while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
      if($counter % $GLOBALS["screen_lines"] == 0)
      {
        if($counter % ($GLOBALS["screen_lines"]*2) == 0)
        {
          switchSliderPage($pageTitle);
        }
        else {
          switchColumn();
        }
      }
      print ('<tr><td>'.$counter.'.</td><td>'.$res["Verein"].'</td><td class="cell-result">'.$res["sum(s.Erg)"] . '</td></tr>
      ');
      $counter++;
  }

  echo '</table></div></div></div>';
}

function printOverview()
{
  echo '<div class="pagerow">
    ';

  $result = getAllShootersByTeam();
  $curVName = "";
  $shooterInTeam = 5; // count shooters in team
  $counter = 9999; // count all shooters for switching the <div>
  $inTable = FALSE;
  while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {

      if($res["Verein"] != $curVName)
      {
        while($shooterInTeam < 5)
        {
          $shooterInTeam++;
          print ('<tr> <td class="cell-shootername">-</td> <td class="cell-result">-</td> </tr>
          ');
        }
        $shooterInTeam = 0;
        if($counter > mysqli_num_rows($result)/2 + 1)
        {
          if($inTable)
          {
            print('</table></div>
            ');
          }
          print('<div class="pagecolumn"><table width="100%">
          ');
          $inTable = TRUE;
          $counter = 0;
        }
        $curVName = $res["Verein"];
        print('<tr> <td class="cell-teamname" colspan=2> '.$curVName.'</td></tr>
        ');
      }
      print ('<tr> <td class="cell-shootername">'.$res["Name"].'</td> <td class="cell-result">'
      . $res["Erg"].' </td> </tr>
      ');
      $counter++;
      $shooterInTeam++;
  }
  // fill up last team
  while($shooterInTeam < 5)
  {
    $shooterInTeam++;
    print ('<tr> <td class="cell-shootername"> - </td> <td class="cell-result">-</td> </tr>
    ');
  }

  echo '</table></div></div>
  ';
}

function printOverviewForSlider()
{
  $pageTitle = "Mannschaftsübersicht";
  echo '
  <div class="slide">';
  //printSliderPageTitle($pageTitle);
  echo '<div class="pagerow">
     <div class="pagecolumn">
     <table>';

  $result = getAllShootersByTeam();
  $first = TRUE;
  $curVName = "";
  $shooterInTeam = 5; // count shooters in team
  $counter = 0; // count teams for switching the <div>
  while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
      if($res["Verein"] != $curVName)
      {
        while($shooterInTeam < 5)
        {
          $shooterInTeam++;
          print ('<tr> <td class="cell-shootername">-</td> <td class="cell-result">-</td> </tr>
          ');
        }
        $shooterInTeam = 0;
        if(!$first && $counter % 4 == 0)
        {
          if($counter % 8 == 0)
          {
            switchSliderPage("");//$pageTitle);
          }
          else
          {
            switchColumn();
          }
        }
        $curVName = $res["Verein"];
        print('
        <tr> <td class="cell-teamname" colspan=2> '.$curVName.'</td></tr>
        ');
        $counter++;
        $first = FALSE;
      }
      print ('<tr> <td class="cell-shootername">'.$res["Name"].'</td> <td class="cell-result">'
      . $res["Erg"].' </td> </tr>
      ');
      $shooterInTeam++;
  }
  // fill up last team
  while($shooterInTeam < 5)
  {
    $shooterInTeam++;
    print ('<tr> <td class="cell-shootername"> - </td> <td class="cell-result">-</td> </tr>
    ');
  }
  echo '</table></div></div></div>';
}

Function switchColumn()
{
  print('</table></div>
    <div class="pagecolumn"><table>
    <!-- tr> <th></th> <th> Name </th> <th>Verein </th> <th>Ergebnis</th></tr -->
    ');
}

Function switchSliderPage($pageTitle)
{
  print('</table></div>
    </div></div>
    <div class="slide">');
  printSliderPageTitle($pageTitle);
  print('
    <div class="pagecolumn"><table>
    <!-- tr> <th></th> <th> Name </th> <th>Verein </th> <th>Ergebnis</th></tr -->
    ');
}

// check string for characters that are not allowed and abort if some are found
Function sanitizeInput($sql)
{
  if (strpos($sql, ';')  !== false) die("Die Eingabe enthält ungültige Zeichen: ;");
  if (strpos($sql, '\\') !== false) die("Die Eingabe enthält ungültige Zeichen: \\");
  if (strpos($sql, '\'') !== false) die("Die Eingabe enthält ungültige Zeichen: '");
  if (strpos($sql, '*')  !== false) die("Die Eingabe enthält ungültige Zeichen: *");
}
?>
