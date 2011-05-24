<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Leave Approve</title>
</head>
<body>
<?php  
if(isset($query)){
foreach($query as $row){
	$empnum = $row->empnum;//EMPLOYEE NUMBER
	$fname = $row->fname;
	$mname = $row->mname;
	$sname = $row->sname;
	$position = $row->position;
	$dept = $row->dept;
	$approval= $row->approval;//
	$type= $row->type;//PAYMENT MODE
	$reason= $row->reason;//PASSWORD
	$fdate =  $row->filedate;
	$sdate = $row->startdate;
	$rdate = $row->returndate;
	}
}
?>
<form name="FRM"  method="post"  accept-charset="utf-8" action="<?php echo site_url(); ?>/leave/approve">
<table  border="0" cellspacing="2">
  <tr>
    <th align="left">Employee Number: </th>
    <td>
	<?php echo $empnum; ?>
	</td>
  </tr>
    <tr>
    <th align="left">Employee Name: </th>
    <td>
	<?php echo $fname; echo " "; echo $mname; echo " "; echo $sname; ?>
	</td>
  </tr>
     <tr>
    <th align="left">Position: </th>
    <td>
	<?php echo $position ?>
	</td>
  </tr>
 <tr>
    <th align="left">Department: </th>
    <td>
	<?php echo $dept ?>
	</td>
  </tr>
  <tr>
    <th align="left">Type of Leave: </th>
    <td>
		<?php echo $type;?>
	</td>
  </tr>
  <tr>
			<th align="left">Date filed: </th>
			<td align="left">
			<?php echo $fdate;?>
			</td>
		</tr>
		<tr>
			<th align="left">Start date of Leave: </th>
			<td align="left">
			<?php echo $sdate;?>
			</td>
		</tr>
		<tr>
			<th align="left">Return date to Work: </th>
			<td align="left">
				<?php echo $rdate;?>
			</td>
		</tr>
  <tr>
    <th align="left">Reason for leave: </th>
   <td> 	<?php echo $reason;?></td>
  </tr>
  <tr>
    <th align="left">Status: </th>
   <td>	<?php echo $approval;?></td>
  
  </tr>
  <tr>
    <td>
						<?php
						$hidden=$empnum;
						$hidden2=$fdate;
						
						echo form_open('leave/not_approved'); 
						echo form_hidden('empnum', $empnum);
						echo form_hidden('filedate', $hidden2);
						echo form_submit('sub','walalangto'); 
						echo form_close(); 
						
						echo form_open('leave/accepted'); 
						echo form_hidden('empnum', $hidden);
						echo form_hidden('filedate', $hidden2);
						echo form_submit('mysubmit','APPROVE'); 
						echo form_close(); 
							
						echo form_open('leave/not_approved'); 
						echo form_hidden('empnum', $hidden);
						echo form_hidden('filedate', $hidden2);
						echo form_submit('mysubmit','DENY'); 
						echo form_close(); 
						

											
					?>
    </td>

  </tr>
  
</table>
</form>

</body>
</html>