<?php

# ==== Logout ====

# Deactivate user keySession

# Values:
# 	keySession
# 	keySessionType

# --- Code ---

$retJson = false;

# -- Logout start --

# - Delete -

# Key session
QB::table('userKeysSession')->where(
		'id',
		'=',
		$session->id
	)->update(
		[
			'keySessionActive' => 0,
			'timeEnd'          => QB::raw('NOW()')
		]
	);

errorRet();

# Return true
$retJson["result"] = true;

die(json_encode($retJson));
