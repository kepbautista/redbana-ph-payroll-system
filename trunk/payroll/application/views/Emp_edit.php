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
<?php  include  ("links.php");

if(isset($query)){
foreach($query as $row){
	$empnum = $row->empnum;//EMPLOYEE NUMBER
	$fname = $row->fname;//FIRST NAME
	$mname = $row->mname;//MIDDLE NAME
	$sname = $row->sname;//LAST NAME
	$mrate= $row->mrate;//MONTHLY RATE
	$position= $row->position;//POSITION
	$dept= $row->dept;//DEPARTMENT
	$gender= $row->gender;//GENDER
	$status= $row->status;//STATUS
	$pmode= $row->payment_mode;//PAYMENT MODE
	$password= $row->password;//PASSWORD
	$sdate = preg_split("/[\s-]+/", $row->sdate);//STARTING DATE
	$bdate = preg_split("/[\s-]+/", $row->bdate);//BIRTH DATE
}
}
?>

<form name="FRM" method="post"  accept-charset="utf-8" action="<?php echo site_url(); ?>/employee/edit">
	<table  border="0" cellspacing="2">
		<tr>
			<th width="100" align="left">Employee Number:</th>
			<td>
				<?php echo $empnum?>
				<input type="hidden" name="empnum" id="empnum" value="<?php echo $empnum;?>" style="background-color: yellow;"/>
			</td>
		</tr>
		<tr>
			<th align="left">First Name:</th>
			<td><input type="text" name="fname" id="fname" class="textfield" size="25" value="<?php echo $fname;?>"/>&nbsp<span class="warning" name="fstname" id="fstname"></td>
		</tr>
		<tr>
			<th align="left">Middle Name:</th>
			<td><input type="text" name="mname" id="mname" class="textfield" size="25" value="<?php echo $mname;?>"/>&nbsp<span class="warning" name="midname" id="midname"></span></td>
			<tr>
			<th align="left">Last Name:</th>
			<td><input type="text" name="sname" id="sname" class="textfield" size="25" value="<?php echo $sname;?>"/>&nbsp<span class="warning" name="lname" id="lname"></span></td>
		</tr>
		<tr>
			<th align="left">Monthly Rate:PHP </th>
			<td><input type="text" name="mrate" id="mrate" class="textfield" size="10" value="<?php echo $mrate;?>"/>&nbsp<span class="warning" name="monthly" id="monthly"></span></td>
		</tr>
		<tr>
	    <th align="left">Payment Mode:</th>
			<td>
				<?php 
				if(isset($pmode)) echo form_dropdown('payment_mode', $pmode_options,$pmode);
				else echo form_dropdown('payment_mode', $pmode_options,set_value('payment_mode'));
				?>
			</td>
		</tr>
		<tr>
			<th align="left">Department:</th>
			<td>
			<?php
			if(isset($dept)) echo form_dropdown('dept', $dept_options,$dept);
			else echo form_dropdown('dept', $dept_options,set_value('dept'));
			?>
			</td>
		</tr>
		<tr>
			<th align="left">Position:</th>
			<td>
			<?php
			if(isset($position)) echo form_dropdown('position', $pos_options,$position);
			else echo form_dropdown('position', $pos_options,set_value('position'));
			?>
			</td>
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
			<th align="left">Start Date:</th>
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
			<th width="100" align="left">Status:</th>
			<td align="left">
			<select name="status" id="status">
			<?php
				for($i=1;$i<count($options);$i++){
					if ($options[$i]==$status) echo '<option value="'.$i.'" SELECTED>'.$options[$i].'</option>\n';
					echo '<option value="'.$i.'">'.$options[$i].'</option>\n';
				}
			?>
			</select>
			</td>	
		</tr>
		<tr>
			<th width="100" align="left">Password:</th>
			<td align="left">
				<input type="text" name="password" id='password' value="<?php echo $password;?>"/>
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
<?php if(!isset($query)) echo validation_errors(); ?>
</div>
</form>
</body>
</html>