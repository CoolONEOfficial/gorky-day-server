<?php

# ==== Signin ====

# Send signin confirmation letter with user mail
# Save user in temp users

# Values:
# 	login
# 	
# 	pass
# 	mail
# 		OR
# 	keySession
# 	keySessionType

# --- Functions ---

# Send signin confirm
require getPathCodePhp('func/mail', 'send');
function sendSigninConfirm(string $to)
{
	global $keySignin;

	return sendMail
		( 
			$to,                      # To
			'Подтверждение аккаунта', # Subject
			'',                       # Body (TXT)
			str_replace               # Put signin confirm key in body (HTML)
			(
				'%KEY%',
				$keySignin,
				file_get_contents(getPathCodeHtml('msg', 'signinConfirm'))
			)
		);
}

# --- Code ---

$retJson = false;

# -- Signin --

if(isSet($keySession) &&
   isSet($keySessionType) &&
   isSet($login)) // with social keySession
{
	# - Create -
	
	# User / get user id
	$userId = QB::table('users')->insert(
			[
				'login' => $login
			]
		);

	# Key session
	QB::table('userKeysSession')->insert(
			[
				'id'               => $userId,
				'keySession'       => $keySession,
				'keySessionActive' => 1,
				'keySessionType'   => $keySessionType,
				'userAgent'        => $_SERVER['HTTP_USER_AGENT']
			]
		);
}
else if(isSet($login) &&
        isSet($mail)  &&
        isSet($pass)) // with login, mail and pass
{
	# Crypt pass
	$passHash = password_hash($pass, PASSWORD_DEFAULT);

	# - Create -

	# User / get user id
	$userId = QB::table('users')->insert(
			[
				'login'    => $login,
				'passHash' => $passHash,
				'mail'     => $mail
			]
		);
	
	# Key signin
	$keySignin = genKey();

	# User signin key
	QB::table('userKeysSignin')->insert(
			[
				'id'        => $userId,
				'keySignin' => $keySignin
			]
		);

	if(DEBUG)
	{
		# Dump
		echo 'signinKey:';
		var_dump($keySignin);
	}
	else
		# Send to mail
		sendSigninConfirm($mail, $keySignin);
}

errorRet();

# Return true
$retJson['result'] = true;

echo json_encode($retJson);
