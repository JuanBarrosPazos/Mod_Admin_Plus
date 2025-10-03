<?php

	// require 'Inclu/ipCliente.php';
	/*
		// Ejecutar comando arp y salida de direccion MAC cliente
		exec("arp -a $ipCliente", $output);
		// La dirección MAC sería el segundo elemento [1]
		$mac_address = $output[0];
		// Imprime la dirección MAC si existe...
		echo "The MAC address for $ipCliente is $mac_address <br>";
	*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	// PHP obtener la MAC del servidor.
	/*
	$MAC = exec('getmac');
	$MAC = strtok($MAC, ' ');
	echo "Dirección MAC del servidor: $MAC <br>";
	*/

			////////////////////		************   		////////////////////

	function GetMacAdd(){

		global $GetMacAdd;

		$strGetMacAdd = exec('getmac');
		$strGetMacAdd = str_replace(' ', '', $strGetMacAdd);

		switch (true) {
			case (($strGetMacAdd!='')&&(!empty($strGetMacAdd))):
				$GetMacAdd = substr($strGetMacAdd, 0, 17);
				break;
			case (($strGetMacAdd=='')||(empty($strGetMacAdd))):
				ob_start();
				system('getmac');
				$SystemGetMac = ob_get_contents();
				ob_clean();
				$GetMacAdd = substr($SystemGetMac, strpos($SystemGetMac,'\\')-20, 17);
				break;
			default:
				$GetMacAdd = "";
				break;
		}

		return $GetMacAdd;
		//echo "Dirección MAC del cliente: ".substr($Content, strpos($Content,'\\')-20, 17)."<br>";
	}
	//echo GetMACAdd();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */
	
?>