<?php

# ==== Check mail function ====

# Check signed or not signed user mail

function checkMail(string $mail, bool $signed)
{
	// Mail

	# Get
	global $user;
	$user = QB::table('users')->where(
			'mail',
			'=',
			$mail
		)->first();

	// Check

	# Signed
	if( $signed )
	{
		if( empty($user) )
			error( [ 'not signed' ] );
	}

	# Not signed
	else
	{
		if( !empty($user) )
			error( [ 'signed' ] );
	}
}
