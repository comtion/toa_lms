<?php

include("conn.php");
mysqli_query($conndb,"SET NAMES 'utf8'");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title></title>

</head>

<body>
<?php 
  $sql = "SELECT lcode,les_name,les_info,time_create,time_start,time_end,time_mod,hidden,lang FROM `LMS_LES`where courses_id = '1'";
  $query = mysqli_query($conndb,$sql);
  while($fetch = mysqli_fetch_array($query)){
    $sql_insert = "insert into LMS_LES(courses_id,lcode,les_name,les_info,time_create,time_start,time_end,time_mod,hidden,lang)values('5','".$fetch['lcode']."','".$fetch['les_name']."','".$fetch['les_info']."','".$fetch['time_create']."','".$fetch['time_start']."','".$fetch['time_end']."','".$fetch['time_mod']."','".$fetch['hidden']."','".$fetch['lang']."')";
    //echo $sql_insert."<br>";
    $query_insert = mysqli_query($conndb,$sql_insert);
  }
?> 
</body>
</html>