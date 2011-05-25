<?php
include 'dbconnection.php';

function finalized($payperiod){
	$sql = "SELECT FINALIZED FROM `payperiod`
				WHERE id='".$payperiod."'";
	$query = mysql_query($sql);
	$data = mysql_fetch_array($query);
		
	if($data['FINALIZED']==1) return true;
	else return false;
}//check if pay period is already finalized

function returnCutoff($payperiod){
	$sql = "SELECT * FROM `payperiod` 
			WHERE id='".$payperiod."'";
	$query = mysql_query($sql);
	$data = mysql_fetch_array($query);
	
	$data['start_date'] = $data['START_DATE'];
	$data['end_date'] = $data['END_DATE'];
	
	return $data;
}//return cutoff start and end date

function getName($employeeNum){
	$sql = "SELECT * FROM `employee` 
			WHERE empnum='".$employeeNum."'";
	$query = mysql_query($sql);
	$data = mysql_fetch_array($query);
	
	return $data['sname'].", "
		   .$data['fname']." "
		   .$data['mname'];
}//get name of the employee

function getTaxStatus($employeeNum){
	$sql = "SELECT * FROM `employee` 
			WHERE empnum='".$employeeNum."'";
	$query = mysql_query($sql);
	$data = mysql_fetch_array($query);
	
	return $data['tax_status'];
}//get tax status of employee

function showPayroll($startDate,$endDate,$payperiod){
	$response = "";

	$sql = "SELECT * FROM `salary` WHERE
			start_date='".$startDate."' 
			AND end_date='".$endDate."' 
			ORDER BY EmployeeNumber";
	$query = mysql_query($sql);
	
	$response = $response."<table><tr>
		 <th>Employee Number</th><th style='align:left'>Employee Name</th>
		 <th>Pay Slip</th>";
	if(!finalized($payperiod))	 
		 $response = $response."<th>Modify</th></tr>";
	
	while($row = mysql_fetch_array($query)){
		$response = $response."<tr id='info' name='info'>
					<form method='post' accept-charset='utf-8' 
					action='editpayslip'>
					<td>".$row['EmployeeNumber']."</td>
					<td>".getName($row['EmployeeNumber'])."</td>
					<td style='text-align:center'>
					<input type='hidden' id='EmployeeNumber' 
					name='EmployeeNumber' value='".$row['EmployeeNumber']."'/>
					<input type='hidden' id='start_date' 
					name='start_date' value='".$startDate."'/>
					<input type='hidden' id='end_date' 
					name='end_date' value='".$endDate."'/>
					<input type='submit' id='netpay' name='netpay' value='View'/></td>";
		if(!finalized($payperiod))
			$response = $response."<td><input type='submit' id='edit' name='edit' value='Edit'/></td>";
		$response = $response."</form></tr>";
	}
	
	$response = $response."</table>";
	return $response;
}//show initial payroll for said payperiod

$connect = connectdb();//open database connection

$payperiod = $_POST['payperiod'];

$cutoff = returnCutoff($payperiod);
$start_date = $cutoff['start_date'];
$end_date = $cutoff['end_date'];
	
$response = showPayroll($start_date,$end_date,$payperiod);

if(finalized($payperiod))
	$response = "<h4 style='color:red'>This Pay Period 
				is already finalized.</h4>".$response;

closeconnection($connect);//close database connection

echo $response;

?>