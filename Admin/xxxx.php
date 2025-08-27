<?php

function validate_form(){
	
	/*	global $sqld;		global $qd;			global $rowd;	*/
		
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
	print( "<table class='TFormAdmin' style='margin-top:10px'>
				<tr>
					<th colspan=3 class='BorderInf'>
						SE HA REGISTRADO CON ESTOS DATOS.
					</th>
				</tr>");
	
	global $rutaimg;				$rutaimg = "src='".$carpetaimg."/".$new_name."'";
	require 'table_data_resum.php';

	print("<tr>
			<td colspan=3 class='BorderSup'>
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
		print ($redir);

	}else{ 	print("</br>ERROR SQL L.102 ".mysqli_error($db))."</br>";
			show_form ();
	}

} // FIN function process_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function y(){
	
	global $trf;					$trf = $_SESSION['iniref'];
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
	
	global $db_name; 	global $db;	 	global $dbconecterror;
	global $trf;		$trf = $_SESSION['iniref'];
	
// CREA EL DIRECTORIO DE USUARIO.

	global $carpeta;
	$carpeta = "../Users/".$trf;

	if (!file_exists($carpeta)) {
		mkdir($carpeta, 0777, true);
		$data1 = "\t* OK DIRECTORIO USUARIO ".$carpeta."\n";
	}else{
		//print("* NO OK DIRECTORIO ".$carpeta."\n");
		$data1 = "\t* NO OK DIRECTORIO USUARIO ".$carpeta."\n";
	}

	if (file_exists($carpeta)){
		copy("../Images/untitled.png", $carpeta."/untitled.png");
		copy("../Images/pdf.png", $carpeta."/pdf.png");
		copy("../config/ayear_Init_System.php", $carpeta."/ayear.php");
		copy("../config/year.txt", $carpeta."/year.txt");
		copy("../config/SecureIndex2.php", $carpeta."/index.php");
		global $data1;			$data1 = $data1."\t* OK USER SYSTEM FILES ".$carpeta."\n";
		y();
		modif();
	}else{
		print("* NO OK USER SYSTEM FILES ".$carpeta."\n");
		global $data1;			$data1 = $data1."\t* NO OK USER SYSTEM FILES".$carpeta."\n";
		}

	/************** CREAMOS LA TABLA CONTROL USUARIO ***************/

	$vname1 = $_SESSION['clave'].$trf."_".date('Y');
	$vname1 = "`".$vname1."`";
	
	$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname1 (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL,
  `Nombre` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `Apellidos` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `din` varchar(10) collate utf16_spanish2_ci NOT NULL,
  `tin` time NOT NULL,
  `dout` varchar(10) collate utf16_spanish2_ci NULL,
  `tout` time NULL,
  `ttot` time NULL,
  `del` varchar(5) NOT NULL default 'false',
  `dfeed` varchar(10) collate utf16_spanish2_ci NULL,
  `tfeed` time NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db , $tcl)){
		global $data5;			$data5 = "\t* OK TABLA FICHAR ".$vname1.".\n";
	}else{
		global $data5;			$data5 = "\t* NO OK TABLA FICHAR. ".mysqli_error($db)." \n";
	}

	/************** CREAMOS LA TABLA FEEDBACK CONTROL USUARIO ***************/

	$vname1 = $_SESSION['clave'].$trf."_feed";
	$vname1 = "`".$vname1."`";
	
	$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname1 (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL,
  `Nombre` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `Apellidos` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `din` varchar(10) collate utf16_spanish2_ci NOT NULL,
  `tin` time NOT NULL,
  `dout` varchar(10) collate utf16_spanish2_ci NULL,
  `tout` time NULL,
  `ttot` time NULL,
  `dfeed` varchar(10) collate utf16_spanish2_ci NULL,
  `tfeed` time NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
if(mysqli_query($db , $tcl)){
	global $data6;			$data6 = "\t* OK TABLA FEED FICHAR ".$vname1.".\n";
}else{
	global $data6;			$data6 = "\t* NO OK TABLA FEED FICHAR. ".mysqli_error($db)." \n";
}

	// CREA EL DIRECTORIO DE IMAGEN DE USUARIO.
	$vn1 = "img_admin";
	$carpetaimg = "../Users/".$trf."/".$vn1;
	if (!file_exists($carpetaimg)) {
		mkdir($carpetaimg, 0777, true);
		copy("../Images/untitled.png", $carpetaimg."/untitled.png");
		$data2 = "\t* OK DIRECTORIO ".$carpetaimg." \n";
	}else{print("* NO OK DIRECTORIO ".$carpetaimg."\n");
		$data2 = "\t* NO OK DIRECTORIO ".$carpetaimg."\n";
	}
	
	// CREA EL DIRECTORIO DE LOG DE USUARIO.
	$vn1 = "log";
	$carpetalog = "../Users/".$trf."/".$vn1;
	if (!file_exists($carpetalog)) {
		mkdir($carpetalog, 0777, true);
		$data3 = "\t* OK DIRECTORIO ".$carpetalog."\n";
	}else{print("* NO OK EL DIRECTORIO ".$carpetalog."\n");
		$data3 = "\t* NO OK DIRECTORIO ".$carpetalog."\n";
	}
	
	// CREA EL DIRECTORIO RESUMEN FICHAR MES.
	$vn1 = "mrficha";
	$carpetamrf = "../Users/".$trf."/".$vn1;
	if (!file_exists($carpetamrf)) {
		mkdir($carpetamrf, 0777, true);
		$data4 = "\t* OK DIRECTORIO ".$carpetamrf."\n";
	}else{print("* NO OK DIRECTORIO ".$carpetamrf."\n");
		$data4= "\t* NO OK DIRECTORIO ".$carpetamrf."\n";
	}

	/************	PASAMOS LOS PARAMETROS A .LOG	*****************/
	
	$datein = date('Y-m-d/H:i:s');
	
	global $dir;			$dir = "../Users/".$_SESSION['ref']."/log";

	$logdocu = $_SESSION['ref'];
	$logdate = date('Y_m_d');
	$logtext = PHP_EOL."- NUEVO USUARIO CREADAS BBDD TABLAS Y DIRECTORIOS. ".$datein.PHP_EOL." ".$dbconecterror.$data1.$data2.$data3.PHP_EOL;
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

} // FIN function crear_tablas

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
	}else{$defaults = array ( 'Nombre' => '','Apellidos' => '','Nivel' => '',
								'ref' => '','doc' => '','dni' => '',
								'ldni' => '','Email' => '','Usuario' => '',
								'Usuario2' => '','Password' => '','Password2' => '',
								'Direccion' => '','Tlf1' => '','Tlf2' => '');
	}
	
	if ($errors){
		print("	<table align='center'>
					<tr>
						<th style='text-align:center>
							<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font><br/>
						</th>
					</tr>
					<tr>
						<td style='text-align:left'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#F1BD2D'>**</font>  ".$errors [$a]."<br/>");
			}
		print("</td>
				</tr>
				</table>");
	}
		
	$Nivel = array( '' => 'NIVEL USUARIO',
					'admin' => 'ADMINISTRADOR',
					'plus' => 'USER PLUS',
					'user'  => 'USER',
					'close'  => 'CLOSE',);														

	$doctype = array('DNI' => 'DNI/NIF Espa&ntilde;oles',
					 'NIE' => 'NIE/NIF Extranjeros',
					 'NIFespecial' => 'NIF Persona F&iacute;sica Especial',
						/*
						'NIFsa' => 'NIF Sociedad An&oacute;nima',
						'NIFsrl' => 'NIF Sociedad Responsabilidad Limitada',
						'NIFscol' => 'NIF Sociedad Colectiva',
						'NIFscom' => 'NIF Sociedad Comanditaria',
						'NIFcbhy' => 'NIF Comunidad Bienes y Herencias Yacentes',
						'NIFscoop' => 'NIF Sociedades Cooperativas',
						'NIFasoc' => 'NIF Asociaciones',
						'NIFcpph' => 'NIF Comunidad Propietarios Propiedad Horizontal',
						'NIFsccspj' => 'NIF Sociedad Civil, con o sin Personalidad Juridica',
						'NIFee' => 'NIF Entidad Extranjera',
						'NIFcl' => 'NIF Corporaciones Locales',
						'NIFop' => 'NIF Organismo Publico',
						'NIFcir' => 'NIF Congragaciones Instituciones Religiosas',
						'NIFoaeca' => 'NIF Organos Admin Estado y Comunidades Autonomas',
						'NIFute' => 'NIF Uniones Temporales de Empresas',
						'NIFotnd' => 'NIF Otros Tipos no Definidos',
						'NIFepenr' => 'NIF Establecimientos Permanentes Entidades no Residentes',
						*/);
	
////////////////////				////////////////////				////////////////////

	global $db;				global $db_name;

	global $table_name_a;	$table_name_a = "`".$_SESSION['clave']."admin`";

	$nu =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` <> '$_SESSION[mydni]'";
	$user = mysqli_query($db, $nu);
	//$ruser = mysqli_fetch_assoc($user);
	$nuser = mysqli_num_rows($user);
	
	require 'Admin_Botonera.php';

	if($nuser >= $_SESSION['nuser']){ 
		print("<table align='center' style=\"margin-top:10px;margin-bottom:170px\">
				<tr align='center'>
					<td>
						<b>
							<font color='red'>ACCESO RESTRINGIDO</font>	
						</b>
				</br>
		EMPLEADOS PERMITIDOS: ".$_SESSION['nuser'].". Nº EMPLEADOS: ".$nuser.". PARA CONTINUAR:
					</br>
		ELIMINE ALGUN EMPLEADO EN BORRAR BAJAS O DAR DE BAJA.
						</td>
					</tr>
			</table>");
	}else{
		print("<table class='TFormAdmin'>
				<tr>
					<th colspan=2>NUEVO ADMINISTRADOR</th>
				</tr>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'  enctype='multipart/form-data'>
				<tr>
					<td>NOMBRE:</td>
					<td>
		<input type='text' name='Nombre' size=28 maxlength=25 pattern='[a-zA-Z\s]{3,25}' placeholder='MI NOMBRE' value='".$defaults['Nombre']."' required />
					</td>
				</tr>
				<tr>
					<td>APELLIDOS:</td>
					<td>
		<input type='text' name='Apellidos' size=28 maxlength=25 pattern='[a-zA-Z\s]{3,25}' placeholder='MIS APELLIDOS' value='".$defaults['Apellidos']."' required />
					</td>
				</tr>
				<tr>
					<td>DOCUMENTO:</td>
					<td>
		<select name='doc' required >");
				foreach($doctype as $option => $label){
					print ("<option value='".$option."' ");
					if($option == $defaults['doc']){print ("selected = 'selected'");}
													print ("> $label </option>");
												}	
		print ("</select>
					</td>
				</tr>
				<tr>
					<td>N&Uacute;MERO:</td>
					<td>
		<input type='text' name='dni' size=12 maxlength=8 pattern='[0-9]{8,8}' placeholder='NUM. DOC.' value='".$defaults['dni']."' required />
					</td>
				</tr>
				<tr>
					<td>CONTROL:</td>
					<td>
		<input type='text' name='ldni' size=4 maxlength=1 pattern='[A-Z]{1,1}' value='".$defaults['ldni']."' required />
					</td>
				</tr>
				<tr>
					<td>MAIL:</td>
					<td>
		<input type='mail' name='Email' size=32 maxlength=50 placeholder='MI EMAIL EN MINUSCULAS' value='".$defaults['Email']."' required />
					</td>
				</tr>	
				<tr>
					<td>NIVEL USER:</td>
					<td>
		<select name='Nivel' required >");
			foreach($Nivel as $optionnv => $labelnv){
				print ("<option value='".$optionnv."' ");
				if($optionnv == $defaults['Nivel']){ print ("selected = 'selected'");}
													 print ("> $labelnv </option>");
						}	
	print ("</select>
					</td>
				</tr>
				<tr>
					<td>USER NICK:</td>
					<td>
		<input type='text' name='Usuario' size=12 maxlength=10 pattern='[a-z A-Z 0-9\s]{3,10}' placeholder='MI NICK' value='".$defaults['Usuario']."' required />
					</td>
				</tr>
				<tr>
					<td>USER NICK:</td>
					<td>
		<input type='text' name='Usuario2' size=12 maxlength=10 pattern='[a-z A-Z 0-9\s]{3,10}' placeholder='MI NICK' value='".$defaults['Usuario2']."' required />
					</td>
				</tr>
				<tr>
					<td>PASSWORD:</td>
					<td>
		<input type='text' name='Password' size=12 maxlength=10 pattern='[a-z A-Z 0-9\s]{3,10}' placeholder='MI PASSWORD' value='".$defaults['Password']."' required />
					</td>
				</tr>
				<tr>
					<td>PASSWORD:
					</td>
					<td>
		<input type='text' name='Password2' size=12 maxlength=10 pattern='[a-z A-Z 0-9\s]{3,10}' placeholder='MI PASSWORD' value='".$defaults['Password2']."' required />
					</td>
				</tr>
				<tr>
					<td>DIRECCION:</td>
					<td>
		<input type='text' name='Direccion' size=32 maxlength=60 placeholder='MI DIRECCION' value='".$defaults['Direccion']."' required />
					</td>
				</tr>
				<tr>
					<td> TELEFONO 1:</td>
					<td>
		<input type='text' name='Tlf1' size=12 maxlength=9 pattern='[0-9]{9,9}' placeholder='TELEFONO 1' value='".$defaults['Tlf1']."' required />
					</td>
				</tr>
				<tr>
					<tr>
					<td>TELEFONO 2:</td>
					<td>
		<input type='text' name='Tlf2' size=12 maxlength=9 pattern='[0-9\s]{9,9}' placeholder='TELEFONO 2' value='".$defaults['Tlf2']."' />
					</td>
				</tr>
				<tr>
					<td colspan='2'>
			<button type='submit' title='GUARDAR DATOS' class='botonverde imgButIco SaveBlack' style='vertical-align:top;' ></button>
			<input type='hidden' name='oculto' value=1 />
		</form>".$inicioadmin."
					</td>
				</tr>
			</table>"); 
	} // FIN CONDICIONAL NUMERO USUARIOS
	
} // FIN function show_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		require '../Inclu_MInd/rutaadmin.php';
		require '../Inclu_MInd/Master_Index.php';
		
	} 


?>