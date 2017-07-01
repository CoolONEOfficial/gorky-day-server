<?php

# ==== Generate reqular expression function ====

# Generates regular expression with flags

# Flags:
# 	w - words
# 	n - numbers
# 	s - spaces and tabs

function genRegExp(string $map)
{
	// Generate
	
	# Begin
	$regExp = '/^[';
	
	# Middle
	for($mStrId = 0; $mStrId < strLen($map); $mStrId++)
		
		switch($map[$mStrId])
		{
			case 'n':
				$regExp .= '0-9';
				
				break;

			case 'w':
				$regExp .= 'a-zA-Z';

				break;
			
			case 's':
				$regExp .= ' ';

				break;

			default:
				errorFatal( [ 'genRegExp' => [ 'map' => [ 'bad' ] ] ] );
		}
	
	# End
	$regExp .= ']*$/';

	return $regExp;
}
