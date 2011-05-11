<?php
/*Redbana Payroll System
  Program Description: A PHP File for validating forms using AJAX.
*/

include "dbconnection.php";

function validator($q,$response){
	//user entered a script as input
	if((stripos($q,"script") !== false)){
		if((stripos($q,"<") !== false) && (stripos($q,">") !== false))
			$response = "Invalid <script></script> input";		
	}
	
	//sql injections
	
	//input is null
	if(($_POST['vtype']!='open') && ($_POST['vtype']!='e-mail')){
		//value is required
		if(strlen($q)==0) $response = "Required Value.";
	}
		
	return $response;
}

function validateEmpNum($q,$response){
	
	//search if employee number is existing
	$query = mysql_query("SELECT * from `employee` WHERE empnum LIKE '".$q."'");
	
	//count number of rows produced by the query
	$rows = mysql_num_rows($query);
	
	if($rows>0)
		$response = "Employee Number already exists.";
		//employee number already exists
	//else
	/**VALIDATE EMPLOYEE NUMBER FORMAT
							here!!!**/
	
	return $response;
}//function for validating employee number format

function validateUname($q,$response){
	if(strlen($q)<5)
		$response = "Minimum of 5 characters";
	
	if(strlen($q)>12)
		$response = "Maximum of 12 characters";
	
	return $response;
}//check length of username

function validatePword($q,$response){
	if(strlen($q)<10)
		$response = "Minimum of 10 characters";
		
	return $response;
}//check length of password

function validateEmail($email,$response){
	if((strlen($email)>0)){
		// check an email address is possibly valid
		if (!preg_match("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$^", $email)) {
			$response = "Invalid E-mail Address!";
			//prompt for invalid e-mail address
		}
	}//check if the email address entered is valid
	
	return $response;
}//check validity of email address

function validateNumber($q,$response){
	if(!is_numeric($q))
		$response = "Input should be numeric.";
		//input is not a number
	else if($q<0)
		$response = "Number should not be negative.";
		//check if number is negative

	return $response;
}

$connect = connectdb();//open database connection

$response = "";
$q = "";
$vtype = "";

if(isset($_POST)){

$q = $_POST["query"];
$vtype = $_POST["vtype"];

$response = validator($q,$response);

if($response==""){
	switch($vtype){
		case 'enum': $response = validateEmpNum($q,$response);
					break;
		case 'uname': $response = validateUname($q,$response);
					break;
		case 'password': $response = validatePword($q,$response);
					break;
		case 'e-mail': $response = validateEmail($q,$response);
					break;
		case 'numeric': $response = validateNumber($q,$response);
					break;
	}//validation type
}

closeconnection($connect);//close database connection

echo $response;
}
?>