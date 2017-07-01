<?php

# ==== Require function ====

# Require input path massive 
# Root directory is $_SERVER['DOCUMENT_ROOT']

if(!function_exists('requireArr'))
{
	function requireArr(array $pathArr)
	{
		# Require path massive
		foreach($pathArr as $mPath)
			require $mPath;
	}
}
