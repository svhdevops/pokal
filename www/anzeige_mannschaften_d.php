<?php
    include( "db_func.php" );
    init_globals();
    printPageHeader();
    echo '<body><h2>Mannschaftswertung Damenklasse</h2>';

    printTeamResults(2);

    echo '<br> <a href="index.html">Zurück zur Auswahl</a><br>
      </body>
      </html>';
?>
