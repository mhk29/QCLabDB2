<?php 
	
	$file = fopen("documents/file_5eee8301c6f66","r");
	$m1 = fgets($file);
	$m2 = fgets($file);
	$m3 = fgets($file);
	$m4 = fgets($file);
	echo $m4;
	rename("documents/file_5eee8301c6f66","documents/".substr($m4,0,-2));
	fclose($file);

?>