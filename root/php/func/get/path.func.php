<?php

# ==== Get path ====

# Get path in $_SERVER['DOCUMENT_ROOT']

function getPath(string $path)
{
	return $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
}
