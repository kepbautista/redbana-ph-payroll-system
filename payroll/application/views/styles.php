	<style text="text/css">.warning{background-color:#ffd700;}</style>
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