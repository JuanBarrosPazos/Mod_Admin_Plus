<?php
session_start();

	// SE USA ESTE SCRIPT PARA CONSTRUIR TODOS LOS BALANCES...
	// SE CAMBIA EL NOMBRE DE Balances_otr.php POR Balances.php
	// SE CANCELA BalancesUser.php ANTES Balances.php...

	global $balances;			$balances = 1;
	global $balancesOtros;		$balancesOtros = 1;
	
	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

	$_SESSION['usuarios'] = '';
	//unset($_SESSION['usuarios']);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	
	require 'Balances_Funciones.php';
	require 'Balances_Logica.php';
	require '../Inclu/Admin_Inclu_footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>