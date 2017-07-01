<?php

# ==== Check polygon id function ====

function checkPolyId(int $id)
{
	$ret = NULL;

	if( ($resp = QB::table('polygons')->where(
			'id',
			'=',
			$id
		)->first()) !== NULL )
	{
		# Return id
		$ret = $resp->id;
	}
	else
		error( [ 'bad' ] );

	return $ret;
}
