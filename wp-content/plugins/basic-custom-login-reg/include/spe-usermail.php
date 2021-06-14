<?php
		$subj = 'Greetings!! Welcome to '.get_bloginfo('name');   
		$body = '<html><body><p>Hello User,<br/><br/> Welcome to '.get_bloginfo('name').'.</div><br/><br/>Admin can be verify your account details and approve your acoutnt,then login with your credentials to explore more on '.get_bloginfo('name').'.<br/><br/> 
			We would love to chat. Just hit our contact form to get in touch with feedback, questions, or ideas for us!<br/>
			<br/>Have an awesome day!<br/>
			Regards,<br>
			'.get_bloginfo('name') .' Team
			</body></html></p>';

		$headers 	='';
		$headers 	.= 'From:'.get_bloginfo('name').' <info@'.$_SERVER['HTTP_HOST'].">\r\n" .'Reply-To: noreply@'.$_SERVER['HTTP_HOST']. "\r\n" .'MIME-Version: 1.0' . "\r\n".'Content-type: text/html; charset=iso-8859-1' . "\r\n".'X-Mailer: PHP/' . phpversion();

		mail($email,$subj,$body,$headers);

		//---------------Mail send to Admin
		$admin_email 	= get_option('admin_email');
		$subject 		= "New User Registered";
		$adbody 		= '<html><body><p>Hello Admin,<br/><br/>
		</b> Email Address: <b>'.$email.' </b> registered on '.get_bloginfo('name').'.<br/><br/>
		Regards,<br>
		'.get_bloginfo('name').' Team
		</body></html></p>';
		mail( $admin_email,$subject,$adbody,$headers);