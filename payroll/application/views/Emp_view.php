<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<title>Add Employee</title>
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
	<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/requiered/jquery.js" ></script>
	<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/jqtransformplugin/jquery.jqtransform.js" ></script>
	<script>
	function randomPassword()
	{
	  chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	  pass = "";
	  for(x=0;x<10;x++)
	  {
	    i = Math.floor(Math.random() * 62);
	    pass += chars.charAt(i);
	  }
	  return pass;
	}
	function formSubmit()
	{
	  FRM.password.value = randomPassword(10);
	  return false;
	}
	</script>
	<script language="javascript">
		$(function(){
			$('form').jqTransform({imgPath:'<?php echo base_url();?>/jqtransform/jqtransformplugin/img/'});
		});
	</script>	
</head>
<body>

<form name="FRM" class="jNice" method="post"  accept-charset="utf-8" action="<?php echo site_url(); ?>/employee/InsertDb" >
<?php  include  ("links.php");?>
<table  border="0" cellspacing="2">
  <tr>
    <th width="100" align="left">Employee Number:</th>
    <td><input name="empnum" type="text" id="textfield" size="25" /></td>
  </tr>
  <tr>
    <th align="left">First Name:</th>
    <td><input type="text" name="fname" id="textfield" size="25" /></td>
  </tr>
  <tr>
    <th align="left">Middle Name:</th>
    <td><input type="text" name="mname" id="textfield" size="25" /></td>
  </tr>
  <tr>
    <th align="left">Last Name:</th>
    <td><input type="text" name="sname" id="textfield" size="25" /></td>
  </tr>
  <tr>
    <th align="left">Monthly Rate:PHP </th>
   <td><input type="text" name="mrate" id="textfield" size="10" /></td>
  </tr>
  <tr>
    <th align="left">Payment Mode:</th>
    <td>
	<?php
		echo form_dropdown('payment_mode', $pmode_options);?>
	</td>
  </tr>
  <tr>
    <th align="left">Department:</th>
    <td>
		<?php
		echo form_dropdown('dept', $dept_options);?>
	</td>
  </tr>
  <tr>
    <th align="left">Position:</th>
    <td>
	<?php
		echo form_dropdown('position', $pos_options);?>
    </td>
  </tr>
  <tr>
    <th align="left">Gender:</th>
    <td><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><label>
          <input type="radio" name="gender" checked="checked" value="M" id="radio_0"  />
          Male</label></td>
      </tr>
      <tr>
        <td><label>
          <input type="radio" name="gender" value="F" id="radio_1" />
          Female</label></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <th align="left">Birthday:</th>
	<td align="left">
	<?php
		echo form_dropdown('bmonth', $months);?>
		<select name="bday" id="select">
		<?php
		foreach ($days as $value) { 
		echo '<option value="'.$value.'">'.$value.'</option>\n'; 
		}
		?></select>
		<select name="byear" id="select">
		<?php
		foreach ($years as $value) { 
		echo '<option value="'.$value.'">'.$value.'</option>\n'; 
		}
		?></select>
    </td>
  </tr>
  <tr>
    <th align="left">Start Date:</th>
	<td align="left">
	<?php
	echo form_dropdown('smonth', $months);?>
	<select name="sday" id="select">
	<?php
		foreach ($days as $value) { 
		echo '<option value="'.$value.'">'.$value.'</option>\n'; 
		}
		?></select>
		<select name="syear" id="select">
		<?php
		foreach ($years as $value) { 
		echo '<option value="'.$value.'">'.$value.'</option>\n'; 
		}
		?></select>
    </td>
  </tr>
   <tr>
   <th width="100" align="left">Status:</th>
		<td align="left"><?php 
		echo form_dropdown('status', $options);?>
		</td>
  </tr>
  <tr>
   <th width="100" align="left">Password:</th>
		<td align="left">
		<input type="text" name="password" />
		 <input type="button" id="pwd" value="Generate"  /></td>
		<td>
		</td>
		 <script type="text/javascript">
                $(document).ready(function() {
                        $(":button#pwd").click(function() {
                                formSubmit();
                        });
                });
        </script>
  </tr>   
  <tr>
    <td><input type="submit" name="Submit" id="Submit" value="Add Employee!" />
    </td><td>  <input type="reset" value="Reset" /></td>
  </tr>
  
</table>
</form>
</body>
</html>