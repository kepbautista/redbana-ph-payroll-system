<?php
if ( $this->login_model->isUser_LoggedIn() ) 	
		{
			if ($this->login_model->can_Access("editemp"))
			{
?><?php		