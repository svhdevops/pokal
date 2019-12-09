<?php
    include( "db_func.php" );
    init_globals();
    printPageHeader();
    echo '<body><h2>Mannschaftswertung Schützenklasse</h2>';

    printTeamResults(1);

    echo '<br> <a href="index.html">Zurück zur Auswahl</a><br>
      </body>
      </html>';
?>
