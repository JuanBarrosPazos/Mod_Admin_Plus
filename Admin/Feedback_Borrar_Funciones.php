<?php

function process_form(){
	
	global $db; 	global $db_name;
	
	global $nombre; 		$nombre = $_POST['Nombre'];
	global $apellido;		$apellido = $_POST['Apellidos']; 
	global $table_name_f;	$table_name_f = "`".$_SESSION['clave']."admin`";
	
	global $sql;
	$sql = "DELETE FROM `$db_name`.$table_name_f WHERE $table_name_f.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $sql)){
		print("<table class='TFormAdmin'>
				<tr>
					<th colspan=3>DATOS ELEMINADOS</th>
				</tr>");
	
		require 'Admin_Botonera.php';
		global $rutaimg;
		$rutaimg = "src='../Users/temp/".$_POST['myimg']."'";
		//$rutaimg = "src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."'";
		require 'tabla_data_resum.php';

		print("<tr>
				<td colspan=3>".$inicioadmin.$inciobajas."</td>
			</tr>
		</table>"); // SE IMPRIME LA TABLA DE CONFIRMACION

	/*************	BORRAMOS DIRECTORIO DE USUARIO	***************/
	
	$_SESSION['iniref'] = $_POST['ref'];
	global $refnorm;	$refnorm = $_POST['ref'];
	// BORRA DIRECTORIOS DENTRO DEL USUARIO
	// BORRADO DATOS EN SUBDIRECTORIOS USUARIOS
	$carpeta1 = "../Users/".$refnorm."/img_admin";
	if(file_exists($carpeta1)){	$dir1 = $carpeta1."/";
								$handle1 = opendir($dir1);
								while($file1 = readdir($handle1)){
									if(is_file($dir1.$file1)){
										unlink($dir1.$file1);
									}
								}	
								rmdir (	$carpeta1);
								global $dd1;		$dd1 = "\t- BORRADA: ".$carpeta1."/ \n";
	}else{ print(""); }

	$carpeta2 = "../Users/".$refnorm."/log";
	if(file_exists($carpeta2)){	$dir2 = $carpeta2."/";
								$handle2 = opendir($dir2);
								while($file2 = readdir($handle2)){
									if(is_file($dir2.$file2)){
										unlink($dir2.$file2);
									}
								}	
								rmdir (	$carpeta2);
								global $dd2; 		$dd2 = "\t- BORRADA: ".$carpeta2."/ \n";
	}else{ print(""); }
	
	$carpeta3 = "../Users/".$refnorm."/mrficha";
	if(file_exists($carpeta3)){ $dir3 = $carpeta3."/";
								$handle3 = opendir($dir3);
								while($file3 = readdir($handle3)){
									if(is_file($dir3.$file3)){
										unlink($dir3.$file3);
									}
								}
								rmdir ($carpeta3);
								global $dd2; 		$dd2 .= "\t- BORRADA: ".$carpeta3."/ \n";
	}else{ print(""); }
	// FIN BORRA DIRECTORIOS DENTRO DEL USUARIO
	// FIN BORRADO DATOS EN SUBDIRECTORIOS USUARIOS

	/*************	BORRAMOS TODAS LAS TABLAS DEL USUARIO 	***************/

	/* Se busca las tablas en la base de datos */
	/* REFERENCIA DEL USUARIO O $_SESSION['iniref'] = $_POST['ref'] */
	/* $nom PARA LA CLAVE USUARIO ACOMPAÑANDA DE _ O NO */
	global $db;		global $db_name;
	global $nom;	$nom = strtolower($_POST['ref']);
	$nom = $_SESSION['clave'].$_POST['ref']."%"; // SOLO COINCIDEN AL PRINCIPIO
	$nom = "LIKE '$nom'";
	//$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME $nom ";
	$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom ";
	$respuesta = mysqli_query($db, $consulta);
	//$count = mysqli_num_rows($respuesta);
	//print("* NUMERO TABLAS: ".$count."<br>");
	//print("* CLAVE TABLA USUARIO: ".$nom."<br>");

	//global $fila;
	//$fila = mysqli_fetch_row($respuesta);

	global $tx1;		global $deletet2;

	if(!$respuesta){
		print("ERROR SQL L.85 ".mysqli_error($db)."</br>");
	}else{ 
		while($fila = mysqli_fetch_row($respuesta)){
			if($fila[0]){
		/* PROCEDEMOS A BORRAR LAS TABLAS DEL USUARIO */
				global $sqlt1; 		$sqlt1 = "DROP TABLE `$db_name`.`$fila[0]` ";
				if(mysqli_query($db, $sqlt1)){
				// SE PASAN PARAMETROS A .LOG
					$tx1 = "\t* HA BORRADO LA TABLA ".$fila[0]."\n";
					$deletet2 = $deletet2.$tx1;
				}else{
					$tx1 = "\t* ".mysqli_error($db)."\n";
					print ("<font color='#F1BD2D'>*** </font></br> ".mysqli_error($db).".</br>");
					$deletet2 = $tx1;
				} 
		/* HASTA AQUI BORRA TABLAS Y PASA LOS LOG DE BBDD */
			} // FIN IF $FILA[0]
		} // FIN WHILE

		// SE GRABAN LOS DATOS EN LOG DEL ADMIN
		global $deletet;	$deletet = $dd1.$dd2."\n".$deletet2;
		
	} // FIN ELSE !$respuesta

	// FIN PRIMER IF SI SE CUMPLE EL QUERY BORRA EL USER DE LA BBDD
	}else{
		// FIN BORRADO OK
		// => ELSE BORRADO NO OK PRIMER QUERY			
		print("ERROR SQL L.88 ".mysqli_error($db))."</br>";
		show_form ();
	}

	global $redir;
	$redir = "<script type='text/javascript'>
				function redir(){
					window.location.href='Feedback_Ver.php';
				}
				setTimeout('redir()',10000);
			</script>";
	print($redir);

} // FIN function process_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function deletedir(){
	
	// BORRA EL CONTENIDO DEL DIRECTORIO DEL USUARIO, SUBDIRECTORIOS...

	global $refnorm; 	$refnorm = $_SESSION['iniref'];
	$carpeta0 = "../Users/".$refnorm;

	if(file_exists($carpeta0)){ $dir0 = $carpeta0."/";
								$handle0 = opendir($dir0);
						while($file0 = readdir($handle0)){
							if(is_file($dir0.$file0)){
								unlink($dir0.$file0);
							}
						}
						//rmdir($carpeta0);
						global $dd0;	$dd0 = "\t- BORRADO CONTENIDO: ".$carpeta0."/ \n";
	}else{ print(""); }
								
	global $ddr;	$ddr = $dd0;

} // FIN FUNCTION deletedir()

function deleteUserDir(){
	// BORRA EL DIRECTORIO DEL USUARIO...
	global $refnorm; 	$refnorm = $_SESSION['iniref'];
	$carpeta0 = "../Users/".$refnorm;
	if(file_exists($carpeta0)){ rmdir($carpeta0); }else{ }
	global $ddr;	$ddr = $ddr."\t- BORRADA: ".$carpeta0."/ \n";
}
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
		
	global $ctemp; 		$ctemp = "../Users/temp";
	global $imgorg; 	$imgorg = "../Users/".$_POST['ref']."/img_admin/".$_POST['myimg'];
				
	if(!file_exists($ctemp)) {
		mkdir($ctemp, 0777, true);
		copy($imgorg, $ctemp."/".$_POST['myimg']);
	}else{
		copy($imgorg, $ctemp."/".$_POST['myimg']);
			}

	global $array_a;
	if(isset($_POST['oculto2'])){	$_SESSION['sref'] = $_POST['ref'];
									$array_a = 1;
									require 'admin_array_total.php'; 
	}

	if(isset($_POST['borrar'])){  	$array_a = 1;
									require 'admin_array_total.php'; }
								   
		print("<table class='TFormAdmin'>
			<tr>
				<th colspan=3>
					<div style='display:inline-block; margin-top:0.4em; color:#F1BD2D;'>
						DATOS A ELIMINAR
					</div>
					<a href='Feedback_Ver.php' >
				<button type='button' title='INICIO ADMIN PAPELERA' class='botonlila imgButIco HomeBlack' style='vertical-align:top;float:right;' ></button>
				</th>
			</tr>
				
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>");
			
		require 'admin_input_default.php';
		global $rutaimg;
		//$rutaimg = "src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."'";
		$rutaimg = "src='../Users/".$_SESSION['sref']."/img_admin/".$_POST['myimg']."'";
		require 'tabla_data_resum.php';

	print("<tr>
			<td colspan='3'>
				<button type='submit' title='BORRAR DATOS PERMANENTEMENTE' class='botonrojo imgButIco DeleteBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='borrar' value=1 />
		</form>
				<a href='Feedback_Ver.php' >
					<button type='button' title='INICIO ADMIN PAPELERA' class='botonlila imgButIco HomeBlack' style='vertical-align:top;float:right;' ></button>
				</a>
			</td>
				</tr>
			</table>");
	
	} // FIN FUNCTION show_form()

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

	global $rf; 		$rf = @$_POST['ref'];
	global $nombre; 	$nombre = @$_POST['Nombre'];
	global $apellido; 	$apellido = @$_POST['Apellidos'];
	global $dir; 	$dir = "../Users/".$_SESSION['ref']."/log";
	global $InfoLog; 	global $InfoLogB;
		
	$ActionTime = date('H:i:s');

	global $text;
	$text = PHP_EOL.$InfoLog.$ActionTime.PHP_EOL."\t Nombre: ".$nombre." ".$apellido.PHP_EOL."\t Ref: ".$rf.". Nivel: ".$_POST['Nivel'].PHP_EOL."\t User: ".$_POST['Usuario'].". Pass: ".$_POST['Pass'].$InfoLogB;

	require 'log_write.php';

} // FIN FUNCTION UserLog()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>