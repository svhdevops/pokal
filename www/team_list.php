<?php
    include( "db_func.php" );
    init_globals();
    printPageHeader();
    echo '<body>';

    echo '<div class="pagerow">
    ';

    $result = getAllShootersByTeam();
    $curVName = "";
    $shooterInTeam = 5; // count shooters in team
    $counter = 9999; // count all shooters for switching the <div>
    $inTable = FALSE;
    while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        if($res["Verein"] != $curVName)
        {
            while($shooterInTeam < 5)
            {
                $shooterInTeam++;
                print ('<tr> <td class="cell-shootername">-</td></tr>
                ');
            }
            $shooterInTeam = 0;
            if($counter > mysqli_num_rows($result)/2 + 1)
            {
                if($inTable)
                {
                    print('</table></div>
                    ');
                }
                print('<div class="pagecolumn"><table width="100%">
                ');
                $inTable = TRUE;
                $counter = 0;
            }
            $curVName = $res["Verein"];
            print('<tr> <td class="cell-teamname" colspan=2> '.$curVName.'</td></tr>
            ');
        }
        print ('<tr> <td class="cell-shootername"><input type="checkbox" id="c'.$counter.'"><label for="c'.$counter.'">&nbsp;'.$res["Name"].'</label></td> </tr>
        ');
        $counter++;
        $shooterInTeam++;
    }
    // fill up last team
    while($shooterInTeam < 5)
    {
        $shooterInTeam++;
        print ('<tr> <td class="cell-shootername"> - </td></tr>
        ');
    }

    echo '</table></div></div>';

    echo '<br> <a href="index.html">Zurück zur Auswahl</a><br>
      </body>
      </html>';
?>
