<?php

require 'Inclu/ipCliente.php';

// Ejecutar comando arp y salida de direccion MAC cliente
exec("arp -a $ipCliente", $output);
// La dirección MAC sería el segundo elemento [1]
$mac_address = $output[0];
// Imprime la dirección MAC si existe...
echo "The MAC address for $ipCliente is $mac_address <br>";

////////////////////////////////////

// PHP codigo para obtener la MAC del servidor.
$MAC = exec('getmac');
$MAC = strtok($MAC, ' ');
echo "Dirección MAC del servidor: $MAC <br>";

////////////////////////////////////

function GetMACAdd(){
	ob_start();
	system('getmac');
	$Content = ob_get_contents();
	ob_clean();
	//return substr($Content, strpos($Content,'\')-20, 17);
	echo "Dirección MAC del cliente: ".substr($Content, strpos($Content,'\\')-20, 17)."<br>";
}
echo GetMACAdd();

?>