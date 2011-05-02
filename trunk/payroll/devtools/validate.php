<?php
/*Redbana Payroll System
  Program Description: A PHP File for validating forms using AJAX.
*/
function validator($q,$response){
	//user entered a script as input
	if((stripos($q,"script") !== false)){
		if((stripos($q,"<") !== false) && (stripos($q,">") !== false))
			$response = "Invalid <script></script> input";		
	}
	
	//sql injections
	
	//input is null
	if(strlen($q)==0)
		$response = "Required Value.";
		
	return $response;
}

function validateUname($q,$response){
	if(strlen($q)<5)
		$response = "Minimum of 5 characters";
	
	if(strlen($q)>12)
		$response = "Maximum of 12 characters";
	
	return $response;
}//check length of username

function validatePword($q,$response){
	if(strlen($q)<6)
		$response = "Minimum of 6 characters";
		
	return $response;
}//check length of password

function validateEmail($q,$response){
	if(stripos($q,"@")===false)
		$response = "Invalid E-mail Address";

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

$response = "";
$q = "";
$vtype = "";

if(isset($_POST)){

$q = $_POST["query"];
$vtype = $_POST["vtype"];

$response = validator($q,$response);

if($response==""){
	switch($vtype){
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

echo $response;
}
?>