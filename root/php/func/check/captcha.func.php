<?php

# ==== Check captcha function ====

# Check google reCaptcha valid


# Captcha
function checkCaptcha(string $captchaResponse)
{
	$ret = false;

	if(INTERNET)
	{
		# -- Check --

		// Captcha

		# Create
		$captcha = new \ReCaptcha\ReCaptcha('6LdEbBEUAAAAAHkZowL5n_mWNfkf_-zznx-ScY4U');

		# Get response
		$resp = $captcha->verify($captchaResponse, $_SERVER['REMOTE_ADDR']);
		
		# Check
		if($resp->isSuccess())
			$ret = true;
	}
	else
		$ret = true;

	return $ret;
};
