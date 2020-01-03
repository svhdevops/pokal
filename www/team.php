<?php
    include( "db_func.php" );
    init_globals();

// first run query
    $dbconn = createDbConnection()or die('Could not connect: ' . mysqli_connect_error());
    $resultMannschaften = mysqli_query($dbconn,
      "select Verein from dorfpokal_mannschaft order by Verein;");
//       "select m.Verein,k.Bezeichnung from dorfpokal_mannschaft as m, dorfpokal_klasse as k
//        where m.KlassenID=k.KlassenID order by m.Verein;");
    mysqli_close($dbconn);

// now create some simple html
    printPageHeader();
    echo '<body>
      <h2>Mannschaften</h2>';
    $counter = 0; // enumerate teams
    while($mannschaft = mysqli_fetch_array($resultMannschaften, MYSQLI_ASSOC))
    {
        $counter++;
//        print ($counter.'. '.$mannschaft['Verein']."  (".$mannschaft['Bezeichnung'].')<br>
        print ($counter.'. '.$mannschaft["Verein"].'<br>
              ');
    }
    echo '<h2>Neue Mannschaft anlegen</h2>
      <FORM NAME="Mannschaft" action="team_store.php" method="post">
      Name: <input type="text" name="name">
      <input type="submit" value="Speichern">

      </FORM><hr>
      <p> <a href="index.html">Zurück zur Auswahl</a><br></p>
      </body>
      </html>';

?>
