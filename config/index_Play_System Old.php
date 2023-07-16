<?php
session_start();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
 
	// DETERMINO EL NAVEGADOR WEB Y PASO EL MENU ADECUADO
	global $user_agent;
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	//getBrowser($user_agent);
	$_SESSION['menu'] = getBrowser($user_agent);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require 'Inclu/error_hidden.php';
	require 'Inclu/Inclu_Menu_00.php';
	require 'Conections/conection.php';
	require 'Conections/conect.php';
	require 'Inclu/my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if((isset($_POST['Usuario'])&&(isset($_POST['Password'])))){

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sql =  "SELECT * FROM $table_name_a WHERE `Usuario` = '$_POST[Usuario]' AND `Pass` = '$_POST[Password]'";
	$q = mysqli_query($db, $sql);
	global $row;
	$row = mysqli_fetch_assoc($q);
	global $countq;
	$countq = mysqli_num_rows($q);
	global $userid;
	global $uservisita;

	if($countq < 1){}
		else{
	$_SESSION['id'] = $row['id'];
	$_SESSION['ref'] = $row['ref'];
	$_SESSION['Nivel'] = $row['Nivel'];
	$_SESSION['Nombre'] = $row['Nombre'];
	$_SESSION['Apellidos'] = $row['Apellidos'];
	$_SESSION['myimg'] = $row['myimg'];
	$_SESSION['dni'] = $row['dni'];
	$_SESSION['Email'] = $row['Email'];
	$_SESSION['Usuario'] = $row['Usuario'];
	$_SESSION['Password'] = $row['Password'];
	$_SESSION['Pass'] = $row['Pass'];
	$_SESSION['Direccion'] = $row['Direccion'];
	$_SESSION['Tlf1'] = $row['Tlf1'];
	$_SESSION['Tlf2'] = $row['Tlf2'];
	$_SESSION['lastin'] = $row['lastin'];
	$_SESSION['lastout'] = $row['lastout'];
	$_SESSION['visitadmin'] = $row['visitadmin'];

	$userid = $_SESSION['id'];
	$uservisita = $_SESSION['visitadmin'];
		}
}

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
										} 
						else {	process_form();
								//ayear();
							  	show_ficha();
							  	errors();
								//ver_todo();
								//suma_acces();
								/* admin() ENVIA UN MAIL AL WEBMASTER 
								CUANDO UN USUARIO INICIA SESION */
								//admin();
								}
 									 
			}	// FIN POST OCULTO

	elseif(isset($_POST['ocultop'])){
					
			if($form_errorsp = validate_formp()){
				show_form2($form_errorsp);
				if($_SESSION['showf'] == 69){table_desblock();}
				else{show_form(@$form_errors);}
					 show_visit();
					} else {process_pin();
						    //ayear();
						   		}
							} 

	elseif(isset($_POST['entrada'])){	pin_in();
										//errors();
								}
							
	elseif(isset($_POST['salida'])){	pin_out();
										//errors();
								}

	elseif (isset($_POST['cancel'])) {	show_form2();
								if($_SESSION['showf'] == 69){table_desblock();}
								else{show_form(@$form_errors);
									 show_visit();}
							  }

	elseif(isset($_GET['ocultop'])){ process_pin();
							  		//ayear();
							  		errors();
								}

	elseif(isset($_GET['pin']) != ''){ process_pin();
								//ayear();
							 	errors();
							  }

	elseif (isset($_GET['salir'])) { salir();
									 show_form2();
									 show_form();
									 session_destroy();
									}

	else {	show_form2();
			if($_SESSION['showf'] == 69){table_desblock();}
			else{show_form(@$form_errors);
				 show_visit();}
			suma_visit();
		  	bbdd_backup();
				 }
				
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

 // DETERMINO EL NAVEGADOR WEB Y PASO EL MENU ADECUADO
 function getBrowser($user_agent){

	if(strpos($user_agent, 'MSIE') !== FALSE){
		//return 'Internet explorer';
		return "Inclu_MInd";
	}elseif(strpos($user_agent, 'Edge') !== FALSE){ //Microsoft Edge
		//return 'Microsoft Edge';
		return "Inclu_MInd";
	}elseif(strpos($user_agent, 'Trident') !== FALSE){ //IE 11
		//return 'Internet explorer';
		return "Inclu_MInd";
	}elseif(strpos($user_agent, 'Firefox') !== FALSE){
		//return 'Mozilla Firefox';
		return "Inclu_MInd";
	}elseif(strpos($user_agent, 'Chrome') !== FALSE){
		//return 'Google Chrome';
		return "Inclu_MInd";
	}else{
		//return 'No hemos podido detectar su navegador';
		return "Inclu_MInd";
		}
} // FIN FUNCION NAVEGADOR

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
	global $ruta; 	$ruta ="upbbdd/bbdd_export_tot";
	//print("RUTA: ".$ruta.".</br>");
	global $rutag; 	$rutag = "upbbdd/bbdd_export_tot/{*}";
	//print("RUTA G: ".$rutag.".</br>");
	$directorio = opendir($ruta);
	global $num; 	$num=count(glob($rutag,GLOB_BRACE));
	
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
						<a href='Inclu/desblock_ip.php'>FORMULARIO DESBLOQUEO IP</a>
					</td>
				</tr>
				<tr>
					<td colspan='2' align='center' valign='middle' class='BorderSup' style='padding-top: 10px'>
						<a href='Admin/Claves_Perdidas.php'>HE PERDIDO MIS CLAVES</a>
					</td>
				</tr>
				<tr>
					<td colspan='2' align='center' valign='middle' class='BorderSup' style='padding-top: 10px'>
						<a href='Mail_Php/index.php'  target='_blank'>WEBMASTER @ CONTACTO</a>
					</td>
				</tr>
			</table>");
	
			global $redir;
			$redir = "<script type='text/javascript'>
							function redir(){
							window.location.href='index.php';
						}
						setTimeout('redir()',60000);
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

	global $db;
	global $db_name;
	global $userid;
	$userid = $_SESSION['id'];
	
	global $uservisita;
	$uservisita = $_SESSION['visitadmin'];
	$total = $uservisita + 1;
	
	global $datein;
	$datein = date('Y-m-d/H:i:s');

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqladin = "UPDATE `$db_name`.$table_name_a SET `lastin` = '$datein', `visitadmin` = '$total' WHERE $table_name_a.`id` = '$userid' LIMIT 1 ";
		
	if(mysqli_query($db, $sqladin)){
			// print("* ");
				} else {
				print("</br>
				<font color='#FF0000'>
		* FATAL ERROR funcion admin_entrada(): </font></br> ".mysqli_error($db))."
				</br>";
							}
					
	global $dir;
	$dir = "Users/".$_SESSION['ref']."/log";

global $datos;
$logdocu = $_SESSION['ref'];
$logdate = date('Y-m-d');
	
$logtext = PHP_EOL."** INICIO SESION => ".$datein;
$logtext = $logtext.PHP_EOL.".\t User Ref: ".$_SESSION['ref'];
$logtext = $logtext.PHP_EOL.".\t User Name: ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'];
$logtext = $logtext.PHP_EOL.$datos;

$filename = $dir."/".$logdate."_".$logdocu.".log";
$log = fopen($filename, 'ab+');
fwrite($log, $logtext);
fclose($log);

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_visit(){

	global $db;
	global $db_name;
	global $rowv;
	global $sumavisit;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqlv =  "SELECT * FROM $table_name_c";
	$qv = mysqli_query($db, $sqlv);
	
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit;
	$sumavisit = $tot + 1;

	$idv = 69;
	
	if(mysqli_query($db, $sqlv)){
		print("<table align='center'>
				<tr>	
					<td align='right'>
						<font color='#59746A'>VISITS:</font>
					</td>
					<td  align='right'>
						<font color='#59746A'>".$tot."</font>
					</td>
				</tr>
				<tr>
					<td align='right'>
						<font color='#59746A'>AUTHORIZED:</font>
					</td>
					<td align='right'>
						<font color='#59746A'>".$rowv['acceso']."</font>
					</td>
				</tr>
				<tr>
					<td align='right'>
						<font color='#59746A'>
							FORBIDDEN:
						</font>
					</td>
					<td align='right'>
						<font color='#59746A'>".$rowv['deneg']."</font>
					</td>
				</tr>
			</table>");
	} else {print("<font color='#FF0000'>
						* Error: show visit
					</font>
						</br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db)."
						</br>");
						
						}

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_visit(){

	global $db;
	global $db_name;
	global $rowv;
	global $sumavisit;
	
	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqlv =  "SELECT * FROM $table_name_c";
	$qv = mysqli_query($db, $sqlv);
	$rowv = mysqli_fetch_assoc($qv);
	
	$_SESSION['admin'] = $rowv['admin'];
	
	$tot = $rowv['admin'];

	global $sumavisit;
	$sumavisit = $tot + 1;

	$idv = 69;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqlv = "UPDATE `$db_name`.$table_name_c SET `admin` = '$sumavisit' WHERE $table_name_c.`idv` = '$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqlv)){
		/**/	print(" </br>");
										} 
				
				 else {
				print("<font color='#FF0000'>
						* Error: suma visit</font>
						</br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db)."
						</br>");
						
							}
								}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_acces(){

	global $db;
	global $db_name;
	global $rowa;
	global $sumaacces;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqla =  "SELECT * FROM $table_name_c";
	$qa = mysqli_query($db, $sqla);
	$rowa = mysqli_fetch_assoc($qa);
	
	$_SESSION['acceso'] = $rowa['acceso'];
	
	$tota = $rowa['acceso'];

	global $sumaacces;
	$sumaacces = $tota + 1;

	$idv = 69;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqla = "UPDATE `$db_name`.$table_name_c SET `acceso` = '$sumaacces' WHERE $table_name_c.`idv` = '$idv' LIMIT 1 ";

	if(mysqli_query($db, $sqla)){ print ('</br>');
				} else {
				print("<font color='#FF0000'>
						* Error: suma access</font>
						</br>
						&nbsp;&nbsp;&nbsp;".mysqli_error($db)."
						</br>");
							}

			////////////////////		************   		////////////////////
	
	require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$date = date('Y/m/d');
	$time = date('H:i:s');

	global $table_name_b;
	$table_name_b = "`".$_SESSION['clave']."ipcontrol`";

	$sqlip = "INSERT INTO `$db_name`.$table_name_b (`ref`, `nivel`, `ipn`, `error`, `acceso`, `date`, `time`) VALUES ('$_SESSION[ref]', '$_SESSION[Nivel]', '{$geoplugin->ip}', '0', '1', '$date', '$time')";
	if(mysqli_query($db, $sqlip)){ } else { print("* MODIFIQUE LA ENTRADA L.457: ".mysqli_error($db));}

	} // FIN FUNCTION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_denegado(){

	global $db;
	global $db_name;
	global $rowd;
	global $sumadeneg;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqld =  "SELECT * FROM $table_name_c";
	$qd = mysqli_query($db, $sqld);
	$rowd = mysqli_fetch_assoc($qd);
	
	$_SESSION['deneg'] = $rowd['deneg'];
	
	$dng = $rowd['deneg'];
	
	global $sumadeneg;
	$sumadeneg = $dng + 1;

	$idd = 69;

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$sqld = "UPDATE `$db_name`.$table_name_c SET `deneg` = '$sumadeneg' WHERE $table_name_c.`idv` = '$idd' LIMIT 1 ";

	if(mysqli_query($db, $sqld)){/*	print("	</br>");*/
		
				}  else {	print("<font color='#FF0000'>
									* Error: suma denegado</font>
									</br>
									&nbsp;&nbsp;&nbsp;".mysqli_error($db)."
									</br>");
								}
	
			////////////////////		**********   		////////////////////
	
	require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$date = date('Y/m/d');
	$time = date('H:i:s');

	global $table_name_b;
	$table_name_b = "`".$_SESSION['clave']."ipcontrol`";

	$sqlip = "INSERT INTO `$db_name`.$table_name_b (`ref`, `nivel`, `ipn`, `error`, `acceso`, `date`, `time`) VALUES ('anonimo', 'anonimo', '{$geoplugin->ip}', '1', '0', '$date', '$time')";
	if(mysqli_query($db, $sqlip)){ } else { print("* MODIFIQUE LA ENTRADA L.477: ".mysqli_error($db));}

	bloqueo();
	
	} // FIN FUNCTION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	global $db;
	global $db_name;

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqlp =  "SELECT * FROM $table_name_a WHERE `Usuario` = '$_POST[Usuario]' ";
	$qp = mysqli_query($db, $sqlp);
	$rn = mysqli_fetch_assoc($qp);
	$count = mysqli_num_rows($qp);

	global $password;
	$password = $_POST['Password'] ;
	global $hash;
	global $row;
	$hash = @$row['Password'];
	//echo $row['Password']."<br>";
	//echo $hash;

	$errors = array();
	
		global $sql;
		global $q;
		
		if (strlen(trim($_POST['Usuario'])) == 0){
			//$errors [] = "Usuario: Campo obligatorio.";
			$errors [] = "USER ACCES ERROR";
			}

		elseif (strlen(trim($_POST['Password'])) == 0){
			//$errors [] = "Password: Campo Obligatorio:";
			$errors [] = "USER ACCES ERROR";
			}

		elseif($count < 1){
			//$errors [] = "Nombre incorrecto.";
			$errors [] = "USER ACCES ERROR";
			}

		elseif(!password_verify($_POST['Password'], $hash)){
			if(trim($_POST['Password'] != $row['Pass'])){
				//$errors [] = "Password incorrecto.";
				$errors [] = "USER ACCES ERROR";
				} else {}
	
			}
		
		elseif ($rn['Nivel'] == 'close'){
			$errors [] = "ACCESO RESTRINGIDO POR EL WEB MASTER";
			}
	
	return $errors;

		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_formp(){
	
	global $db;
	global $db_name;

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqlp =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$_POST[pin]' ";
	$qp = mysqli_query($db, $sqlp);
	$cp = mysqli_num_rows($qp);
	
	$errorsp = array();
	
	if (strlen(trim($_POST['pin'])) == 0){
		//$errorsp [] = "PIN: Campo obligatorio.";
		$errorsp [] = "USER ACCES PIN ERROR";
		}

	elseif (strlen(trim($_POST['pin'])) < 8){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
		}

	elseif (strlen(trim($_POST['pin'])) > 8){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
		}
	
	elseif (!preg_match('/^[A-Z\d]+$/',$_POST['pin'])){
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

		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


function process_form(){
	
	global $db;
					
	if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){				 
	//print("Wellcome: ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].".");
	master_index();
	print("<embed src='audi/sesion_open.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' ></embed>");
			admin_entrada();
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
	
	global $db;
	global $db_name;
	
	global $vname;
	$tabla1 = $_SESSION['clave'].$_SESSION['ref'];
	$tabla1 = strtolower($tabla1);
	$vname = $tabla1."_".date('Y');
	$vname = "`".$vname."`";

	// FICHA ENTRADA O SALIDA.
	
	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);

	// FICHA ENTRADA.
	
	if($count1 < 1){
		
		global $din;
		global $tin;
		$din = date('Y-m-d');

		/*
			HORA ORIGINAL DE ENTRADA DEL SCRIPT
			$tin = date('H:i:s');
		*/

		require 'fichar/fichar_redondeo_in.php';

			////////////////////		***********  		////////////////////

		global $dout;
		global $tout;
		global $ttot;
		$dout = '';
		$tout = '00:00:00';
		$ttot = '00:00:00';
		
	print("<table align='center' style=\"margin-top:2px\">
			<tr>
				<td>
					".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].". Ref: ".$_SESSION['ref']."
				</td>
					<td valign='middle'  align='center'>
	<form name='form_datos' method='post' action='fichar/fichar_Crear.php' enctype='multipart/form-data'>
		<input type='hidden' id='ref' name='ref' value='".$_SESSION['ref']."' />
		<input type='hidden' id='name1' name='name1' value='".$_SESSION['Nombre']."' />
		<input type='hidden' id='name2' name='name2' value='".$_SESSION['Apellidos']."' />
		<input type='hidden' id='din' name='din' value='".$din."' />
		<input type='hidden' id='tin' name='tin' value='".$tin."' />
		<input type='hidden' id='dout' name='dout' value='".$dout."' />
		<input type='hidden' id='tout' name='tout' value='".$tout."' />
		<input type='hidden' id='ttot' name='ttot' value='".$ttot."' />
				<input type='submit' value='FICHAR ENTRADA' class='botonverde' />
				<input type='hidden' name='entrada' value=1 />
	</form>														
				</td>
			</tr>
			</table>"); 
		}
	
	// FICHA SALIDA.
	
	elseif($count1 > 0){
		
		global $dout;
		global $tout;
		global $ttot;
		$dout = date('Y-m-d');

		/*
			HORA ORIGINAL DE SALIDA DEL SCRIPT
			$tout = date('H:i:s');
		*/

		require 'fichar/fichar_redondeo_out.php';

			////////////////////		***********  		////////////////////

	print("<table align='center' style=\"margin-top:6px\">
			<tr>
				<td>
					".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].". Ref: ".$_SESSION['ref']."
				</td>
				<td valign='middle'  align='center'>
	<form name='form_datos' method='post' action='fichar/fichar_Crear.php' enctype='multipart/form-data'>
		<input type='hidden' id='ref' name='ref' value='".$_SESSION['ref']."' />
		<input type='hidden' id='name1' name='name1' value='".$_SESSION['Nombre']."' />
		<input type='hidden' id='name2' name='name2' value='".$_SESSION['Apellidos']."' />
		<input type='hidden' id='dout' name='dout' value='".$dout."' />
		<input type='hidden' id='tout' name='tout' value='".$tout."' />
						<input type='submit' value='FICHAR SALIDA' class='botonverde' />
						<input type='hidden' name='salida' value=1 />
		</form>														
					</td>
				</tr>
			</table>"); 
		
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

	if ($cp > 0){
	
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
		
		global $din;
		global $tin;
		$din = date('Y-m-d');

		/*
			HORA ORIGINAL DE ENTRADA DEL SCRIPT
			$tin = date('H:i:s');
		*/

		require 'fichar/fichar_redondeo_in.php';

			////////////////////		***********  		////////////////////

		global $dout;
		global $tout;
		global $ttot;
		$dout = '';
		$tout = '00:00:00';
		$ttot = '00:00:00';
		
	print("<table align='center' style=\"margin-top:6px\">
			<tr>
				<td>
	<img src='Users/".$rp['ref']."/img_admin/".$rp['myimg']."' height='40px' width='30px' />
				</td>
				<td>
					".$rp['Nombre']." ".$rp['Apellidos'].". Ref: ".$rp['ref']."
				</td>
				<td valign='middle'  align='center'>
	<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
		<input name='myimg' type='hidden' value='".$rp['myimg']."' />
		<input type='hidden' id='ref' name='ref' value='".$rp['ref']."' />
		<input type='hidden' id='name1' name='name1' value='".$rp['Nombre']."' />
		<input type='hidden' id='name2' name='name2' value='".$rp['Apellidos']."' />
		<input type='hidden' id='din' name='din' value='".$din."' />
		<input type='hidden' id='tin' name='tin' value='".$tin."' />
		<input type='hidden' id='dout' name='dout' value='".$dout."' />
		<input type='hidden' id='tout' name='tout' value='".$tout."' />
		<input type='hidden' id='ttot' name='ttot' value='".$ttot."' />
					<input type='submit' value='FICHAR ENTRADA' class='botonverde' />
					<input type='hidden' name='entrada' value=1 />
	</form>														
				</td>
			<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' >
				<td valign='middle'  align='center'>
						<input type='submit' value='CANCELAR Y VOLVER' class='botonnaranja' />
						<input type='hidden' name='cancel' value=1 />
				</td>
			</form>
		</tr>
<embed src='audi/conf_user_data.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
</embed>
	</table>"); 
		}
	
	// FICHA SALIDA.
	
	elseif($count1 > 0){
		
		global $dout;
		global $tout;
		global $ttot;
		$dout = date('Y-m-d');
		$tout = date('H:i:s');

		/*
			HORA ORIGINAL DE SALIDA DEL SCRIPT
			$tout = date('H:i:s');
		*/

		require 'fichar/fichar_redondeo_out.php';

			////////////////////		***********  		////////////////////

	print("<table align='center' style=\"margin-top:6px\">
			<tr>
				<td>
	<img src='Users/".$rp['ref']."/img_admin/".$rp['myimg']."' height='40px' width='30px' />
				</td>
				<td>
					".$rp['Nombre']." ".$rp['Apellidos'].". Ref: ".$rp['ref']."
				</td>
				<td valign='middle'  align='center'>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
			<input name='myimg' type='hidden' value='".$rp['myimg']."' />
			<input type='hidden' id='ref' name='ref' value='".$rp['ref']."' />
			<input type='hidden' id='name1' name='name1' value='".$rp['Nombre']."' />
			<input type='hidden' id='name2' name='name2' value='".$rp['Apellidos']."' />
			<input type='hidden' id='dout' name='dout' value='".$dout."' />
			<input type='hidden' id='tout' name='tout' value='".$tout."' />
						<input type='submit' value='FICHAR SALIDA' class='botonverde' />
						<input type='hidden' name='salida' value=1 />
		</form>														
					</td>
				<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' >
					<td valign='middle'  align='center'>
							<input type='submit' value='CANCELAR Y VOLVER' class='botonnaranja' />
							<input type='hidden' name='cancel' value=1 />
					</td>
				</form>
			</tr>
<embed src='audi/conf_user_data.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
</embed>
	</table>"); 
		
		}
	
	ayear();
		
	}else{		print("<table align='center' style='margin-top:10px' width=450px >
				<tr>
					<th class='BorderInf'>
					<b>
					<font color='#FF0000'>
						NO EXISTE EL USUARIO.
						</br>
						PONGASE EN CONTACTO CON ADMIN SYSTEM.
					</font>
					</b>
					</th>
				 </tr>
				 <tr>
					<td valign='middle'  align='center'>
				 	<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' >
						<input type='submit' value='CANCELAR Y VOLVER' class='botonnaranja' />
						<input type='hidden' name='cancel' value=1 />
					</form>
					</td>
				</tr>
	<embed src='audi/user_lost.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
	</embed>
		</table>");

	 	global $redir;
		$redir = "<script type='text/javascript'>
							function redir(){
							window.location.href='index.php';
						}
						setTimeout('redir()',4000);
						</script>";
			print ($redir);
		 	}			
		
} // FIN FUNCTION process_pin()


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function pin_out(){
	
	global $db;
	global $db_name;
	
	$_SESSION['usuarios'] = $_POST['ref'];

	global $vname;
	$tabla1 = $_SESSION['clave'].$_POST['ref'];
	$tabla1 = strtolower($tabla1);
	$vname = $tabla1."_".date('Y');
	$vname = "`".$vname."`";

	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);
	$row1 = mysqli_fetch_assoc($q1);
	global $din;
	global $tin;
	$din = trim($row1['din']);
	$tin = trim($row1['tin']);
	global $in;
	$in = $din." ".$tin;
	global $dout;
	global $tout;
	$dout = trim($_POST['dout']);
	$tout = trim($_POST['tout']);
	global $out;
	$out = $dout." ".$tout;
	
	$fecha1 = new DateTime($in);//fecha inicial
	$fecha2 = new DateTime($out);//fecha de cierre

	global $difer;
	$difer = $fecha1->diff($fecha2);
	//print ($difer);
	
	global $ttot;
	$ttot = $difer->format('%H:%i:%s');

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
	

	if (($ttoth > 9)||($ttotd > 0)){
		
		print("<table align='center' style='margin-top:10px' width=450px >
				<tr>
					<th class='BorderInf'>
					<b>
					<font color='#FF0000'>
						NO PUEDE FICHAR MÁS DE 10 HORAS.</br>PONGASE EN CONTACTO CON ADMIN SYSTEM.
					</font>
					</b>
					</th>
				 </tr>
				</table>");
		
					global $ttot;
					$ttot = '03:22:02';
					global $text;
					$text = PHP_EOL."*** ERROR CONSULTE ADMIN SYSTEM ***";
					$text = $text.PHP_EOL."\t- FICHA SALIDA ".$_POST['dout']." / ".$_POST['tout'];
					$text = $text.PHP_EOL."\t- N HORAS: ".$ttot;

					} /* fin if >9 */

			else {	global $ttot;
					global $text;
					$text = PHP_EOL."** F. SALIDA ".$_POST['dout']." / ".$_POST['tout'];
					$text = $text.PHP_EOL."\t- N HORAS: ".$ttot;

			 } /* Fin else >9 */
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	$tabla = "<table style='margin-top:10px' width=320px >
				<tr>
					<th colspan=2 align='center' class='BorderInf'>
						HA FICHADO LA SALIDA</br>".$_POST['name1']." ".$_POST['name2']."
					</th>
				</tr>
				<tr>
					<td colspan=2 align='center'>
		<img src='Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."' height='40px' width='30px' />
					</td>
				</tr>
				<tr>
					<td>REFERENCIA</td><td>".$_POST['ref']."</td>
				</tr>
				<tr>
					<td>FECHA ENTRADA</td><td>".$din."</td>
				</tr>
				<tr>
					<td>HORA ENTRADA</td><td>".$tin."</td>
				</tr>
				<tr>
					<td>FECHA SALIDA</td><td>".$_POST['dout']."</td>
				</tr>
				<tr>
					<td>HORA SALIDA</td><td>".$_POST['tout']."</td>
				</tr>
				<tr>
					<td>HORAS REALIZADAS</td><td>".$ttot."</td>
				</tr>
				<tr>
					<td colspan=2  valign='middle'  align='center'>
						<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' >
							<input type='submit' value='VOLVER INICIO' class='botonverde' />
							<input type='hidden' name='cancel' value=1 />
						</form>	
					</td>
				</tr>
			</table>
			<embed src='audi/salida.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
			</embed>";	
		
	//print($in." / ".$out." / ".$ttot."</br>");
	//echo $difer->format('%Y años %m meses %d days %H horas %i minutos %s segundos');
						//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos

	$sqla = "UPDATE `$db_name`.$vname SET `dout` = '$_POST[dout]', `tout` = '$_POST[tout]', `ttot` =  '$ttot' WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
		
		if(mysqli_query($db, $sqla)){ 
			
			print($tabla); 
			suma_todo();

					global $dir;
					$dir = "Users/".$_POST['ref']."/mrficha";

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
	
		} else {
					print("* MODIFIQUE LA ENTRADA L.1054: ".mysqli_error($db));
							show_form2();
							show_form ();
							global $texerror;
							$texerror = PHP_EOL."\t ".mysqli_error($db);
					}
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function pin_in(){
	
	$tabla = "<table style='margin-top:10px' width=320px >
				<tr>
					<th colspan=2 align='center' class='BorderInf'>
						HA FICHADO LA ENTRADA</br>".$_POST['name1']." ".$_POST['name2']."
					</th>
				</tr>
				<tr>
					<td colspan=2 align='center'>
	<img src='Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."' height='40px' width='30px' />
					</td>
				</tr>
				<tr>
					<td>REFERENCIA</td><td>".$_POST['ref']."</td>
				</tr>
				<tr>
					<td>FECHA ENTRADA</td><td>".$_POST['din']."</td>
				</tr>
				<tr>
					<td>HORA ENTRADA</td><td>".$_POST['tin']."</td>
				</tr>
				<tr>
					<td colspan=2  valign='middle'  align='center'>
						<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' >
							<input type='submit' value='VOLVER INICIO' class='botonverde' />
							<input type='hidden' name='cancel' value=1 />
						</form>
					</td>
				</tr>
	<embed src='audi/entrada.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' ></embed>
		</table>";	
		
	global $db;  	global $db_name;
	
	$_SESSION['usuarios'] = $_POST['ref'];

	global $vname;
	$tabla1 = $_SESSION['clave'].$_POST['ref'];
	$tabla1 = strtolower($tabla1);
	$vname = "`".$tabla1."_".date('Y')."`";

	$sqla = "INSERT INTO `$db_name`.$vname (`ref`, `Nombre`, `Apellidos`, `din`, `tin`, `dout`, `tout`, `ttot`) VALUES ('$_POST[ref]', '$_POST[name1]', '$_POST[name2]', '$_POST[din]', '$_POST[tin]', '$_POST[dout]', '$_POST[tout]', '$_POST[ttot]')";
		
	if(mysqli_query($db, $sqla)){ 
		
			print($tabla);
		
			global $dir;
			$dir = "Users/".$_SESSION['usuarios']."/mrficha";

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

		} else {
					print("* MODIFIQUE LA ENTRADA L.1151: ".mysqli_error($db));
							show_form2();
							show_form ();
							global $texerror;
							$texerror = PHP_EOL."\t ".mysqli_error($db);
				}
	
	}	


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

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form2($errorsp=''){
	
	if(isset($_POST['pin'])){
		$defaults = $_POST;
		} else {$defaults = array ('pin' => '');}
	
	if ($errorsp){
		print("	<table align='center'>
					<tr>
						<td style='text-align:center'>
							<!--
							<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
							-->
							<font color='#FF0000'>ERROR ACCESO PIN</font>
						</td>
					</tr>
					<!--
					<tr>
						<td style='text-align:left'>
					-->");
			
		/*
		for($a=0; $c=count($errorsp), $a<$c; $a++){
			print("<font color='#FF0000'>**</font>  ".$errorsp [$a]."<br/>");
			}
		*/
		print("<!--</td>
				  </tr>-->
	<embed src='audi/pin_error.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' ></embed>
		</table>");
		}
	
	print("<table style=\"margin-top:2px; margin-bottom:2px\" >
				<tr>
					<th colspan=3 width=100% valign='bottom' class='BorderInf'>FICHAR CON PIN</th>
				</tr>
				<tr>
					<td valign='middle'>
		<form name='pin' method='post' action='$_SERVER[PHP_SELF]'>	
		<input type='Password' name='pin' size=10 maxlength=8 value='".$defaults['pin']."' />
					</td>
					<td valign='middle' align='right' colspan='2'>
						<input type='submit' value='FICHAR CON SU PIN' class='botonverde' />
						<input type='hidden' name='ocultop' value=1 />
		</form>	
					</td>
				</tr>
				<tr>
					<td colspan=3 class='BorderSup' style='padding-top: 10px; text-align: center !important;'>
							<a href='indexcamini.php'>GO TO QR SCANNER CAM</a>
					</td>
				</tr>
			</table>"); 
	
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function desbloqueo(){
	
	require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	
	global $db;		global $db_name;

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
	} else { print("* ERROR ENTRADA 1678: ".mysqli_error($db))."."; }
	} elseif($cx < 1) { $_SESSION['showf'] = 0; }	
	
	global $blocker;
	$blocker = @$rowx['error'];
	if(strlen(trim(@$rowx['error'])) < 4){ @$rowx['error'] = "0".@$rowx['error'];}
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
	
	global $db;		global $db_name;
	
	$date = date('Y/m/d');
	
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
print("	<embed src='audi/ip_block.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
		</embed>");

		if(mysqli_query($db, $emarc)){ }else {print("* ERROR ENTRADA 95: ".mysqli_error($db)).".";}
	}else{ $_SESSION['showf'] = 0;}
		
} // FIN FUCNTION BLOQUEO

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	unset($_SESSION['usuarios']);
	unset($_SESSION['ref']);
	unset ($_SESSION['dni']);
	unset ($_SESSION['mydni']);
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
		} else {
				$defaults = array ('Usuario' => '',
								   'Password' => '');
								   }
	
	if ($errors){	
		print("<table align='center'>
					<!--
					<tr>
						<td style='text-align:center'>
							<font color='#FF0000'>* SOLUCIONE ESTOS ERRORES:</font><br/>
							<font color='#FF0000'>ERROR ACCESO USER</font>
						</td>
					</tr>
					-->
					<tr>
						<td style='text-align:left'>");

		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#FF0000'>".$errors [$a]."</font><br/>");
			}
		
		print("</td>
				  </tr>
	<embed src='audi/user_error.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
	</embed>
		</table>");
		}
	
	print(/**/"<table align='center' style=\"margin-top:2px; margin-bottom:2px\" >
				<tr>
					<th colspan=2 width=100% valign=\"bottom\" class='BorderInf'>
						SUS DATOS DE ACCESO
					</th>
				</tr>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<tr>
					<td>USUARIO</td>
					<td>
<input type='Password' name='Usuario' size=20 maxlength=50 value='".$defaults['Usuario']."' />
					</td>
				</tr>
				<tr>
					<td>PASSWORD</td>
					<td>
<input type='Password' name='Password' size=20 maxlength=50 value='".$defaults['Password']."' />
					</td>
				</tr>
				<tr>
					<td valign='middle' align='right' colspan='2'>
						<input type='submit' value='ACCEDER' class='botonverde' />
						<input type='hidden' name='oculto' value=1 />
		</form>	
					</td>
				</tr>
				<tr>
					<td colspan='2' align='center' valign='middle' class='BorderSup' style='padding-top: 10px'>
						<a href='Admin/Claves_Perdidas.php'>HE PERDIDO MIS CLAVES</a>
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
	
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $db;		global $db_name;
	
	global $dyt1;	$dyt1 = date('Y');
	global $dm1;	$dm1 = date('m');
	global $dd1;	$dd1 = '';
	global $fil;	$fil = "%".$dyt1."-%".$dm1."%-".$dd1."%";

	$tabla1 = $_SESSION['clave'].$_SESSION['ref'];
	$tabla1 = strtolower($tabla1);
	global $vname;
	$vname = "`".$tabla1."_".$dyt1."`";

	require 'fichar/Inc_Suma_Todo.php';

			////////////////////		**********  		////////////////////

	global $sqlb; 	global $qb;
	$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' ORDER BY  `din` ASC ";
	$qb = mysqli_query($db, $sqlb);
	
			////////////////////		**********  		////////////////////

	global $pdm;		$pdm = "pdm";
	global $feedtot;	$feedtot = "";
	global $name1;		$name1 = $_SESSION['Nombre'];
	global $name2;		$name2 = $_SESSION['Apellidos'];
	global $refses;		$refses = $_SESSION['ref'];
	global $nodata;		$nodata = "NO HAY DATOS ESTE MES ".date('Y/m');
	if(isset($_POST['dy']) == ''){ global $ycons;
							$ycons = date('Y');
	}else{ global $ycons;	$ycons = "20".$_POST['dy'];}
	global $twhile;
	$twhile = "<tr>
				<th colspan=6 class='BorderInf'>".$name1." ".$name2.". Ref: ".$refses." RESULTADOS.</th>
				</tr>";

	global $tdplus;			$tdplus = "";
	global $formularioh;	$formularioh = "";
	global $formulariof;	$formulariof = "";
	global $colspana;		$colspana = "6";
	global $colspanb;		$colspanb = "4";

	require 'fichar/Inc_Fichar_While_Total.php';

			////////////////////		**********  		////////////////////
		
	}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function salir() {	unset($_SESSION['id']);
						unset($_SESSION['Nivel']);
						unset($_SESSION['Nombre']);
						unset($_SESSION['Apellidos']);
						unset($_SESSION['doc']);
						unset($_SESSION['dni']);
						unset($_SESSION['ldni']);
						unset($_SESSION['Email']);
						unset($_SESSION['Usuario']);
						unset($_SESSION['Password']);
						unset($_SESSION['Direccion']);
						unset($_SESSION['Tlf1']);
						unset($_SESSION['Tlf2']);
						unset($_SESSION['nclient']);

						echo "<div class='centradiv'>YOU HAVE CLOSE SESSION</div>";
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	function master_index(){ 

	require $_SESSION['menu'].'/rutaindex.php';
	require $_SESSION['menu'].'/Master_Index.php';
		
				} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	require 'Inclu/Admin_Inclu_footer.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

require 'Inclu/misdatos.php';

 function admin(){	
  
	require_once('geo_class/geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();

	 $text_body = " <!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
				<html>
					<head>
						<title>Untitled Document</title>
						<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
						<meta http-equiv='content-type' content='text/html' charset='utf-8' />
						<meta http-equiv='Content-Language' content='es-es'>
						<META NAME='Language' CONTENT='Spanish'>
					</head>
						<body bgcolor='#D7F0E7'>
					<STYLE>
						body {
							font-family: 'Times New Roman', Times, serif;
						}
						body a {
							text-decoration:none;
						}
						table a {
							color: #666666;
							text-decoration: none;
							font-family: 'Times New Roman', Times, serif;
						}
						table a:hover {
							color: #FF9900;
							text-decoration: none;
						}
						tr {
							margin: 0px;
							padding: 0px;
						}
						td {
							margin: 0px;
							padding: 6px;
						}
						th {
							padding: 6px;
							margin: 0px;
							text-align: center;
							color: #666666;
						}
					</STYLE>
	<table font-family='Times New Roman' width='90%' border='0' align='center' cellpadding='0' cellspacing='0'>
				<tr>
					<th colspan='3'>
						ACCESO ".$_SESSION['Nombre']." ".$_SESSION['Apellidos']."
					</th>
				</tr>
				<tr>
					<th colspan='3'>MENSAJE AUTOMÁTICO</th>
				</tr>
				 <tr>
					<td align='right'>ASUNTO:</td>
					<td width='12'>&nbsp;</td>
					<td align='left'>ACCESO A CONTROL HORARIO LABORAL</td>
				</tr>
				<tr>
					<td align='right'>FECHA:</td>
					<td>&nbsp;</td>
					<td align='left'>".date('d-m-Y/H:i:s')."</td>
				</tr>
				<tr>
					<td align='right'>URL:</td>
					<td>&nbsp;</td>
					<td align='left'>".$_SERVER['HTTP_HOST']."/".$_SERVER['PHP_SELF']."</td>
				</tr>
				<tr>
					<td align='right'>SERVER NAME:</td>
					<td>&nbsp;</td>
					<td align='left'>".$_SERVER['SERVER_NAME']."</td>
				</tr>
				<tr>
					<td align='right'>SERVER IP:</td>
					<td>&nbsp;</td>
					<td align='left'>".$_SERVER['SERVER_ADDR']."</td>
				</tr>
				<tr>
					<td align='right'>SERVER ADMIN:</td>
					<td>&nbsp;</td>
					<td align='left'>".$_SERVER['SERVER_ADMIN']."</td>
				</tr>
					<tr>
					<td align='right'>IP ACCESS:</td>
					<td>&nbsp;</td>
					<td align='left'>".$_SERVER['REMOTE_ADDR']."</td>
				</tr>
				<tr>
					<td align='right'>GEOLOCATION FOR:</td>
					<td>&nbsp;</td>
					<td align='left'>{$geoplugin->ip}</td>
				</tr>
				<tr>
					<td align='right'>LONGITUD:</td>
					<td>&nbsp;</td>
					<td align='left'>{$geoplugin->longitude}</td>
				</tr>
					<tr>
					<td align='right'>LATITUD:</td>
					<td>&nbsp;</td>
					<td align='left'>{$geoplugin->latitude}</td>
				</tr>
				<tr>
					<td align='right'>COUNTRY NAME</td>
					<td>&nbsp;</td>
					<td align='left'>{$geoplugin->countryName}</td>
				</tr>
				<tr>
					<td align='right'>COUNTY CODE:</td>
					<td>&nbsp;</td>
					<td align='left'>{$geoplugin->countryCode}</td>
				</tr>
				<tr>
					<td align='right'>REGION:</td>
					<td>&nbsp;</td>
					<td align='left'>{$geoplugin->region}</td>
				</tr>
				<tr>
					<td align='right'>CITY:</td>
					<td>&nbsp;</td>
					<td align='left'>{$geoplugin->city}</td>
				</tr>
				<tr>
					<td align='right'>DMA CODE:</td>
					<td>&nbsp;</td>
					<td align='left'>{$geoplugin->dmaCode}</td>
				</tr>
					</table>
				</body>
			</html>";
			
	global $headers;		
	$headers = array ('From' => $_SESSION['mail_from'],
					  'Subject' => "ACCESO CONTROL HORARIO LABORAL");
				$destinatario= $_SESSION['mail_destin'];
				$titulo= "ACCESO ".$_SESSION['Nombre']." ".$_SESSION['Apellidos'].".";
				$responder= $_SESSION['mail_respon'];
				$remite= $_SESSION['mail_admin'];
				$remitente= $_SESSION['admin_url'];
				$separador = "_separador".md5 (uniqid (rand()));
				$cabecera = "Date: ".date('l j F Y, G:i')."\n";
				$cabecera .="MIME-Version: 1.0\n";
				$cabecera .="From: ".$remitente."<".$remite.">\n";
				$cabecera .="Return-path: ". $remite."\n";
				$cabecera .= "Reply-To: ".$remite."\n";
				$cabecera .="X-Mailer: PHP/". phpversion()."\n";
				$cabecera .= "Content-Type: multipart/mixed;"."\n";
				$cabecera .= " boundary=$separador"."\r\n\r\n";	/**/
				$texto_html ="\n"."--$separador"."\n";			/**/
				$texto_html .="Content-Type:text/html; charset=\'utf-8\'"."\n";
				$texto_html .="Content-Transfer-Encoding: 7bit"."\r\n\r\n";
				$texto_html .= $text_body;
				$mensaje= $texto_html;
			if( @mail($destinatario, $titulo, $mensaje, $cabecera)){print("");
							}else{print("");}
	 		}

/* Creado por Juan Barros Pazos 2020/2023 */

?>
