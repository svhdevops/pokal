<?php
    include( "admin_interface.php" );
    init_globals();

    if (isAdminEnabled() === 0)
    {
	print "Die Importfunktion ist deaktiviert. Letzte Änderung " . getAdminStateChange();
	return;
    }
    printPageHeader();
    echo '
    <body>
    <h2>Datenbankimport</h2>

    <FORM NAME="Import" action="do_import.php" method="post">
    Commands: <br>
    <textarea name="script" id="script" style="width:450px;height:350px;">
    Your script goes here ...</textarea><br>
    <input type="submit" value="execute">
    </FORM><hr>

    <p> <a href="index.html">Zurück zur Auswahl</a><br></p>
    </body>
    </html>';

?>
