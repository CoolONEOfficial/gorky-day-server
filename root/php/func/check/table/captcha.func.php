<?php

# ==== Check captcha function ====

# Check google reCaptcha valid

function checkCaptcha(string $captchaResponse)
{
	if(INTERNET)
	{
		// Captcha

		# Create
		$captcha = new \ReCaptcha\ReCaptcha('6LdEbBEUAAAAAHkZowL5n_mWNfkf_-zznx-ScY4U');

		# Get response
		$resp = $captcha->verify($captchaResponse, $_SERVER['REMOTE_ADDR']);
		
		# Check
		if( !$resp->isSuccess() )
			error( [ 'bad' ] );
	}
};
