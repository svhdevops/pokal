<?php
    include( "db_func.php" );
    init_globals();

// first run query
    $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());
    $result = mysqli_query($dbconn, "select MannschaftsID,Verein from `dorfpokal_mannschaft` order by Verein");
    mysqli_close($dbconn);

// now create some simple html
    printPageHeader();
    echo '<body>
      <h2>Mannschaft löschen</h2>
      <span class="warn">Achtung: alle Schützen der Mannschaft werden ebenfalls gelöscht.<br></span>
      <br>
      <FORM NAME="Teamdel" action="teamdel_commit.php" method="post">
      Mannschaft <SELECT NAME="mannschaft">';

    while($klasse = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
	     print ("<OPTION VALUE=".$klasse['MannschaftsID'].">".$klasse['Verein']."\n");
    }

    echo '
      </SELECT>
      <input type="submit" value="Löschen">
      </FORM>
      <hr>
      <a href="index.html">Zurück zur Auswahl</a><br>
      </body>
      </html>';
?>
