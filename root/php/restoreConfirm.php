<?php

# ==== Restore confirm ====

# Generate, set and send to user mail new password

# Values:
# 	keyRestore
# 	mail

# --- Functions ---

# Send restore (new pass)
require getPathCodePhp('func/mail', 'send');
function sendRestore(string $to, string $pass)
{
	# Send mail
	return sendMail
		(
			$to,                           # To
			'Новый пароль',                # Subject
			'',                            # Body (TXT)
			str_replace                    # Put restore key in body (HTML)
			(
				'%PASS%',
				$pass,
				file_get_contents(getPathCodeHtml('msg', 'restore'))
			)
		);
}

# --- Code ---

$retJson = false;

# -- Restore start --

echo 'restore column:';
var_dump($restore);

// New pass

# Generate
$newPass = genKey();
$newPassHash = password_hash($newPass, PASSWORD_METHOD);

# Update
QB::table('users')->where(
		'id',
		'=',
		$restore->id
	)->update(
		[
			'passHash' => $newPassHash
		]
	);

/// Delete

// Key

# Sessions
QB::table('userKeysSession')->where(
		'id',
		'=',
		$restore->id
	)->delete();

# Restore
QB::table('userKeysRestore')->where(
		'id',
		'=',
		$restore->id
	)->delete();

# Send new pass to mail
#sendRestore($mail, $newPass);

# Output new pass
if(DEBUG)
{
	echo 'new pass:';
	var_dump($newPass);
}

errorRet();

# Return true
$retJson["result"] = true;

die(json_encode($retJson));
