<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title> REDBANA PAYROLL SYSTEM </title>
</head>

<body>
<br /><br /><br />	
<div id="drdw">
<div> Welcome accounting officer! :)
<?php 
	echo "<a class='active' href='login/logout' id='cname' alignment='left' > Sign out </a>";				
?>	
			
	<ul>    	
    	<li><a href="#" class="underline"> Edit payroll </a></li>
		<li><a href="#" class="underline"> View payroll </a></li>
		<li><a href="sss/getall" class="underline"> Edit SSS table </a></li>
		<li><a href="#" class="underline"> Edit PhilHealth table </a></li>
		<li><a href="witholdingtaxcontroller" class="underline"> Edit Payment modes </a></li>
    </ul>
</div>
</div>
<br /><br />
</body>
</html>