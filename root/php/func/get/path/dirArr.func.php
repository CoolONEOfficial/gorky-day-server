<?php

# ==== Get directory path massive function ====

# Returns massive with pathes to files in input directory

function getDirPathArr(string $dirPath, string $fileExt = '')
{
	return glob($dirPath . '*.' . $fileExt . '*');
}
