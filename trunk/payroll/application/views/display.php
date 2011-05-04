<!--Jquery Functions-->
<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
	<style text="text/css">span{background-color:#ff8c00;}</style>
	<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/jqtransformplugin/jquery.jqtransform.js" ></script>
	<script>
	function randomPassword()//FUNCTION FOR MAKING PASSWORD
	{
	  chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	  pass = "";
	  for(x=0;x<10;x++)
	  {
	    i = Math.floor(Math.random() * 62);
	    pass += chars.charAt(i);
	  }
	  return pass;
	}
	function formSubmit()
	{
	  FRM.password.value = randomPassword(10);
	  return false;
	}
	</script>
	<script language="javascript">
		$(function(){
			$('form').jqTransform({imgPath:'<?php echo base_url();?>/jqtransform/jqtransformplugin/img/'});
		});
	</script>