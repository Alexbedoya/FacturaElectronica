<?php 

	/**
	 * This example shows sending a message using PHP's mail() function.
	*/ 
	//require '../PHPMailer.php';
	require '../PHPMailer/PHPMailerAutoload.php';

	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Set who the message is to be sent from
	$mail->setFrom('alex.bedoya@gmail.com', 'Administrador');
	//Set an alternative reply-to address
	//$mail->addReplyTo('replyto@example.com', 'First Last');
	//Set who the message is to be sent to
	$mail->addAddress('alexis.bedoya@hotmail.es', 'Alex');
	//Set the subject line
	$mail->Subject = 'PHPMailer mail() test';
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML(file_get_contents('content.html'), dirname(__FILE__));
	//Replace the plain text body with one created manually
	$mail->AltBody = 'This is a plain-text message body';
	//Attach an image file
	$mail->addAttachment('');

	//send the message, check for errors
	if (!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	    echo "Message sent!";
	}
	
?>