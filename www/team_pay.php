<?php
    include( "db_func.php" );
    init_globals();

    // first run query
    $dbconn = createDbConnection()or die('Could not connect: ' . mysqli_connect_error());
    $resultMannschaften = mysqli_query($dbconn,
      "select Verein,Paid from dorfpokal_mannschaft order by Verein;");
    mysqli_close($dbconn);

    // now create some simple html
    printPageHeader();
    echo '<body>
      <h2>Mannschaften - Startgeld</h2>
      ';
    $counter = 0; // enumerate teams
    while($mannschaft = mysqli_fetch_array($resultMannschaften, MYSQLI_ASSOC))
    {
        $counter++;
        print('<FORM NAME="Zahlung" action="team_pay_update.php" method="post" name="'.$mannschaft["Verein"].'">');
        print($counter.'. '.$mannschaft["Verein"].'  - ');
        if(0 < $mannschaft["Paid"]) {
          print('bereits bezahlt<br>');
        } else {
          print('<button type="submit" name="name" value="'.$mannschaft["Verein"].'">Kassiert</button></FORM>');
        }
        print('
        ');
    }
    echo '
      </body>
      </html>';

?>
