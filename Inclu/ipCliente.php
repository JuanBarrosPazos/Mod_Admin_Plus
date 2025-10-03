<?php

	global $GetMacAdd;
	// UTILIZO $_SESSION['GetMacAdd'] para llamar GetMacAdd solo una vez...
	if((!isset($_SESSION['GetMacAdd'])||($_SESSION['GetMacAdd']==''))){
		GetMacAdd();
		//echo "* \$GetMacAdd = ".$GetMacAdd."<br>";
		$_SESSION['GetMacAdd'] = $GetMacAdd;
		//echo "* \$_SESSION['GetMacAdd'] = ".$_SESSION['GetMacAdd']."<br>";
	}else{ 
		//echo "* \$_SESSION['GetMacAdd'] = ".$_SESSION['GetMacAdd']."<br>"; 
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	global $ipCliente;
	switch (true) {
		case (isset($_SESSION['GetMacAdd'])):
			$ipCliente = $_SESSION['GetMacAdd'];
			break;
		case (($GetMacAdd != "")&&(!empty($GetMacAdd))):
			// Pasamos la MAC del cliente como identificador...
			$ipCliente = $GetMacAdd;
			break;
		case (!empty($_SERVER['HTTP_CLIENT_IP'])):
			$ipCliente = $_SERVER['HTTP_CLIENT_IP'];
			break;
		case ($_SERVER['REMOTE_ADDR'] == getenv("REMOTE_ADDR")):
			$ipCliente = $_SERVER['REMOTE_ADDR'];
			break;
		case (!empty(getenv("REMOTE_ADDR"))):
			$ipCliente = getenv("REMOTE_ADDR");
			break;
		case (!empty($_SERVER['REMOTE_ADDR'])):
			$ipCliente = $_SERVER['REMOTE_ADDR'];
			break;
		case (getenv($_SERVER['HTTP_X-FORWARDED_FOR'])):
			$ipCliente = $_SERVER['HTTP_X-FORWARDED_FOR'];
			break;
		case (getenv($_SERVER['HTTP_X_FORWARDED'])):
			$ipCliente = $_SERVER['HTTP_X_FORWARDED'];
			break;
		case (getenv($_SERVER['HTTP_FORWARDED_FOR'])):
			$ipCliente = $_SERVER['HTTP_FORWARDED_FOR'];
			break;
		case (getenv($_SERVER['HTTP_FORWARDED'])):
			$ipCliente = $_SERVER['HTTP_FORWARDED'];
			break;
		default:
			echo "** NO SE DETECTA LA IP DEL CLIENTE<br>";
			$ipCliente = "10.0.0.0";
			break;
	} // FIN swhitch

   	//echo "* \$ipCliente = ".$ipCliente."<br>";

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>