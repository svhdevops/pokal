<?php
    include( "db_func.php" );
    init_globals();

    printPageHeader();

    // store submtted values
    $dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());
    $sql = 'update dorfpokal_schuetze set Serie1=' . $_POST["ser_1"]
                                     . ', Serie2=' . $_POST["ser_2"]
                                     . ', Schuss11=' . $_POST["s_11"]
                                     . ', Schuss12=' . $_POST["s_12"]
                                     . ', Schuss13=' . $_POST["s_13"]
                                     . ' where SchuetzenID=' . $_POST["schuetze"] . ' ;';

    if ($dbconn->query($sql) === TRUE) {
        echo '<h2>Ergebnis eingetragen</h2>';
        echo 'Serie 1 ' . $_POST["ser_1"] . "<br>Serie 2 " . $_POST["ser_2"] .'<br>SchützenID '.$_POST["schuetze"].'<br>';
    } else {
        echo "Error: " . $sql . "<br>" . $dbconn->error;
    }
    mysqli_close($dbconn);

    echo '<br><a href="result.php">Weiteres Ergebnis anlegen</a><br>
    <a href="index.html">Zurück zur Auswahl</a><br>
    </body>
      </html>';
?>
