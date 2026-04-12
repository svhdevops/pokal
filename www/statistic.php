<?php
    include( "db_func.php" );
    init_globals();
    printPageHeader();
    echo '<body><h2>Statistik</h2>';

    $teams = mysqli_fetch_array(getNumTeams(), MYSQLI_ASSOC);
    $shooters = mysqli_fetch_array(getNumShooters(), MYSQLI_ASSOC);
    print ('Mannschaften: '.$teams["numTeams"].'<br>Schützen: '
        . $shooters["numShooters"] );

    echo '<body><h4>Noch austehende Ergebnisse</h4>';
    echo '<table>
      <tr> <th></th> <th> Name </th> <th>Verein </th> </tr>
      ';

    $result = getMissingResults();
    $idx = 1;
    $rowStyles = [ "even-row", "uneven-row"];

    while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        print ('<tr class="'.$rowStyles[ $idx % 2 ].'"> <td> '.$idx.'. </td> <td>'.$res["Name"].'</td> <td> '
          . $res["Verein"] . '</td>  </tr>');
        $idx++;
    }

    echo '</table>';

    echo '<br> <a href="index.html">Zurück zur Auswahl</a><br>
      </body>
      </html>';
?>
