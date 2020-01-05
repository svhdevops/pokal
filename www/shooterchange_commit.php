<?php
    include( "db_func.php" );
    init_globals();

    printPageHeader();

    $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());

    $sql = 'update dorfpokal_schuetze set MannschaftsID="'.$_POST["newteam"].'" where SchuetzenID="' . $_POST["schuetze"] . '";';

    if ($dbconn->query($sql) === TRUE) {
	echo '<h2>Schütze mit ID '.$_POST["schuetze"] .' in Mannschaft mit ID '.$_POST["newteam"].' verlegt.</h2>';
    } else {
	echo "Error: " . $sql . "<br><h3>" . $dbconn->error . "</h3><hr>";
    }
    mysqli_close($dbconn);

    echo '<br>
    <a href="schuetze.php">Weiteren Schützen anlegen</a><br>
    <a href="team.php">Neue Mannschaft anlegen</a><br>
    <a href="index.html">Zurück zur Auswahl</a><br>
    </body>
    </html>';
?>
