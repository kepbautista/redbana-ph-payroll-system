<?php
include "dbconnection.php";
$connect = connectdb();//open database connection

function getName($empnum) {
	$result = mysql_query("SELECT * FROM `employee` WHERE empnum='".$empnum."'");
	while($row = mysql_fetch_array($result))
		$name=$row['fname'].' '.$row['sname'];
	return $name;
}
function getThing($id,$table) {
	if ($table=="user_main")
		$result = mysql_query("SELECT * FROM `".$table."` WHERE user_right='".$id."'");
	else
		$result = mysql_query("SELECT * FROM `".$table."` WHERE id='".$id."'");
	while($row = mysql_fetch_array($result))
	{
		switch($table){
			case 'emp_type':
				$name=$row['type'];
				break;
			case 'tax_status':
				$name=$row['status'];
				break;
			case 'pos_main':
				$name=$row['position'];
				break;
			case 'user_main':
				$name=$row['user_right'];
				break;
			case 'daily_desc':
				$name=$row['title'];
				break;
			case 'dept_main':
				$name=$row['dept'];
				break;
			
		}
	}return $name;
}
function getTime()
{
	$result = mysql_query("SELECT NOW() time FROM dual");
	while($row = mysql_fetch_array($result))
		$time=$row['time'];
	return $time;
}
function insert_history($date,$user,$person,$table,$action)
{
		mysql_query('INSERT INTO history(`date`,`user`,`person`,`table`,`action`) VALUES ("'.$date.'","'.$user.'","'.$person.'","'.$table.'","'.$action.'")');
}
if(isset($_POST)){

$query2 = $_POST['query'];
$table = $_POST['tableType'];
$name = $_POST['person'];//name of account user

switch($table){
	case 'employee':
	{
		$field = 'empnum';
		insert_history(getTime(),$name,getName($query2),"employee","delete");
		break;
	}
	case 'user_main': 
	{
		$field = 'user_right';			
		insert_history(getTime(),$name,getThing($query2,"user_main"),"user_main","delete");
		break;
	}
	case 'tax_status': 
	{
		$field = 'id';			
		insert_history(getTime(),$name,getThing($query2,"tax_status"),"tax_status","delete");
		break;
	}
	case 'pos_main': 
	{
		$field = 'id';			
		insert_history(getTime(),$name,getThing($query2,"pos_main"),"pos_main","delete");
		break;
	}
	case 'emp_type': 
	{
		$field = 'id';			
		insert_history(getTime(),$name,getThing($query2,"emp_type"),"emp_type","delete");
		break;
	}
	case 'daily_desc': 
	{
		$field = 'id';			
		insert_history(getTime(),$name,getThing($query2,"daily_desc"),"daily_desc","delete");
		break;
	}
	case 'dept_main': 
	{
		$field = 'id';			
		insert_history(getTime(),$name,getThing($query2,"dept_main"),"dept_main","delete");
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