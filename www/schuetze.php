<?php
    include( "db_func.php" );
    init_globals();

// first run query
    $dbconn = createDbConnection()or die('Could not connect: ' . mysql_error());
    $result = mysqli_query($dbconn, "select MannschaftsID,Verein from `dorfpokal_mannschaft` order by Verein");
    mysqli_close($dbconn);

// now create some simple html
    printPageHeader();
    echo '<body>
      <h2>Neuen Schützen anlegen</h2>
      <FORM NAME="Schuetze" action="schuetze_store.php" method="post">
      <table class="input-table" >
      <tr><td>Mannschaft</td><td> <SELECT NAME="mannschaft">';

    while($klasse = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
	     print ("<OPTION VALUE=".$klasse['MannschaftsID'].">".$klasse['Verein']."\n");
    }

    echo '</SELECT></td></tr>
      <tr><td>Name</td><td> <input type="text" name="name" value="" id="name"/>
      </td></tr>
        <tr><td>Vorname</td><td> <input type="text" name="vorname" value="" id="vorname"/>
      </td></tr><tr><td>
      </td><td>
      <fieldset>
         <input type="radio" name="klasse" id="DK" value="2" checked>
         <label for="DK"> Damenklasse</label><br>
         <input type="radio" name="klasse" id="SK" value="1">
         <label for="SK"> Schützenklasse</label>
      </fieldset>
      </td></tr>
      <tr><td></td>
      <td> <input type="submit" value="Speichern"></td><td>
      </table>
      </FORM>
      <hr>
      <a href="team.php">Neue Mannschaft anlegen</a><br>
      <a href="index.html">Zurück zur Auswahl</a><br>
      </body>
      </html>';
?>
