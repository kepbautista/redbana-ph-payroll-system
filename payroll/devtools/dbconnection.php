<?php
/*Functions for database connections*/
function connectdb() {
	$con = mysql_connect("localhost","root");//create connection to the database
	if (!$con)
		die('Could not connect: ' . mysql_error());
		
	mysql_select_db("redbana_payroll", $con);//select database from user
	return $con;
}//connect to the database
	
function closeconnection($con) {
	mysql_close($con);
}//close database connection
?>