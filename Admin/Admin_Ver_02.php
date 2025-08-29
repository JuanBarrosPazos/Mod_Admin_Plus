<?php
session_start();

	global $docs;			$docs = 1;
	global $popup;			$popup = 1;
	
	require '../Inclu/error_hidden.php';
	require '../Inclu/Admin_head.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){
				
	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];
	
	if($_POST['oculto2']){	process_form();
							UserLog();
											} 
	}else{ require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];
	
	print("<table class='TFormAdmin'>
			<tr>
				<th colspan=3>DATOS DEL USUARIO</th>
			</tr>");

	global $rutaimg;
	$rutaimg = "src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."'";
	require 'tabla_data_resum.php';

	print("<tr>
			<td colspan=3>
				<form name='closewindow' action='$_SERVER[PHP_SELF]'  onsubmit=\"window.close()\">
		 <button type='submit' title='CERRAR VENTANA' class='botonrojo imgButIco CancelBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='oculto2' value=1 />
				</form>
			</td>
		</tr>
	</table>");

	global $redir;
	$redir = "<script type='text/javascript'>
				function redir(){
					window.close();
				}
			setTimeout('redir()',8000);
		</script>";
	print ($redir);

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
	$text = PHP_EOL."** USERS VER DETALLES ".$ActionTime.PHP_EOL."\t Nombre: ".$nombre." ".$apellido;

	require 'log_write.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por Juan Barros Pazos 2021/25 */
?>
