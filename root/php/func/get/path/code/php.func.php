<?php

# ==== Get path code php function ====

# Get path to php file

function getPathCodePhp(string $dir, string $name = NULL)
{
	return getPathCode($dir, 'php', $name);
}
