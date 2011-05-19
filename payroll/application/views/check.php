<?php

function check($array,$priv)
{
	$ans="No";
		foreach($array as $row)
		{
			if ($array==($priv))$ans="Yes";
		}
	return $ans; 
}

?>