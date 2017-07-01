<?php

# ==== Restore ====

# Send restore confirmation letter to user mail

# Values:
# 	login
# 	g-recaptcha-response

# --- Functions ---

# Send restore confirm
function sendRestoreConfirm(string $to, string $restoreKey)
{
	# Send mail
	return sendMail
		(
			$to,                           # To
			'Подтверждение сброса пароля', # Subject
			'',                            # Body (TXT)
			str_replace                    # Put restore key in body (HTML)
			(
				'%KEY%',
				$restoreKey,
				file_get_contents(getPathCodeHtml('msg', 'restoreConfirm'))
			)
		);
}

# --- Code ---

$retJson = false;

# Check login or mail
if( empty($user) )
	errorFatal( [ 'login or/and mail' => [ 'bad' ] ] );

# -- Restore start --

// Key restore

# Generate
$keyRestore = genKey();

if(DEBUG)
{
	# Dump
	echo 'key restore:';
	var_dump($keyRestore);
}
else
	# Send to mail
	sendRestoreConfirm($mail, $keyRestore);

# Set
QB::table('userKeysRestore')->insert(
		[
			'id'         => $user->id,
			'keyRestore' => $keyRestore,
			'timeStart'  => QB::raw('CURRENT_TIMESTAMP'),
			'timeEnd'    => QB::raw('CURRENT_TIMESTAMP + INTERVAL ' . KEY_RESTORE_LIFE_MINUTES . ' MINUTE')
		]
	);

errorRet();

# Return true
$retJson["result"] = true;

echo json_encode($retJson);
