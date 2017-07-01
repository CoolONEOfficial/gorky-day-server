<?php

# ==== Log in ====

# Activate user key

# Values:
# 	login OR mail
# 	pass
# 		OR
# 	keySession
# 	keySessionType

# --- Code ---

$retJson = false;

# -- Create session --

// Key session

# Generate
$keySessionNew = genKeySingleton('userKeysSession', 'keySession');

if(isSet($login) &&
   isSet($pass)  ) // with login and pass
{
	# Check login or mail
	if( empty($user) )
		errorFatal( [ 'login or/and mail' => [ 'bad' ] ] );

	// Password

	# Check
	if(password_verify($pass, $user->passHash))
	{
		# Check rehash
		if(password_needs_rehash($user->passHash, PASSWORD_METHOD))
		{
			/// Pass hash

			// Update
			
			# Local
			$user->passHash = password_hash($pass, PASSWORD_METHOD);

			# Global
			$tableUser->where(
					'id',
					'=',
					$user->id
				)->update(
					[
						'passHash' => $user->passHash
					]
				);
		}

		# --- Start login ---

		// Session
		
		# -- Check --

		# Not created?
		if( ( $session = QB::table('userKeysSession')->where(
					'id',
					'=',
					$user->id
				)->where(
					'userAgent',
					'=',
					$_SERVER['HTTP_USER_AGENT']
				)->first() ) === NULL )
		{
			if(DEBUG)
				echo('Creating session...');

			# Create
			QB::table('userKeysSession')->insert(
					[
						'id'               => $user->id,
						'keySession'       => $keySessionNew,
						'keySessionActive' => 1,
						'userAgent'        => $_SERVER['HTTP_USER_AGENT']
					]
				);
		}

		# Created?
		else
		{
			if(DEBUG)
				echo('Activating/regenerating existed session...');

			# Activate
			QB::table('userKeysSession')->where(
					'id',
					'=',
					$session->id
				)->update(
					[
						'keySession'       => $keySessionNew,
						'keySessionActive' => 1
					]
				);
		}

		# Return key session
		$retJson['keySession'] = $keySessionNew;
		$retJson['keySessionType'] = 'default';
	}
	else
		errorFatal( [ 'pass' => [ 'bad' ] ] );
}
else if(isSet($keySession) &&
        isSet($keySessionType)) // with social keySession
{
	# Activate
	QB::table('userKeysSession')->where(
			'keySession',
			'=',
			$keySession
		)->update(
			[
				'keySessionActive' => 1,
				'keySession'       => $keySessionNew
			]
		);

	$retJson['result'] = true;
}

# Return errors
errorRet();

die(json_encode($retJson));
