<?php
    include( "db_func.php" );
    init_globals();

    printPageHeader();

    // delete submtted values
        $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());

        $sql = 'update dorfpokal_schuetze set MannschaftsID="'.$_POST["newteam"].'" where SchuetzenID="' . $_POST["schuetze"] . '";';

        if ($dbconn->query($sql) === TRUE) {
            echo '<h2>Schütze mit ID '.$_POST["schuetze"] .' in Mannschaft mit ID '.$_POST["newteam"].' verlegt.</h2>';
        } else {
            echo "Error: " . $sql . "<br>" . $dbconn->error;
        }
        mysqli_close($dbconn);

    echo '<a href="index.html">Zurück zur Auswahl</a><br>
    </body>
      </html>';
?>
