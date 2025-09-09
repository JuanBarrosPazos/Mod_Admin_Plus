<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu/Admin_head.php';

	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if($_SESSION['Nivel'] == 'admin'){
				
	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];
	
	if($_POST['oculto2']){  process_form();
							UserLog();
						} 
}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];
	print("<table class='TFormAdmin'>
				<tr>
					<th colspan=3  class='BorderInf'>
						ESTOS SON LOS DATOS DE SU CONSULTA
					</th>
				</tr>");

	global $rutaimg;
	$rutaimg = "src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."'";
	require 'tabla_data_resum.php';
	require 'tabla_data_resum_feed.php';
				
		print(" <tr>
					<td colspan=3 align='right' class='BorderSup'>
						<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
							<input type='submit' value='CERRAR VENTANA' class='botonrojo' />
							<input type='hidden' name='oculto2' value=1 />
			</form>
					</td>
				</tr>
			</table>");	

	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function UserLog(){

	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];	
	$rf = $_POST['ref'];

	$ActionTime = date('H:i:s');
	
	global $dir;				$dir = "../Users/".$_SESSION['ref']."/log";
	global $text;
	$text = PHP_EOL."** ADMIN FEEDBACK DETALLES ".$ActionTime.PHP_EOL."\t Nombre: ".$nombre." ".$apellido;
	
	require 'log_write.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2021/25 */
?>