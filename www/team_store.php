<?php
    include( "db_func.php" );
    init_globals();

    printPageHeader();
    echo '<body>';

    // store submtted values
    $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());

    $sql = 'INSERT INTO dorfpokal_mannschaft (Verein) VALUES ( "'. $_POST["name"] . '" )';

    if ($dbconn->query($sql) === TRUE) {
        echo '<h2>Mannschaft angelegt</h2>';
        echo 'Name: '.$_POST["name"].' <br>';
    } else {
        echo "Error: " . $sql . "<br>" . $dbconn->error;
    }
    mysqli_close($dbconn);

    echo '<a href="team.php">Weitere Mannschaft anlegen</a><br>
    <a href="index.html">Zurück zur Auswahl</a><br>
    </body>
      </html>';
?>
