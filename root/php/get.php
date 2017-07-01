<?php

# ==== Get ====

# Returns info

# Values:
# 	get
# 	count

# --- Code ---

$retJson = [];

# -- Get --

$resp = NULL;

switch($get)
{
case 'messages':
case 'friends':
case 'users':
case 'polygons':

	# Create request / open table
	switch($get)
	{
	case 'messages':
	case 'friends':
	case 'users':
	case 'polygons':
		$request = QB::table($get);
	}

	# Set specific filter
	switch($get)
	{
	case 'messages':
	case 'friends':
		# Messages / Friends From / To user
		$request->where(function($q)
				{
					global $session;
					$q->where(
							'idFrom',
							'=',
							$session->id
						)->orWhere(
							'idTo',
							'=',
							$session->id
						);
				}
			);

	case 'polygons':

		$queryStr = 'SELECT AsText(poly), id, name FROM polygons';

		if(isSet($name))
		{
			$queryStr .= ' WHERE name=' . $name;
		}

		else if(isSet($id))
		{
			$queryStr .= ' WHERE id=' . $id;
		}

		$request = QB::table($get)->query($queryStr);

		break;

	case 'messages':

		# Messages from / to user from / to custom user id
		if(isSet($id))
		{
			$request->where(function($q)
					{
						global $id;
						$q->where(
								'idFrom',
								'=',
								$id
							)->orWhere(
								'idTo',
								'=',
								$id
							);
					}
				);
		}

		break;

	case 'friends':
		# Confirmed friends
		$request->where(
				'confirm',
				'=',
				1
			);

		break;

	case 'users':

		# Find users with...

		# ...login
		if(isSet($login))
			$request->where(
					'login',
					'=',
					$login
			);

		# ...mail
		else if(isSet($mail))
			$request->where(
					'mail',
					'=',
					$mail
			);

		# ...id
		else if(isSet($id))
			$request->where(
					'id',
					'=',
					$id
			);

		# Public info
		$request->select('login')
			->select('mail')
			->select('id');

		break;
	}

	# Set limit
	if(isSet($count))
		$request->limit($count);

	# Get response
	$resp = $request->get();

	break;
}

# Change response
switch($get)
{
case 'friends':

	# Change friends ids to friends info
	
	foreach($resp as $mFriendId => $mFriend)
	{
		// Friend added from...

		# ...user
		if($session->id == $mFriend->idFrom)
		{
			# Change
			$resp[$mFriendId] = QB::table('users')->where(
					'id',
					'=',
					$mFriend->idTo
				)->select('id')
				 ->select('mail')
				 ->select('login')
				 ->first();
		}

		# ...friend
		else if($session->id == $mFriend->idTo)
		{
			# Change
			$resp[$mFriendId] = QB::table('users')->where(
					'id',
					'=',
					$mFriend->idFrom
				)->select('id')
				 ->select('mail')
				 ->select('login')
				 ->first();
		}
	}

	break;

case 'messages':

	# Change message users ids to users info
	
	foreach($resp as $mMessageId => $mMessage)
	{
		// Message from...

		# ...user
		if($session->id == $mMessage->idFrom)
		{
			# Change
			$resp[$mMessageId]->user = QB::table('users')->where(
					'id',
					'=',
					$mMessage->idTo
				)->select('id')
				 ->select('mail')
				 ->select('login')
				 ->first();
			$resp[$mMessageId]->dir = 'to';
		}

		# ...friend
		else if($session->id == $mMessage->idTo)
		{
			# Change
			$resp[$mMessageId]->user = QB::table('users')->where(
					'id',
					'=',
					$mMessage->idFrom
				)->select('id')
				 ->select('mail')
				 ->select('login')
				 ->first();
			$resp[$mMessageId]->dir = 'from';
		}

		# Delete ids
		unSet($resp[$mMessageId]->idFrom);
		unSet($resp[$mMessageId]->idTo);
	}

	break;

case 'users':

	# Return first result, not array of results

	if( ($resp) &&
	    (isSet($login) ||
	     isSet($mail)  ||
	     isSet($id)    ))
		# Return first object
		$resp = $resp[0];

	break;

case 'polygons':

	$resp = $resp[0];

	$resp->poly = $resp->{'AsText(poly)'};
	unSet($resp->{'AsText(poly)'});

	$resp->poly = substr($resp->poly, 9, -2);
	
	$openPolyResp = QB::table('openPolygons')->where(
			'userId',
			'=',
			$session->id
		)->get();

	foreach($openPolyResp as $mPoly)
	{
		$resp->openPoly[] = $mPoly->polyId;
	}
}

# Return null if empty result
if(empty($resp))
	$resp = null;

# Return request result
$retJson[$get] = $resp;

errorRet();

echo json_encode($retJson);
