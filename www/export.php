<?php
    include( "db_func.php" );
    init_globals();

    // export the content of the database so that it can be loaded again later

    echo "<h3>Datenbankexport</h3>";

    // this would require mysql client on php container
    // exec("mysqldump --user={$dbuser} --password={$dbpwd} --host={$dbhost} {$dbname} 2>&1", $output);
    // var_dump($output);

    $dbconn = createDbConnection() or die('Could not connect: ' . mysqli_connect_error());

    // just get content of teams and shooters - all other stuff is part of the db schema
    $teams = mysqli_query($dbconn, "select * from dorfpokal_mannschaft;");
    if($teams === FALSE){
        echo "Query failed:<br>" . $dbconn->error . "<br>";
    }
    $num_teams = $teams->num_rows;
    echo $num_teams . " Mannschaften<br>";

    $shooters = mysqli_query($dbconn, "select * from dorfpokal_schuetze;");
    if($shooters === FALSE){
        echo "Query failed:<br>" . $dbconn->error . "<br>";
    }
    $num_shooter = $shooters->num_rows;  
    echo $num_shooter . " Schützen<br>";

    // print the stuff in a way that it can be used for import directly
    echo "<pre>";
    $idx = 0;
    $num_fields = $teams->field_count;  
    echo "INSERT INTO dorfpokal_mannschaft VALUES <br>";
    while($row = $teams->fetch_row()) 
    {
	$idx++;
	$cont=" (";
	for($i=0; $i<$num_fields; $i++)
	{
	    // $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
	    if (isset($row[$i]))
	    {
		$cont .= '"'.$row[$i].'"'; 
	    }else {
		$cont .= 'NULL';
	    }
	    if ($i<($num_fields-1))
	    {
		$cont .= ',';
	    }

	}
	$cont .= ")";
	echo $cont;
	if($idx < $num_teams) echo ",";
	else echo ";";
	echo "<br>";
    }
    echo "<br>";

    $idx = 0;
    $num_fields = $shooters->field_count;  
    echo "INSERT INTO dorfpokal_schuetze VALUES <br>";
    while($row = $shooters->fetch_row()) 
    {
	$idx++;
	$cont=" (";
	for($i=0; $i<$num_fields; $i++)
	{
	    // $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
	    if (isset($row[$i]))
	    {
		$cont .= '"'.$row[$i].'"'; 
	    }else {
		$cont .= 'NULL';
	    }
	    if ($i<($num_fields-1))
	    {
		$cont .= ',';
	    }

	}
	$cont .= ")";
	echo $cont;
	if($idx < $num_shooter) echo ",";
	else echo ";";
	echo "<br>";
    }
    echo "</pre>";
?>
