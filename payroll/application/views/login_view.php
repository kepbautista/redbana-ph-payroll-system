
 
<html>
<head> 
	<title> REDBANA PAYROLL SYSTEM</title>
</head>
<body>


		<br /><br /><br />
		
		<div id="drdw">
<div>
Log in <!--  for the login -->
    	<?php echo form_open('login/view_form'); ?>
    <ul>	
		<!-- <form name="login" action="succe.php" method ="post" onsubmit="return validate(this)"> -->
      	<li>Employee Number <input type="text" name="empnum"></li>
      	<li>Password <input type="password" name="password"><br/></li>
      	<br/> <input type="submit" value="Log-in" onclick="validate(this)"><br/><br/></li>
      	
      	<?php 
    		//if(($this->session->set_flashdata('login_error'))){
    			//echo 'You entered an incorrect username or password.';
    		//}
    		
    	echo validation_errors()?>
      	<?php echo form_close();?>
      	
    </ul>

</div>


</div>
<br /><br />
 
</body>
</html>
