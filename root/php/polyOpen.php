<?php

# ==== Open polygon ====

# Opens polygon

# Values:
# 	polyId
# 	keySession
# 	keySessionType

$retJson = [];

QB::table('openPolygons')->insert(
		[
			'userId' => $session->id,
			'polyId' => $polyId
		]
	);

errorRet();

$retJson['result'] = true;

die(json_encode($retJson));
