<?php
include "dbconnection.php";

if(isset($_POST)){

$query = $_POST['query'];
$table = $_POST['tableType'];

$connect = connectdb();//open database connection

//delete bracket from the specified table
mysql_query("DELETE FROM `".$table."` WHERE id='".$query."'");

closeconnection($connect);//close database connection

echo $_POST['query'];
}
?>