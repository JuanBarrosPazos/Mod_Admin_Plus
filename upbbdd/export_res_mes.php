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

	global $db;
	
	if((isset($_POST['oculto1']))||(isset($_POST['delete']))){
				$_SESSION['tablas'] = $_POST['tablas'];
				$defaults = array ('Orden' => '`id` ASC',
								   'tablas' => $_POST['tablas'],);
		//print($_SESSION['tablas']);
	}else{	unset($_SESSION['tablas']);
				$defaults = array ('Orden' => '`id` ASC',
								   'tablas' => '',);
			print("<embed src='../audi/select_one_user.mp3' autostart='true' loop='false' ></embed>");
	}

	if($_SESSION['Nivel'] == 'admin'){
		print("
			<table class='centradiv'>
				<tr>
					<td>EXPORTE RESUMEN MENSUAL</td>
				</tr>		
				<tr>
					<td>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<input type='hidden' name='Orden' value='".$defaults['Orden']."' />
				<select name='tablas' style='margin-right:0.4;vertical-align:middle;'>");

			global $db;
			global $tablau;			$tablau = "`".$_SESSION['clave']."admin`";

			$sqlu =  "SELECT * FROM $tablau ORDER BY `ref` ASC ";
			$qu = mysqli_query($db, $sqlu);
			if(!$qu){
					print("Modifique la entrada L.60 ".mysqli_error($db)."<br>");
			}else{
				while($rowu = mysqli_fetch_assoc($qu)){
						print ("<option value='".$rowu['ref']."' ");
						if($rowu['ref'] == $defaults['tablas']){
											print ("selected = 'selected'");
						}
						print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
				}
			}  
			
		print ("</select>
					<button type='submit' title='SELECCIONE RESUMEN MENSUAL' class='botonlila imgButIco InicioBlack' style='vertical-align:middle;' ></button>
					<input type='hidden' name='oculto1' value=1 />
					</form>	
					</td>
				</tr>
			</table>");

	global $ExportBotonera;		$ExportBotonera = 2;
	require 'Export_Botonera.php';

	}
	
} // FIN function show_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function listfiles(){

	echo "<div id='audiDescarga'></div>";
	$embed = '<embed src="../audi/file_exp_ok.mp3" autostart="true" loop="false" ></embed>';
	$FunEmbed = "<script type='text/javascript'>
					function FunEmbed(){
						document.getElementById('audiDescarga').innerHTML = '".$embed."';
					}
				</script>";
	print($FunEmbed);
	
	if(@$_SESSION['tablas'] == ''){ $_SESSION['tablas'] = $_SESSION['ref']; }
	//print("*".$_SESSION['tablas'].".</br>");

	global $ruta;			$ruta ="../Users/".$_SESSION['tablas']."/mrficha/";
	//print("RUTA: ".$ruta.".</br>");
	
	global $rutag;			$rutag = "../Users/".$_SESSION['tablas']."/mrficha/{*}";
	//print("RUTA G: ".$rutag.".</br>");
		
	$directorio = opendir($ruta);
	global $num;			$num=count(glob($rutag,GLOB_BRACE));
	if($num < 1){
		print ("<div class='centradiv alertdiv'>NO HAY ARCHIVOS PARA DESCARGAR</div>");
		if(!isset($_POST['delete'])){
			print("<embed src='../audi/no_file.mp3' autostart='true' loop='false' ></embed>");
		}
	}else{
		if(isset($_POST['oculto1'])){
			print("<embed src='../audi/files_for_exp.mp3' autostart='true' loop='false' ></embed>");
		}
		print ("<table class='TFormAdmin' style='padding:0.2em;'>
				<tr>
					<th colspan='3'>".strtoupper($_SESSION['tablas'])." RESUMENES MES</th>
				</tr>");

		$countbgc = 0;
		while($archivo = readdir($directorio)){

			if(($countbgc%2)==0){
				$bgcolor ="background-color:#59746A;";
			}else{ $bgcolor =""; }

			if($archivo != ',' && $archivo != '.' && $archivo != '..'){
				print("<tr>
				<td style='".$bgcolor."'>
					<form name='delete' action='$_SERVER[PHP_SELF]' method='post'>
						<input type='hidden' name='tablas' value='".$_SESSION['tablas']."' />
						<input type='hidden' name='ruta' value='".$ruta.$archivo."'>
				<button type='submit' title='ELIMINAR ".strtoupper($archivo)."' class='botonrojo imgButIco DeleteBlack' style='vertical-align:top;' ></button>
						<input type='hidden' name='delete' value='1' >
					</form>
				</td>
				<td style='".$bgcolor."'>
					<form name='archivos' action='".$ruta.$archivo."' target='_blank' method='post'>
						<input type='hidden' name='tablas' value='".$_SESSION['tablas']."' />
				<button type='submit' title='DESCARGAR ".strtoupper($archivo)."' class='botonverde imgButIco DescargaBlack' style='vertical-align:top;' onclick='FunEmbed()' ></button>
					</form>
				</td>
				<td style='".$bgcolor."'>".strtoupper($archivo)."</td>");
			}else{}
			$countbgc = $countbgc+1;
		} // FIN DEL WHILE
	}
	closedir($directorio);
	print("</table>");

} // FIN function listfiles

function delete(){ unlink($_POST['ruta']);
					print("<embed src='../audi/file_deleted.mp3' autostart='true' loop='false' ></embed>");
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
