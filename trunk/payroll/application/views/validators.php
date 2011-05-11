<script type="text/javascript" src="<?php echo base_url();?>devtools/jquery-1.5.2"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#empnum').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#empnum').val(),
			 vtype: "enum",
          },
          function(data){
                $("#enum").text(data);
          }
		  );
		});
		$('#fname').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#fname').val(),
			 vtype: "firstname",
          },
          function(data){
                $("#fstname").text(data);
          }
		  );
		});
		$('#mname').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#mname').val(),
			 vtype: "mname",
          },
          function(data){
                $("#midname").text(data);
          }
		  );
		});
		$('#sname').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#sname').val(),
			 vtype: "sname",
          },
          function(data){
                $("#lname").text(data);
          }
		  );
		});
		$('#username').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#username').val(),
			 vtype: "uname",
          },
          function(data){
                $("#uname").text(data);
          }
		  );
		});
		$('#password').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#password').val(),
			 vtype: "password",
          },
          function(data){
            $("#pword").text(data);
          }
		  );
		});
		$('#passconf').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#passconf').val(),
			 vtype: "password",
          },
          function(data){
                $("#pconf").text(data);
          }
		  );
		});
		$('#email').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#email').val(),
			 vtype: "e-mail",
          },
          function(data){
                $("#eMail").text(data);
          }
		  );
		});
		$('.numeric').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $(this).val(),
			 vtype: "numeric",
          },
          function(data){
			if(data!='') alert(data);
          }
		  );
		});
		$('#mrate').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#mrate').val(),
			 vtype: "numeric",
          },
          function(data){
			$("#monthly").text(data);
          }
		  );
		});
		$('#hphone').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#hphone').val(),
			 vtype: "open",
          },
          function(data){
			$("#telno").text(data);
          }
		  );
		});
		$('#mphone').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#mphone').val(),
			 vtype: "open",
          },
          function(data){
			$("#mobileNo").text(data);
          }
		  );
		});
		$('#address').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#address').val(),
			 vtype: "open",
          },
          function(data){
			$("#pAdd").text(data);
          }
		  );
		});
		$('#zip').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#zip').val(),
			 vtype: "open",
          },
          function(data){
			$("#zpcode").text(data);
          }
		  );
		});
		$('#sss').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#sss').val(),
			 vtype: "sss",
          },
          function(data){
			$("#sssNo").text(data);
          }
		  );
		});
		$('#tin').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#tin').val(),
			 vtype: "tin",
          },
          function(data){
			$("#tinNo").text(data);
          }
		  );
		});
		$('#pagibig').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#pagibig').val(),
			 vtype: "pagibig",
          },
          function(data){
			$("#pgNo").text(data);
          }
		  );
		});
		$('#phil').blur(function(){
			$.post("<?php echo base_url();?>devtools/validate.php", {
             query: $('#phil').val(),
			 vtype: "philhealth",
          },
          function(data){
			$("#phNo").text(data);
          }
		  );
		});
	});
	</script>