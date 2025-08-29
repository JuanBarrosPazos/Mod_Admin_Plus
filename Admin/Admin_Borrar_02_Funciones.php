<?php

function process_form(){
	
	require 'Admin_Botonera.php';

	print("<table class='TFormAdmin'>
				<tr>
					<th colspan=3>
						OK BAJA TEMPORAL DEL USUARIO
					</th>
				</tr>");
				
	global $rutaimg;
	$rutaimg = "src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."'";
	
	require 'tabla_data_resum.php';

	print("	<tr>
				<td colspan=3>
				".$inicioadmin.$inciobajas."
				</td>
			</tr>
		</table>");	

	global $db;					global $db_name;

	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";
	
	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];

	$FBaja = date('Y-m-d H:i:s');

	$sql = "UPDATE `$db_name`.$table_name_a SET `del` = 'true',`borrado` = '$FBaja' WHERE $table_name_a.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $sql)){
			//print("* ");
	}else{	print("ERROR SQL L.32 ".mysqli_error($db))."</br>";
			show_form ();
	}

	global $redir;
	$redir = "<script type='text/javascript'>
				function redir(){
					window.location.href='Admin_Ver.php';
				}
				setTimeout('redir()',8000);
			</script>";
	print ($redir);

} // FIN function process_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
					
function show_form(){
		
	require 'Admin_Botonera.php';
	if($_POST['oculto2']){  global $array_a;
							$array_a = 1;
							require 'admin_array_total.php'; }

	if(@$_POST['borrar']){  global $array_a;
							$array_a = 1;
							require 'admin_array_total.php'; }
								   
	print("<table class='TFormAdmin'>
			<tr>
				<th colspan=3 style='color:#F1BD2D;'>
				<div style:'display:inline-block';>
						SE DARÁ DE BAJA TEMPORAL
						</br>
						PODRÁR RECUPERARLO
				</div>		
						".$inicioadmin."
					</th>
				</tr>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>");

	require 'admin_input_default_a.php';

	print("<tr>
			<td style='text-align:right !important; width:120px;'>Nivel: </td>
			<td style='text-align:left !important; width:100px;'>".$defaults['Nivel']."</td>
			<td rowspan='5' align='center' width='94px'>
<img src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."' height='120px' width='90px' />
			</td>
		</tr>
		<tr>
			<td>Nombre: </td>
			<td>".$defaults['Nombre']."</td>
		</tr>
		<tr>
			<td>Apellidos: </td>
			<td>".$defaults['Apellidos']."</td>
		</tr>
		<tr>
			<td>Tipo Documento: </td>
			<td>".$defaults['doc']."</td>
		</tr>
		<tr>
			<td>N&uacute;mero: </td>
			<td>".$defaults['dni']."</td>
		</tr>
		<tr>
			<td>Control: </td>
			<td colspan='2'>".$defaults['ldni']."</td>
		</tr>
		<tr>
			<td>Mail: </td>
			<td colspan='2'>".$defaults['Email']."</td>
		</tr>	
		<tr>
			<td>Nombre de Usuario: </td>
			<td colspan='2'>".$defaults['Usuario']."</td>
		</tr>
		<tr>
			<td>Password: </td>
			<td colspan='2'>".$defaults['Pass']."</td>
		</tr>
		<tr>
			<td>Dirección: </td>
			<td colspan='2'>".$defaults['Direccion']."</td>
		</tr>
		<tr>
			<td>Teléfono 1: </td>
			<td colspan='2'>".$defaults['Tlf1']."</td>
		</tr>
		<tr>
			<td>Teléfono 2: </td>
			<td colspan='2'>".$defaults['Tlf2']."</td>
		</tr>
		<tr>
			<td colspan='3'>
				<button type='submit' title='CONFIRMAR LA BAJA TEMPORAL' class='botonrojo imgButIco DeleteBlack' style='vertical-align:top;display:inline-block;' ></button>
				<input type='hidden' name='borrar' value=1 />
		</form>".$inicioadmin."											
			</td>
		</tr>
		</table>"); 
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function master_index(){
		
	require '../Inclu_MInd/rutaadmin.php';
	require '../Inclu_MInd/Master_Index.php';
		
} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function UserLog(){

	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];
	global $rf;					$rf = $_POST['ref'];
	global $orden;				$orden = @$_POST['Orden'];	
	global $dir;				$dir = "../Users/".$_SESSION['ref']."/log";

	$ActionTime = date('H:i:s');
	global $InfoLog;

	global $text;
	$text = PHP_EOL.$InfoLog.$ActionTime.PHP_EOL."\t ID:".$_POST['id'].PHP_EOL."\t Nombre: ".$nombre." ".$apellido.PHP_EOL."\t Ref: ".$rf.". Nivel: ".$_POST['Nivel'].PHP_EOL."\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Pass'];

	require 'log_write.php';

	}

?>