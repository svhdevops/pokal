<?php
    include( "db_func.php" );
    init_globals();

    printPageHeader();

    // store submtted values
    $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());

    if ($dbconn->query($_POST["script"]) === TRUE) {
        echo '<h2>Daten erfolgreich importiert</h2>';
    } else {
        echo "Error: " . $sql . "<br>" . $dbconn->error;
    }
    mysqli_close($dbconn);

    echo '
    <a href="index.html">Zurück zur Auswahl</a><br>
    </body>
    </html>';
?>

