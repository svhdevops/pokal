<?php
include( "db_func.php" );
init_globals();

$dbconn = createDbConnection() or die('Could not connect: ' . mysql_error());
$result = mysqli_query($dbconn, 'select Serie1,Serie2,Schuss11,Schuss12,Schuss13 from `dorfpokal_schuetze` where SchuetzenID='.$_POST["mID"]);
mysqli_close($dbconn);

$res = mysqli_fetch_array($result, MYSQLI_ASSOC);

echo $res['Serie1']." ".$res['Serie2']." ".$res['Schuss11']." ".$res['Schuss12']." ".$res['Schuss13'];

?>
