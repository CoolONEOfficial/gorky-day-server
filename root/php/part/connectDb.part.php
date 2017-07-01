<?php

# ==== Connect Database part ====

# --- Classes ---

# SafeMySQL class
require_once getPath('/php/composer/vendor/autoload.php');

# --- Code ---

# Connect to Database
new \Pixie\Connection('mysql', 
	[
		'driver'   => 'mysql',
		'host'     => 'localhost',
		'database' => 'db',
		'username' => 'coolone',
		'password' => 'password'
	], 'QB');
