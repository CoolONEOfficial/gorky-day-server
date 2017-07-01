<?php

# ==== Require recursive directory files and directory head file function ====

# Recursive require all files in directory and head file

# Files sctruct:
# /name.func.php
# /name/subname.func.php
# /name/...

if(!function_exists('requireDirRec'))
{
	function requireDirRec(string $dir)
	{
		# --- Reqiure dir recursive ---
		
		# Create recursive directory iterator
		$iter = new RecursiveIteratorIterator( new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS) );

		# Require with iterator
		foreach($iter as $mFile)
			if(pathInfo($mFile, PATHINFO_EXTENSION) == 'php')
				require $mFile->getPathname();

		# Require dir head file
		$headPath = $dir . '.func.php';
		if(file_exists($headPath))
			require $headPath;
	}
}
