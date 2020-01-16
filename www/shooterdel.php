<?php
    include( "db_func.php" );
    init_globals();

// first run query
    $dbconn = createDbConnection()or die('Could not connect: ' . mysql_error());
    $resultMannschaften = mysqli_query($dbconn, "select MannschaftsID,Verein from `dorfpokal_mannschaft` order by Verein ");
    mysqli_close($dbconn);

// now create html
    printPageHeader();
echo '
<body>
<h2>Schütze löschen</h2>
<FORM NAME="ergebnis" action="shooterdel_commit.php" method="post">
    <table style="table-layout:auto; width:300px">
    <tr><td>Mannschaft</td>
    <td><SELECT id="mannschaft">';
    while($mannschaft = mysqli_fetch_array($resultMannschaften, MYSQLI_ASSOC))
    {
	     print ("      <OPTION VALUE=".$mannschaft['MannschaftsID'].">".$mannschaft['Verein']."\n");
    }
    echo '
    </SELECT></td></tr>
    <tr><td>Name</td>
    <td><select id="schuetze" name="schuetze">
    </select></td>
    </tr>
    <tr><td></td><td><input type="submit" value="Löschen"></td></tr>
    </table>
</FORM>
<hr> <p> <a href="schuetze.php">Schützen anlegen</a>
<br> <a href="index.html">Zurück zur Auswahl</a><br>

<script src="jquery.js"></script>
<script>
// Listens to the event that is trigerred by selecting the Mannschaft and calls the function to load team members
// and update the member selction box
$("#mannschaft").on(\'change\', function(){
  var selected = $(this).children(":selected").val();
  //Calls the function and passes to it the selection as a parameter.
  loadMannschaft(selected);
});


// A function that uses jQuery.post to transfer the selected option to the server side, and returns the data back from the server.
function loadMannschaft(selected){
  var selbox = $(\'#schuetze\');
  $.post(\'loadMannschaft.php\', {mID : selected} , function(data) {
    //Takes the data returned from the server and embeds in the HTML.
    selbox.html(data);
  });
}

//Calls to the function when the page loads.
$(window).on(\'load\', loadMannschaft($("#mannschaft").children(":selected").val()));
</script>

</body>
</html>
';

?>
