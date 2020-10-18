<?php

$hostname_condb="localhost";
$username_condb="root";
$password_conndb="comtion35";
$db_name="isuzu_motor";

$conndb=mysqli_connect($hostname_condb,$username_condb,$password_conndb,$db_name);
//$conndb=mysqli_connect($hostname_condb2,$username_condb2,$password_conndb2,$db_name2);
//mysqli_set_charset($conndb, 'utf8'); 
if (mysqli_connect_errno())
{
	echo "Error Connect".mysqli_connect_error();
	exit();
}


include("MysqliDb.php");
$strHost = "localhost";
$strDB = "isuzu_motor";
$strUser = "root";
$strPassword = "comtion35";
$db = new MysqliDb($strHost,$strUser,$strPassword,$strDB);

?>