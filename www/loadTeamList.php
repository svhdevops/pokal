<?php

// returns a list of team members separated by new line
// post param 'mID' - ID of the team

include( "db_func.php" );
init_globals();

$dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());
$result = mysqli_query($dbconn, 'select SchuetzenID,Name from `dorfpokal_schuetze` where MannschaftsID='.$_POST["mID"].' order by Name');
mysqli_close($dbconn);

while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
   print ($res['Name']."\n");
}
?>
