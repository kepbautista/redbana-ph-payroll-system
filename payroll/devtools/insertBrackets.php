<?php
/** File Name: insertBrackets.php
	Program Description: Count number of brackets to be added
	and return input fields that with respect to the that number.
**/

function addSSS($N,$response){
	$response = $response.'<table><tr>
		<td rowspan="3">&nbsp&nbsp</td>
		<th colspan="2" rowspan="2"> Range <br /> of <br /> Compensation </th>
		<th rowspan="3"> Monthly <br /> Salary <br /> Credit </th>
		<th colspan="7"> EMPLOYER-EMPLOYEE </th>
		<th> SE/VM/OFW </th>
		<tr>
		<th colspan="3"> SOCIAL SECURITY </th>
		<th> EC </th>
		<th colspan="3"> TOTAL CONTRIBUTION </th>
		<th rowspan="2"> TOTAL <br /> CONTRIBUTION </th>
		</tr>
		<tr><th>Lower Range</th><th>Upper Range</th><th> ER </th><th> EE </th>
		<th> Total </th><th> EC </th><th> ER </th><th> EE </th>
		<th> Total </th></tr></tr>';
	
	for($i=0;$i<$N;$i++){
		$response = $response."<tr><td>".($i+1)."</td>
		            <td><input type='text' name='rangel[]' id='rangel[]' size='3' class='numeric'/></td>
		            <td><input type='text' name='rangeh[]' id='rangeh[]' size='3' class='numeric'/></td>
		            <td><input type='text' name='msc[]' id='msc[]' size='3' class='numeric'/></td>
		            <td><input type='text' name='ser[]' id='ser[]' size='3' class='numeric'/></td>
		            <td><input type='text' name='see[]' id='see[]' size='3' class='numeric'/></td>
					<td><input type='text' name='stotal[]' id='stotal[]' size='3' class='numeric'/></td>
					<td><input type='text' name='ecer[]' id='ecer[]' size='3' class='numeric'/></td>
					<td><input type='text' name='ter[]' id='ter[]' size='3' class='numeric'/></td>
					<td><input type='text' name='tee[]' id='tee[]' size='3' class='numeric'/></td>
					<td><input type='text' name='ttotal[]' id='ttotal[]' size='3' class='numeric'/></td>
					<td><input type='text' name='totalcont[]' id='totalcont[]' size='3' class='numeric'/></td>
					</tr>";
	}
	
	$response = $response."</table><input type='submit' name='addBrackets' id='addBrackets' value='Add Brackets'>";
	return $response;
}	// function for output of SSS Bracket fields

$N = $_POST['N'];	// get post information
$tType = $_POST['tableType'];
$response = "";	// initialize $response variable

if(!is_numeric($N))	// evaluate if input is a number
	$response = "<h3>Input is not a number.</h3>";
if($N<=0)
	$response = "<h3>Input number should be greater than zero.</h3>";

if($response == ""){
	switch($tType){
		case 'sss': $response = addSSS($N,$response);
					break;
	}
}
echo $response;	// return response
?>