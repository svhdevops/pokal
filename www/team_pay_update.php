<?php
    include( "db_func.php" );
    init_globals();

    printPageHeader();
    echo '<body>';

    // store submtted values
    $dbconn = createDbConnection() or die('Could not connect: ' . mysqli_connect_error());

    sanitizeInput($_POST["name"]);
    $sql = 'UPDATE dorfpokal_mannschaft set Paid=1 where Verein="'.$_POST["name"].'"';

    if ($dbconn->query($sql) === TRUE) {
        echo '<h3>Startgeld bezahlt</h3>';
    } else {
        echo "Error: " . $sql . "<br>" . $dbconn->error;
    }
    mysqli_close($dbconn);

    echo '<hr>
    <a href="team_new.php">Weitere Mannschaft anlegen</a><br>
    <a href="schuetze.php">Neuen Schützen anlegen</a><br>
    <a href="index.html">Zurück zur Auswahl</a><br>
    </body>
      </html>';
?>
