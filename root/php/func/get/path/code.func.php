<?php

# ==== Get code path function ====

# Returns path to code

# --- Functions ---

# Get path
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/func/get/path.func.php';

# --- Code ---

function getPathCode(string $folder, string $ext, string $name = NULL)
{
	# -- Position --

	# Path to code dir
	$ret = getPath($ext . '/' . $folder);

	# File name and extension exists?
	if($name and $ext)
	{
		# -- Generate final filename --

		# Find slash
		if( ($slashPos = strPos($folder, '/')) === false )

			# Set end symbol
			$slashPos = strLen($folder);

		# Generate
		$ret .= '/' . $name . '.' . substr($folder, 0, $slashPos) . '.' . $ext;
	}

	return $ret;
}
