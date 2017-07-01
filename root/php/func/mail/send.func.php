<?php

# ==== Send mail function ====

# Send formatted letter to user mail

//use Mailgun\Mailgun;

function sendMail($to, $subject, $bodyTxt, $bodyHtml)
{
	$ret = false;

	// Mailgun

//	# Create
//	$mg = new Mailgun('key-8dd1ed9c4d062667eb2001f4b9014dc9');

//	# Send letter
//	$mg->sendMessage('coolone.ru', 
//		[
//			'from'    => '@coolone.ru',
//			'to'      => 'kolann056@gmail.com',
//			'subject' => 'test',
//			'text'    => 'test'
//		] );

	$ret = true;

	return $ret;
}
