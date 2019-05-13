<?php
	@session_start();
	
	$a = rand(2, 10);
	$b = rand(2, 10);
	$d = rand(2, 10);
	$e = rand(2, 10);
	$f = rand(1000, 99999);
	
	$_SESSION['capha_3_nn'] = $f;
	
	$s = $a * ($b + $d) * $e;
	
	$_SESSION['capha_3'] = $s;
	
	echo '{"n":"' . $f . '", "s":"' . $a . ' * ' . '(' . $b . ' + ' . $d . ')' . ' * ' . $e . '"}';
	exit;
?>