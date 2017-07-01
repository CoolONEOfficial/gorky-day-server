<?php

# ==== Check key session function ====

# Check user key session

function checkKeySession($keySession, int $active = 0)
{
	// Key
	
	# Get
	global $session;
	global $keySessionType;
	$session = QB::table('userKeysSession')->where(
			'keySession',
			'=',
			$keySession
		)->where(
			'userAgent',
			'=',
			$_SERVER['HTTP_USER_AGENT']
		)->where(
			'keySessionType',
			'=',
			$keySessionType
		);
	if($active != 0)
		$session->where(
			'keySessionActive',
			'=',
			($active == KEY_SESSION_ACTIVE) ? 1 : 0
		);
	$session = $session->first();
	
	# Check
	if( empty($session) )
		error( [ 'keySession' => [ 'bad' ] ] );
};
