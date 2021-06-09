<?php

require_once("class/config.php");

$q = $mysqli->query("desc demandletter_anchor");

echo"<table border =1>";
while($r = $q->fetch_object()){
    echo "<td>".$r->Field."</td>";
}
echo "</table>";

?>