<?php

# ==== Check table user id function ====

# Checks signed or not signed user id

function checkId(int $id, &$idRef, bool $signed)
{
	// Id

	global $id;

	# Replace -1 id to self id
	global $session;
	if($id == -1)
	{
		# Local
		$id = $session->id;

		# Global
		$idRef = $session->id;
	}

	if($id > 0)
	{
		# Get
		global $user;
		$user = QB::table('users')->where(
				'id',
				'=',
				$id
			)->first();

		/// Check

		// Id != user id

		# Get session table column
		global $session;
		if( empty($session) ) // varMap syntax error
			errorFatal( [ 'session' => [ 'null' ] ] );

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
	else
		error( [ 'bad' ] );
}
