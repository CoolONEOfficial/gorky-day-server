<?php

# ==== Check table users with login function ====

# Check user exists in users table with login

function checkUserLogin()
{
	$ret = NULL;

	# -- Check user --
	
	global $user;
	global $tableUser;

	# Table
	$tableUser = QB::table('users');

	# User
	global $login;
	$user = $tableUser->where(
			'login',
			'=',
			$login
		)->orWhere(
			'mail',
			'=',
			$login
		)->first();

	# Return user
	$ret = $user;

	return $ret;
}
