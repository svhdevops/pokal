<?php
    include( "db_func.php" );
    init_globals();

    printPageHeader();

    // delete submtted values
        $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());

        $sql = $sql = 'update dorfpokal_schuetze set Serie1=null'
                                     . ', Serie2=null'
                                     . ', Schuss11=null'
                                     . ', Schuss12=null'
                                     . ', Schuss13=null'
                                     . ' where SchuetzenID=' . $_POST["schuetze"] . ' ;';

        if ($dbconn->query($sql) === TRUE) {
            echo '<h2>Ergebnis für den Schützen mit ID '.$_POST["schuetze"] .' wurde gelöscht</h2>';
        } else {
            echo "Error: " . $sql . "<br>" . $dbconn->error;
        }
        mysqli_close($dbconn);

    echo '<a href="index.html">Zurück zur Auswahl</a><br>
    </body>
      </html>';
?>
