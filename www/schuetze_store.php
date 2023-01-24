<?php
    include( "db_func.php" );
    init_globals();
    printPageHeader();
    echo ' <body>';

    $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());

    sanitizeInput($_POST["name"]);
    sanitizeInput($_POST["vorname"]);
    $sql = 'INSERT INTO dorfpokal_schuetze (Name,MannschaftsID,KlassenID)
	    VALUES ( "'. $_POST["name"] . ', ' . $_POST["vorname"] . '", ' . $_POST["mannschaft"] . ' , ' . $_POST["klasse"] . ' )';

    if ($dbconn->query($sql) === TRUE) {
	echo '<h2>Schütze angelegt</h2>';
	echo 'Name: '.$_POST["name"].', '.$_POST["vorname"].'<br>MannschaftsID: ' . $_POST["mannschaft"] . '<br>';
    } else {
	echo "Error: " . $sql . "<br><h3>" . $dbconn->error . "</h3>";
    }
    mysqli_close($dbconn);

    echo '<hr>
    <a href="schuetze.php?teamid='.$_POST["mannschaft"].'">Weiteren Schützen anlegen</a><br>
    <a href="team.php">Neue Mannschaft anlegen</a><br>
    <a href="index.html">Zurück zur Auswahl</a><br>
    </body>
    </html>';
?>
