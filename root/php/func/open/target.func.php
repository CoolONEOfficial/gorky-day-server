<?php

# ==== Open target ====

# Redirect to index.php with target

function openTarget($nameTarget)
{
	header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php?target=' . $nameTarget);
}
