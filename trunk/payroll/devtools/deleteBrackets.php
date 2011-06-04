<?php
include "dbconnection.php";
$connect = connectdb();//open database connection


function getName($empnum) {
	$result = mysql_query("SELECT * FROM `employee` WHERE empnum='".$empnum."'");
	while($row = mysql_fetch_array($result))
		$name=$row['fname'].' '.$row['sname'];
	return $name;
}

function getTime()
{
	$result = mysql_query("SELECT NOW() time FROM dual");
	while($row = mysql_fetch_array($result))
		$time=$row['time'];
	return $time;
}

if(isset($_POST)){

$query2 = $_POST['query'];
$table = $_POST['tableType'];
$name = $_POST['person'];//name of account user

switch($table){
	case 'employee':
	{
		$field = 'empnum';
		//add to history
		$person=getName($query2);//name of person to be deleted
		$today=getTime();
		$query1="INSERT INTO history(`date`,`user`,`person`,`table`,`action`) VALUES ('".$today."','".$name."','".$person."','employee','delete')";
		mysql_query($query1);
		break;
	}
	case 'user_main': 
	{
		$field = 'user_right';			
		break;
	}
	default: 
	{
		$field = 'id';
		break;
	}
}

//delete row from the specified table
$sql = "DELETE FROM `".$table."` WHERE ".$field."='".$query2."'";
mysql_query($sql);
closeconnection($connect);//close database connection
}
?>