<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<title>Edit Employee</title>
	<?php include 'validators.php'?>
	<?php include 'display.php'?>	
</head>
<body>
<?php  include  ("links.php");?>

<form name="FRM" method="post"  accept-charset="utf-8" action="<?php echo site_url(); ?>/employee/edit">
	<table  border="0" cellspacing="2">
		<tr>
			<th width="100" align="left">Employee Number:</th>
			<td>
				<input name="hidden" type="hidden" name="empnum" id="empnum" value="<?php echo set_value('empnum');?>"/>
			</td>
		</tr>
		<tr>
			<th align="left">First Name:</th>
			<td><input type="text" name="fname" id="fname" class="textfield" size="25" value="<?php if(isset($fname)) echo $fname; else echo set_value('fname'); ?>"/>&nbsp<span class="warning" name="fstname" id="fstname"></td>
		</tr>
		<tr>
			<th align="left">Middle Name:</th>
			<td><input type="text" name="mname" id="mname" class="textfield" size="25" value="<?php if(isset($mname)) echo $mname; else echo set_value('mname'); ?>"/>&nbsp<span class="warning" name="midname" id="midname"></span></td>
			<tr>
			<th align="left">Last Name:</th>
			<td><input type="text" name="sname" id="sname" class="textfield" size="25" value="<?php if(isset($sname)) echo $sname; else echo set_value('sname'); ?>"/>&nbsp<span class="warning" name="lname" id="lname"></span></td>
		</tr>
		<tr>
			<th align="left">Monthly Rate:PHP </th>
			<td><input type="text" name="mrate" id="mrate" class="textfield" size="10" value="<?php if(isset($mrate)) echo $mrate; else echo set_value('mrate'); ?>"/>&nbsp<span class="warning" name="monthly" id="monthly"></span></td>
		</tr>
		<tr>
	    <th align="left">Payment Mode:</th>
			<td>
				<?php echo form_dropdown('payment_mode', $pmode_options,set_value('payment_mode'));?>
			</td>
		</tr>
		<tr>
			<th align="left">Department:</th>
			<td>
			<?php echo form_dropdown('dept', $dept_options,set_value('dept'));?>
			</td>
		</tr>
		<tr>
			<th align="left">Position:</th>
			<td>
				<?php echo form_dropdown('position', $pos_options,set_value('position'));?>
			</td>
		</tr>
		<tr>
			<th align="left">Gender:</th>
			<td>
				<table border="0" cellpadding="0" cellspacing="0">
				<?php $gender = set_value('gender');
				if ($gender=="F"){ ?>
				<tr>
					<td>
					<label><input type="radio" name="gender" id="gender" value="M" id="radio_0"  />Male</label>
					</td>
				</tr>
				<tr>
				<td>
				<label><input type="radio" name="gender" id="gender" checked="checked" value="F" id="radio_1"  />Female</label></td>
				</tr>
				<?php } else { ?>
				<tr>
					<td>
					<label>  <input type="radio" name="gender" id="gender" checked="checked" value="M" id="radio_0"  />Male</label>
					</td>
				</tr>
				<tr>
					<td>
						<label><input type="radio" name="gender" value="F" id="radio_1" />Female</label>
					</td>
				</tr><?php } ?>
				</table>
			</td>
		</tr>
		<tr>
			<th align="left">Birthday:</th>
			<td align="left">
			<?php
			$bdate[1] = set_value('bmonth');
			$bdate[2] = set_value('bday');
			$bdate[0] = set_value('byear');
			
			echo form_dropdown('bmonth', $months,$bdate[1]);?>
			<select name="bday" id="select">
			<?php
			foreach ($days as $value) { 
				if ($value==$bdate[2])echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
				else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
			}
			?></select>
			<select name="byear" id="select">
			<?php
			foreach ($years as $value) { 
				if ($value==$bdate[0])echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
				else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
			}
			?></select>
			</td>
		</tr>
		<tr>
			<th align="left">Start Date:</th>
			<td align="left">
			<?php
			$sdate[1] = set_value('smonth');
			$sdate[2] = set_value('sday');
			$sdate[0] = set_value('syear');
			
			echo form_dropdown('smonth', $months,$sdate[1]);?>
			<select name="sday" id="select">
			<?php
				foreach ($days as $value) { 
				if ($value==$sdate[2])echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
				else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
				}
			?></select>
			<select name="syear" id="select">
			<?php
			foreach ($years as $value)
			{
			if ($value==$sdate[0])echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
			else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
			}
			?></select>
			</td>
		</tr>
		<tr>
			<th width="100" align="left">Status:</th>
			<td align="left"><?php
				echo form_dropdown('status', $options,set_value('status'));?>
			</td>	
		</tr>
		<tr>
			<th width="100" align="left">Password:</th>
			<td align="left">
				<input type="text" name="password" id='password' value="<?php if(isset($pwd)) echo $pwd; else echo set_value('password'); ?>"/>
				<input type="button" id="pwd" value="Generate"  />
				&nbsp
		<span class="warning" name='pword' id='pword'></span>
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
			<td>
				<input type="submit" name="Submit" id="Submit" value="Update!" />
			</td>
			<td>  
				<input type="reset" value="Reset" />
			</td>
		</tr>
	</table>
<div>
<?php echo validation_errors(); ?>
</div>
</form>
</body>
</html>