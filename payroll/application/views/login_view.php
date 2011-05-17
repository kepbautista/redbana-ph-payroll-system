<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Login - REDBANA PAYROLL SYSTEM</title>
<link href="<?php echo base_url(); ?>assets/css/mainstyling.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="header" class="center">
	<img src="<?php echo base_url(); ?>assets/images/payroll.png" height="78" width="1000"  alt="banner image"/>
</div>
<div id="header2" class="center">
	<ul class="nav">
		<li class="nav"><a href="<?php echo base_url(); ?>">Home</a></li>
	</ul></div>
<div id="container" class="center">
<div style="width: 70%; float:left; overflow:auto">

</div >
<div id="drdw">
<div style="width: 30%; overflow:auto">

				<!-- <form name="login" action="succe.php" method ="post" onsubmit="return validate(this)"> -->
				<?php echo form_open('login/view_form'); ?>
				<br/>
				<br/>
				<table>
					<tr>
						<td style="height: 26px">Employee Number:</td>
						<td style="height: 26px"><input type="text" name="empnum" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" value="Log-in" onclick="validate(this)" /></td>
					</tr>
				</table>
						      	
		      	<?php 		      		
		    		if( isset($incorrect_credentials) ){		    			
		    			echo '<div id="form_error_notice" style="width: 80%" class="center"><br/>';
		    			echo 'You have entered an incorrect username or password.<br/><br/>Please try again.';
		    			echo '</div>';
		    		}    
		    		if( strlen(validation_errors()) > 0 )
		    		{
		    			echo '<div id="form_error_notice" style="width: 80%" class="center"><br/>';
		    			echo validation_errors();
		    			echo '</div>';

		    		}
		    		if( isset($relayThisError) )
		    		{
		    			echo '<div id="form_error_notice" style="width: 80%" class="center"><br/>';
		    			echo "{$relayThisError["ERROR_CODE"]}: {$relayThisError["ERROR_MESSAGE"]}";
		    			echo '</div>';
		    		}		
		    	?>
		    	
				<br/>		    	
		      	<?php echo form_close(); ?>      	

</div>
</div>
</div>
<div id="copyright" >
<p>Copyright 2011 | Bautista and Associates Information Systems</p>
</div>
</body>

</html>
