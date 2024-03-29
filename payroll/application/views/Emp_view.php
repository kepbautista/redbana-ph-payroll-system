<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<title>Add Employee</title>
	<?php
	include 'validators.php';
	include 'styles.php';
	?>
</head>
<body>

<form name="FRM"  method="post"  accept-charset="utf-8" action="<?php echo site_url(); ?>/employee/insert">
<?php  include  ("links.php");?>
<table  border="0" cellspacing="2">
  <tr>
    <th width="100" align="right"><font color = "red" size=+2 >*</font>Employee Number:</th>
    <td><input name="empnum" id="empnum" type="text" class="textfield" size="25" value="<?php echo set_value('empnum'); ?>"/>&nbsp<span class="warning" name="enum" id="enum"><span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Title:</th>
    <td>
	<?php echo form_dropdown('title', $title);?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>First Name:</th>
    <td><input type="text" name="fname" id="fname" class="textfield" size="25" value="<?php echo set_value('fname'); ?>"/>&nbsp<span class="warning" name="fstname" id="fstname"></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Middle Name:</th>
    <td><input type="text" name="mname" id="mname" class="textfield" size="25" value="<?php echo set_value('mname'); ?>"/>&nbsp<span class="warning" name="midname" id="midname"></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Last Name:</th>
    <td><input type="text" name="sname" id="sname" class="textfield" size="25" value="<?php echo set_value('sname'); ?>"/>&nbsp<span class="warning" name="lname" id="lname"></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>User Right</th>
    <td>
		<?php echo form_dropdown('user_right', $user_right,'Employee');?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Civil Status:</th>
    <td>
		<?php echo form_dropdown('cstatus', $civil_status);?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Shift Hours:</th>
    <td>
		<?php echo form_dropdown('shift_id', $shift_id);?>
	</td>
  </tr>
   <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Employee Status:</th>
    <td>
		<?php echo form_dropdown('emp_status', $emp_status);?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Payment Mode:</th>
    <td>
	<?php echo form_dropdown('pmode', $pmode);?>
	</td>
  </tr>
   <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Department:</th>
    <td>
		<?php echo form_dropdown('dept', $dept_options);?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Position:</th>
    <td>
	<?php echo form_dropdown('position', $pos_options);?>
    </td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Employee Type:</th>
    <td>
	<?php echo form_dropdown('emp_type', $type_options);?>
    </td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Date Of Birth:</th>
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
    <th align="right"><font color = "red" size=+2 >*</font>Date Employed:</th>
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
    <th align="right"><font color = "red" size=+2 >*</font>Tax Status</th>
    <td>
	<?php echo form_dropdown('tax_status', $tax_options);?>
    </td>
  </tr>
  <tr>
    <th align="right">Gender:</th>
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
    <th align="right">Home Phone: </th>
   <td><input type="text" name="hphone" id="hphone" class="textfield" size="10" value="<?php echo set_value('hphone'); ?>"/>&nbsp<span class='warning' name='telno' id='telno'></span></td>
  </tr>
  <tr>
    <th align="right">Mobile Number:</th>
   <td><input type="text" name="mphone" id="mphone" class="textfield" size="11" value="<?php echo set_value('mphone'); ?>"/>&nbsp<span class='warning' name='mobileNo' id='mobileNo'></span></td>
  </tr>
  <tr>
    <th align="right">Email Address:</th>
   <td><input type="text" name="email" id="email" class="textfield" size="25" value="<?php echo set_value('email'); ?>"/>&nbsp<span class='warning' name='eMail' id='eMail'></span></td>
  </tr>
  <tr>
    <th align="right">Present Address:</th>
   <td><input type="text" name="address" id="address" class="textfield" size="50" value="<?php echo set_value('address'); ?>"/>&nbsp<span class='warning' name='pAdd' id='pAdd'></span></td>
  </tr>
  <tr>
    <th align="right">Zip Code:</th>
   <td><input type="text" name="zip" id="zip" class="textfield" size="5" value="<?php echo set_value('zip'); ?>"/>&nbsp<span class='warning' name='zpcode' id='zpcode'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>SSS Number:</th>
   <td><input type="text" name="sss" id="sss" class="textfield" size="20" value="<?php echo set_value('sss'); ?>"/>&nbsp<span class='warning' name='sssNo' id='sssNo'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Tin Number:</th>
   <td><input type="text" name="tin" id="tin" class="textfield" size="20" value="<?php echo set_value('tin');?>"/>&nbsp<span class='warning' name='tinNo' id='tinNo'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Pag-ibig Number:</th>
   <td><input type="text" name="pagibig" id="pagibig" class="textfield" size="20" value="<?php echo set_value('pagibig');?>"/>&nbsp<span class='warning' name='pgNo' id='pgNo'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>PhilHealth Number:</th>
   <td><input type="text" name="phil" id="phil" class="textfield" size="20" value="<?php echo set_value('phil');?>"/>&nbsp<span class='warning' name='phNo' id='phNo'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Monthly Rate:PHP </th>
   <td><input type="text" name="mrate" id="mrate" class="textfield" size="10" value="<?php echo set_value('mrate'); ?>"/>&nbsp<span class="warning" name="monthly" id="monthly"></span></td>
  </tr>
  <tr>
   <th width="100" align="right"><font color = "red" size=+2 >*</font>Password:</th>
		<td align="right">
		<input type="text" name="password" id="password"/>
		<input type="button" id="pwd" value="Generate"/>
		 <script type="text/javascript">
                $(document).ready(function() {
                        $(":button#pwd").click(function() {
                                formSubmit();
                        });
                });
        </script>
		<span class="warning" name='pword' id='pword'></span>
		</td>
  </tr>   
  <tr>
    <td><input type="submit" name="Submit" id="Submit" value="Add Employee" />
    </td><td>  <input type="reset" value="Reset" /></td>
  </tr>
  
</table>
<div>
<?php echo validation_errors(); ?>
</div>
</form>
</body>
</html>