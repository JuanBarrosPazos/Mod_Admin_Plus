<?php

	global $ipCliente;

	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ipCliente = $_SERVER['HTTP_CLIENT_IP'];
	}elseif($_SERVER['REMOTE_ADDR'] == getenv("REMOTE_ADDR")){
			$ipCliente = $_SERVER['REMOTE_ADDR'];
	}elseif(!empty(getenv("REMOTE_ADDR"))){
			$ipCliente = getenv("REMOTE_ADDR");
	}elseif(!empty($_SERVER['REMOTE_ADDR'])){
			$ipCliente = $_SERVER['REMOTE_ADDR'];
	}elseif(getenv($_SERVER['HTTP_X-FORWARDED_FOR'])){
			$ipCliente = $_SERVER['HTTP_X-FORWARDED_FOR'];
	}elseif(getenv($_SERVER['HTTP_X_FORWARDED'])){
			$ipCliente = $_SERVER['HTTP_X_FORWARDED'];
	}elseif(getenv($_SERVER['HTTP_FORWARDED_FOR'])){
			$ipCliente = $_SERVER['HTTP_FORWARDED_FOR'];
	}elseif(getenv($_SERVER['HTTP_FORWARDED'])){
			$ipCliente = $_SERVER['HTTP_FORWARDED'];
	}else{	echo "NO SE DETECTA LA IP DEL CLIENTE"; }
	
   	//echo "\$ipCliente = ".$ipCliente."<br>";

	/*
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ipCliente = "1. ".$_SERVER['HTTP_CLIENT_IP'];
	}
		echo "\$ipCliente = ".$ipCliente."<br>";
	if($_SERVER['REMOTE_ADDR'] == getenv("REMOTE_ADDR")){
			$ipCliente = "2. ".$_SERVER['REMOTE_ADDR'];
	}
		echo "\$ipCliente = ".$ipCliente."<br>";
	if(!empty(getenv("REMOTE_ADDR"))){
			$ipCliente = "3. ".getenv("REMOTE_ADDR");
	}
		echo "\$ipCliente = ".$ipCliente."<br>";
	if(!empty($_SERVER['REMOTE_ADDR'])){
			$ipCliente = "4. ".$_SERVER['REMOTE_ADDR'];
	}
		echo "\$ipCliente = ".$ipCliente."<br>";
	if(getenv($_SERVER['HTTP_X-FORWARDED_FOR'])){
			$ipCliente = "5. ".$_SERVER['HTTP_X-FORWARDED_FOR'];
	}
		echo "\$ipCliente = ".$ipCliente."<br>";
	if(getenv($_SERVER['HTTP_X_FORWARDED'])){
			$ipCliente = "6. ".$_SERVER['HTTP_X_FORWARDED'];
	}
		echo "\$ipCliente = ".$ipCliente."<br>";
	if(getenv($_SERVER['HTTP_FORWARDED_FOR'])){
			$ipCliente = "7. ".$_SERVER['HTTP_FORWARDED_FOR'];
	}
		echo "\$ipCliente = ".$ipCliente."<br>";
	if(getenv($_SERVER['HTTP_FORWARDED'])){
			$ipCliente = "8. ".$_SERVER['HTTP_FORWARDED'];
	}
		echo "\$ipCliente = ".$ipCliente."<br>";
	*/

?>