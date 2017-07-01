<?php

# ==== Open html function ====

# Output html

function openHtml(string $nameHtml)
{
	# Output html
	echo file_get_contents(getPath('html/' . $nameHtml . '.html'));
	die();
}
