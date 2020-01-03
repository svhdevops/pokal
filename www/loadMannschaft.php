<?php
include( "db_func.php" );
init_globals();

$dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());
$result = mysqli_query($dbconn, 'select SchuetzenID,Name from `dorfpokal_schuetze` where MannschaftsID='.$_POST["mID"].' order by Name');
mysqli_close($dbconn);

echo "<select id=\"schuetze\">";
while($res = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
   print ("<OPTION VALUE=".$res['SchuetzenID'].">".$res['Name']."\n");
}
echo "</select>";
?>
