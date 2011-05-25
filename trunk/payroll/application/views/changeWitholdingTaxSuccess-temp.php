<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title> Edit Successful - Redbana Phils. Payroll </title>
</head>

<body>
<h3> Your form was successfully submitted! </h3>
<p><?php echo anchor('form', 'Try it again!'); ?></p>
<?php 
	echo "<a class='active' href='login/logout' id='cname' alignment='left' > Sign out </a>";				
?>
</body>
</html>