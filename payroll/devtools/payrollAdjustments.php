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

function showPayroll($startDate,$endDate){
	$response = "";

	$sql = "SELECT * FROM `salary` WHERE
			start_date='".$startDate."' 
			AND end_date='".$endDate."' 
			ORDER BY EmployeeNumber";
	$query = mysql_query($sql);
	
	$response = $response."<table><tr>
		 <th>Employee Number</th><th>Employee Name</th>
		 <th>Tax Status</th><th>Pay Period Rate</th>
		 <th>NetPay</th><th>Remarks</th><th>Status</th>
		 <th>Modify</th></tr>";
	
	while($row = mysql_fetch_array($query)){
		$response = $response."<tr id='info' name='info'>
					<form method='post' accept-charset='utf-8' 
					action='editpayslip'>
					<td>".$row['EmployeeNumber']."</td>
					<td>".getName($row['EmployeeNumber'])."</td>
					<td>".getTaxStatus($row['EmployeeNumber'])."</td>
					<td>".$row['PayPeriodRate']."</td>
					<td>".$row['NetPay']."</td>
					<td>".$row['Remarks']."</td>
					<td>".$row['Status']."</td>
					<td><input type='hidden' id='empnum' 
					name='empnum' value='".$row['EmployeeNumber']."'/>
					<td><input type='hidden' id='startDate' 
					name='startDate' value='".$startDate."'/>
					<td><input type='hidden' id='endDate' 
					name='endDate' value='".$endDate."'/>
					<input type='submit' id='edit' name='edit' value='Edit'/></td>
					</form></tr>";
	}
	
	$response = $response."</table>";
	return $response;
}//show initial payroll for said payperiod

$connect = connectdb();//open database connection

$payperiod = $_POST['payperiod'];

$cutoff = returnCutoff($payperiod);
$startDate = $cutoff['start_date'];
$endDate = $cutoff['end_date'];
	
$response = showPayroll($startDate,$endDate);

if(finalized($payperiod))
	$response = "<h4>This Pay Period 
				is already finalized.</h4>".$response;

closeconnection($connect);//close database connection

echo $response;

?>