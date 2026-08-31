<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){

	master_index();

	if(isset($_POST['delete'])){ delete();
								 show_form();
								 listfiles();
	}elseif(isset($_POST['oculto2'])){	show_form();
								  		ver_todo();
							  			listfiles();
	}else{	show_form();
			listfiles();
	}
	
}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $db;				global $db_name;		global $defaults;
	
	if((isset($_POST['oculto1']))||(isset($_POST['oculto2']))||(isset($_POST['delete']))){
					$_SESSION['tablas'] = strtolower($_POST['tablas']);
					$defaults = array ('Orden' => isset($ordenar),
								   	   'tablas' => strtolower($_POST['tablas']),);
					// print($_SESSION['tablas']);
		if(($_SESSION['tablas'] == '')&&(!isset($_POST['delete']))){
			print("<div class='centradiv alertdiv'>SELECCIONE UNA TABLA</div>
					<audio src='../audi/bbdd1.mp3' autoplay></audio>");
		}
	}else{ 	unset($_SESSION['tablas']);
			print("<audio src='../audi/bbdd1.mp3' autoplay></audio>");
	}
	
	if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')){
		print("<table class='centradiv'>
				<tr>
					<td>EXPORTE TABLAS BBDD</td>
				</tr>		
				<tr>
					<td>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<input type='hidden' name='Orden' value='".@$defaults['Orden']."' />
						<select name='tablas' style='margin-right:0.4;vertical-align:middle;'>
				<!-- -->	<option value=''");
		if(@$defaults['tablas'] == ''){
					print ("selected = 'selected'");
		}
					print(">SELECCIONE UNA TABLA</option>
				<option value = 'admin'");
		if(@$defaults['tablas'] == 'admin'){
					print ("selected = 'selected'");
		}
					print(">Tabla Usuarios</option>
				<option value = 'horarios'");

		if(@$defaults['tablas'] == 'horarios'){
					print ("selected = 'selected'");
		}
					print(">Tablas Horarios</option>");

		print ("</select>
					<button type='submit' title='SELECCIONE USUARIO / TABLA' class='botonlila imgButIco InicioBlack' style='vertical-align:middle;' ></button>
						<input type='hidden' name='oculto1' value=1 />
						</form>	
					</td>
				</tr>
			</table>");
		
		global $ExportBotonera;		$ExportBotonera = 1;
		require 'Export_Botonera.php';

	}
	
			////////////////////		**********  		////////////////////

	if((isset($_POST['oculto1']))||(isset($_POST['todo']))){
			
		if($_SESSION['tablas'] != ''){

			global $nom; 			$nom = strtolower($_SESSION['tablas']);
			if(strtolower($_SESSION['tablas']) == 'admin'){ $nom = "%".$nom."%";
			}else{ $nom = "%".$nom."%"; }
			$nom = "LIKE '$nom' ";
	
			//$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES ";
			$consulta = "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom AND TABLE_NAME NOT LIKE '%visitasadmin%'";
			$respuesta = mysqli_query($db, $consulta);

			if(!$respuesta){
				print("* upbbdd/bbdd.php ERROR SQL L.103 ".mysqli_error($db)."</br>");
			}else{	
				print("<table class='TFormAdmin alertdiv'>
						<tr>
							<th colspan=2>
								TABLAS EXPORTABLES ".mysqli_num_rows($respuesta)."
							</th>
						</tr>
				<audio src='../audi/bbdd2.mp3' autoplay></audio>");

				$countbgc = 0;
				while ($fila = mysqli_fetch_row($respuesta)){
					if(($countbgc%2)==0){
						$bgcolor ="background-color: #59746a;";
					}else{ $bgcolor =""; }

					if($fila[0]){
						print("<tr>
							<td style='".$bgcolor."'>".$fila[0]."</td>
							<td style='".$bgcolor."'>
						<form name='exporta' action='$_SERVER[PHP_SELF]' method='POST'>
							<input type='hidden' name='tablas' value='".$defaults['tablas']."' />
							<input type='hidden' name='tabla' value='".$fila[0]."' />
				<button type='submit' title='EXPORTA TABLA ".strtoupper($fila[0])."' class='botonverde imgButIco OpenBlack' style='vertical-align:top;' ></button>
							<input type='hidden' name='oculto2' value=1 />
						</form>
							</td>
						<tr>");
					}
					$countbgc = $countbgc+1;
				} // FIN WHILE
				print("</table>");		
			}
		}
	}
	
} // FIN function show_fomr

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
	
		require 'export_bbdd.php';

}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function listfiles(){

	global $Audio;		$Audio = "bbdd4.mp3";
	require 'AudiDescarga.php';
	
	global $ruta;			$ruta ="bbdd/";

	global $directorio;		$directorio = opendir($ruta);
	global $num;			$num=count(glob("bbdd/{*}",GLOB_BRACE));
	
	if($num < 1){
		print ("<div class='centradiv alertdiv'>NO HAY ARCHIVOS PARA DESCARGAR</div>");
		if((@$_SESSION['tablas'] != '')&&(!isset($_POST['oculto1']))&&(!isset($_POST['delete']))){
			print("<audio src='../audi/no_file.mp3' autoplay></audio>");
		}
	}else{
		print ("<table class='TFormAdmin balresult' style='padding:0.2em;'>
				<tr>
					<th colspan='3'>ARCHIVOS RESPALDO BBDD</th>
				</tr>");
		
		require 'ListFiles_While.php';

	}

	closedir($directorio);
	print("</table>");

} // FIN function listfiles

function delete(){ 	unlink($_POST['ruta']);
					print("<audio src='../audi/bbdd5.mp3' autoplay></audio>");
				}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function master_index(){
		
	require '../Inclu_MInd/rutaupbbdd.php';
	require '../Inclu_MInd/Master_Index.php';
		
} /* Fin funcion master_index.*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* Creado por © Juan Barros Pazos 2020/26 Licencia CC BY-NC-SA */

?>