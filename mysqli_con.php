<?php


/*Link zu Datenbank*/ /*Sollte es nicht erfolgreich sein dann gib fehlermeldung aus (dies <-Keyword)*/
$dbc = @mysqli_connect('asdfgh', 'asdf', 'sdf', 'df');

if($dbc->connect_error) {
  exit('Error connecting to database: ' . mysqli_connect_error()); 
}


?>