<?php
	$message= "<html><body>First name: " . $_POST['firstname'] . '<br/>';
	$message.= "Last name: " . $_POST['lastname'] . '<br/>';
	$message.= "E-mail address: " . $_POST['email'] . '<br/>';
	$message.= "Phone: " . $_POST['phone'] . '<br/>';
	$message.= "Message: " . $_POST['message'] . '<br/>';
	 
	if(isset($_POST["receiveupdates"]))
    {
    	$message.="<b>Would like to be emailed</b><br/>";
    }
	
	$message.= "</body></html>";
      
	//Assemble Message
      
	$email = $_POST['email'] ;
      
	mail( 
		//Email address here
		"mrs.laurencameron@gmail.com", 
		
		//Subject here
		"Test", 
		
		//don't touch this
		$message,
		
		//Pretty Recipient Name and email address here
		"To: Lauren Cameron <mrs.laurencameron@gmail.com>\n" . 
		
		//Who the message will be from
		"From: MailBot <" . $email . ">" . 
		
		//don't touch this either 
		"MIME-Version: 1.0\n" . 
		"Content-type: text/html; charset=iso-8859-1"
	);
    echo $message;
    
	echo "<br><br><br>Thank you for your inquiry. We will respond as soon as we are able. <br/><br/> <a href='/'>Return to home page</a>";
?>