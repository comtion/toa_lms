<?php
ini_set('display_errors',1);
error_reporting(~0);
$hostname_condb="localhost";
$username_condb="root";
$password_conndb="comtion35";
$db_name="isuzu_motor";


/*$hostname_condb="localhost";
$username_condb="pmmhhgwrua";
$password_conndb="Verztec123";
$db_name="pmmhhgwrua";
*/
$conndb=mysqli_connect($hostname_condb,$username_condb,$password_conndb,$db_name);
//$conndb=mysqli_connect($hostname_condb2,$username_condb2,$password_conndb2,$db_name2);
//mysqli_set_charset($conndb, 'utf8'); 

?>