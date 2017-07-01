<?php

# ==== Index ====

# Redirect to html or php
# If to php check and get input deperencys (values from $_POST or/and $_GET)

# --- Functions ---

# Get path
require $_SERVER['DOCUMENT_ROOT'] . '/php/func/get/path.func.php';

# Require directory
require getPath('php/func/require/dirRec.func.php');
requireDirRec( getPath('php/func/require') );

# Get pathes code directory
requireDirRec( getPath('php/func/get/path/code') );

// Directory

# Error
requireDirRec( getPath('php/func/error') );

# Open
requireDirRec( getPath('php/func/open') );

# All composer plugins (captcha, mysql query builder (pixie)...)
require getPath('php/composer/vendor/autoload.php');

# Check values functions
requireDirRec( getPath('php/func/check/table') );
# Generate functions
requireDirRec( getPath('php/func/gen') );

# --- Code ---

# Errors array
$errorArr = [];

# Error prefixes array
$errorPrefixArr = [];

# Constants
require getPathCodePhp('part', 'consts');

# Connect to Database
require getPathCodePhp('part', 'connectDb');

# -- To PHP --

if(DEBUG)
{
	echo 'internet flag:';
	var_dump(INTERNET);

	echo 'input:';
	var_dump($_GET, $_POST);
}

# -- Check --

# - Values with map -

# Convert  to array
require getPathCodePhp('func/convert', 'strToArr');

# - Defines -

# Check value alias (for check with func)
define('CHECK_VAL',     1);
define('CHECK_VAL_REF', 2);

# Key session active / passive
define('KEY_SESSION_ACTIVE',  3);
define('KEY_SESSION_PASSIVE', 4);

# - Var map -

# Struct
# [
# 	'from'   => 'pg'      // p - $_POST, g - $_GET (see previous map)
# 	'type'   => 'integer' or 'float' or 'string'.. // !!! TYPE IS FIRST !!!
# 	'regExp' => 'wds',    // w - words, n - numbers, s - spaces and tabs
# 	'len'    => [ 4, 6 ], // var length (if string), or value (if integer)
# 	                      // OR
# 	            [ 5 ],    // fix length or val
# 	'func' => [ 'funcName' => [ ..., CHECK_VAL, ... ] ] // CHECK_VALNAME will be swapped to var value
# ]

// From map

# Struct:
# [
# 	'char' => $charVal # alias char to $charVal (using in target map)
# 	$charVal => 'char' # reverce alias
# 	...
# ]

# Map
$fromMap =
	[
		'p' => $_POST,
		'g' => $_GET
	];

# --- Check profiles ---

// Login

define('CHECK_LOGIN',
		[
			'type'   => 'string',
			'regExp' => genRegExp('wn'), 
			'len'    => [ LOGIN_LEN_MIN, LOGIN_LEN_MAX ]
		]
	);

# Unsigned
define('CHECK_LOGIN_UNSIGNED',
		[
			'type'   => 'string',
			'func'   => [ 'checkLogin', [ CHECK_VAL, FLAG_UNSIGNED ] ]
		]
	);

# Signed
define('CHECK_LOGIN_SIGNED',
		[
			'type' => 'string',
			'func' => [ 'checkLogin', [ CHECK_VAL, FLAG_SIGNED ] ]
		]
	);

// Login or mail

# Signed
define('CHECK_LOGIN_OR_MAIL',
		[
			'type' => 'string',
			'func' => [ 'checkLoginOrMail', [ CHECK_VAL ] ]
		]
	);

// Login or mail or id

# Signed
define('CHECK_LOGIN_OR_MAIL_OR_ID',
		[
			'func' => [ 'checkLoginOrMailOrId', [ CHECK_VAL ] ]
		]
	);

// Mail

# Unsigned
define('CHECK_MAIL', 
		[
			'type' => 'string',
			'func' => [ 'filter_var', [ CHECK_VAL, FILTER_VALIDATE_EMAIL ] ]
		]
	);

# Unsigned
define('CHECK_MAIL_UNSIGNED',
		[
			'type' => 'string',
			'func' => [ 'checkMail', [ CHECK_VAL, FLAG_UNSIGNED ] ]
		]
	);

# Signed
define('CHECK_MAIL_SIGNED',
		[
			'type' => 'string',
			'func' => [ 'checkMail', [ CHECK_VAL, FLAG_SIGNED ] ]
		]
	);

# Pass
define('CHECK_PASS', 
		[
			'type'   => 'string',
			'regExp' => genRegExp('wn'), 
			'len'    => [ PASS_LEN_MIN,  PASS_LEN_MAX ] 
		]
	);

# Captcha
define('CHECK_CAPTCHA', 
		[
			'type' => 'string',
			'func' => [ 'checkCaptcha', [ CHECK_VAL ] ]
		]
	);

// Id

define('CHECK_ID',
		[
			'type' => 'integer'
		]
	);

# Unsigned
define('CHECK_ID_UNSIGNED',
		[
			'type' => 'integer',
			'func' => [ 'checkId', [ CHECK_VAL, CHECK_VAL_REF, FLAG_UNSIGNED ] ]
		]
	);

# Signed
define('CHECK_ID_SIGNED', 
		[
			'type' => 'integer',
			'func' => [ 'checkId', [ CHECK_VAL, CHECK_VAL_REF, FLAG_SIGNED ] ]
		]
	);

# Message
define('CHECK_MSG',
		[
			'type'   => 'string',
			'regExp' => genRegExp('wns'),
			'len'    => [ MSG_LEN_MIN, MSG_LEN_MAX ]
		]
	);

/// Key

define('CHECK_KEY',
		[
			'type' => 'string',
			'len'  => KEY_LEN
		]
	);

// Signin
define('CHECK_KEY_SIGNIN', 
		[ 
			'type' => 'string',
			'func' => [ 'checkKeySignin', [ CHECK_VAL ] ]
		]
	);

# Restore
define('CHECK_KEY_RESTORE',
		[ 
			'type' => 'string',
			'func' => [ 'checkKeyRestore', [ CHECK_VAL ] ]
		]
	);

// Session

define('CHECK_KEY_SESSION', 
		[
			'type' => 'string',
			'func' => [ 'checkKeySession', [ CHECK_VAL, 0 ] ]
		]
	);

# Active
define('CHECK_KEY_SESSION_ACTIVE', 
		[
			'type' => 'string',
			'func' => [ 'checkKeySession', [ CHECK_VAL, KEY_SESSION_ACTIVE ] ]
		]
	);

# Passive
define('CHECK_KEY_SESSION_PASSIVE', 
		[
			'type' => 'string',
			'func' => [ 'checkKeySession', [ CHECK_VAL, KEY_SESSION_PASSIVE ] ]
		]
	);

# Social aliases
define('SOCIAL_ALIASES',
		[
			'vk' => [],
			'fb' => []
		]
	);

# Type
define('CHECK_KEY_SESSION_TYPE',
		[
			'type' => 'string',
			'val' => array_merge(
					SOCIAL_ALIASES,
					[
						'default' => []
					]
				)
		]
	);

# Type
define('CHECK_KEY_SESSION_TYPE_SOCIAL',
		[
			'type' => 'string',
			'val' => SOCIAL_ALIASES
		]
	);

// Poly

# Name
define('CHECK_POLY_NAME',
		[
			'type' => 'string',
			'func' => [ 'checkPolyName', [ CHECK_VAL ] ]
		]
	);

# Id
define('CHECK_POLY_ID',
		[
			'type' => 'integer',
			'func' => [ 'checkPolyId', [ CHECK_VAL ] ]
		]
	);

# Count
define('CHECK_COUNT',
		[
			'type' => 'integer'
		]
	);

# --- Var map profiles (for signed/unsigned vars) ---

// Login

# From
define('VAR_MAP_LOGIN_FROM',
		[
			'from' => 'pg'
		]
	);

# Unsigned
define('VAR_MAP_LOGIN_UNSIGNED',
		array_merge(
			VAR_MAP_LOGIN_FROM,
			CHECK_LOGIN_UNSIGNED
		)
	);

# Signed
define('VAR_MAP_LOGIN_SIGNED',
		array_merge(
			VAR_MAP_LOGIN_FROM,
			CHECK_LOGIN_SIGNED
		)
	);

// Mail

# From
define('VAR_MAP_MAIL_FROM',
		[
			'from' => 'pg'
		]
	);

# Unsigned
define('VAR_MAP_MAIL_UNSIGNED',
		array_merge(
			VAR_MAP_MAIL_FROM,
			CHECK_MAIL_UNSIGNED
		)
	);

# Signed
define('VAR_MAP_MAIL_SIGNED',
		array_merge(
			VAR_MAP_MAIL_FROM,
			CHECK_MAIL_SIGNED
		)
	);

// Key

# From
define('VAR_MAP_KEY_FROM',
		[
			'from' => 'pg'
		]
	);

# Unsigned
define('VAR_MAP_KEY',
		array_merge(
			VAR_MAP_KEY_FROM,
			CHECK_KEY
		)
	);

// Id

# From
define('VAR_MAP_ID_FROM',
		[
			'from' => 'pg'
		]
	);

# Unsigned
define('VAR_MAP_ID_UNSIGNED',
		array_merge(
			VAR_MAP_ID_FROM,
			CHECK_ID_UNSIGNED
		)
	);

# Signed
define('VAR_MAP_ID_SIGNED',
		array_merge(
			VAR_MAP_MAIL_FROM,
			CHECK_ID_SIGNED
		)
	);

# --- Var profiles ---

// Login

# Signed
define('VAR_LOGIN_SIGNED',
		[
			'login' => VAR_MAP_LOGIN_SIGNED
		]
	);

# Unsigned
define('VAR_LOGIN_UNSIGNED',
		[
			'login' => VAR_MAP_LOGIN_UNSIGNED
		]
	);

// Mail

# Signed
define('VAR_MAIL_SIGNED',
		[
			'mail' => VAR_MAP_MAIL_SIGNED
		]
	);

# Unsigned
define('VAR_MAIL_UNSIGNED',
		[
			'mail' => VAR_MAP_MAIL_SIGNED
		]
	);

// Login or mail

# Signed
define('VAR_LOGIN_OR_MAIL',
		[
			'login' =>
				array_merge(
					VAR_MAP_LOGIN_FROM,
					CHECK_LOGIN_OR_MAIL
				),

			'mail' =>
				array_merge(
					VAR_MAP_MAIL_FROM,
					CHECK_LOGIN_OR_MAIL
				)
		]
	);

// Login or mail or id

# Signed
define('VAR_LOGIN_OR_MAIL_OR_ID',
		[
			'login' =>
				array_merge(
					VAR_MAP_LOGIN_FROM,
					CHECK_LOGIN_OR_MAIL_OR_ID
				),
			'mail' =>
				array_merge(
					VAR_MAP_MAIL_FROM,
					CHECK_LOGIN_OR_MAIL_OR_ID
				),
			'id' =>
				array_merge(
					VAR_MAP_ID_FROM,
					CHECK_LOGIN_OR_MAIL_OR_ID
				)
		]
	);

// Id

# Signed
define('VAR_ID_SIGNED',
		[
			'id' => VAR_MAP_ID_SIGNED
		]
	);

# Unsigned
define('VAR_ID_UNSIGNED',
		[
			'id' => VAR_MAP_ID_UNSIGNED
		]
	);

# Pass
define('VAR_PASS',
		[
			'pass' =>
				array_merge(
					[
						'from'  => 'pg'
					],
					CHECK_PASS
				)
		]
	);

# Captcha
define('VAR_CAPTCHA',
		[
			'g-recaptcha-response' =>
				array_merge(
					[
						'from'  => 'pg'
					],
					CHECK_CAPTCHA
				)
		]
	);

# Message
define('VAR_MSG',
		[
			'msg' =>
				array_merge(
					[
						'from'  => 'pg'
					],
					CHECK_MSG
				)
		]
	); 

/// Key

// Signin

# Signed
define('VAR_KEY_SIGNIN',
		[
			'keySignin' =>
				array_merge(
					[
						'from'  => 'pg'
					],
					CHECK_KEY_SIGNIN
				)
		]
	);

// Restore

# Signed
define('VAR_KEY_RESTORE',
		[
			'keyRestore' =>
				array_merge(
					[
						'from'  => 'pg'
					],
					CHECK_KEY_RESTORE
				)
		]
	);

// Session

define('VAR_KEY_SESSION',
		[
			'keySession' =>
				array_merge(
					[
						'from'  => 'pg'
					],
					CHECK_KEY_SESSION
				)
		]
	);

# Active
define('VAR_KEY_SESSION_ACTIVE',
		[
			'keySession' =>
				array_merge(
					[
						'from'  => 'pg'
					],
					CHECK_KEY_SESSION_ACTIVE
				)
		]
	);

# Passive
define('VAR_KEY_SESSION_PASSIVE',
		[
			'keySession' =>
				array_merge(
					[
						'from'  => 'pg'
					],
					CHECK_KEY_SESSION_PASSIVE
				)
		]
	);

# Type
define('VAR_KEY_SESSION_TYPE',
		[
			'keySessionType' =>
				array_merge(
					[
						'from' => 'pg'
					],
					CHECK_KEY_SESSION_TYPE
				)
		]
	);

# Type
define('VAR_KEY_SESSION_TYPE_SOCIAL',
		[
			'keySessionType' =>
				array_merge(
					[
						'from' => 'pg'
					],
					CHECK_KEY_SESSION_TYPE_SOCIAL
				)
		]
	);

// Poly

# Name
define('VAR_POLY_NAME',
		[
			'name' =>
				array_merge(
					[
						'from' => 'pg'
					],
					CHECK_POLY_NAME
				)
		]
	);

# Name
define('VAR_POLY_ID',
		[
			'id' =>
				array_merge(
					[
						'from' => 'pg'
					],
					CHECK_POLY_ID
				)
		]
	);

# Count
define('VAR_COUNT',
		[
			'count' =>
				array_merge(
					[
						'from' => 'pg'
					],
					CHECK_COUNT
				)
		]
	);

# Check variables map function
function checkVarMap(array $varMap)
{
	foreach($varMap as $mVarMode => $mVarArr)
	{
		if(DEBUG)
			errorPrefixPush($mVarMode);

		switch($mVarMode)
		{
		case 'var':
		case 'dep':

			# Check vars array
			foreach($mVarArr as $mVarName => $mVarMap)
			{
				if($mVarName != "target")
					errorPrefixPush($mVarName);

				foreach($mVarMap as $mCheckMapName => $mCheckMap)
				{
					if(DEBUG)
						errorPrefixPush($mCheckMapName);

					switch($mCheckMapName)
					{
					# Check var val with...

					case 'from':

						# ...from method (GET and/or POST)

						$mVarFound = false;

						# Convert str to arr with map
						global $fromMap;
						$fromArr = strToArr($mVarMap['from'], $fromMap);

						# Find
						foreach($fromArr as $mFrom)
						{
							# Search var val
							if( array_key_exists($mVarName, $mFrom) && !empty($mFrom[$mVarName]) )
							{
								# Global create val
								global ${$mVarName};
								${$mVarName} = $mFrom[$mVarName];
								$mVar = &${$mVarName};

								# Activate found flag
								$mVarFound = true;

								# Break search
								break;
							}
						}

						# Check
						if(!$mVarFound)
						{
							# Check deperency satisfaction
							if($mVarMode == 'dep')
								error( [ 'null' ] );

							# Stop check this var
							break 2;
						}
						
						break;

					case 'type':

						# ...type

						$type = $mCheckMap;

						# Convert numeric str to int or float
						switch($type)
						{
							case 'integer':
							case 'double':
							
								# Convert to...
								
								if(is_numeric($mVar))
								{
									# ...float
									if(strpos($type, '.'))
										$mVar = (float)$mVar;
									
									# ...int
									else
										$mVar = (int)$mVar;
								}
								break;
						}

						if(DEBUG)
						{
							echo 'goodType:';
							var_dump($type);

							echo 'currentType:';
							var_dump(getType($mVar));
						}

						if(getType($mVar) != $type)
							errorFatal( [ 'type' => [ 'bad' ] ] );

						break;

					case 'regExp':
						
						# ...regular expression

						error( [ 'check' => [ 'bad' ] ] );

						break;

					case 'len':

						# ...length (for strings)

						# Syntax:
						# 'len' =>
						# [
						# 	2 // min length
						# 	3 // max length
						# ]
						# OR
						# [
						# 	5 // one possible length
						# ]

						errorPrefixPush('length');

						$valLen = strLen($mVar);

						$checkLenMapType = getType($mCheckMap);
						switch($checkLenMapType)
						{
							case 'integer':

								# One length check

								$goodLen = $mCheckMap;
								
								if($valLen >= $goodLen)
									error( [ 'bad' ] );
								break;

							case 'array':

								# Min / Max length check

								$minLen = $mCheckMap[0];
								$maxLen = $mCheckMap[1];

								if($minLen > $maxLen) // varMap syntax error
									errorFatal( [ 'checkLen' => [ 'minMax' => [ 'reversed' ] ] ] );

								# Check
								if($valLen < $minLen)
									error( [ 'small' ] );
								else if($valLen > $maxLen)
									error( [ 'big' ] );

								break;

							default:
								errorFatal( [ 'type' => [ 'bad' ] ] ); # var map syntax error
						}

						errorPrefixPop();

						break;

					case 'func':

						# ...user function

						$funcName   = $mCheckMap[0];
						$funcArgArr = $mCheckMap[1];

						# Replace CHECK_VAL to var val
						foreach($funcArgArr as $mArgId => &$mArg)

							if($mArg == CHECK_VAL)
								$mArg = $mVar;
							else if($mArg == CHECK_VAL_REF)
								$mArg = &${$mVarName};

						# Check
						call_user_func_array($funcName, $funcArgArr);

						break;

					case 'val':

						# ...val

						// Val

						# Find
						$valFound = false;
						foreach($mCheckMap as $mVarVal => $mVarCheckMap)
						{
							if($mVar == $mVarVal)
							{
								# Check next var map
								checkVarMap($mVarCheckMap);

								# Activate found flag
								$valFound = true;
							}
						}

						# Check
						if(!$valFound)
							error( [ 'bad' ] );

						break;

					default:

						echo 'mVarName';
						var_dump($mCheckMapName);

						errorFatal( [ 'checkVarName' => [ 'bad' ] ] ); # var map syntax error
					}

					if(DEBUG)
						errorPrefixPop();
				}

				if($mVarName != "target")
					errorPrefixPop();
			}

			break;

		default:
			errorFatal( [ 'check' => [ 'bad' ] ] );
		}

		errorPrefixPop();
	}
}

// --- Get var ---

# Check
define('CHECK_GET',
		[
			'type' => 'string',
			'val' =>
			[
				'friends' => [],
				'messages' => 
				[
					'var' =>
						array_merge(
							VAR_ID_SIGNED
						)
				],
				'users' =>
				[
					'var' =>
						array_merge(
							VAR_LOGIN_SIGNED,
							VAR_MAIL_SIGNED,
							VAR_ID_SIGNED
						)
				],
				'polygons' =>
				[
					'var' =>
						array_merge(
							VAR_POLY_NAME,
							VAR_POLY_ID
						)
				]
			]
		]
	);

# From
define('VAR_MAP_GET_FROM',
		[
			'from' => 'pg'
		]
	);

# Var map
define('VAR_MAP_GET',
		array_merge(
			VAR_MAP_GET_FROM,
			CHECK_GET
		)
	);

# Var
define('VAR_GET',
		[
			'get' => VAR_MAP_GET
		]
	);

/// Target vals

# Struct
# 
# 'VAL_TARGET_SOMETHING' =>
# [
# 	'something' =>
# 	[
# 		'var' or 'dep' => // variable or deperency
# 		[
# 			array_merge(
# 				VAR_TARGETNAME // variable defines
# 				...
# 			)
# 		]
# 	]
# ]

# Target vals
define('VAL_TARGET_ARR',
		[
			# Login
			'login' =>
			[
				'var' =>
					array_merge(
						VAR_PASS,
						VAR_LOGIN_OR_MAIL,
						VAR_KEY_SESSION_TYPE,
						VAR_KEY_SESSION
					)
			],

			# Logout
			'logout' =>
			[
				'dep' =>
					array_merge(
						VAR_KEY_SESSION_TYPE,
						VAR_KEY_SESSION
					)
			],

			// Signin
			
			'signin' =>
			[
				'dep' =>
					array_merge(
						VAR_LOGIN_UNSIGNED
					),
				'var' =>
					array_merge(
						VAR_MAIL_UNSIGNED,
						VAR_PASS,
						VAR_CAPTCHA,

						VAR_KEY_SESSION_TYPE_SOCIAL,
						[
							'keySession' => VAR_MAP_KEY
						]
					)
			],

			# Confirm
			'signinConfirm' => 
			[
				'dep' =>
					array_merge(
						[
							'mail' => VAR_MAP_MAIL_SIGNED
						],
						VAR_KEY_SIGNIN
					)
			],

			# Signout
			'signout' =>
			[
				'dep' =>
					array_merge(
						VAR_KEY_SESSION_TYPE,
						VAR_KEY_SESSION_ACTIVE
					)
			],

			// Restore
			
			'restore' => 
			[
				'dep' =>
					array_merge(
						VAR_CAPTCHA
					),
				'var' =>
					array_merge(
						VAR_LOGIN_OR_MAIL
					)
			],

			# Confirm
			'restoreConfirm' =>
			[
				'dep' =>
					array_merge(
						[
							'mail' => VAR_MAP_MAIL_SIGNED
						],
						VAR_KEY_RESTORE
					)
			],

			// Friend

			# Add
			'friendAdd' =>
			[
				'dep' =>
					array_merge(
						VAR_KEY_SESSION_TYPE,
						VAR_KEY_SESSION_ACTIVE,
						[
							'friendId' => VAR_MAP_ID_SIGNED
						]
					)
			],

			# Delete
			'friendDelete' =>
			[
				'dep' =>
					array_merge(
						VAR_KEY_SESSION_TYPE,
						VAR_KEY_SESSION_ACTIVE,
						[
							'friendId' => VAR_MAP_ID_SIGNED
						]
					)
			],

			# Send message
			'msgSend' =>
			[
				'dep' =>
					array_merge(
						VAR_KEY_SESSION_TYPE,
						VAR_KEY_SESSION_ACTIVE,
						[
							'friendId' => VAR_MAP_ID_SIGNED
						],
						VAR_MSG
					)
			],

			# Get
			'get' =>
			[
				'dep' =>
					array_merge(
						VAR_KEY_SESSION_TYPE,
						VAR_KEY_SESSION_ACTIVE,
						VAR_GET
					),
					
				'var' =>
					array_merge(
						VAR_COUNT
					)
			],

			# Polygon open
			'polyOpen' =>
			[
				'dep' =>
					array_merge(
						VAR_KEY_SESSION_TYPE,
						VAR_KEY_SESSION,
						VAR_POLY_ID
					)
			]
		]
	);

# Val target
define('VAR_TARGET',
		[
			'target' =>
			[
				'from' => 'g',

				'val' => VAL_TARGET_ARR
			]
		]
	);

# Complete varMap
$varMap = 
	[
		'dep' =>
			array_merge(
				VAR_TARGET
			)
	];

if(DEBUG)
	var_dump($varMap);

# Check input vars
checkVarMap($varMap);

# -- Other vars --

# User agent
$_SERVER['HTTP_USER_AGENT'] = substr($_SERVER['HTTP_USER_AGENT'], 0, USER_AGENT_LENGTH_MAX);

# Return errors
errorRet();

# Go
require getPath('/php/' . $target . '.php');
