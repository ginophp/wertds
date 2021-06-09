<?php 

// $mysqli = new mysqli('localhost','root','','pos'); 
$mysqli = new mysqli('localhost','root','','pos');
require('function.php');

/* change character set to utf8 */
if (!$mysqli->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
} else {
    // printf("Current character set: %s\n", $mysqli->character_set_name());
}
?>