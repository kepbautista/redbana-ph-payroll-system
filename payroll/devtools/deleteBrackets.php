<?php
include "dbconnection.php";

if(isset($_POST)){

$query = $_POST['query'];
$table = $_POST['tableType'];

switch($table){
	case 'employee': $field = 'empnum';
					 break;
			default: $field = 'id';
					 break;
}

$connect = connectdb();//open database connection

//delete row from the specified table
$sql = "DELETE FROM `".$table."` WHERE ".$field."='".$query."'";
mysql_query($sql);

closeconnection($connect);//close database connection

echo $_POST['query'];
}
?>