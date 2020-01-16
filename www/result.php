<?php
    include( "db_func.php" );
    init_globals();

// first run query to get all teams
    $dbconn = createDbConnection()or die('Could not connect: ' . mysqli_error());
    $resultMannschaften = mysqli_query($dbconn, "select MannschaftsID,Verein from `dorfpokal_mannschaft` order by Verein ");
    mysqli_close($dbconn);

// now create html
    printPageHeader();
echo '
<body>
<h2>Neues Ergebnis eintragen</h2>
<FORM NAME="ergebnis" action="result_store.php" method="post">
    <table  class="input-table" >
    <tr><td>Name</td>
    <td><select id="schuetze" name="schuetze">
    </select></td>
    <td>Mannschaft</td>
    <td><SELECT id="mannschaft">';
    while($mannschaft = mysqli_fetch_array($resultMannschaften, MYSQLI_ASSOC))
    {
	     print ("      <OPTION VALUE=".$mannschaft['MannschaftsID'].">".$mannschaft['Verein']."\n");
    }
    echo '
    </SELECT></td></tr>
    <tr>
    <td> 1. Serie </td><td> <input type="number" maxlength="2" max="50" name="ser_1" id="ser_1"></td>
    <td> 2. Serie </td><td> <input type="number" maxlength="2" max="50" name="ser_2" id="ser_2"></td></tr>
    <tr>
    <td>11. Schuss </td><td> <input type="number" maxlength="2" max="10" name="s_11" id="s_11"></td>
    <td>12. Schuss </td><td> <input type="number" maxlength="2" max="10" name="s_12" id="s_12"></td>
    <td>13. Schuss </td><td> <input type="number" maxlength="2" max="10" name="s_13" id="s_13"></td></tr>
    </table>
    <input type="submit" value="Speichern">
</FORM>
<hr> <p> <a href="schuetze.php">Schützen anlegen</a>
<br> <a href="index.html">Zurück zur Auswahl</a><br>

<script src="jquery.js"></script>
<script>
// Listens to the event that is trigerred by selecting the team, calls the function to load team members
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
    loadShooterResult($("#schuetze").children(":selected").val());
  });
}

// pretty much the same as above just for the shooter - to show results if any have been stored before
$("#schuetze").on(\'change\', function(){
  var selected = $(this).children(":selected").val();
  //Calls the function and passes to it the selection as a parameter.
  loadShooterResult(selected);
});

function loadShooterResult(selected){
  $.post(\'loadShooter.php\', {mID : selected} , function(data) {
    // fill input boxes with the data returned from the server 
    var ret = data.split(\' \');
    document.getElementById(\'ser_1\').value = ret[0];
    document.getElementById(\'ser_2\').value = ret[1];
    document.getElementById(\'s_11\').value = ret[2];
    document.getElementById(\'s_12\').value = ret[3];
    document.getElementById(\'s_13\').value = ret[4];
  });
}

//Calls to the functions when the page loads.
$(window).on(\'load\', loadMannschaft($("#mannschaft").children(":selected").val()) );
$(window).on(\'load\', loadShooterResult($("#schuetze").children(":selected").val()));

</script>

</body>
</html>
';

?>
