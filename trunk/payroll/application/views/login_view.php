<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login - REDBANA PAYROLL SYSTEM</title>
<link href="<?php echo base_url(); ?>assets/css/style_x.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="main_container">
	<div id="header">
    	<div id="logo">
    	<a href="home.html"><img src="<?php echo base_url(); ?>assets/images/redbana_logo2.png" alt="" title="" style="border:0" /></a>    	
    	</div>
    	<div id="logo">
    	<a href="home.html"><img src="<?php echo base_url(); ?>assets/images/payroll_logo.jpg" alt="" title="" style="border:0" /></a>    	
    	</div>
        
        <div id="menu">
            <ul>                                        
                <li><a class="current" href="<?php echo base_url(); ?>" title="">Home</a></li>
            </ul>
        </div>
		<div id="graynavbar" >
			&nbsp;
		</div>
        
    </div>
    
    <!--end of green box-->
    
    <div id="main_content">
    	<div id="left_content">
        <h2>Welcome! Please log-in.</h2>
        <div class="text_box">
        								<?php echo form_open('login/view_form'); ?>
										<div class="login_form_row">
										<label class="login_label">Username:</label><input type="text" name="empnum" class="login_input" />
										</div>
										
										<div class="login_form_row">
										<label class="login_label">Password:</label><input type="password" name="password" class="login_input" />
										</div>                                     
										<!--<input type="image" src="images/login.gif" class="login" />-->										
										<div class="login_form_row">
										<label class="login_label">
										<input type="submit" value="Log-in" onclick="validate(this)" class="btnExample" />
										</label>
										</div>  
										<?php echo form_close(); ?>      	
		</div>
         <div id="left_nav">
         <?php 		      		
		    		if( isset($incorrect_credentials) or
						$this->session->userdata('LOGIN_WARNING') != FALSE
					){		    					    			
		    			echo '<div style="color:red; font-size:1.5em"><br/> ';
		    			echo 'You have entered an incorrect username or password.<br/><br/>Please try again.';
		    			echo '</div>';
						@$this->session->unset_userdata('LOGIN_WARNING');
		    		}    
		    		if( strlen(validation_errors()) > 0 )
		    		{
		    			echo '<div id="form_error_notice" style="width: 80%" class="center"><br/>';
		    			echo validation_errors();
		    			echo '</div>';

		    		}
		    		if( isset($relayThisError) )
		    		{
		    			echo '<div id="form_error_notice" style="width: 80%" class="center"><br/>';
		    			echo "{$relayThisError["ERROR_CODE"]}: {$relayThisError["ERROR_MESSAGE"]}";
		    			echo '</div>';
		    		}		
		    	?>
         </div>
        
    
        
        
        
        </div><!--end of left content-->



    	<div id="right_content">
        <h2>Announcements</h2>
        	<div class="products_box">
  <img src="../../../../../Users/Abraham_Darius_Llave/Desktop/sample/111/images/box_icon.gif" alt="" title="" class="box_img" />
 <h3>Dolore magna aliqua</h3>  
            <p>         
"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.        
            </p>
            <div class="read_more_link"><a href="#">read more</a></div>
            </div>
            
            
         	<div class="products_box">
  <img src="../../../../../Users/Abraham_Darius_Llave/Desktop/sample/111/images/box_icon.gif" alt="" title="" class="box_img" />
 <h3>Dolore magna aliqua</h3>  
            <p>         
"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.        
            </p>
            <div class="read_more_link"><a href="#">read more</a></div>
            </div>
            
                        
            </div>  
            
            
                     
            
            
            
            
            
            
        
        </div><!--end of right content-->
    <div style=" clear:both;"></div>
    </div><!--end of main content-->
 

     <div id="footer">
     	<div class="copyright">
			2011 UPLB Students
        </div>
    	<div class="footer_links"> 
        <a href="#">About us</a>
         <a href="privacy.html">Privacy policy</a> 
        <a href="contact.html">Contact us </a>        
        </div>        
    </div>     
<!--end of main container-->
</body>
</html>
