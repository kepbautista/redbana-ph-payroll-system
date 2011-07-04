<script type="text/javascript">
function ajaxUpdate()
{
	var divs;
	var x;
	var y;
	var isNoError = true;	
    var showAreasHere = document.getElementById('notifyErrorInner');
    var onWhere_arr;
       
	divs = document.getElementsByName('ajax_ok_indicator');
	y = divs.length;
	showAreasHere.innerHTML = "";
	
	for(x=0; x<y; x++) 
		if(divs[x].innerHTML != '<h4>OK</h4>')
		{
			divs[x].innerHTML = '<h4 style="color:red">!!!</h4>';
			onWhere_arr = divs[x].id.split('|');
			$("#notifyError").show();
			showAreasHere.innerHTML = showAreasHere.innerHTML + '<p>' + onWhere_arr[1] + "|" + onWhere_arr[0] + "</p>";
			isNoError = false;
		}	
	/*divs[x].focus();*/
	if(isNoError) $("#notifyError").hide();
	
	return isNoError;
}

function performRitual()
{
	$("#notifyError").hide();
}
</script>
<script type="text/javascript">
$(document).ready(function(){
  $("select").change(function(){  
    $("#a").val($(this).attr("name"));
    
    
    var onWhere_RAW = $(this).attr("name");
	var x = document.getElementById(onWhere_RAW+"|SPAN");
	x.innerHTML = '<h4 style="color:white">&nbsp;</h4>';
    var onWhere_arr = onWhere_RAW.split('|');
    var theInfo = $(this).val();

	
	
    $.post("<?php echo site_url('AttendanceController/updateOvertime') ?>", 
            {
              empnum: onWhere_arr[0], 
              work_date: onWhere_arr[1], 
              value: theInfo
            }, 
			function(data) {									
				if(data != "")
				{
					alert(data);
					x.innerHTML = '<h4 style="color:red">X</h4>';						
				}else{									
					x.innerHTML = "<h4>OK</h4>";	
					var thisIndicator = onWhere_RAW + '|IDN';
				}
			}             
          );

  });  
});
</script>
