<?php

include( "db_func.php" );
init_globals();

Function isAdminEnabled()
{
    $dbconn = createDbConnection() or die('Could not connect: ' . mysqli_connect_error());

    $result = mysqli_query($dbconn, "select status,since from admin order by since desc limit 1;");
    if($result === FALSE){
        echo "Query failed:<br>" . $dbconn->error . "<br>";
	return False;
    }
    mysqli_close($dbconn);

    # there is just one row
    $row = $result->fetch_row();

    # print "DEBUG: Admin-Interface enabled: " . $row[0] . " since " . $row[1];

    if ( "1" == $row[0]) return 1;
    else return 0;
}

Function getAdminStateChange()
{
    $dbconn = createDbConnection() or die('Could not connect: ' . mysqli_connect_error());

    $result = mysqli_query($dbconn, "select status,since from admin order by since desc limit 1;");
    if($result === FALSE){
        echo "Query failed:<br>" . $dbconn->error . "<br>";
	return False;
    }
    mysqli_close($dbconn);

    # there is just one row
    $row = $result->fetch_row();

    # print "DEBUG: Admin-Interface enabled: " . $row[0] . " since " . $row[1];

    return $row[1];
}
?>
