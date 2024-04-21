<?php
    include( "db_func.php" );
    init_globals();

// first run query
    $dbconn = createDbConnection()or die('Could not connect: ' . mysqli_connect_error());
    $result = mysqli_query($dbconn, "select MannschaftsID,Verein from `dorfpokal_mannschaft` order by Verein");
    mysqli_close($dbconn);

// now create some simple html
    printPageHeader();
    $teamid = $_GET["teamid"];
    echo '<body>
      <h2>Neuen Schützen anlegen</h2>
      <table class="input-table">
      <tr><td><table>
      <FORM NAME="Schuetze" action="schuetze_store.php" method="post">
      <table >
      <tr><td>Mannschaft</td><td> <SELECT id="mannschaft" NAME="mannschaft">';

    while($klasse = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
	     print ("<OPTION VALUE=".$klasse['MannschaftsID']);
       if($klasse['MannschaftsID'] == $teamid)
       {
         print(' SELECTED="true"');
       }
       print (">".$klasse['Verein']."\n");
    }

    echo '</SELECT></td></tr>
      <tr><td>Name</td><td> <input type="text" name="name" minlength="2" value="" id="name"/>
      </td></tr>
        <tr><td>Vorname</td><td> <input type="text" name="vorname" minlength="2" value="" id="vorname"/>
      </td></tr><tr><td>
      </td><td>
      <fieldset>
         <input type="radio" name="klasse" id="DK" value="2" checked>
         <label for="DK"> Damenklasse</label><br>
         <input type="radio" name="klasse" id="SK" value="1">
         <label for="SK"> Schützenklasse</label>
      </fieldset>
      </td></tr>
      <tr><td></td>
      <td> <input type="submit" value="Speichern"></td></tr>
      </table>
      </FORM></td><td id="teamlist" valign=top>
      <b>Mannschaftsmitglieder</b><ul>
      <li> - </li>
      </ul></td></tr></table>
      <hr>
      <a href="team_new.php">Neue Mannschaft anlegen</a><br>
      <a href="index.html">Zurück zur Auswahl</a><br>

<script src="jquery.js"></script>
<script>
// Listens to the event that is trigerred by selecting the Mannschaft and calls the function to load team members
// and update the member list
$("#mannschaft").on(\'change\', function(){
  var selected = $(this).children(":selected").val();
  //Calls the function and passes to it the selection as a parameter.
  loadMannschaft(selected);
});

// use jQuery.post to transfer the id of the selected team to the server side,
// and get a list of team members back
function loadMannschaft(selected){
  var box = $(\'#teamlist\');
  $.post(\'loadTeamList.php\', {mID : selected} , function(data) {
    // transforms the returned data to proper HTML
    var text = "<b>Mannschaftsmitglieder:</b><ul>";
    var arr = data.split("\n");
    var i;
    for(i=0; i < arr.length - 1; i++) {
        text += "<li>" + arr[i];
    }
    text += "</ul></td></tr></table>";
    if (i > 4) {
      text += "<h3 class=warn>Diese Mannschaft hat bereits 5 Schützen</h3>";
    }
    box.html(text);
  });
}

//Calls to the function when the page loads.
$(window).on(\'load\', loadMannschaft($("#mannschaft").children(":selected").val()));
</script>

</body>
</html>';
?>
