<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<title>File a Leave</title>
	
</head>
<body>
File a Leave
<form name="FRM" class="jNice" method="post"  accept-charset="utf-8" action="<?php echo site_url(); ?>/leave/insert">
<table  border="0" cellspacing="2">
 
  <tr>
    <th align="left">Type of Leave:</th>
    <td>
		<?php echo form_dropdown('type', $type_options);?>
	</td>
  </tr>

  <tr>
    <th align="left">Date Filed:</th>
	<td align="left">
	<?php
		echo form_dropdown('fmonth', $months);?>
		<select name="fday" id="select">
		<?php
		foreach ($days as $value) { 
		echo '<option value="'.$value.'">'.$value.'</option>\n'; 
		}
		?></select>
		<select name="fyear" id="select">
		<?php
		foreach ($years as $value) { 
		echo '<option value="'.$value.'">'.$value.'</option>\n'; 
		}
		?></select>
    </td>
  </tr>
  <tr>
    <th align="left">Start Date of Leave:</th>
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
    <th align="left">Date of Return:</th>
	<td align="left">
	<?php
	echo form_dropdown('rmonth', $months);?>
	<select name="rday" id="select">
	<?php
		foreach ($days as $value) { 
		echo '<option value="'.$value.'">'.$value.'</option>\n'; 
		}
		?></select>
		<select name="ryear" id="select">
		<?php
		foreach ($years as $value) { 
		echo '<option value="'.$value.'">'.$value.'</option>\n'; 
		}
		?></select>
    </td>
  </tr>

  <tr>
   <th width="100" align="left">Reason for leave:</th>
		<td align="left">
		<textarea name="reason" id="reason"></textarea>
		</td>
		<td>
		</td>
		 
  </tr>   
  <tr>
    <td><input type="submit" name="Submit" id="Submit" value="File a Leave!" />
    </td><td>  <input type="reset" value="Reset" /></td>
  </tr>
  
</table>
<div>
</div>
</form>
</body>
</html>