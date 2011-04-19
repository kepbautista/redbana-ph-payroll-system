<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>PCC Dairy Corner</title>
<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url()."css/product.css"?>' />

	<title><?=$title;?></title>
</head>

<body>
<br/><br/>
<div id="page">
	<?php 
				echo "<a class = 'active' href = 'dropdown1/logout' id = 'cname' alignment = 'left' > Sign out </a>";
				
			?>	
	<div id="contentarea">
		<br/><br/>
		<table id="tab" bordercolor="#9ac1c9" border="5" >
				<tr id="tr_header">
				<th id="10">Employee Number</th>
				<th id="40">Password</th>
				<th id="10">Type</th>
				<th id="10">Fname</th>
				<th id="10">Mname</th>
				<th id="10">Lname</th>
				</tr>

				<!--HELPFUL DYNAMIC TABLE (FOR LOOP NG PHP)
					MAKIKITA KAGAD PAG-UPDATE SA DATABASE
				-->
				<?php
				echo form_open('user');
				$n=0;
				foreach($result->result_array() as $entry):
					
					
				
					
					if($result == NULL){echo "null";}else{ //if null display NULL pero ayaw!
					if($n%2==0){
						echo"<tr id=\"row1\" > "; 
					}else{
						echo"<tr id=\"row2\" > "; 
					}$n++;
					
					echo"<th id=\"10\">";
					echo $entry['empnum'];
					echo"</th>";
					echo"<th id=\"40\">";
					echo $entry['password'];
					echo"</th>";
					echo "<td id=\"10\">";
					echo $entry['type'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['fname'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['mname'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['lname'];
					echo"</td>";
					
					
					echo "</tr>";
					}
				
				 endforeach;

			echo "</table>";
			
			echo form_close();
			?>
			
	</div>
	
	
	
	<div id="footer">
		<a href="http://www.templatesold.com/" target="_blank">Website Templates</a> by <a href="http://www.free-css-templates.com/" target="_blank">Free CSS Templates</a>	</div>

</div>

</body>

</html>