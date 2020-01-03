<?php
    include( "db_func.php" );
    init_globals();
    printPageHeader();
    echo ' <body>';

    // store submtted values
        $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());

        $sql = 'INSERT INTO dorfpokal_schuetze (Name,MannschaftsID,KlassenID)
                VALUES ( "'. $_POST["name"] . ', ' . $_POST["vorname"] . '", ' . $_POST["mannschaft"] . ' , ' . $_POST["klasse"] . ' )';

        if ($dbconn->query($sql) === TRUE) {
            echo '<h2>Schütze angelegt</h2>';
            echo 'Name: '.$_POST["name"].' MannschaftsID=' . $_POST["mannschaft"] . '<br>';
        } else {
            echo "Error: " . $sql . "<br>" . $dbconn->error;
        }
        mysqli_close($dbconn);

    echo '<br>
    <a href="schuetze.php">Weiteren Schützen anlegen</a><br>
    <a href="team.php">Neue Mannschaft anlegen</a><br>
    <a href="index.html">Zurück zur Auswahl</a><br>
    </body>
      </html>';
?>
