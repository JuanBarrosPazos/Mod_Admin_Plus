<?php

function process_form(){
	
	global $db;				global $db_name;
	global $nombre;			$nombre = $_POST['Nombre'];
	global $apellido;		$apellido = $_POST['Apellidos'];

	global $table_name_a;	$table_name_a = "`".$_SESSION['clave']."admin`";

	$FRecup = date('Y-m-d H:i:s');

	$sqlc = "UPDATE `$db_name`.$table_name_a SET `Nivel` = 'user',`del` = 'false',`recuper` = '$FRecup' WHERE $table_name_a.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $sqlc)){
		print("<table class='TFormAdmin'>
				<tr>
					<th colspan=3>DATOS USER RECUPERADOS</th>
				</tr>");
							
		require 'Admin_Botonera.php';
		global $rutaimg;
		$rutaimg = "src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."'";
		$_POST['recuper']=$FRecup;
		$_POST['Nivel'] = "user";
		require 'tabla_data_resum.php';
				
		print("<tr>
				<td colspan=3>".$inicioadmin.$inciobajas."</td>
			</tr>
		</table>");

	}else{
		print("ERROR SQL L.13 ".mysqli_error($db)."</br>");
		show_form ();
		global $texerror;		$texerror = "\n\t ".mysqli_error($db);
	}

	global $redir;
	$redir = "<script type='text/javascript'>
				function redir(){
					window.location.href='Admin_Ver.php';
				}
				setTimeout('redir()',10000);
			</script>";
	print ($redir);

} // FIN function process_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
			
function show_form(){
	
	global $dt;				$dt = $_POST['doc'];
	global $img;			$img = 	$_POST['myimg'];

	if(isset($_POST['oculto2'])){
		$_SESSION['sref'] = $_POST['ref'];
		global $array_a;		$array_a = 1;
		require 'admin_array_total.php'; 
	}else{ }
	
	print("<table class='TFormAdmin'>
			<tr>
				<th colspan=3>
					<div style='display:inline-block; margin-top:0.4em; color:#F1BD2D;'>
						DATOS A RECUPERAR
					</div>
					<a href='Feedback_Ver.php' >
				<button type='button' title='INICIO ADMIN PAPELERA' class='botonlila imgButIco HomeBlack' style='vertical-align:top;float:right;' ></button>
					</a>
				</th>
			</tr>
				
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>");
			
			require 'admin_input_default.php';
			global $rutaimg;
			//$rutaimg = "src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."'";
			$rutaimg = "src='../Users/".$_SESSION['sref']."/img_admin/".$_POST['myimg']."'";
			require 'tabla_data_resum.php';
				
		print("<tr height=40px>
				<td colspan='3'>
			<button type='submit' title='CONFIRME RECUPERAR USER' class='botonverde imgButIco CachedBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='modifica' value=1 />
		</form>
				<a href='Feedback_Ver.php' >
            <button type='button' title='INICIO ADMIN PAPELERA' class='botonlila imgButIco HomeBlack' style='vertical-align:top;float:right;' ></button>
				</a>
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

	global $nombre;			$nombre = $_POST['Nombre'];
	global $apellido;		$apellido = $_POST['Apellidos'];
	global $rf;				global $texerror;
	
	if(isset($_POST['ref'])){ $rf = $_POST['ref']; }else{ }
		
	$ActionTime = date('H:i:s');
	
	global $InfoLog;
	global $dir;			$dir = "../Users/".$_SESSION['ref']."/log";

	global $text;
	$text = PHP_EOL.$InfoLog.$ActionTime.PHP_EOL."\t Nombre: ".$nombre." ".$apellido.PHP_EOL."\t Ref: ".$rf.". Nivel: ".$_POST['Nivel'].PHP_EOL."\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Pass'].$texerror;

	require 'log_write.php';

}

?>