<?php
/** File Name: insertPHBrackets.php
	Program Description: Count number of brackets to be added
	and return input fields that with respect to the that number.
**/

function addPHILHEALTH($N,$response){
	$response = $response.'<table><tr>
		<td rowspan="3">&nbsp&nbsp</td>
		<th rowspan="3"> Monthly <br /> Salary <br /> Bracket </th>
		<th rowspan="3" colspan="3">  Monthly Salary Range </th>
		<th rowspan="3" colspan="2"> Salary Base <br /> (SB) </th>
		<th rowspan="3" colspan="2"> Total Monthly <br /> Contributions </th>
		<th rowspan="3" colspan="2"> Employee Share <br /> (EeS) <br /> (EeS = 0.5 x TMC) </th>
		<th rowspan="3" colspan="2"> Employer Share <br /> (ErS) <br /> (ErS = 0.5 x TMC) </th>
	</tr>';
	
	for($i=0;$i<$N;$i++){
		$response = $response."
		<tr>
			<td>".($i+1)."</td>
		    <td><input type='text' name='bracket[]' id='bracket[]' size='3' class='numeric'/></td>
			<td><input type='text' name='rangel[]' id='rangel[]' size='3' class='numeric'/></td>
		    <td><input type='text' name='rangeh[]' id='rangeh[]' size='3' class='numeric'/></td>
		    <td><input type='text' name='base[]' id='base[]' size='3' class='numeric'/></td>
		    <td><input type='text' name='total[]' id='total[]' size='3' class='numeric'/></td>
			<td><input type='text' name='pes[]' id='pes[]' size='3' class='numeric'/></td>
			<td><input type='text' name='per[]' id='per[]' size='3' class='numeric'/></td>
		</tr>";
	}
	
	$response = $response."</table><input type='submit' name='addBrackets' id='addBrackets' value='Add Brackets'>";
	return $response;
}	// function for output of PhilHealth Bracket fields

$N = $_POST['N'];	// get post information
$tType = $_POST['tableType'];
$response = "";	// initialize $response variable

if(!is_numeric($N))	// evaluate if input is a number
	$response = "<h3>Input is not a number.</h3>";
if($N<=0)
	$response = "<h3>Input number should be greater than zero.</h3>";

if($response == ""){
	switch($tType){
		case 'philhealth': $response = addPHILHEALTH($N,$response);
					break;
	}
}

echo $response;	// return response
?>