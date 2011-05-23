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
	<div id="header"></div>
	
	<div id="mainarea">
	<div id="sidebar">
		<div id="headerleft">
			<h1><a href="dropdown1" id="cname">PCC Dairy Corner</a></h1>
		</div>
		<div id="menulinks">
		<?php 
			echo anchor('buy', 'Counter');
			echo anchor('productlist', 'Product List', array('class' => 'active'));
			echo anchor('rawmilk', 'RM Distribution');
			echo anchor('turnover', 'Turnover');
			echo anchor('adsreport', 'Daily Reports');
		
		?>
		</div>
	</div>
	
	
	<div id = "logout">
			
			<?php 
				echo "<a class = 'active' href = 'dropdown1/logout' id = 'cname' alignment = 'left' > Sign out </a>";
			?>	
	
	<div id="contentarea">
		<br/><br/>
		<table id="tab" id="tab" bordercolor="#9ac1c9" border="5" >
				<tr id="tr_header">
				<th id="10">Mark</th>
				<th id="40">Product Name</th>
				<th id="10">Classification</th>
				<th id="10">Quantity</th>
				<th id="10">Price</th>
				<th id="10">Date</th>
				</tr>

				<!--HELPFUL DYNAMIC TABLE (FOR LOOP NG PHP)
					MAKIKITA KAGAD PAG-UPDATE SA DATABASE
				-->
				<?php
				echo form_open('form/delete');
				$n=0;
				foreach($result->result_array() as $entry):
					
					
				
					
					if($result == NULL){echo "null";}else{ //if null display NULL pero ayaw!
					if($n%2==0){
						echo"<tr id=\"row1\" > "; 
					}else{
						echo"<tr id=\"row2\" > "; 
					}$n++;
					echo "<td class=\"10\">";
							/*
							echo"<input type=\"checkbox\"  id=\"";
							echo $entry['id'];
							echo "\" />";
							
							*/
						$cbox = array(
						    'name'        => 'cb[]',
						    'value'       =>  $entry['id'],
						    'checked'     => FALSE
						    
						    );

						echo form_checkbox($cbox);
						//echo $cbox['value'];
					echo"</td>";
					
					echo"<th id=\"40\">";
					echo $entry['name'];
					echo"</th>";
					echo "<td id=\"10\">";
					echo $entry['class'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['qty'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['price'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['date'];
					echo"</td>";
					
					
					echo "</tr>";
					}
				
				 endforeach;

			echo "</table>";
			echo "<input type=\"submit\" value=\"delete\" ";
							echo">";
			echo form_close();
			?>
			
			<div id="subs">Subpages:  <a href="productlist"><< back to list </a><br/><a href="edit">edit >></a> <a href="addprod">add >></a></div>
	</div>
	
	
	
	<div id="footer">
		<a href="http://www.templatesold.com/" target="_blank">Website Templates</a> by <a href="http://www.free-css-templates.com/" target="_blank">Free CSS Templates</a>	</div>

</div>

</body>

</html>