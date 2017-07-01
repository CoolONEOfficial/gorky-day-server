<?php

# ==== Send message ====

# Send message to friend

# Values:
# keySession
# friendId
# msg

# --- Code ---

$retJson = false;

// Message

# Send
QB::table('messages')->insert(
		[
			'idFrom' => $session->id,
			'idTo'   => $friendId,
			'msg'    => $msg
		]
	);

errorRet();

$retJson['result'] = true;

die(json_encode($retJson));
