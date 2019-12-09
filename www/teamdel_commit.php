<?php
    include( "db_func.php" );
    init_globals();

    printPageHeader();

    // delete submtted values
        $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());

        $sql = 'delete from dorfpokal_mannschaft where MannschaftsID="' . $_POST["mannschaft"] . '";';

        if ($dbconn->query($sql) === TRUE) {
            echo '<h2>Mannschaft ID '.$_POST["mannschaft"] .' gelöscht</h2>';
        } else {
            echo "Error: " . $sql . "<br>" . $dbconn->error;
        }
        mysqli_close($dbconn);

    echo '<a href="team.php">Weitere Mannschaft anlegen</a><br>
    <a href="index.html">Zurück zur Auswahl</a><br>
    </body>
      </html>';
?>
