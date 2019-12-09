<?php
    include( "db_func.php" );
    init_globals();
    printPageHeader();
    echo '<body><h2>Einzelwertung Damenklasse</h2>';

    printSingleResultTable(2);

    echo '<br> <a href="index.html">Zurück zur Auswahl</a><br>
      </body>
      </html>';
?>
