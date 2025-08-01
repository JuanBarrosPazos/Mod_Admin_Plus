<?php
session_start();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	global $playini;		$playini = 1;

	require 'Inclu/error_hidden.php';
	require 'Inclu/Admin_head.php';
	require 'Inclu/webmaster.php';
	require 'Conections/conection.php';
	require 'Conections/conect.php';
	require 'Inclu/my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	
	desbloqueo();
	
	if(isset($_POST['oculto'])){
		if($form_errors = validate_form()){
						suma_denegado();
						show_form2();
						if($_SESSION['showf'] == 69){table_desblock();}
						else{show_form($form_errors);
							 show_visit();}
		}else{ require 'Inclu/Only.index.php'; 
				process_form();
				show_ficha();
				errors();
		}
	// FIN POST OCULTO
	}elseif(isset($_POST['ocultop'])){
					
		if($form_errorsp = validate_formp()){
				show_form2($form_errorsp);
				if($_SESSION['showf'] == 69){
					table_desblock();
				}else{
					show_form(@$form_errors);
				}
				show_visit();
		}else{	process_pin();
				//ayear();
		}

	}elseif(isset($_POST['entrada'])){	pin_in();
										//errors();

	}elseif(isset($_POST['salida'])){	pin_out();
										//errors();

	}elseif (isset($_POST['cancel'])) {	show_form2();
										if($_SESSION['showf'] == 69){table_desblock();
										}else{	show_form(@$form_errors);
												show_visit();
										}

	}elseif(isset($_GET['ocultop'])){ 	process_pin();
							  		 	//ayear();
							  		 	errors();

	}elseif(isset($_GET['pin']) != ''){ process_pin();
									   	//ayear();
							 		   	errors();

	}elseif (isset($_GET['salir'])) { 	salir();
									 	show_form2();
									 	show_form();
									 	show_visit();
									 	session_destroy();
	}else{	show_form2();
			if($_SESSION['showf'] == 69){
				table_desblock();
			}else{
				show_form(@$form_errors);
				show_visit();
			}
			suma_visit();
			bbdd_backup();
	}
				
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function bbdd_backup(){
	
	global $db; 	global $db_name;
	
	global $dated; 		$dated = date('d');
	global $datem; 		$datem = date('m');
	global $datey; 		$datey = date('Y'); 
	global $datebbddx; 	$datebbddx = date("Ymd");
	
	// SI HAY MAS DE OCHO COPIAS DE SEGURIDAD BORRARLAS.
	global $ruta; 		$ruta ="upbbdd/bbdd_export_tot"; 
	//print("RUTA: ".$ruta.".</br>");
	global $rutag; 		$rutag = "upbbdd/bbdd_export_tot/{*}";
	//print("RUTA G: ".$rutag.".</br>");
	$directorio = opendir($ruta);
	global $num; 		$num=count(glob($rutag,GLOB_BRACE));
	
	if($num > 8){	if(file_exists($ruta)){ $dir = $ruta."/";
			$handle = opendir($dir);
			// Si el mes es distinto a Febrero y el dia 12
		   if(($datem != 2)&&($dated == 12)){
					$name0 = $db_name.'_'.($datebbddx-6).'.sql';
					$name1 = $db_name.'_'.($datey.($datem-1).'30').'.sql';
		   			}
		   // Si el mes es igual a Febrero y el día 12
		   elseif(($datem == 2)&&($dated == 12)){
					$name0 = $db_name.'_'.($datebbddx-6).'.sql';
					$name1 = $db_name.'_'.($datey.($datem-1).'24').'.sql';
		   			}
		   // Si el mes es distinto a Febrero y el día 6
		   if(($datem != 2)&&($dated == 6)){
					$name0 = $db_name.'_'.($datey.($datem-1).'30').'.sql';
					$name1 = $db_name.'_'.($datey.($datem-1).'24').'.sql';
			   			}
		   // Si el mes es igual a Febrero y el día 6
			   elseif(($datem == 2)&&($dated == 6)){
						$name0 = $db_name.'_'.($datey.($datem-1).'24').'.sql';
						$name1 = $db_name.'_'.($datey.($datem-1).'18').'.sql';
			   			}
		   	  else{	$name0 = $db_name.'_'.($datebbddx-6).'.sql';
					$name1 = $db_name.'_'.($datebbddx-12).'.sql';
		   			}
							   
			if(file_exists($dir.$name0)){copy($dir.$name0, "upbbdd/temp/".$name0);}else{}
			if(file_exists($dir.$name1)){copy($dir.$name1, "upbbdd/temp/".$name1);}else{}
			// Borra los archivos temporales
			while ($file = readdir($handle)){if (is_file($dir.$file)) {unlink($dir.$file);}}
				} else { }
				if(file_exists("upbbdd/temp/".$name0)){rename("upbbdd/temp/".$name0, $dir.$name0);}else{}
				if(file_exists("upbbdd/temp/".$name1)){rename("upbbdd/temp/".$name1, $dir.$name1);}else{}
				}

					//////////////////			//////////////////
	
	// SI EXISTE EL RESPALDO CORRESPONDIENTE A HOY NO HACER NADA.
	if(file_exists('upbbdd/bbdd_export_tot/'.$db_name.'_'.$datebbddx.'.sql')){ }

	// DE LO CONTRARIO HACER EL RESPALDO.
	elseif(!file_exists('upbbdd/bbdd_export_tot/'.$db_name.'_'.$datebbddx.'.sql')){
		if(($dated == "6") || ($dated == "12") || ($dated == "18") || ($dated == "24") || ($dated == "30")){ 
			require 'upbbdd/bbdd_export_tot.php';
			} else { }
	} // Fin del condicional que realiza el respaldo
	
} // Fin function respado automatico bbdd.

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function table_desblock(){
	
require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();

$table_desblock;
$table_desblock = print("<table align='center' style=\"margin-top:2px; margin-bottom:2px\" >
				<tr>
					<th colspan=2 width=100% valign=\"bottom\" class='BorderInf'>
						* IP {$geoplugin->ip} BLOQUEADA HASTA LAS ".$_SESSION['desbloqh']."
					</th>
				</tr>
				<tr>
					<td colspan='2' align='center' valign='middle' class='BorderSup' style='padding-top: 10px'>
						<a href='Inclu/desblock_ip.php'>
							FORMULARIO DESBLOQUEO IP
						</a>
					</td>
				</tr>
				<tr>
					<td colspan='2' align='center' valign='middle' class='BorderSup' style='padding-top: 10px'>
						<a href='Admin/Claves_Perdidas.php'>
							HE PERDIDO MIS CLAVES
						</a>
					</td>
				</tr>
				<tr>
					<td colspan='2' align='center' valign='middle' class='BorderSup' style='padding-top: 10px'>
						<a href='Mail_Php/index.php'  target='_blank'>
							WEBMASTER @ CONTACTO
						</a>
					</td>
				</tr>
			</table>");
	
			global $redir;
			$redir = "<script type='text/javascript'>
							function redir(){
							window.location.href='index.php';
						}
						setTimeout('redir()',600000);
						</script>";
			print ($redir);

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function modif(){
									   							
	$filename = "Users/".$_SESSION['ref']."/ayear.php";
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
	global $dat1;
	$dat1 = "\tMODIFICADO Y ACTUALIZADO ".$filename.PHP_EOL;
}

function modif2(){

	$filename = "Users/".$_SESSION['ref']."/year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);
	global $dat2;
	$dat2 = "\tMODIFICADO Y ACTUALIZADO ".$filename.PHP_EOL;
}

function modif2b(){

	$filename = "config/year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);
	global $dat3;
	$dat3 = "\tMODIFICADO Y ACTUALIZADO ".$filename.PHP_EOL;
}

function tcl(){
	
	global $db;
	global $db_name;
	
	$vname = $_SESSION['clave'].$_SESSION['ref']."_".date('Y');
	$vname = "`".$vname."`";
	
	$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) collate utf8_spanish2_ci NOT NULL,
  `Nombre` varchar(25) collate utf8_spanish2_ci NOT NULL,
  `Apellidos` varchar(25) collate utf8_spanish2_ci NOT NULL,
  `din` varchar(10) collate utf8_spanish2_ci NOT NULL,
  `tin` time NOT NULL,
  `dout` varchar(10) collate utf8_spanish2_ci NULL,
  `tout` time NULL,
  `ttot` time NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db , $tcl)){
		
					global $dat4;
					$dat4 = "\t* OK TABLA ADMIN ".$vname.PHP_EOL;
			
				} else {
					
					global $dat4;
					$dat4 = "\t* NO OK TABLA ADMIN. ".mysqli_error($db).PHP_EOL;
					
					}
}
					
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

					
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ayear(){
	$filename = "Users/".$_SESSION['ref']."/year.txt";
	$fw2 = fopen($filename, 'r+');
	$fget = fgets($fw2);
	fclose($fw2);
	
	if($fget == date('Y')){
		/*print(" <div style='clear:both'></div>
				<div style='width:200px'>* EL AÑO ES EL MISMO</br>&nbsp;&nbsp;&nbsp;".date('Y')." == ".$fget."</div>"); */
				}
	elseif($fget != date('Y')){ 
		print(" <div style='clear:both'></div>
				<div style='width:200px'>* EL AÑO HA CAMBIADO</div>");/*</br>&nbsp;&nbsp;&nbsp;".date('Y')." != ".$fget." */
		modif();
		modif2();
		modif2b();
		tcl();
		global $dat1;	global $dat2;	global $dat3;	global $dat4;
		global $datos;
		$datos = $dat1.$dat2.$dat3.$dat4.PHP_EOL;
		}
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function admin_entrada(){ 

	global $db; 	global $db_name;
	global $userid;
	$userid = $_SESSION['id'];
	
	global $uservisita; 
	$uservisita = $_SESSION['visitadmin'];
	$total = $uservisita + 1;
	
	global $datein;
	$datein = date('Y-m-d H:i:s');

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqladin = "UPDATE `$db_name`.$table_name_a SET `lastin` = '$datein', `visitadmin` = '$total' WHERE $table_name_a.`id` = '$userid' LIMIT 1 ";
		
	if(mysqli_query($db, $sqladin)){
			// print("* ");
				} else {
				print("</br>
				<font color='#F1BD2D'>
		* FATAL ERROR funcion admin_entrada(): </font></br> ".mysqli_error($db))."
				</br>";
							}
					
	global $dir;
	$dir = "Users/".$_SESSION['ref']."/log";

	global $datos;
	global $text;
	$text = PHP_EOL."** INICIO SESION => ".$datein.PHP_EOL.".\t User Ref: ".$_SESSION['ref'].PHP_EOL.".\t User Name: ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].PHP_EOL.$datos;

	require 'Admin/log_write.php';

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_visit(){

	global $db;			global $db_name;
	global $rowv;		global $sumavisit;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqlv =  "SELECT * FROM $table_name_c";
	$qv = mysqli_query($db, $sqlv);
	 
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit;		$sumavisit = $tot + 1;

	$idv = 69;
	
	if(mysqli_query($db, $sqlv)){
		print("<div class='juancentra' style='border:none;'>
				<font color='#59746A'>
					VISITS: ".$tot."<br>
					AUTHORIZED: ".$rowv['acceso']."<br>
					FORBIDDEN: ".$rowv['deneg']."
				</font>
			</div>");

	}else{
		print("<font color='#F1BD2D'>* Error: show visit</font>
				</br>&nbsp;&nbsp;&nbsp;".mysqli_error($db)."</br>");
	}

} // FIN function show_visit

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_visit(){

	global $db;				global $db_name;
	global $rowv;			global $sumavisit;
	
	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqlv =  "SELECT * FROM $table_name_c";
	$qv = mysqli_query($db, $sqlv);
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit;		$sumavisit = $tot + 1;

	$idv = 69;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqlv = "UPDATE `$db_name`.$table_name_c SET `admin`='$sumavisit' WHERE $table_name_c.`idv`='$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqlv)){
		/**/	print(" </br>");

	}else{	print("<font color='#F1BD2D'>* Error: suma visit</font>
						</br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db)."
						</br>");
	}
	
	global $text;		$text = "ACCESO A ADMIN SING IN".PHP_EOL;
	ini_log();

} // FIN function suma_visit

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_acces(){

	global $db; 	global $db_name; 	global $rowa; 	global $sumaacces;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqla =  "SELECT * FROM $table_name_c";
	$qa = mysqli_query($db, $sqla);
	$rowa = mysqli_fetch_assoc($qa);
	
	$_SESSION['acceso'] = $rowa['acceso'];
	
	$tota = $rowa['acceso'];

	global $sumaacces;		$sumaacces = $tota + 1;

	$idv = 69;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqla = "UPDATE `$db_name`.$table_name_c SET `acceso` = '$sumaacces' WHERE $table_name_c.`idv` = '$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqla)){ 
			print ('</br>');
	}else{ 	print("<font color='#F1BD2D'>* Error: suma access</font></br>
					&nbsp;&nbsp;&nbsp;".mysqli_error($db)."</br>");
	}

			////////////////////		************   		////////////////////
	
	require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$date = date('Y-m-d');
	$time = date('H:i:s');

	global $table_name_b;
	$table_name_b = "`".$_SESSION['clave']."ipcontrol`";

	$sqlip = "INSERT INTO `$db_name`.$table_name_b (`ref`, `nivel`, `ipn`, `error`, `acceso`, `date`, `time`) VALUES ('$_SESSION[ref]', '$_SESSION[Nivel]', '{$geoplugin->ip}', '0', '1', '$date', '$time')";
	if(mysqli_query($db, $sqlip)){ } else { print("* MODIFIQUE LA ENTRADA L.457: ".mysqli_error($db));}


} // FIN function suma_acces

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_denegado(){

	global $db;				global $db_name;
	global $rowd;			global $sumadeneg;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqld =  "SELECT * FROM $table_name_c";
	$qd = mysqli_query($db, $sqld);
	$rowd = mysqli_fetch_assoc($qd);
	
	$_SESSION['deneg'] = $rowd['deneg'];
	
	$dng = $rowd['deneg'];
	
	global $sumadeneg;		$sumadeneg = $dng + 1;

	$idd = 69;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqld = "UPDATE `$db_name`.$table_name_c SET `deneg` = '$sumadeneg' WHERE $table_name_c.`idv` = '$idd' LIMIT 1 ";

	if(mysqli_query($db, $sqld)){/*	print("	</br>");*/
		
	}else{	print("<font color='#F1BD2D'>* Error: suma denegado</font></br>
							&nbsp;&nbsp;&nbsp;".mysqli_error($db)."</br>");
	}
	
			////////////////////		**********   		////////////////////
	
	require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$date = date('Y-m-d');
	$time = date('H:i:s');

	global $table_name_b;
	$table_name_b = "`".$_SESSION['clave']."ipcontrol`";

	$sqlip = "INSERT INTO `$db_name`.$table_name_b (`ref`, `nivel`, `ipn`, `error`, `acceso`, `date`, `time`) VALUES ('anonimo', 'anonimo', '{$geoplugin->ip}', '1', '0', '$date', '$time')";
	if(mysqli_query($db, $sqlip)){ 
			global $text;
			$text = "!! ACCESO DENEGADO A ADMIN SING IN => IP: ".$geoplugin->ip.PHP_EOL;
			ini_log();

	}else{ 	print("* MODIFIQUE LA ENTRADA L.518: ".mysqli_error($db));}

	bloqueo();
	
	} // FIN FUNCTION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	global $db;				global $db_name;
	
	global $table_name_a;	
	$table_name_a = "`".$_SESSION['clave']."admin`";

	global $sqlp;
	$sqlp =  "SELECT * FROM `$db_name`.$table_name_a WHERE `Usuario` = '$_POST[Usuario]' AND `Pass` = '$_POST[Password]' LIMIT 1";
	global $qp;			$qp = mysqli_query($db, $sqlp);
	global $rn;			$rn = mysqli_fetch_assoc($qp);
	global $count;		$count = mysqli_num_rows($qp);

	global $password;	$password = $_POST['Password'] ;
	global $row;
	global $hash;		$hash = @$row['Password'];
	
	//echo $row['Password']."<br>";
	//echo $hash;

	$errors = array();
	
	if(strlen(trim($_POST['Usuario'])) == 0){
			//$errors [] = "Usuario: Campo obligatorio.";
			$errors [] = "USER ACCES ERROR";
	}elseif(strlen(trim($_POST['Password'])) == 0){
			//$errors [] = "Password: Campo Obligatorio:";
			$errors [] = "USER ACCES ERROR";
	}elseif($count < 1){
			//$errors [] = "Nombre / password incorrecto";
			$errors [] = "USER ACCES ERROR";
	}elseif(!@password_verify($_POST['Password'], $hash)){
					// VERIFICO EL HASH
		if(trim($_POST['Password'] != $rn['Pass'])){
			//$errors [] = "Password incorrecto.";
			$errors [] = "USER ACCES ERROR";
		}else{ }
	}
		
	if(@$rn['Nivel'] == 'close'){
		// VERIFICO NIVEL CLOSE
		$errors [] = "ACCESO RESTRINGIDO POR EL WEB MASTER";
		global $CloseLog;
		$CloseLog = "\t ** NOMBRE: ".$rn['Nombre']." ".$rn['Apellidos']." REF: ".$rn['ref'];
	}
	
	return $errors;

} // FIN FUNCTION validate_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_formp(){
	
	global $db;					global $db_name;

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqlp =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$_POST[pin]' ";
	$qp = mysqli_query($db, $sqlp);
	$cp = mysqli_num_rows($qp);
	
	$errorsp = array();
	
	if (strlen(trim($_POST['pin'])) == 0){
		//$errorsp [] = "PIN: Campo obligatorio.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}elseif (strlen(trim($_POST['pin'])) < 8){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}elseif (strlen(trim($_POST['pin'])) > 8){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}elseif (!preg_match('/^[A-Z\d]+$/',$_POST['pin'])){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}
	
	/*
	elseif (!preg_match('/^[^a-z@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,\/:\.\*]+$/',$_POST['pin'])){
		$errors [] = "PIN: Incorrecto.";
		}

	elseif (!preg_match('/^[^a-z]+$/',$_POST['pin'])){
		$errors [] = "PIN: Incorrecto.";
		}*/
	
	elseif($cp == 0){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}

	return $errorsp;

	} // FIN function validate_formp()


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;
					
	if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){	

		global $onlyindex;
		if($onlyindex == 1){
				master_index();
				ver_todo();
				ayear();
				admin_entrada();
				suma_acces();
				bbdd_backup();
		}else{ }

	print("<embed src='audi/sesion_open.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
	</embed>");

	}else { require 'Inclu/table_permisos.php'; }
}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function errors(){
	
	global $db; 	global $db_name;
	
	global $sesus; 	$sesus = $_SESSION['ref'];

	require 'fichar/Inc_errors.php';

}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_ficha(){
	
	global $db; 	global $db_name;
	
	global $vname;
	$tabla1 = $_SESSION['clave'].$_SESSION['ref'];
	$tabla1 = strtolower($tabla1);
	$vname = "`".$tabla1."_".date('Y')."`";

	// FICHA ENTRADA O SALIDA.
	
	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);

	// FICHA ENTRADA.
	
	if($count1 < 1){
		
		global $din;		$din = date('Y-m-d');
		global $tin;			

		/*
			HORA ORIGINAL DE ENTRADA DEL SCRIPT
			$tin = date('H:i:s');
		*/

		require 'fichar/fichar_redondeo_in.php';

			////////////////////		***********  		////////////////////

		global $dout;	$dout = '';
		global $tout;	$tout = '00:00:00';
		global $ttot;	$ttot = '00:00:00';
		
	print("<div class='juancentra' style='border:none;'>
				".strtoupper($_SESSION['Nombre'])." ".strtoupper($_SESSION['Apellidos']).".
				<br>REFER: ".strtoupper($_SESSION['ref'])."
				<br>FICHE SU ENTRADA<br>
			<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block; margin-right:10%;'>
				<button type='submit' title='CANCELAR Y VOLVER' class='botonazul imgButIco HomeBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='cancel' value=1 />
			</form>
			<form name='form_datos' method='post' action='fichar/fichar_Crear.php' enctype='multipart/form-data'>
				<input type='hidden' id='ref' name='ref' value='".$_SESSION['ref']."' />
				<input type='hidden' id='name1' name='name1' value='".$_SESSION['Nombre']."' />
				<input type='hidden' id='name2' name='name2' value='".$_SESSION['Apellidos']."' />
				<input type='hidden' id='din' name='din' value='".$din."' />
				<input type='hidden' id='tin' name='tin' value='".$tin."' />
				<input type='hidden' id='dout' name='dout' value='".$dout."' />
				<input type='hidden' id='tout' name='tout' value='".$tout."' />
				<input type='hidden' id='ttot' name='ttot' value='".$ttot."' />
					<button type='submit' title='FICHAR ENTRADA' class='botonverde imgButIco Clock1Black' style='vertical-align:top;' ></button>
					<input type='hidden' name='entrada' value=1 />
			</form>														
		</div>"); 
	// FICHA SALIDA.
	}elseif($count1 > 0){
		
		global $dout;	$dout = date('Y-m-d');
		global $tout;	global $ttot;
		
		/*
			HORA ORIGINAL DE SALIDA DEL SCRIPT
			$tout = date('H:i:s');
		*/

		require 'fichar/fichar_redondeo_out.php';

			////////////////////		***********  		////////////////////

		print("<div class='juancentra' style='border:none;'>
				".strtoupper($_SESSION['Nombre'])." ".strtoupper($_SESSION['Apellidos']).".
				<br>RERER: ".strtoupper($_SESSION['ref'])."
				<br>FICHE SU SALIDA<br>
			<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' style='display: inline-block; margin-right:10%'' >
				<button type='submit' title='CANCELAR Y VOLVER' class='botonazul imgButIco HomeBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='cancel' value=1 />
			</form>
			<form name='form_datos' method='post' action='fichar/fichar_Crear.php' enctype='multipart/form-data'>
				<input type='hidden' id='ref' name='ref' value='".$_SESSION['ref']."' />
				<input type='hidden' id='name1' name='name1' value='".$_SESSION['Nombre']."' />
				<input type='hidden' id='name2' name='name2' value='".$_SESSION['Apellidos']."' />
				<input type='hidden' id='dout' name='dout' value='".$dout."' />
				<input type='hidden' id='tout' name='tout' value='".$tout."' />
					<button type='submit' title='FICHAR SALIDA' class='botonnaranja imgButIco Clock1Black' style='vertical-align:top;' ></button>
					<input type='hidden' name='salida' value=1 />
			</form>														
		</div>"); 
		
		}
	
	} // FIN FUNCTION show_ficha()


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_pin(){
	
	global $db; 	global $db_name;	global $qrp;
	
	if ((isset($_GET['ocultop']))  || (isset($_GET['pin']) != '')){ $qrp = $_GET['pin']; }
	else{ $qrp = $_POST['pin']; }
	
	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqlp =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$qrp' ";
	$qp = mysqli_query($db, $sqlp);
	$cp = mysqli_num_rows($qp);
	$rp = mysqli_fetch_assoc($qp);
	
	$_SESSION['usuarios'] = $rp['ref'];
	$_SESSION['ref'] = $rp['ref'];

	if($cp > 0){
	
	global $vname;
	$tabla1 = $_SESSION['clave'].$rp['ref'];
	$tabla1 = strtolower($tabla1);
	$vname = $tabla1."_".date('Y');
	$vname = "`".$vname."`";

	// FICHA ENTRADA O SALIDA.
	
	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);

	// FICHA ENTRADA.
		if($count1 < 1){
			
			global $din;	$din = date('Y-m-d');	
			global $tin;

			/*
				HORA ORIGINAL DE ENTRADA DEL SCRIPT
				$tin = date('H:i:s');
			*/

			require 'fichar/fichar_redondeo_in.php';

				////////////////////		***********  		////////////////////

			global $dout;		$dout = '';
			global $tout;		$tout = '00:00:00';
			global $ttot;		$ttot = '00:00:00';
		
		print("<div class='juancentra' style='border:none;'>
			<img src='Users/".$rp['ref']."/img_admin/".$rp['myimg']."' height='80.0em' width='64.0em' />
			<br>".strtoupper($rp['Nombre'])." ".strtoupper($rp['Apellidos']).".
			<br>REFER: ".strtoupper($rp['ref'])."<br>
			<br>FICHE SU ENTRADA<br>

			<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block; margin-right:10%;'>
				<button type='submit' title='CANCELAR Y VOLVER' class='botonazul imgButIco HomeBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='cancel' value=1 />
			</form>
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data' style='display:inline-block;'>
				<input type='hidden' id='myimg' name='myimg' value='".$rp['myimg']."' />
				<input type='hidden' id='ref' name='ref' value='".$rp['ref']."' />
				<input type='hidden' id='name1' name='name1' value='".$rp['Nombre']."' />
				<input type='hidden' id='name2' name='name2' value='".$rp['Apellidos']."' />
				<input type='hidden' id='din' name='din' value='".$din."' />
				<input type='hidden' id='tin' name='tin' value='".$tin."' />
				<input type='hidden' id='dout' name='dout' value='".$dout."' />
				<input type='hidden' id='tout' name='tout' value='".$tout."' />
				<input type='hidden' id='ttot' name='ttot' value='".$ttot."' />
					<button type='submit' title='FICHAR ENTRADA' class='botonverde imgButIco Clock1Black' style='vertical-align:top;' ></button>
					<input type='hidden' name='entrada' value=1 />
			</form>														
			<embed src='audi/conf_user_data.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
			</embed>
		</div>");

		// FICHA SALIDA.
		}elseif($count1 > 0){
		
			global $dout;		$dout = date('Y-m-d');
			global $tout;		$tout = date('H:i:s');
			global $ttot;

			/*
				HORA ORIGINAL DE SALIDA DEL SCRIPT
				$tout = date('H:i:s');
			*/

			require 'fichar/fichar_redondeo_out.php';

			////////////////////		***********  		////////////////////

		print("<div class='juancentra' style='border:none;'>
			".strtoupper($rp['Nombre'])." ".strtoupper($rp['Apellidos']).".
			<br>REFER: ".strtoupper($rp['ref'])."<br>
			<img src='Users/".$rp['ref']."/img_admin/".$rp['myimg']."' height='80.0em' width='64.0em' />
			<br>FICHE SU SALIDA<br>
			
			<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' style='display: inline-block; margin-right:10%'' >
				<button type='submit' title='CANCELAR Y VOLVER' class='botonazul imgButIco HomeBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='cancel' value=1 />
			</form>
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data' style='display: inline-block;'>
				<input type='hidden' id='myimg' name='myimg' value='".$rp['myimg']."' />
				<input type='hidden' id='ref' name='ref' value='".$rp['ref']."' />
				<input type='hidden' id='name1' name='name1' value='".$rp['Nombre']."' />
				<input type='hidden' id='name2' name='name2' value='".$rp['Apellidos']."' />
				<input type='hidden' id='dout' name='dout' value='".$dout."' />
				<input type='hidden' id='tout' name='tout' value='".$tout."' />
					<button type='submit' title='FICHAR SALIDA' class='botonnaranja imgButIco Clock1Black' style='vertical-align:top;' ></button>
					<input type='hidden' name='salida' value=1 />
			</form>														
	<embed src='audi/conf_user_data.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
	</embed>
		</div>"); 
			
		}
	
	ayear();
		
	}else{ print("<div class='juancentra' style='border-color:#F1BD2D;' >
					<font color='#F1BD2D'>
						NO EXISTE EL USUARIO.<br>
						PONGASE EN CONTACTO CON ADMIN SYSTEM.<br>
					</font>
			<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' style='margin-left:85%;' >
				<button type='submit' title='CANCELAR Y VOLVER' class='botonazul imgButIco HomeBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='cancel' value=1 />
			</form>
			<embed src='audi/user_lost.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
			</embed>
		</div");

	 	global $redir;
		$redir = "<script type='text/javascript'>
							function redir(){
							window.location.href='index.php';
						}
						setTimeout('redir()',4000);
						</script>";
		print ($redir);
	}			
		
} // FIN function process_pin()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function pin_out(){
	
	global $db;				global $db_name;
	
	$_SESSION['usuarios'] = $_POST['ref'];

	global $vname;
	$tabla1 = $_SESSION['clave'].$_POST['ref'];
	$tabla1 = strtolower($tabla1);
	$vname = $tabla1."_".date('Y');
	$vname = "`".$vname."`";

	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout`='' AND $vname.`tout`='00:00:00' LIMIT 1 ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);
	$row1 = mysqli_fetch_assoc($q1);
	global $din;		$din = trim($row1['din']);
	global $tin;		$tin = trim($row1['tin']);
	global $in;			$in = $din." ".$tin;
	
	global $dout;		$dout = trim($_POST['dout']);
	global $tout;		$tout = trim($_POST['tout']);
	
	global $out;		$out = $dout." ".$tout;
	
		$fecha1 = new DateTime($in);//fecha inicial
	$fecha2 = new DateTime($out);//fecha de cierre

	global $difer;		$difer = $fecha1->diff($fecha2);
	
	//print ($difer);
	
	global $ttot;		$ttot = $difer->format('%H:%i:%s');
	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	$ttot1 = $difer->format('%H:%i:%s');
	global $ttoth;
	$ttoth = substr($ttot1,0,2);
	$ttoth = str_replace(":","",$ttoth);
	
	$ttot2 = $difer->format('%d-%H:%i:%s');
	global $ttotd;
	$ttotd = substr($ttot2,0,2);
	$ttotd = str_replace("-","",$ttotd);
	
	if(($ttoth > 9)||($ttotd > 0)){
		
		print("<div class='juancentra' style='border-color:#F1BD2D;'>
					<font color='#F1BD2D'>
						NO PUEDE FICHAR MÁS DE 10 HORAS.<br>PONGASE EN CONTACTO CON ADMIN SYSTEM.
					</font>
				</div>");
		
					global $ttot;
					$ttot = '03:22:02';
					global $text;
					$text = PHP_EOL."*** ERROR CONSULTE ADMIN SYSTEM ***";
					$text = $text.PHP_EOL."\t- FICHA SALIDA ".$_POST['dout']." / ".$_POST['tout'];
					$text = $text.PHP_EOL."\t- N HORAS: ".$ttot;
		/* fin if >9 */
		}else{	global $ttot;
				global $text;
				$text = PHP_EOL."** F. SALIDA ".$_POST['dout']." / ".$_POST['tout'];
				$text = $text.PHP_EOL."\t- N HORAS: ".$ttot;

	} /* Fin else >9 */
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
		$tabla = "<div class='juancentra' >
					HA FICHADO LA SALIDA<br>".strtoupper($_POST['name1'])." ".strtoupper($_POST['name2'])."<br>
			<img src='Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."' height='80.0em' width='64.0em' />
					<br>REFERENCIA: ".$_POST['ref']."
					<br>FECHA ENTRADA: ".$din."
					<br>HORA ENTRADA: ".$tin."
					<br>FECHA SALIDA: ".$_POST['dout']."
					<br>HORA SALIDA: ".$_POST['tout']."
					<br>HORAS REALIZADAS: ".$ttot."<br>
				<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' style='margin-left:85%;'>
					<button type='submit' title='VOLVER INICIO' class='botonazul imgButIco HomeBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='cancel' value=1 />
				</form>	
			</div>
			<embed src='audi/salida.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
			</embed>";	
		
	//print($in." / ".$out." / ".$ttot."</br>");
	//echo $difer->format('%Y años %m meses %d days %H horas %i minutos %s segundos');
						//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos

	$sqla = "UPDATE `$db_name`.$vname SET `dout` = '$_POST[dout]', `tout` = '$_POST[tout]', `ttot` =  '$ttot' WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
		
	if(mysqli_query($db, $sqla)){ 
			
		print($tabla); 
		suma_todo();

		global $dir;		$dir = "Users/".$_POST['ref']."/mrficha";

		global $sumatodo;
		global $text;
		$text = $text.PHP_EOL."** H. TOT. MES: ".$sumatodo;
		$text = $text.PHP_EOL."**********".PHP_EOL;
		$rmfdocu = $_POST['ref'];
		$rmfdate = date('Y_m');
		$rmftext = $text.PHP_EOL;
		$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
		$rmf = fopen($filename, 'ab+');
		fwrite($rmf, $rmftext);
		fclose($rmf);
			
		global $redir;
		$redir = "<script type='text/javascript'>
						function redir(){
						window.location.href='index.php';
					}
					setTimeout('redir()',8000);
					</script>";
		print ($redir);
	
	}else{	print("* MODIFIQUE LA ENTRADA L.1054: ".mysqli_error($db));
			show_form2();
			show_form ();
			global $texerror;		$texerror = PHP_EOL."\t ".mysqli_error($db);
	}
	
} // FIN function pin_out()
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function pin_in(){
	
	$tabla = "<div class='juancentra'>
				HA FICHADO LA ENTRADA</br>".strtoupper($_POST['name1'])." ".strtoupper($_POST['name2'])."<br>
			<img src='Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."' height='80.0em' width='64.0em' />
				<br>REFERENCIA: ".$_POST['ref']."
				<br>FECHA ENTRADA: ".$_POST['din']."
				<br>HORA ENTRADA: ".$_POST['tin']."<br>
			<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' style='margin-left:85%;' >
				<button type='submit' title='VOLVER INICIO' class='botonazul imgButIco HomeBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='cancel' value=1 />
			</form>
		</div>
			<embed src='audi/entrada.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
			</embed>";	
		
	global $db;  	global $db_name;
	
	$_SESSION['usuarios'] = $_POST['ref'];

	global $vname;
	$tabla1 = $_SESSION['clave'].$_POST['ref'];
	$tabla1 = strtolower($tabla1);
	$vname = "`".$tabla1."_".date('Y')."`";

	$sqla = "INSERT INTO `$db_name`.$vname (`ref`, `Nombre`, `Apellidos`, `din`, `tin`, `dout`, `tout`, `ttot`) VALUES ('$_POST[ref]', '$_POST[name1]', '$_POST[name2]', '$_POST[din]', '$_POST[tin]', '$_POST[dout]', '$_POST[tout]', '$_POST[ttot]')";
		
	if(mysqli_query($db, $sqla)){ 
		
			print($tabla);
		
			global $dir;			$dir = "Users/".$_SESSION['usuarios']."/mrficha";

			global $text;
			$text = PHP_EOL."\t- NOMBRE: ".$_POST['name1']." ".$_POST['name2'];
			$text = $text.PHP_EOL."\t- USER REF: ".$_POST['ref'];
			$text = $text.PHP_EOL."** F. ENTRADA ".$_POST['din']." / ".$_POST['tin'];
			
			$rmfdocu = $_POST['ref'];
			$rmfdate = date('Y_m');
			$rmftext = $text.PHP_EOL;
			$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
			$rmf = fopen($filename, 'ab+');
			fwrite($rmf, $rmftext);
			fclose($rmf);
		
			global $redir;
			$redir = "<script type='text/javascript'>
							function redir(){
							window.location.href='index.php';
						}
						setTimeout('redir()',8000);
						</script>";
			print ($redir);

		}else{	print("* MODIFIQUE LA ENTRADA L.1151: ".mysqli_error($db));
				show_form2();
				show_form ();
				global $texerror;
				$texerror = PHP_EOL."\t ".mysqli_error($db);
		}
	
	} // FIN function pin_in()
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_todo(){
		
	global $db;		global $db_name;
	
	global $dyt;	$dyt = date('Y');
	global $dm;		$dm = "-".date('m')."-";
	global $dd;		$dd = '';
	global $fil;	$fil = $dyt.$dm."%";

	$tabla1 = $_SESSION['clave'].$_SESSION['usuarios'];
	$tabla1 = strtolower($tabla1);
	global $vname;
	$vname = "`".$tabla1."_".$dyt."`";

	require 'fichar/Inc_Suma_Todo.php';

} // FIN FUNCTION suma_todo()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form2($errorsp=''){
	
	if(isset($_POST['pin'])){
		$defaults = $_POST;
	}else{$defaults = array ('pin' => '');}
	
	print("<div class='juancentra' style='border:none;' >
			<form name='pin' method='post' action='$_SERVER[PHP_SELF]'>	
				<input type='Password' name='pin' size=16 maxlength=8 value='".$defaults['pin']."' placeholder='FICHAR CON PIN' required style='text-align:center; margin-top:0.4em;' />
				<button type='submit' title='FICHAR CON SU PIN' class='botonverde imgButIco Clock1Black' style='vertical-align:top;' ></button>
				<input type='hidden' name='ocultop' value=1 />
			</form>
			<!--
			<hr> 
			<a href='indexcamini.php'>GO TO QR SCANNER CAM</a>
			-->
		</div>"); 

	if ($errorsp){
		print("	<div class='juancentra' style='border-color:#F1BD2D !important;'>
				<!--
					<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font><br>
				-->
					<font color='#F1BD2D'>ERROR ACCESO PIN</font>");
		/*
		for($a=0; $c=count($errorsp), $a<$c; $a++){
			print("<font color='#F1BD2D'>**</font>  ".$errorsp [$a]."<br/>");
			}
		*/
		print("<embed src='audi/pin_error.mp3' autostart='true' loop='false' width='0' height='0' hidden='true'>
		</embed>
		</div>");
		}
	
	} // FIN FUNCTION show_form2()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function desbloqueo(){
	
	require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	
	global $db;				global $db_name;

	$date = date('Y-m-d');
	$time = date('H:i:s');
	$time1 = date('H');
	$time1 = ($time1+1).date(':i:s');

	// BORRO LAS ENTRADAS DEL DÍA ANTERIOR.
	global $table_name_b;
	$table_name_b = "`".$_SESSION['clave']."ipcontrol`";

	$sdip =  "SELECT * FROM `$db_name`.$table_name_b WHERE `date` <> '$date' ";
	$qdip = mysqli_query($db, $sdip);
	$cdip = mysqli_num_rows($qdip);
	if($cdip > 0){
	$sqlxd = "DELETE FROM `$db_name`.$table_name_b WHERE `date` <> '$date' ";
	if(mysqli_query($db, $sqlxd)){
			// SI SE CUMPLE EL QUERY Y NO HAY DATOS EN LA TABLA LE PASO EL ID 1.
			$sx =  "SELECT * FROM $table_name_b ";
			$qx = mysqli_query($db, $sx);
			$cx = mysqli_num_rows($qx);
				if($cx < 1){
				$sx1 = "ALTER TABLE `$db_name`.$table_name_b AUTO_INCREMENT=1";
						if(mysqli_query($db, $sx1)){ }
						else { print("* MODIFIQUE LA ENTRADA L.1565: ".mysqli_error($db));}
							}
		} else {}
	}else{} // Fin borrado de las entradas del día anterior.
	
	// SELECCIONO LAS IPs == A LA MIA, BLOQUEADAS CON "ACCESO X".

	$sqlx =  "SELECT * FROM $table_name_b WHERE `ipn` = '{$geoplugin->ip}' AND `acceso` = 'x' ORDER BY `id` ASC ";
	$qx = mysqli_query($db, $sqlx);
	$cx = mysqli_num_rows($qx);
	$rowx = mysqli_fetch_assoc($qx);
	$timex = date('Hi');
	
	// VERIFICO IP BLOQUEO DE LA IP
	if(($cx >= 1)&&($rowx['error'] > $timex)){ $_SESSION['showf'] = 69;}
	elseif((($cx >= 1)&&(@$rowx['error'] <= $timex))||((strlen(trim(@$rowx['error'] >= 3)))&&(@$rowx['error'] <= $timex))){ 
	// DESBLOQUEO TODAS LAS IPs IGUALES A LA MIA
	$desb = "UPDATE `$db_name`.$table_name_b SET `error` = 'des', `acceso` = 'des' WHERE $table_name_b.`ipn` = '{$geoplugin->ip}' ";
	$_SESSION['showf'] = 0;	
	if(mysqli_query($db, $desb)){ 
				// PASO LOGS DE DESBLOQUEO
				global $text;
				$text = "!! ACCESO DESBLOQUEADO ADMIN SING IN => IP: ".$geoplugin->ip.PHP_EOL;
				ini_log();
	}else{ print("* ERROR ENTRADA 1678: ".mysqli_error($db))."."; }
	}elseif($cx < 1) { $_SESSION['showf'] = 0; }	
	
	global $blocker;		$blocker = @$rowx['error'];

	//$a = @str_replace(" ","",@$rowx['error']);
	//if(strlen(trim(@$rowx['error'])) < 4){ @$rowx['error'] = "0".@$rowx['error'];}
	$a = @trim(@$rowx['error']);
	if(strlen($a) < 4){ @$rowx['error'] = "0".@$rowx['error'];}

	$dbloqh = substr($rowx['error'],0,2);
	$dbloqm = substr($rowx['error'],2,2);
	$_SESSION['desbloqh'] = $dbloqh.":".$dbloqm.":00";

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function bloqueo(){
	
	require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	
	global $db;			global $db_name;
	
	$date = date('Y-m-d');
	
	$time = date('H:i:s');
	$time1 = date('H');
	$time1 = ($time1+1).date(':i:s');

	// SELECCIONO LAS IPs == A LA MIA, CON MÁS DE TRES ACCESOS DENEGADOS.
	global $table_name_b;
	$table_name_b = "`".$_SESSION['clave']."ipcontrol`";

	$sqlip =  "SELECT * FROM $table_name_b WHERE `ipn` = '{$geoplugin->ip}' AND `error` = '1' AND `acceso` = '0' AND `date` = '$date' ORDER BY `id` DESC ";
	$qip = mysqli_query($db, $sqlip);
	global $cip;
	$cip = mysqli_num_rows($qip);
	$_SESSION['cip'] = $cip;
	
	$rowip = mysqli_fetch_assoc($qip);

	/*
	// CALCULO LA FECHA DE DESBLOQUEO.
	$bloqy = substr($rowip['date'],0,4);
	$bloqm = substr($rowip['date'],5,2);
	$bloqm = str_replace("/","0",$bloqm);
	$bloqd = substr($rowip['date'],-2);
	$bloqd = str_replace("/","0",$bloqd);
	$bloqd = $bloqd + 1;
	global $desbloq;
	$desbloq = $bloqy."/".$bloqm."/".$bloqd;
	*/	
	
	// CALCULO LA HORA DE DESBLOQUEO
	global $bloqh;
	$bloqh = substr($rowip['time'],0,2);
	$bloqh = str_replace(":","",$bloqh);
	$bloqh = $bloqh + 1;
	global $bloqm;
	$bloqm = substr($rowip['time'],3,2);
	$bloqm = str_replace(":","",$bloqm);
	$_SESSION['bloqh'] = $bloqh.$bloqm;
	if($_SESSION['bloqh'] >= 2300){$_SESSION['bloqh'] = 2359;}
	
	$_SESSION['ipid'] = $rowip['id'];
	
	/* 
	IMPRIMO LOS DATOS EN PANTALLA.
	print("** ACCESO DENEGADO ERRORES: ".$cip.".</br>- BBDD Id: ".$rowip['id']."</br>- BBDD Time: ".$rowip['time'].".</br>- Real Time: ".$time.".</br>- Real Time +1 ".$time1.".</br>- BBDD Date: ".$rowip['date'].".</br>- BBDD DesBloq: ".$desbloq.".");
	*/
	
	// MARCO LA ULTIMA ENTRADA ERROR CON "ERROR HORA BBDD+1" Y "ACCESO x" PARA BLOQUEAR LA IP
	if($_SESSION['cip'] >= 3){
	$emarc = "UPDATE `$db_name`.$table_name_b SET `error` = '$_SESSION[bloqh]', `acceso` = 'x' WHERE $table_name_b.`id` = '$_SESSION[ipid]' LIMIT 1 ";
			$_SESSION['showf'] = 69;
			global $bloqh;
			global $bloqm;
			if($_SESSION['bloqh'] >= 2300){$_SESSION['desbloqh'] = "23:59:00"; } 
			elseif(strlen(trim($_SESSION['bloqh'] <= 3))){  $_SESSION['desbloqh'] = "0".$bloqh.":".$bloqm.":00";}
			else{ $_SESSION['desbloqh'] = $bloqh.":".$bloqm.":00";}
		print("	
		<embed src='audi/ip_block.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
		</embed>");

		// PASO LOGS DE BLOQUEO
		global $text;
		$text = "!! ACCESO BLOQUEADO ADMIN SING IN => IP: ".$geoplugin->ip.PHP_EOL;
		ini_log();

		if(mysqli_query($db, $emarc)){ }else {print("* ERROR ENTRADA 95: ".mysqli_error($db)).".";}
	}else{ $_SESSION['showf'] = 0;}

} // FIN FUCNTION BLOQUEO

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	unset($_SESSION['usuarios']);		unset($_SESSION['ref']);
	unset ($_SESSION['dni']);			unset ($_SESSION['webmaster']);
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
	}else{
		$defaults = array ('Usuario' => '', 'Password' => '');
	}
								   
	if($errors){	
		print("<div class='juancentra' style='border-color:#F1BD2D !important;'>
				<!--
					<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font><br>
					<font color='#F1BD2D'>ERROR ACCESO USER</font><br>
				-->");
		// PASO LOGS DE DESBLOQUEO
		global $CloseLog;		global $text;
		$text = "!! ERRORES VALIDACION FORMULARIO ADMIN SING".PHP_EOL.$CloseLog;
		ini_log();
				 
		global $c;		$c=count($errors);
		for($a=0; $a<$c; $a++){
			print("<font color='#F1BD2D'>".$errors [$a]."</font>");
				// ESCRIBE ERRORES EN INI_LOG
				global $text;
				$text = $errors[$a];
				$logdate = date('Y-m-d');
				$logtext = "\t ** ".$text.PHP_EOL;
				$filename = "LogsAcceso/LogsAcceso_".$logdate.".log";
				$log = fopen($filename, 'ab+');
				fwrite($log, $logtext);
				fclose($log);
		}
	print("<embed src='audi/user_error.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
	</embed></div>");
	}
	
	print("<div class='juancentra' style='border:none;'>
		<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
			<input type='Password' name='Usuario' size=20 maxlength=50 value='".$defaults['Usuario']."' placeholder='USUARIO' required  style='text-align:center; margin-top:0.4em;' />

			<input type='Password' name='Password' size=20 maxlength=50 value='".$defaults['Password']."' placeholder='PASSWORD' required  style='text-align:center; margin-top:0.4em;' />

			<button type='submit' title='INICIAR SESIÓN' class='botonazul imgButIco OpenBlack' style='vertical-align:top;' ></button>
			
			<input type='hidden' name='oculto' value=1 />
		</form>	

			<a href='http://juanbarrospazos.blogspot.com.es/' target='_blank'>
				<button type='submit' title='WEB CORPORATIVA' class='botonverde imgButIco WebBlack' style='vertical-align:top;' ></button>
			</a>
			<a href='indexcamini.php'>
				<button type='submit' title='GO TO QR SCANNER CAM' class='botonverde imgButIco QrBlack' style='vertical-align:top;' ></button>
			</a>
			<a href='Admin/Claves_Perdidas.php'>
				<button type='submit' title='HE PERDIDO MIS CLAVES' class='botonverde imgButIco LlavesBlack' style='vertical-align:top;' ></button>
			</a>
			<a href='Mail_Php/index.php'  target='_blank'>
				<button type='submit' title='WEBMASTER @ CONTACTO' class='botonverde imgButIco MailBlack' style='vertical-align:top;' ></button>
			</a>
		</div>"); 
	
} // FIN function show_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){

	global $db;				global $db_name;

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	if (($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){ 
			$ref = $_SESSION['ref'];
			$sqlb =  "SELECT * FROM $table_name_a WHERE `ref` = '$ref'";
			$qb = mysqli_query($db, $sqlb);
	}elseif(($_SESSION['Nivel'] == 'admin') && ($_SESSION['dni'] == $_SESSION['webmaster'])){ 
				require 'Admin/Paginacion_Head.php';
				global $orden;
				$orden = @$_POST['Orden'];
				/*$sqlb =  "SELECT * FROM $table_name_a ORDER BY $orden ";*/
				$sqlb =  "SELECT * FROM $table_name_a  ORDER BY  `id` ASC $limit";
				$qb = mysqli_query($db, $sqlb);
	}elseif(($_SESSION['Nivel'] == 'admin') && ($_SESSION['dni'] != $_SESSION['webmaster'])){ 
				require 'Admin/Paginacion_Head.php';
				global $orden;
				$orden = @$_POST['Orden'];
				/*$sqlb =  "SELECT * FROM $table_name_a WHERE $table_name_a.`dni` <> '$_SESSION[webmaster]' ORDER BY $orden ";*/
				$sqlb =  "SELECT * FROM $table_name_a WHERE $table_name_a.`dni` <> '$_SESSION[webmaster]' ORDER BY  `id` ASC $limit";
				$qb = mysqli_query($db, $sqlb);
	}

			////////////////////		**********  		////////////////////

	global $twhile;			$twhile = "TODOS USUARIOS CONSULTA";
	global $ruta;			$ruta = "Admin/";
	require 'Admin/Inc_While_Form.php';
	global $rutaimg;		$rutaimg = "Users/";
	global $pagedest;		$pagedest = "Admin_Ver.php";
	require 'Admin/Inc_While_Total.php';

			////////////////////		**********  		////////////////////

		// PASO LOGS DE ACCESO
		global $text;
		$text = "!! ACCESO USUARIO: ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].".".PHP_EOL."\t\tREFERENCIA: ".$_SESSION['ref']." NIVEL: ".$_SESSION['Nivel'].PHP_EOL;
		ini_log();
		// PASO LOGS DE USUARIO
		$ActionTime = date('H:i:s');
		global $dir;		$dir = "Users/".$_SESSION['ref']."/log";
		global $text;		$text = "** ".$ActionTime.PHP_EOL."\t".$text;
		require 'Admin/log_write.php';
		
	}	/* FIN FUNCTION VER TODO */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function salir() {	unset($_SESSION['id']);				unset($_SESSION['Nivel']);
					unset($_SESSION['Nombre']);			unset($_SESSION['Apellidos']);
					unset($_SESSION['doc']);			unset($_SESSION['dni']);
					unset($_SESSION['ldni']);			unset($_SESSION['Email']);
					unset($_SESSION['Usuario']);		unset($_SESSION['Password']);
					unset($_SESSION['Direccion']);		unset($_SESSION['Tlf1']);
					unset($_SESSION['Tlf2']);			unset($_SESSION['nclient']);
					echo "<div class='centradiv'>YOU HAVE CLOSE SESSION</div>";
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function master_index(){

	require 'Inclu_MInd/rutaindex.php';
	require 'Inclu_MInd/Master_Index.php';
			
}
 
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ini_log(){

	$ActionTime = date('H:i:s');

	global $text;

    $logdate = date('Y-m-d');

    $logtext = "** ".$ActionTime.PHP_EOL."\t ** ".$text.PHP_EOL;
    $filename = "LogsAcceso/LogsAcceso_".$logdate.".log";
    $log = fopen($filename, 'ab+');
    fwrite($log, $logtext);
    fclose($log);

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	require 'Inclu/Admin_Inclu_footer.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por Juan Barros Pazos 2020/2025 */

?>
