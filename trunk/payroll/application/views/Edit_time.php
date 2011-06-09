<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>View Record </title>
		<!-- For DATATABLES-->
		<style type="text/css" title="currentStyle"> 
			@import "<?php echo base_url();?>/css/demo_page.css";
			@import "<?php echo base_url();?>/css/demo_table.css";
		</style> 
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>/js/jquery.js"></script> 
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8"> 
			$(document).ready(function() {
				$('#example').dataTable();
			} );
		</script> 
		<!-- For JQTRANSFORM-->
		<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
		<link href="<?php echo base_url(); ?>assets/css/mainstyling.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/jqtransformplugin/jquery.jqtransform.js" ></script>
		<script type="text/javascript" >
			$(function(){
				$(":button").jqTransform({imgPath:'<?php echo base_url();?>/jqtransform/jqtransformplugin/img/'});
			});
		</script>
</head>
<body id="dt_example">
<div id="demo">
	<h1><span class="center" ><?php echo date('M d, Y', strtotime($year_s.'-'.$month_s.'-'.$day_s));?></span></h1>
	<h1 style="text-align:right" ><a href="<?php echo base_url();?>/index.php/timesheet/viewtimesheet">View Record Today</a></h1>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
					<thead> 
						<tr> 
							<th>Employee Number</th> 
							<th>Name</th> 
							<th>Date of Time-in</th> 
							<th>Time-in</th> 
							<th>Date of Time-Out</th>
							<th>Time-out</th>
							<th>Shift Schedule</th>
							<th>Reason for Absence</th>
							<th>Restday?</th>
						</tr> 
					</thead> 
					<tbody> 
					<?php 
					$cnt=1;
					foreach ($query as $row)
					{ 
						if ($cnt%2==0)	
							$class="even";//identifies the 'td' class for css styling
						else	
							$class="odd";
						$name= $row->sname.', '.$row->fname.', '.$row->mname.'.';
						$emp=$row->empnum;	
						if($emp==$edit)
						{
						?>
						<tr id="<?php echo $emp ?>" class="<?php echo $class ?>" >
							<td><?php echo $emp; ?></td>
							<td><?php echo $name; ?></td>
							<td>
								<?php 
									echo form_open('timesheet/UpdateTime'); 
									echo date('M d, Y', strtotime($row->date_in)); 
								    
								?>							
							</td>
							<td>
								
								<select name="time_in1" id="select"><!-- Make dropdown for hour-->
								<?php
								$log = preg_split("/[\s:]+/", $row->time_in);
								foreach ($hour as $value) 
								{ 
									if ($value==$log[0]) $select=" SELECTED"; else $select="";
									if ($value<10)echo '<option value="0'.$value.'" '.$select.'>0'.$value.'</option>\n'; 
									else echo '<option value="'.$value.'" '.$select.'>'.$value.'</option>\n'; 
								}
								?>
								</select>
								<select name="time_in2" id="select"><!-- Make dropdown for minutes-->
								<?php
								foreach ($minute as $value) 
								{ 
									if ($value==$log[1]) $select="SELECTED"; else $select="";
									if ($value<10)echo '<option value="0'.$value.'" '.$select.'>0'.$value.'</option>\n'; 
									else echo '<option value="'.$value.'" '.$select.'>'.$value.'</option>\n'; 
								}
								?>
								</select>
								<select name="time_in3" id="select"><!-- Make dropdown for hour-->
								<?php
								foreach ($second as $value) 
								{ 
									if ($value==$log[2]) $select="SELECTED"; else $select="";
									if ($value<10)echo '<option value="0'.$value.'" '.$select.'>0'.$value.'</option>\n'; 
									else echo '<option value="'.$value.'" '.$select.'>'.$value.'</option>\n'; 
								}
								?>
								</select>
							</td>
							<td><?php $date=date('M-d-Y', strtotime($row->date_out));
								$date_out = preg_split("/[\s-]+/", $date);
								echo form_dropdown('date_out1', $months,date('m', strtotime($row->date_out)));?>
								<select name="date_out2" id="select">
								<?php
								foreach ($days as $value) { 
									if ($value==$date_out[1])echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
									else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
								}
								?></select>
								<select name="date_out3" id="select">
								<?php
								foreach ($years as $value) { 
									if ($value==$date_out[2])echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
									else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
								}
								?></select>
							</td>
							<td>
								<select name="time_out1" id="select"><!-- Make dropdown for hour-->
								<?php
								$log = preg_split("/[\s:]+/", $row->time_out);
								foreach ($hour as $value) 
								{ 
									if ($value==$log[0]) $select=" SELECTED"; else $select="";
									if ($value<10)echo '<option value="0'.$value.'" '.$select.'>0'.$value.'</option>\n'; 
									else echo '<option value="'.$value.'" '.$select.'>'.$value.'</option>\n'; 
								}
								?>
								</select>
								<select name="time_out2" id="select"><!-- Make dropdown for minutes-->
								<?php
								foreach ($minute as $value) 
								{ 
									if ($value==$log[1]) $select="SELECTED"; else $select="";
									if ($value<10)echo '<option value="0'.$value.'" '.$select.'>0'.$value.'</option>\n'; 
									else echo '<option value="'.$value.'" '.$select.'>'.$value.'</option>\n'; 
								}
								?>
								</select>
								<select name="time_out3" id="select"><!-- Make dropdown for hour-->
								<?php
								foreach ($second as $value) 
								{ 
									if ($value==$log[2]) $select="SELECTED"; else $select="";
									if ($value<10)echo '<option value="0'.$value.'" '.$select.'>0'.$value.'</option>\n'; 
									else echo '<option value="'.$value.'" '.$select.'>'.$value.'</option>\n'; 
								}
								?>
								</select>
							</td>
							<td><?php echo $shifts[$row->shift_id]['START_TIME']."-". $shifts[$row->shift_id]['END_TIME']; ?></td>
							<td><!--make dropdown for absence_reason -->
								<select name="ABSENCE_REASON">									
						 			<?php
						 				foreach($absence_reasons as $individ)
						 				{
						 					$paid_or_not = "";
						 					if( $individ->TO_DISPLAY_DEDUCTIBLE == '1' )
						 					{
						 						$paid_or_not = "UNPAID ";
						 						if( $individ->DEDUCTIBLE == '0' ){
						 							$paid_or_not = "PAID ";
						 						}
						 					}
						 			?>
						 				<option value="<?php echo $individ->ID; ?>" ><?php echo $paid_or_not.$individ->TITLE; ?></option>
						 			<?php
						 				}
						 			?>			 			
				 				</select>
							</td>
							<td>								
								<?php
									echo '<input type="checkbox" name="restday" ';
									if($row->restday == 1) echo 'checked="checked"';
									echo ' /> ';
								?>
								
							</td>
							<td>
								<?php
								echo form_hidden('empnum', $emp);
								echo form_hidden('date', $row->date_in);
								echo form_submit('mysubmit','Update!'); 
								echo form_close(); 
								?>
							</td>
						</tr>
					<?php
						}
						else
						{
					?>
					<tr id="<?php echo $emp ?>" class="<?php echo $class ?>" >
							<td><?php echo $emp; ?></td>
							<td><?php echo $name; ?></td>
							<td><?php echo date('M d, Y', strtotime($row->date_in)); ?></td>
							<td><?php echo $row->time_in; ?></td>
							<td><?php echo date('M d, Y', strtotime($row->date_out)); ?></td>
							<td><?php echo $row->time_out; ?></td>
							<td><?php echo $shifts[$row->shift_id]['START_TIME']."-". $shifts[$row->shift_id]['END_TIME']; ?></td>
							<td><!-- make dropdown for absence_reason -->
								<?php 
								   if($row->absence_reason == NULL){
								   		echo "NOT-FILLED-OUT";
								   	}else{								   
								   		if( $absence_reasons[$row->absence_reason]->TO_DISPLAY_DEDUCTIBLE == '1' )
								   		{
									   		if( $absence_reasons[$row->absence_reason]->DEDUCTIBLE == '1' 
										   			|| $absence_reasons[$row->absence_reason]->DEDUCTIBLE == TRUE								   			
									   		)
									   			echo "UNPAID ";
									   		else
									   			echo "PAID ";
								   		}
										echo $absence_reasons[$row->absence_reason]->TITLE; 										
									}
								?>
							</td>
							<td>
								<?php if($row->restday == 1)
										echo "YES";
									  else
									  	echo "NO";
								?>
							</td>
							<td>
							<?php
							echo form_open('timesheet/editTime'); 
							echo form_hidden('empnum', $emp);
							echo form_hidden('date', $row->date_in);
							echo form_submit('mysubmit','Edit'); 
							echo form_close(); 
							?>
							</td>
						</tr>
					<?php 
						}
					$cnt++; 
					} ?>
					</tbody>
					<tfoot> 
						<tr> 
							<th>Employee Number</th> 
							<th>Name</th> 
							<th>Date of Time-in</th> 
							<th>Time-in</th> 
							<th>Date of Time-Out</th>
							<th>Time-out</th>
							<th>Shift Schedule</th>
							<th>Reason for Absence</th>						
							<th>Restday?</th>
						</tr> 
					</tfoot>  
				</table>
			<center><!-- For Viewing Other dates-->
				<?php $yrs=range(2011,2050);
				$days=range(1,31);
				echo "<h1>View Time sheet for other date</h1>";
				echo form_open('timesheet/viewotherdate');//Once the user clicked view, it will redirect to employee/viewotherdate 
				echo form_dropdown('mos', $mos,$month_s);//make dropdown for months
				?>
				<select name="days" id="select"><!-- Make drodown for days-->
				<?php
				foreach ($days as $value) 
				{ 
					if ($value==$day_s)echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
					else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
				}
				?>
				</select>
				<select name="yrs" id="select"><!-- Make drodown for months-->
				<?php
				foreach ($yrs as $value) { 
				if ($value==$year_s)echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
				else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
				}
				?>
				</select>
				<?php echo form_submit('mysubmit','View!'); 
				echo form_close(); ?>
			</center>
</div>
</body>
</html>