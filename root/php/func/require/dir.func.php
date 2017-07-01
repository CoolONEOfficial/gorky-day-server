<?php

# ==== Require dir function ====

# Require all files and head directory file in directory

# Files sctruct:
# /name.func.php
# /name/subname.func.php
# /name/...

# --- Functions ---

# Require array
require getPath('php/func/require/arr.func.php');

# --- Code ---

if(!function_exists('requireDir'))
{
	function requireDir(string $dir)
	{
		// Require 

		# Directory files
		requireArr(glob($dir . '/*.php'));

		# Head directory file
		$headPath = $dir . '.func.php';
		if(file_exists($headPath))
			require $dir . '.func.php';
	}
}
