<?php
    include( "db_func.php" );
    init_globals();

// first run query
    $result = getAllShooters();

// now create some simple html
    printPageHeader();

    echo '<table>
      <tr> <th></th> <th> Name </th> <th>Verein </th></tr>
      ';

    $idx = 1;

    while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        print ('<tr> <td class="cell-place"> '.$idx.'. </td> <td class="cell-shootername">'.$res["Name"].'</td>  <td> '.$res["Verein"].'</td></tr>
        ');
        $idx++;
    }

    echo '</table>

      <hr>
      <a href="index.html">Zurück zur Auswahl</a><br>
      </body>
      </html>';
?>
