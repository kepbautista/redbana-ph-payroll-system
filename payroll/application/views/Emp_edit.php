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
<?php  
if(isset($query)){
foreach($query as $row){
	$empnum = $row->empnum;//EMPLOYEE NUMBER
	$fname = $row->fname;//FIRST NAME
	$mname = $row->mname;//MIDDLE NAME
	$sname = $row->sname;//LAST NAME
	$title1 = $row->title;//title
	$mrate= $row->mrate;//MONTHLY RATE
	$position= $row->position;//POSITION
	$dept= $row->dept;//DEPARTMENT
	$gender= $row->gender;//GENDER
	$emp_status1= $row->emp_status;
	$cstatus= $row->civil_status;
	$user=$row->user_right;
	$sss= $row->sssno;//
	$phil= $row->philno;//STATUS
	$tin= $row->tinno;//
	$mphone= $row->mphone;//
	$hphone= $row->hphone;//
	$email= $row->email;//
	$address= $row->address;//
	$emp_type1= $row->emp_type;//
	$zip= $row->zipcode;//
	$tax= $row->tax_status;//
	$bank= $row->bank;//
	$baccount= $row->baccount;//
	$pagibig= $row->pagibig;//STATUS
	$pmode1= $row->payment_mode;//PAYMENT MODE
	$password= $row->password;//PASSWORD
	$sdate = preg_split("/[\s-]+/", $row->sdate);//STARTING DATE
	$bdate = preg_split("/[\s-]+/", $row->bdate);//BIRTH DATE
	}
}
?>
<form name="FRM"  method="post"  accept-charset="utf-8" action="<?php echo site_url(); ?>/employee/edit">
<?php  include  ("links.php");?>
<table  border="0" cellspacing="2">
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Title:</th>
    <td>
	<?php echo form_hidden('empnum', $empnum);?>
	<?php echo form_dropdown('title', $title,$title1);?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>First Name:</th>
    <td><input type="text" name="fname" id="fname" class="textfield" size="25" value="<?php echo $fname;?>"/>&nbsp<span class="warning" name="fstname" id="fstname"></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Middle Name:</th>
    <td><input type="text" name="mname" id="mname" class="textfield" size="25" value="<?php echo $mname;?>"/>&nbsp<span class="warning" name="midname" id="midname"></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Last Name:</th>
    <td><input type="text" name="sname" id="sname" class="textfield" size="25" value="<?php echo $sname;?>"/>&nbsp<span class="warning" name="lname" id="lname"></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>User Right</th>
    <td>
		<?php echo form_dropdown('user_right', $user_right,$user);?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Civil Status:</th>
    <td>
		<?php echo form_dropdown('cstatus', $civil_status,$cstatus);?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>User Right</th>
    <td>
		<?php echo form_dropdown('user_right', $user_right,$user);?>
	</td>
  </tr>
   <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Employee Status:</th>
    <td>
		<?php echo form_dropdown('emp_status', $emp_status,$emp_status1);?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Payment Mode:</th>
    <td>
	<?php echo form_dropdown('pmode', $pmode,$pmode1);?>
	</td>
  </tr>
   <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Department:</th>
    <td>
		<?php echo form_dropdown('dept', $dept_options,$dept);?>
	</td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Position:</th>
    <td>
	<?php echo form_dropdown('position', $pos_options,$position);?>
    </td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Employee Type:</th>
    <td>
	<?php echo form_dropdown('emp_type', $type_options,$emp_type1);?>
    </td>
  </tr>
  <tr>
			<th align="left">Birthday:</th>
			<td align="left">
			<?php
			if(!isset($bdate)){
				$bdate[1] = $bmonth;
				$bdate[2] = $bday;
				$bdate[0] = $byear;
			}
			
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
			<th align="left">Date Employed:</th>
			<td align="left">
			<?php
			if(!isset($sdate)){
				$sdate[1] = $smonth;
				$sdate[2] = $sday;
				$sdate[0] = $syear;
			}
			
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
			<th align="right"><font color = "red" size=+2 >*</font>Tax Status</th>
			<td><?php echo form_dropdown('tax_status', $tax_options);?></td>
		</tr>
		<tr>
			<th align="left">Gender:</th>
			<td>
				<table border="0" cellpadding="0" cellspacing="0">
				<?php 
				if(!(isset($gender))) $gender = set_value('gender');
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
					<label>  <input type="radio" name="gender" id="gender" checked="checked" value="M" id="gender"  />Male</label>
					</td>
				</tr>
				<tr>
					<td>
						<label><input type="radio" name="gender" value="F" id="gender" />Female</label>
					</td>
				</tr><?php } ?>
				</table>
			</td>
		</tr>
  <tr>
    <th align="right">Home Phone: </th>
   <td><input type="text" name="hphone" id="hphone" class="textfield" size="10" value="<?php echo $hphone;?>"&nbsp<span class='warning' name='telno' id='telno'></span></td>
  </tr>
  <tr>
    <th align="right">Mobile Number:</th>
   <td><input type="text" name="mphone" id="mphone" class="textfield" size="11" value="<?php echo $mphone;?>"&nbsp<span class='warning' name='mobileNo' id='mobileNo'></span></td>
  </tr>
  <tr>
    <th align="right">Email Address:</th>
   <td><input type="text" name="email" id="email" class="textfield" size="25" value="<?php echo $email;?>"&nbsp<span class='warning' name='eMail' id='eMail'></span></td>
  </tr>
  <tr>
    <th align="right">Present Address:</th>
   <td><input type="text" name="address" id="address" class="textfield" size="50" value="<?php echo $address;?>"/>&nbsp<span class='warning' name='pAdd' id='pAdd'></span></td>
  </tr>
  <tr>
    <th align="right">Zip Code:</th>
   <td><input type="text" name="zip" id="zip" class="textfield" size="5" value="<?php echo $zip;?>"/>&nbsp<span class='warning' name='zpcode' id='zpcode'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>SSS Number:</th>
   <td><input type="text" name="sss" id="sss" class="textfield" size="20" value="<?php echo $sss;?>"/>&nbsp<span class='warning' name='sssNo' id='sssNo'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Tin Number:</th>
   <td><input type="text" name="tin" id="tin" class="textfield" size="20" value="<?php echo $tin;?>"/>&nbsp<span class='warning' name='tinNo' id='tinNo'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Pag-ibig Number:</th>
   <td><input type="text" name="pagibig" id="pagibig" class="textfield" size="20" value="<?php echo $pagibig;?>"/>&nbsp<span class='warning' name='pgNo' id='pgNo'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>PhilHealth Number:</th>
   <td><input type="text" name="phil" id="phil" class="textfield" size="20" value="<?php echo $phil;?>"/>&nbsp<span class='warning' name='phNo' id='phNo'></span></td>
  </tr>
  <tr>
    <th align="right"><font color = "red" size=+2 >*</font>Monthly Rate:PHP </th>
   <td><input type="text" name="mrate" id="mrate" class="textfield" size="10" value="<?php echo $mrate; ?>"/>&nbsp<span class="warning" name="monthly" id="monthly"></span></td>
  </tr>
  <tr>
   <th width="100" align="right"><font color = "red" size=+2 >*</font>Password:</th>
		<td align="right">
		<input type="text" name="password" id="password" value="<?php echo $password;?>"/>
		<input type="button" id="pwd" value="Generate"/>
		&nbsp
		<span class="warning" name='pword' id='pword'></span>
		</td>
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
    <td><input type="submit" name="Submit" id="Submit" value="Update!" />
    </td><td>  <input type="reset" value="Reset" /></td>
  </tr>
  
</table>
<div>
<?php if(!isset($query)) echo validation_errors(); ?>
</div>
</form>

</body>
</html>