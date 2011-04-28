<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>whatever</title>
	<title><?=$title;?></title>
</head>

<body>
<br/><br/>
<div id="page">
	<?php 
				echo "<a class = 'active' href = 'login/logout' id = 'cname' alignment = 'left' > Sign out </a>";
				
			?>	
	<div id="contentarea">
		<br/><br/>
		<table id="tab" bordercolor="#9ac1c9" border="5" >
				<tr id="tr_header">
				<th id="10">bracket</th>
				<th id="40">rangel</th>
				<th id="10">rangeh</th>
				<th id="10">base</th>
				<th id="10">total</th>
				<th id="10">pes</th>
				<th id="10">per</th>
				</tr>

				<!--HELPFUL DYNAMIC TABLE (FOR LOOP NG PHP)
					MAKIKITA KAGAD PAG-UPDATE SA DATABASE
				-->
				<?php
				echo form_open('philhealth');
				$n=0;
				foreach($result->result_array() as $entry):
					
					
				
					
					if($result == NULL){echo "null";}else{ //if null display NULL pero ayaw!
					if($n%2==0){
						echo"<tr id=\"row1\" > "; 
					}else{
						echo"<tr id=\"row2\" > "; 
					}$n++;
					
					echo"<th id=\"10\">";
					echo $entry['bracket'];
					echo"</th>";
					echo"<th id=\"40\">";
					echo $entry['rangel'];
					echo"</th>";
					echo "<td id=\"10\">";
					echo $entry['rangeh'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['base'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['total'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['pes'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['per'];
					echo"</td>";
					
					
					echo "</tr>";
					}
				
				 endforeach;

			echo "</table>";
			
			echo form_close();
			?>
			
	</div>
	
	
	
	<div id="footer">
	

</div>

</body>

</html>