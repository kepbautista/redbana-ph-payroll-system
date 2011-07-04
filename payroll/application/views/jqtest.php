<html>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" ></script>
<script type="text/javascript">
$(document).ready(function(){
  $("select").change(function(){
    $("#a").css("background-color","#AAAFFF");
    $("#a").val($(this).attr("name"));
   
    var onWhere_RAW = $(this).attr("name");
    var onWhere_arr = onWhere_RAW.split('|');
    var theInfo = $(this).val();
		
    alert(" onWHere " + onWhere_arr[0] + " theInfo " + onWhere_arr[1]);
    
    $.post("<?php echo site_url('AttendanceController/updateOvertime') ?>", 
            {
              empnum: onWhere_arr[0], 
              work_date: onWhere_arr[1], 
              value: theInfo
            }, 
			function(data) {		
				var x = document.getElementById(onWhere_RAW+"|SPAN");
				if(data != "")
				{
					x.innerHTML = '<h5 style="color:red">X</h5>';
				}else{									
					x.innerHTML = "<h5>OK</h5>";					
				}
			}             
          );

  });  
});
</script>
</head>
<body>
<p>Enter your name: <input type="text" id="a" /></p>
<select name="2008-13917|2011-06-16">
<option value="2" >OVERTIME w/ ND, M-F</option>
<option value="5" >OVERTIME w/ ND, SP HOL(M-F)
</option><option value="14" >OVERTIME w/ ND. 10-6, LEG HOL or REG HOL</option></select>
<select name="2008-13916|2011-06-16">
<option value="2" >OVERTIME w/ ND, M-F</option>
<option value="5" >OVERTIME w/ ND, SP HOL(M-F)
</option><option value="14" >OVERTIME w/ ND. 10-6, LEG HOL or REG HOL</option></select>


<!------ gaga --->





</body>
</html>