<?php

	/*	
	echo "1. \$SERVER['REMOTE_ADDR'] = ".$_SERVER['REMOTE_ADDR']."<br>";
	echo "2. getenv('REMOTE_ADDR') = ".getenv("REMOTE_ADDR")."<br>";
	echo "3. \$_SERVER['HTTP_X_FORWRDED_FOR'] = ".$_SERVER['HTTP_X_FORWARDED_FOR']."<br>";
    */

	global $ipCliente;
	if(!empty($_SERVER['HHTP_X-FORWARDED_FOR'])){
		$ipCliente = $_SERVER['REMOTE_ADDR'];
	}elseif($_SERVER['REMOTE_ADDR'] == getenv("REMOTE_ADDR")){
		$ipCliente = $_SERVER['REMOTE_ADDR'];
	}elseif(!empty($_SERVER['REMOTE_ADDR'])){
		$ipCliente = $_SERVER['REMOTE_ADDR'];
	}elseif(!empty(getenv("REMOTE_ADDR"))){
		$ipCliente = getenv("REMOTE_ADDR");
	}else{	echo "NO SE DETECTA LA IP DEL CLIENTE"; }
	
    //echo "\$ipCliente = ".$ipCliente."<br>";

?>