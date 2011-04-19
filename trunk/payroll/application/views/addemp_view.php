<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>PCC Dairy Corner</title>
<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url()."css/product.css"?>' />

<script type="text/javascript">
	
	function forForm(){
		
		document.getElementById("rm").disabled=true;
		document.getElementById("magic").textContent= "Kg";
		
	}
	
	function activate(){
		
		document.getElementById("rm").disabled=false;
		document.getElementById("magic").textContent= "mL";
		
	}
	
	function deactivate(){
		
		document.getElementById("rm").disabled=true;
		document.getElementById("magic").textContent= "Kg";
		
	}
</script>
</head>

<body onLoad="forForm();">
<br/><br/>
<div id="page">
	<div id="header"></div>
	
	<div id="mainarea">
	<div id="sidebar">
		<div id="headerleft">
			<h1 ><a href="#" id="cname">PCC Dairy Corner</a></h1>
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
		
	
	<div id="contentarea">
		
		
		<div id="leftcontent" style="border:10px;text-align:left;line-height:35px;margin-left:80px;">
		<br><h1>ADD PRODUCT</h1>
			<?php 
				echo form_open('addprod');

				
			?>
		<br/>
		
			
		<div>	Product ID:<input style="margin-left:28px;" type="text" name="id" maxlength="4" size="4" value="<?php set_value(NULL); ?>">	</div>
			<div>Product Name:
				<input type="text" name="name" value="<?php set_value(NULL); ?>"></div>
			<div>Classification:
				<input  type="radio" id="class" onclick="activate()"  name="class" value="milk" /> milk &nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="class" onclick="deactivate()" checked="true" name="class" value="meat" /> meat</div>
			<div>Volume:
				<input style="margin-left:40px;"type="text" name="qty" maxlength="4" size="4" value="<?php set_value(NULL); ?>"><span id="magic"></span></div>
			<div style="line-height:2px;">Raw Milk/Unit:
				<input style="margin-left:3px;"type="text" id="rm" name="rm_amt" maxlength="4" size="4" value="<?php set_value(NULL); ?>">mL&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:green;font-size:10px;">(NOTE: only for MILK products)</span></div>
			<div>Unit Price:
				<input type="text"style="margin-left:25px;" name="price" maxlength="6" size="6"value="<?php set_value(NULL); ?>">Php</div>
			<div>Remark:
				<select name="remarks" style="margin-left:36px;">
					<option value="" selected="selected">normal</option>
					<option value="discounted">discounted</option>
					<option value="buyonetakeone" >buy one take one</option>
					
				</select>
			</div>
			<?php
				date_default_timezone_set('Asia/Brunei');
				$today = getdate();
				//print_r($today); 
				//echo $today[yday];
				$timestamp = null;
   $timestamp = time(); 

    $dateParts = array(
        
        'mday'    => 'j',
        'month'   => 'F',
        'year'    => 'Y',
    );
	$value2="";
	$value3="hello2";
    while (list(, $value) = each($dateParts)) {
        $value = gmdate($value, $timestamp);
        if (is_numeric($value)) { $value = (int)$value; }
	$value2 = $value2." ".$value;	
    }
	

					
			?>
			
			<?php	echo// "<input type=\"hidden\"  value=\"set_value('date', 2011-02-16 12:12:12)\" name =\"date\"/>";
			"<input type=\"hidden\"  value=\"$value2\" name =\"date\"/>";?>
				<?php echo validation_errors()?>
				
			<br/>
			<!--BUTTON SUBMIT-->
			<input type="submit" value="New Product"><br><br>
			</form>
		</div>	
<div id="subs">Subpages:  <a href="productlist"><< back to list </a><br/><a href="form">delete >></a><a href="edit">edit >></a> </div>		
	</div>
	
	
	
	<div id="footer">
		<a href="http://www.templatesold.com/" target="_blank">Website Templates</a> by <a href="http://www.free-css-templates.com/" target="_blank">Free CSS Templates</a>	</div>

</div>

</body>

</html>