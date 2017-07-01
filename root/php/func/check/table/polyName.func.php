<?php

# ==== Check polygon name function ====

function checkPolyName(int $name)
{
	$ret = NULL;

	if( ($respName = QB::table('polygons')->where(
			'name',
			'=',
			$name
		)->first->name) !== NULL )
	{
		# Return name
		$ret = $respName;
	}
	else
		error( [ 'bad' ] );

	return $ret;
}
