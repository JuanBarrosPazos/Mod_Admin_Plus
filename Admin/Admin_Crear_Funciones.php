<?php

function validate_form(){
	
	/*
		global $sqld;
		global $qd;
		global $rowd;
	*/
		
	require '../Inclu/validate.php';	
		
	return $errors;

} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db; 	global $db_name;
	
	/*	REFERENCIA DE USUARIO	*/
	global $rf1;	global $rf2;	global $rf3;	global $rf4;

	if(preg_match('/^(\w{1})/',$_POST['Nombre'],$ref1)){ $rf1 = $ref1[1];
														$rf1 = trim($rf1);
														/*print($ref1[1]."</br>");*/
		}
	if(preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Nombre'],$ref2)){	$rf2 = $ref2[2];
																	$rf2 = trim($rf2);
																	/*print($ref2[2]."</br>");*/
		}
	if(preg_match('/^(\w{1})/',$_POST['Apellidos'],$ref3)){	$rf3 = $ref3[1];
															$rf3 = trim($rf3);
																/*print($ref3[1]."</br>");*/
		}
	if(preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Apellidos'],$ref4)){ $rf4 = $ref4[2];
																	$rf4 = trim($rf4);
																	/*print($ref4[2]."</br>");*/
		}

	global $rf;			$rf = $rf1.$rf2.$rf3.$rf4.$_POST['dni'].$_POST['ldni'];
	$rf = trim($rf);	$rf = strtolower($rf);
	$_SESSION['iniref'] = $rf;

	/**************************************/

		crear_tablas();

	/**************************************/

	// CREA IMAGEN DE USUARIO.
	global $trf;				$trf = $_SESSION['iniref'];
	global $vn1;				$vn1 = "img_admin";
	global $carpetaimg;			$carpetaimg = "../Users/".$trf."/".$vn1;
	global $new_name;			$new_name = $trf.".png";
	copy("../Images/untitled.png", $carpetaimg."/".$new_name);

	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];
	
	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";

	global $password;			$password = $_POST['Password'] ;
	global $passwordhash;
	$passwordhash = password_hash($password, PASSWORD_DEFAULT, array ( "cost"=>10));

	global $db_name;

	$sql = "INSERT INTO `$db_name`.$table_name_a (`ref`, `Nivel`, `Nombre`, `Apellidos`, `myimg`, `doc`, `dni`, `ldni`, `Email`, `Usuario`, `Password`, `Pass`, `Direccion`, `Tlf1`, `Tlf2`) VALUES ('$rf', '$_POST[Nivel]', '$_POST[Nombre]', '$_POST[Apellidos]', '$new_name', '$_POST[doc]', '$_POST[dni]', '$_POST[ldni]', '$_POST[Email]', '$_POST[Usuario]', '$passwordhash', '$password', '$_POST[Direccion]', '$_POST[Tlf1]', '$_POST[Tlf2]')";
		
	require 'Admin_Botonera.php';

	if(mysqli_query($db, $sql)){
		
	/*	$fil = "%".$rf."%";
		$pimg =  "SELECT * FROM `$db_name`.$table_name_a WHERE `ref` = '$rf' ";
		$qpimg = mysqli_query($db, $pimg);
		$rowpimg = mysqli_fetch_assoc($qpimg);
		$_SESSION['dudas'] = $rowpimg['myimg'];
		global $dudas;
		$dudas = trim($_SESSION['dudas']);
		print("** ".$rowpimg['myimg']);
	*/
	print( "<table class='TFormAdmin'>
				<tr>
					<th colspan=3>
						DATOS DE REGISTRO
					</th>
				</tr>");
	
	global $rutaimg;				$rutaimg = "src='".$carpetaimg."/".$new_name."'";
	require 'tabla_data_resum.php';

	print("<tr>
			<td colspan=3>
			".$inicioadmin.$inicioadmincrear."
			</td>
		</tr>
	</table>");

	$datein = date('Y-m-d/H:i:s');
	
	global $dir;				$dir = "../Users/".$_SESSION['ref']."/log";

	$logdocu = $_SESSION['ref'];
	$logdate = date('Y_m_d');
	$logtext = PHP_EOL."- CREADO NUEVO USUARIO ".$datein.PHP_EOL."\t User Ref: ".$rf.PHP_EOL."\t Name: ".$_POST['Nombre']." ".$_POST['Apellidos'].PHP_EOL."\t User: ".$_POST['Usuario'].PHP_EOL."\t Pass: ".$_POST['Password'].PHP_EOL;
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

		global $redir;
		$redir = "<script type='text/javascript'>
					function redir(){
						window.location.href='Admin_Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print($redir);

	}else{ 	print("</br>ERROR SQL L.102 ".mysqli_error($db))."</br>";
			show_form();
	}

} // FIN function process_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function y(){
	
	global $trf;
	$trf = $_SESSION['iniref'];
	$carpeta = "../Users/".$trf;
	$filename = $carpeta."/ayear.php";
	$fw1 = fopen($filename, 'r+');
	$contenido = fread($fw1,filesize($filename));
	fclose($fw1);
	$contenido = explode("\n",$contenido);
	$contenido[2] = "'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',";
	$contenido = implode("\n",$contenido);
	//fseek($fw, 37);
	$fw = fopen($filename, 'w+');
	fwrite($fw, $contenido);
	fclose($fw);
}

function modif(){

	$filename = "../Users/".$_SESSION['iniref']."/year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);
}

function crear_tablas(){
	
	global $db;	 		global $db_name; 	global $db_host;	global $db_user;
	global $db_pass; 	global $dbconecterror;
	
	global $trf; 	$trf = $_SESSION['iniref'];
	
	global $rutCreaTablas; 	$rutCreaTablas = "../config/";
	require 'admin_crea_tablas.php';
	
	/************	PASAMOS LOS PARAMETROS A .LOG	*****************/
	
	$datein = date('Y-m-d H:i:s');
	
	global $dir;
	$dir = "../Users/".$_SESSION['ref']."/log";

	global $text;
	$text = PHP_EOL."** NUEVO USUARIO CREADOS DIRECTORIOS. ".$datein.PHP_EOL." ".$dbconecterror.$data1.$data2.$data3.$data4.$data5.$data6.PHP_EOL;

	require 'log_write.php';

} // FIN FUNCTION CREAR_TABLAS	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	require 'admin_array_total.php';
	
	if(isset($_POST['oculto'])){
			$defaults = $_POST;
	}else{	global $array_cero;		$array_cero = 1; 
			require 'admin_array_total.php';
	}
	
	require 'tabla_errors.php';

	global $array_nive_doc;		$array_nive_doc = 1;
	require 'admin_array_total.php';

	global $db;				global $db_name;
	global $table_name_a;	$table_name_a = "`".$_SESSION['clave']."admin`";

	//$nu =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` <> '$_SESSION[mydni]'";
	//$nu =  "SELECT * FROM `$db_name`.$table_name_a";
	$nu =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`Nivel` <> 'wmaster'";
	$user = mysqli_query($db, $nu);
	//$nuser = (mysqli_num_rows($user))-1; // NO SE CUENTA EL WEBMASTER...
	$nuser = (mysqli_num_rows($user)); // NO SE CUENTA NINGÚN WEBMASTER...

	if($nuser >= $_SESSION['nuser']){ 
		print("<div class='centradiv alertdiv'>
					<font color='red'>ACCESO RESTRINGIDO</font>	
				</br>
		EMPLEADOS PERMITIDOS: ".$_SESSION['nuser'].".<br>Nº EMPLEADOS: ".$nuser.".<br>
		ELIMINE EMPLEADOS O LIMPIE<br> LA PAPELERA DE EMPLEADOS.
				</div>");
	
		global $redir;
		$redir = "<script type='text/javascript'>
					function redir(){
						window.location.href='Admin_Ver.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print($redir);

	}else{
		require 'tabla_crea_admin.php';
	} // FIN CONDICIONAL NUMERO USUARIOS
	
} // FIN function show_form

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

?>