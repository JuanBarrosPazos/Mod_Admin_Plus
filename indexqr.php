<?php
session_start();
 
	require 'Inclu/error_hidden.php';
	require 'Inclu/Inclu_Menu_qr.php';
	require 'Conections/conection.php';
	require 'Conections/conect.php';
	require 'Inclu/my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if(isset($_GET['ocultop'])){ process_pinqr();
							 //ayear();
							 errors();
}elseif(isset($_POST['cancel'])) {	
						unset($_SESSION['usuarios']); 
}else{ 	process_pinqr();
		//ayear();
		errors();
}
												
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_pinqr(){
	
	global $db;					global $db_name;

	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqlp =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$_GET[pin]' ";
	$qp = mysqli_query($db, $sqlp);
	$cp = mysqli_num_rows($qp);
	$rp = mysqli_fetch_assoc($qp);
	
	//if($rp['ref']!=""){ $_SESSION['usuarios'] = strtolower($rp['ref']);	}else{ $_SESSION['usuarios'] = ""; }
	//$_SESSION['usuarios'] = strtolower($rp['ref'] ?? '');
	$_SESSION['usuarios'] = (!empty($rp['ref'])) ? strtolower($rp['ref']) : "";

	if($cp > 0){
	
		ayear();	
		
		//$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
		global $vname;		$vname = "`".strtolower($_SESSION['clave']."horarios_").date('Y')."`";
							
		// FICHA ENTRADA O SALIDA.
		global $table_admin;		$table_admin = "`".$_SESSION['clave']."admin`";

		//$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE `ref` = '$_SESSION[usuarios]' AND `dout` = '' AND `tout` = '00:00:00' ";

		$sql1 =  "SELECT hor.*, ad.`Nombre`, ad.`Apellidos` FROM `$db_name`.$vname AS hor, `$db_name`.$table_admin AS ad WHERE ad.`ref` = '$_SESSION[usuarios]' AND hor.`ref` = '$_SESSION[usuarios]' AND hor.`dout` = '' AND hor.`tout` = '00:00:00' ";

		$q1 = mysqli_query($db, $sql1);
		$count1 = mysqli_num_rows($q1);

		// FICHA ENTRADA.
		if($count1 < 1){
			global $din;			$din = date('Y-m-d');
			global $tin;
			/*
				HORA ORIGINAL DE ENTRADA DEL SCRIPT
				$tin = date('H:i:s');
			*/

			require 'fichar/Fichar_Redondeo_in.php';

			global $dout;			$dout = '';
			global $tout;			$tout = '00:00:00';
			global $ttot;			$ttot = '00:00:00';
			
			global $imgTabla;
			$imgTabla = "<li class='liCentra'>
							<img src='Users/".$_SESSION['usuarios']."/img_admin/".$rp['myimg']."' />
						</li>";
			global $rutaAudio;		$rutaAudio = "<audio src='audi/entrada.mp3' autoplay></audio>";
			global $rutaHome;		$rutaHome = "indexcamini.php";
			global $rutaRedir;		$rutaRedir = "indexcamini.php";
			global $TablaIn;
			require 'fichar/Fichar_Tablas_Resum.php';
			
			global $vname;		$vname = "`".strtolower($_SESSION['clave']."horarios_").date('Y')."`";

			$sqla = "INSERT INTO `$db_name`.$vname (`ref`, `din`, `tin`, `dout`, `tout`, `ttot`) VALUES ('$_SESSION[usuarios]', '$din', '$tin', '$dout', '$tout', '$ttot')";
		
			if(mysqli_query($db, $sqla)){

				print($TablaIn);
				
				global $dir;			$dir = "Users/".$_SESSION['usuarios']."/mrficha";
				global $text;			
				$text = PHP_EOL."\t- NOMBRE: ".$rp['Nombre']." ".$rp['Apellidos'];
				$text = $text.PHP_EOL."\t- USER REF: ".$_SESSION['usuarios'];
				$text = $text.PHP_EOL."** F. ENTRADA ".$din." / ".$tin;
				
				$rmfdocu = $_SESSION['usuarios'];
				$rmfdate = date('Y_m');
				$rmftext = $text.PHP_EOL;
				$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
				$rmf = fopen($filename, 'ab+');
				fwrite($rmf, $rmftext);
				fclose($rmf);
	
			}else{ 
				print("ERROR SQL L.85: ".mysqli_error($db));
				global $texerror;		$texerror = PHP_EOL."\t ".mysqli_error($db);
			}
		// FIN FICHA ENTRADA
		
		}elseif($count1 > 0){ // FICHA SALIDA.
		
			global $dout;			$dout = date('Y-m-d');
			global $tout;			global $ttot;
			/*
				HORA ORIGINAL DE SALIDA DEL SCRIPT
				$tout = date('H:i:s');
			*/

			require 'fichar/Fichar_Redondeo_out.php';

			global $vname;			$vname = "`".strtolower($_SESSION['clave']."horarios_").date('Y')."`";

			global $table_admin;	$table_admin = "`".$_SESSION['clave']."admin`";

			//$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE `ref` = '$_SESSION[usuarios]' AND `dout` = '' AND `tout` = '00:00:00' LIMIT 1 ";

			$sql1 =  "SELECT hor.*, ad.`Nombre`, ad.`Apellidos` FROM `$db_name`.$vname AS hor, `$db_name`.$table_admin AS ad WHERE ad.`ref` = '$_SESSION[usuarios]' AND hor.`ref` = '$_SESSION[usuarios]' AND hor.`dout` = '' AND hor.`tout` = '00:00:00' ";

			$q1 = mysqli_query($db, $sql1);
			$count1 = mysqli_num_rows($q1);
			$row1 = mysqli_fetch_assoc($q1);
			
			require 'fichar/Fichar_Salida.php';

			global $imgTabla;
			$imgTabla = "<li class='liCentra'>
							<img src='Users/".$_SESSION['usuarios']."/img_admin/".$rp['myimg']."' />
						</li>";
			global $rutaAudio;		$rutaAudio = "<audio src='audi/salida.mp3' autoplay></audio>";
			global $rutaHome;		$rutaHome = "indexcamini.php";
			global $rutaRedir;		$rutaRedir = "indexcamini.php";
			global $TablaOut;
			
			require 'fichar/Fichar_Tablas_Resum.php';

		//print($in." / ".$out." / ".$ttot."</br>");
		//echo $difer->format('%Y años %m meses %d days %H horas %i minutos %s segundos');
							//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos

		$sqla = "UPDATE `$db_name`.$vname SET `dout` = '$dout', `tout` = '$tout', `ttot` =  '$ttot', `error` = '$terror' WHERE `ref` = '$_SESSION[usuarios]' AND `dout` = '' AND `tout` = '00:00:00' LIMIT 1 ";
		
			if(mysqli_query($db, $sqla)){ 
					
				print($TablaOut);
				suma_todo();
						
				$dir = "Users/".$_SESSION['usuarios']."/mrficha";

				global $sumatodo;
				global $text;
				$text = $text.PHP_EOL."** H. TOT. MES: ".$sumatodo;
				$text = $text.PHP_EOL."**********".PHP_EOL;
				$rmfdocu = $_SESSION['usuarios'];
				$rmfdate = date('Y_m');
				$rmftext = $text.PHP_EOL;
				$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
				$rmf = fopen($filename, 'ab+');
				fwrite($rmf, $rmftext);
				fclose($rmf);
			
			}else{ 	print("* MODIFIQUE LA ENTRADA L.368: ".mysqli_error($db));
					global $texerror;		$texerror = PHP_EOL."\t ".mysqli_error($db);
			}
		} // FIN elseif($count1 > 0)
	
	}else{	// FIN if($cp > 0)
		print("<div class='centradiv' >
					<font color='#F1BD2D'>NO EXISTE EL USUARIO.
						<br>PONGASE EN CONTACTO CON ADMIN SYSTEM.
					</font>
			<form name='cancel' action='cam/indexcam.php' >
				<button type='submit' title='VOLVER INICIO' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
			</form>
			</div>
		<audio src='audi/user_lost.mp3' autoplay></audio>");
		global $redir;
		$redir = "<script type='text/javascript'>
					function redir(){
						window.location.href='indexcamini.php';
					}
					setTimeout('redir()',6000);
				</script>";
		print($redir);
	}	
	
} // FIN function process_pinqr

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_todo(){
		
	global $db;				global $db_name;
	
	global $dyt;			$dyt = date('Y');
	global $dm;				$dm = "-".date('m')."-";
	global $dd;				$dd = '';
	global $fil;			$fil = $dyt.$dm."%";

	$tabla1 = strtolower($_SESSION['clave']."horarios_");
	global $vname;			$vname = "`".$tabla1.$dyt."`";

	global $ruta;		$ruta = '';
	require 'fichar/Inc_Suma_Todo.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function errors(){
	
	global $db;				global $db_name;
	global $sesus;			$sesus = $_SESSION['usuarios'];

	require 'fichar/Inc_errors.php';

}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function modif(){
									   							
	global $filename;		$filename = "config/ayear.php";
	global $dat1;
	$dat1 = "SE COMPRUEBA EL CAMBIO DE AÑO Y SE MODIFICA EL ARCHIVO DE ARRAY ANUAL ".$filename;

	if(file_exists('config/ayear.php')){
		//$filename = "config/ayear.php";
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

		$dat1 = $dat1.PHP_EOL."\t* MODIFICADO: EXISTE EL ARCHIVO config/ayear.php";

	}elseif(!file_exists('config/ayear.php')){
		//$filename = "config/ayear.php";
		$fw = fopen($filename, 'w+');
		$contenido = "<?php\n\$dy = array (\n'' => 'YEAR',\n'".date('y')."' => '".date('Y')."',\n);\n?>";
			fwrite($fw, $contenido);
			//file_put_contents($fw, $contenido);
			fclose($fw);

		// Pasamos logs...
		$dat1 = $dat1.PHP_EOL."\t* CREADO: NO EXISTE EL ARCHIVO ../config/ayear.php";
	}else{
		$dat1 = $dat1.PHP_EOL."\t* ERROR DESCONOCIDO ../config/ayear.php";
	}
}

function modif2(){

	global $filename;		$filename = "config/year.txt";
	global $dat2;
	$dat2 = "SE COMPRUEBA EL CAMBIO DE AÑO Y SE MODIFICA EL ARCHIVO SI PROCEDE: ".$filename;

	if(file_exists('config/year.txt')){
		//$filename = "config/year.txt";
		$fw2 = fopen($filename, 'w+');
		$date = "".date('Y')."";
		fwrite($fw2, $date);
		fclose($fw2);

		$dat2 = $dat2.PHP_EOL."\tMODIFICADO Y ACTUALIZADO config/year.txt".$filename;

	}elseif(!file_exists('config/year.txt')){
			//$filename = "config/year.txt";
			//file_put_contents($filename, "");
			$dataYear = "".date('Y')."";
			$configYear = fopen($filename, 'w+');
			fwrite($configYear, $dataYear);
			fclose($configYear);

			$dat2 = $dat2.PHP_EOL."\t* CREADO: NO EXISTE EL ARCHIVO ../config/year.txt";
	}else{
			$dat2 = $dat2.PHP_EOL."\t* ERROR DESCONOCIDO ../config/year.txt";
	}
}

function tcl(){
	
	global $db_name; 			global $db;
	global $table_name_fk;		$table_name_fk = "`".$_SESSION['clave']."admin`";
	
	global $vname;		$vname = "`".strtolower($_SESSION['clave']."horarios_").date('Y')."`";
	
	$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname (
  `id` int NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL,
  /*`Nombre` varchar(25) collate utf16_spanish2_ci NOT NULL,*/
  /*`Apellidos` varchar(25) collate utf16_spanish2_ci NOT NULL,*/
  `din` varchar(10) collate utf16_spanish2_ci NOT NULL,
  `tin` time NOT NULL,
  `dout` varchar(10) collate utf16_spanish2_ci NULL,
  `tout` time NULL,
  `ttot` time NULL,
  `error` varchar(5) NOT NULL default 'false',
  `del` varchar(5) NOT NULL default 'false',
  `dfeed` varchar(10) collate utf16_spanish2_ci NULL,
  `tfeed` time NULL,
  UNIQUE KEY `id` (`id`),
  KEY `ref` (`ref`),
  FOREIGN KEY (`ref`) REFERENCES ".$table_name_fk."(`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	global $dat3;
	if(mysqli_query($db , $tcl)){
		$dat3 = "\t* CREADA OK TABLA ADMIN ".$vname.PHP_EOL;
	}else{
		$dat3 = "\t* NO CREADA TABLA ADMIN. ".mysqli_error($db).PHP_EOL;
	}
	
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function ayear(){

	global $dat1;	global $dat2;	global $dat3;
	global $datos;
	global $filename;		$filename = "config/year.txt";

	if(file_exists('config/year.txt')){
		//$filename = "config/year.txt";
		$fw2 = fopen($filename, 'r+');
		$fget = fgets($fw2);
		fclose($fw2);
		
		if($fget == date('Y')){
			/*print(" <div style='clear:both'></div>
					<div style='width:200px'>
						* EL AÑO ES EL MISMO</br>&nbsp;&nbsp;&nbsp;".date('Y')." == ".$fget."
					</div>"); */
		}elseif($fget != date('Y')){ 
			print(" <div style='clear:both'></div>
					<div style='width:200px'>* EL AÑO HA CAMBIADO</div>");
					/*</br>&nbsp;&nbsp;&nbsp;".date('Y')." != ".$fget." */
			modif();
			modif2();
			tcl();
			$datos = $dat1.$dat2.$dat3.PHP_EOL;

			global $dir;			$dir = "Users/".$_SESSION['usuarios']."/log";
	
			$logdocu = $_SESSION['usuarios'];
			$logdate = date('Y-m-d');
		
			$logtext = PHP_EOL."** EL AÑO HA CAMBIADO **".PHP_EOL.".\t User Ref: ".$_SESSION['usuarios'];
			$logtext = $logtext.PHP_EOL.$datos;

			$filename = $dir."/".$logdate."_".$logdocu.".log";
			$log = fopen($filename, 'ab+');
			fwrite($log, $logtext);
			fclose($log);
		}
	}elseif(!file_exists('config/year.txt')){
		//$filename = "config/year.txt";
		//file_put_contents($filename, "");
		$dataYear = "".date('Y')."";
		$configYear = fopen($filename, 'w+');
		fwrite($configYear, $dataYear);
		fclose($configYear);

		$datos = PHP_EOL."\t* CREADO: NO EXISTE EL ARCHIVO ../config/year.txt";
	}else{
		$datos = PHP_EOL."\t* ERROR DESCONOCIDO ../config/year.txt";
	}

} // FIN function ayear

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function salir(){	
	unset($_SESSION['id']);				unset($_SESSION['Nivel']);
	unset($_SESSION['Nombre']);			unset($_SESSION['Apellidos']);
	unset($_SESSION['doc']);			unset($_SESSION['dni']);
	unset($_SESSION['ldni']);			unset($_SESSION['Email']);
	unset($_SESSION['Usuario']);		unset($_SESSION['Password']);
	unset($_SESSION['Direccion']);		unset($_SESSION['Tlf1']);
	unset($_SESSION['Tlf2']);			unset($_SESSION['GetMacAdd']);
}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require 'Inclu/Admin_Inclu_footer.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>
