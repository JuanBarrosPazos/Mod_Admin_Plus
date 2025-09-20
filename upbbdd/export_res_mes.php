<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['delete'])){	delete();
									show_form();
									listfiles();
	}else {	show_form();
			listfiles();
	}
								
}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $db;				global $db_name;
	global $TablaTitulo;	$TablaTitulo = "EXPORTE RESUMEN MENSUAL";
	global $ButtonTitulo;	$ButtonTitulo = "SELECCIONE RESUMEN MENSUAL";

	require 'ExportFiles_ShowForm.php';

	global $ExportBotonera;		$ExportBotonera = 2;
	require 'Export_Botonera.php';
	
} // FIN function show_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function listfiles(){

	global $Audio;		$Audio = "file_exp_ok.mp3";
	require 'AudiDescarga.php';

	if(@$_SESSION['tablas'] == ''){ $_SESSION['tablas'] = $_SESSION['ref']; }
	//print("*".$_SESSION['tablas'].".</br>");

	global $ruta;			$ruta ="../Users/".$_SESSION['tablas']."/mrficha/";
	//print("RUTA: ".$ruta.".</br>");
	global $rutag;			$rutag = "../Users/".$_SESSION['tablas']."/mrficha/{*}";
	//print("RUTA G: ".$rutag.".</br>");
		
	global $directorio;		$directorio = opendir($ruta);
	global $num;			$num=count(glob($rutag,GLOB_BRACE));

	if($num < 1){
		print ("<div class='centradiv alertdiv'>NO HAY ARCHIVOS PARA DESCARGAR</div>");
		if(($_SESSION['tablas'] != '')&&((isset($_POST['oculto1'])))){
			print("<audio src='../audi/no_file.mp3' autoplay></audio>");
		}
	}else{
		if(isset($_POST['oculto1'])){
			print("<audio src='../audi/files_for_exp.mp3' autoplay></audio>");
		}
		print ("<table class='TFormAdmin' style='padding:0.2em;'>
				<tr>
					<th colspan='3'>".strtoupper($_SESSION['tablas'])." RESUMENES MES</th>
				</tr>");

		require 'ListFiles_While.php';
		
	}
	closedir($directorio);
	print("</table>");

} // FIN function listfiles

function delete(){ unlink($_POST['ruta']);
					print("<audio src='../audi/file_deleted.mp3' autoplay></audio>");
}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function master_index(){
		
	require '../Inclu_MInd/rutaupbbdd.php';
	require '../Inclu_MInd/Master_Index.php';
		
	} // FIN master_index

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>
