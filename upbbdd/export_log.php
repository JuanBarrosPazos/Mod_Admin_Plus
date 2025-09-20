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

	if(isset($_POST['delete'])){ delete();
								 show_form();
								 listfiles();
	}else{	show_form();
			listfiles();
	}
								
}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $db;				global $db_name;
	
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
		
		print("<table class='centradiv'>
				<tr>
					<td>EXPORT USER LOG</td>
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
				print("Modifique la entrada L.95 ".mysqli_error($db)."<br>");
		}else{
			while($rowu = mysqli_fetch_assoc($qu)){
					print ("<option value='".$rowu['ref']."' ");
					if($rowu['ref'] == $defaults['tablas']){
								print("selected = 'selected'");
					}
					print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
			}
		}  
			
		print ("</select>
					<button type='submit' title='SELECCIONE USUARIO' class='botonlila imgButIco InicioBlack' style='vertical-align:middle;' ></button>
					<input type='hidden' name='oculto1' value=1 />
				</form>	
			</td>
		</tr>
			</table>"); 
	}

	global $ExportBotonera;		$ExportBotonera = 3;
	require 'Export_Botonera.php';

}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function listfiles(){

	global $Audio;		$Audio = "file_exp_ok.mp3";
	require 'AudiDescarga.php';

	if(@$_SESSION['tablas'] == ''){ $_SESSION['tablas'] = $_SESSION['ref']; }
	//print("*".$_SESSION['tablas'].".</br>");

	global $ruta;			$ruta ="../Users/".$_SESSION['tablas']."/log/";
	//print("RUTA: ".$ruta.".</br>");
	
	global $rutag;			$rutag = "../Users/".$_SESSION['tablas']."/log/{*}";
	//print("RUTA G: ".$rutag.".</br>");
		
	global $directorio;		$directorio = opendir($ruta);
	global $num;			$num=count(glob($rutag,GLOB_BRACE));

	if($num < 1){
		print ("<div class='centradiv alertdiv'>NO HAY ARCHIVOS PARA DESCARGAR</div>");
		if(($_SESSION['tablas'] != '')&&((isset($_POST['oculto1'])))){
			print("<embed src='../audi/no_file.mp3' autostart='true' loop='false' ></embed>");
		}
	}else{
		if(isset($_POST['oculto1'])){
			print("<embed src='../audi/files_for_exp.mp3' autostart='true' loop='false' ></embed>");
		}
		print ("<table class='TFormAdmin' style='padding:0.2em;'>
				<tr>
					<th colspan='3'>".strtoupper($_SESSION['tablas'])." ARCHIVOS LOG</th>
				</tr>");

		require 'ListFiles_While.php';

	}
	closedir($directorio);
	print("</table>");
}

function delete(){ unlink($_POST['ruta']);
					print("<embed src='../audi/file_deleted.mp3' autostart='true' loop='false' ></embed>");
}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function master_index(){
		
	require '../Inclu_MInd/rutaupbbdd.php';
	require '../Inclu_MInd/Master_Index.php';
		
} // FIN funcion master_index

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';

					   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>
