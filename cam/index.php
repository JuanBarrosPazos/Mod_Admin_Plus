<?php
session_start();
 
	//require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Inclu/mydni.php';

	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')){	

	require '../Inclu_MInd/rutacam.php';
	require '../Inclu_MInd/Master_Index.php';

	if(isset($_POST['entrada'])){
							pin_in();
							//errors();
	}elseif(isset($_POST['salida'])){
							pin_out();
							//errors();
	}elseif(isset($_POST['cancel'])) {
							red(); 
	}elseif(isset($_GET['ocultop'])){ 
							process_pin();
							//ayear();
							errors();
	}elseif(isset($_GET['pin']) != ''){
							process_pin();
							//ayear();
							errors();
	}else{ show_form2(); }

}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function red(){

	global $redir;
	$redir = "<script type='text/javascript'>
					function redir(){
					window.location.href='indexcam.php';
				}
				setTimeout('redir()',500);
			</script>";
	print($redir);

}
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function modif(){
									   							
	$filename = "../Users/".$_SESSION['ref']."/ayear.php";
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
	global $dat1;			$dat1 = "\tMODIFICADO Y ACTUALIZADO ".$filename.PHP_EOL;
}

function modif2(){

	$filename = "../Users/".$_SESSION['ref']."/year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);
	global $dat2;			$dat2 = "\tMODIFICADO Y ACTUALIZADO ".$filename.PHP_EOL;
}

function modif2b(){

	$filename = "../config/year.txt";
	$fw2 = fopen($filename, 'w+');
	$date = "".date('Y')."";
	fwrite($fw2, $date);
	fclose($fw2);
	global $dat3;			$dat3 = "\tMODIFICADO Y ACTUALIZADO ".$filename.PHP_EOL;
}

function tcl(){
	
	global $db;				global $db_name;
	global $vname;			$vname = "`".$_SESSION['clave'].$_SESSION['ref']."_".date('Y')."`";
	
	$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL,
  `Nombre` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `Apellidos` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `din` varchar(10) collate utf16_spanish2_ci NOT NULL,
  `tin` time NOT NULL,
  `dout` varchar(10) collate utf16_spanish2_ci NULL,
  `tout` time NULL,
  `ttot` time NULL,
  `error` varchar(5) NOT NULL default 'false',
  `del` varchar(5) NOT NULL default 'false',
  `dfeed` varchar(10) collate utf16_spanish2_ci NULL,
  `tfeed` time NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";

	global $dat4;	
	if(mysqli_query($db , $tcl)){
			$dat4 = "\t* OK TABLA ADMIN ".$vname.PHP_EOL;
	}else{
			$dat4 = "\t* NO OK TABLA ADMIN. ".mysqli_error($db).PHP_EOL;
	}

}
					
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ayear(){
	$filename = "../Users/".$_SESSION['ref']."/year.txt";
	$fw2 = fopen($filename, 'r+');
	$fget = fgets($fw2);
	fclose($fw2);
	
	if($fget == date('Y')){
		/*print(" <div style='clear:both'></div>
				<div style='width:200px'>* EL AÑO ES EL MISMO</br>&nbsp;&nbsp;&nbsp;".date('Y')." == ".$fget."</div>"); */
	}elseif($fget != date('Y')){ 
		print(" <div style='clear:both'></div>
				<div style='width:200px'>* EL AÑO HA CAMBIADO</div>");/*</br>&nbsp;&nbsp;&nbsp;".date('Y')." != ".$fget." */
		modif();
		modif2();
		modif2b();
		tcl();
		global $dat1;	global $dat2;	global $dat3;	global $dat4;
		global $datos;			$datos = $dat1.$dat2.$dat3.$dat4.PHP_EOL;
	}
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_formp(){
	
	global $db;					global $db_name;

	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqlp =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$_POST[pin]' ";
	$qp = mysqli_query($db, $sqlp);
	$cp = mysqli_num_rows($qp);
	
	$errorsp = array();
	
	if(strlen(trim($_POST['pin'])) == 0){
		//$errorsp [] = "PIN: Campo obligatorio.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}elseif(strlen(trim($_POST['pin'])) < 8){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}elseif(strlen(trim($_POST['pin'])) > 8){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}elseif(!preg_match('/^[A-Z\d]+$/',$_POST['pin'])){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}/*elseif(!preg_match('/^[^a-z@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,\/:\.\*]+$/',$_POST['pin'])){
		$errors [] = "PIN: Incorrecto.";
		}

	elseif(!preg_match('/^[^a-z]+$/',$_POST['pin'])){
		$errors [] = "PIN: Incorrecto.";
	}*/elseif($cp == 0){
		//$errorsp [] = "PIN: Incorrecto.";
		$errorsp [] = "USER ACCES PIN ERROR";
	}

	return $errorsp;

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function errors(){
	
	global $db;				global $db_name;
	global $sesus;			$sesus = $_SESSION['ref'];

	require '../fichar/Inc_errors.php';

}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_pin(){
	
	global $db;					global $db_name;
	
	global $qrp;
	
	if((isset($_GET['ocultop']))||(isset($_GET['pin']) != '')){ $qrp = $_GET['pin']; 
	}else{ $qrp = $_POST['pin']; }
	
	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqlp =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$qrp' ";
	$qp = mysqli_query($db, $sqlp);
	$cp = mysqli_num_rows($qp);
	$rp = mysqli_fetch_assoc($qp);
	
	$_SESSION['usuarios'] = $rp['ref'];
	//$_SESSION['ref'] = $rp['ref'];

	if($cp > 0){
	
	$tabla1 = strtolower($_SESSION['clave'].$rp['ref']);
	global $vname;				$vname = "`".$tabla1."_".date('Y')."`";

	// FICHA ENTRADA O SALIDA.
	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);

	// FICHA ENTRADA.
		if($count1 < 1){
			
			global $din;			$din = date('Y-m-d');		
			global $tin;			$tin = date('H:i:s');
			global $dout;			$dout = '';
			global $tout;			$tout = '00:00:00';
			global $ttot;			$ttot = '00:00:00';
			
			global $ImgFormIndex;		$ImgFormIndex = 1;
			global $Action;				$Action = "action='$_SERVER[PHP_SELF]'";
			global $ImgForm;
			$ImgForm = "<li class='liCentra'>
							<img src='../Users/".$rp['ref']."/img_admin/".$rp['myimg']."' />
						</li>";
			global $FormButtonHome;
			$FormButtonHome = "<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block; margin-right:10%;'>
					<button type='submit' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='cancel' value=1 />
				</form>";
			global $rutaAudio;
			$rutaAudio = "<audio src='../audi/conf_user_data.mp3' autoplay></audio>";
			require '../fichar/Fichar_Tablas_Form.php';
			print($FichaIn);
			
			global $redir;
			$redir = "<script type='text/javascript'>
								function redir(){
								window.location.href='indexcam.php';
							}
							setTimeout('redir()',14000);
							</script>";
			//print($redir);
		// FICHA SALIDA.
		}elseif($count1 > 0){
			
			global $dout;			$dout = date('Y-m-d');
			global $tout;			$tout = date('H:i:s');
			global $ttot;

			global $ImgFormIndex;	$ImgFormIndex = 1;
			global $Action;			$Action = "action='$_SERVER[PHP_SELF]'";
			global $ImgForm;
			$ImgForm = "<li class='liCentra'>
							<img src='../Users/".$rp['ref']."/img_admin/".$rp['myimg']."' />
						</li>";
			global $FormButtonHome;
			$FormButtonHome = "<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' style='display: inline-block; margin-right:10%;' >
					<button type='submit' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='cancel' value=1 />
				</form>";
			global $rutaAudio;
			$rutaAudio = "<audio src='../audi/conf_user_data.mp3' autoplay></audio>";
			require '../fichar/Fichar_Tablas_Form.php';
			print($FichaOut);

		}
		
		ayear();
			
	}else{ print("<div class='centradiv alertdiv' >
							NO EXISTE EL USUARIO.
							</br>
							PONGASE EN CONTACTO CON ADMIN SYSTEM.
					<form name='fcancel' method='post' action='$_SERVER[PHP_SELF]' >
							<input type='submit' value='CANCELAR Y VOLVER' class='botonnaranja' />
							<input type='hidden' name='cancel' value=1 />
					</form>
				</div>
				<audio src='../audi/user_lost.mp3' autoplay></audio>");

		global $redir;
		$redir = "<script type='text/javascript'>
							function redir(){
							window.location.href='indexcam.php';
						}
						setTimeout('redir()',4000);
						</script>";
		//print($redir);

	}			
		
} // FIN FUNCTION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function pin_out(){
	
	global $db;				global $db_name;
	
	$_SESSION['usuarios'] = $_POST['ref'];

	$tabla1 = strtolower($_SESSION['clave'].$_POST['ref']);
	global $vname;			$vname = "`".$tabla1."_".date('Y')."`";

	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);
	$row1 = mysqli_fetch_assoc($q1);

	require '../fichar/Fichar_Salida.php';
	global $imgTabla;
	$imgTabla = "<li class='liCentra'>
					<img src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."' />
				</li>";
	global $rutaAudio;
	$rutaAudio = "<audio src='../audi/salida.mp3' autoplay></audio>";
	global $rutaHome;		$rutaHome = "indexcam.php";
	global $rutaRedir;		$rutaRedir = "indexcam.php";
	global $TablaOut;
	require '../fichar/Fichar_Tablas_Resum.php';
	
	//print($in." / ".$out." / ".$ttot."</br>");
	//echo $difer->format('%Y años %m meses %d days %H horas %i minutos %s segundos');
						//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos

	$sqla = "UPDATE `$db_name`.$vname SET `dout` = '$_POST[dout]', `tout` = '$_POST[tout]', `ttot` =  '$ttot', `error` = '$terror' WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
		
	if(mysqli_query($db, $sqla)){ 
			
		print($TablaOut); 
		suma_todo();

		global $dir;			$dir = "../Users/".$_POST['ref']."/mrficha";

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
			
	}else{	print("ERROR SQL L.497: ".mysqli_error($db));
			show_form2();
			show_form ();
			global $texerror;			$texerror = PHP_EOL."\t ".mysqli_error($db);
	}
	
}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function pin_in(){
	
	global $imgTabla;
	$imgTabla = "<li class='liCentra'>
					<img src='../Users/".$_POST['ref']."/img_admin/".$_POST['myimg']."' />
				</li>";
	global $rutaAudio;
	$rutaAudio = "<audio src='../audi/entrada.mp3' autoplay></audio>";
	global $rutaHome;		$rutaHome = "indexcam.php";
	global $rutaRedir;		$rutaRedir = "indexcam.php";
	global $TablaIn;
	require '../fichar/Fichar_Tablas_Resum.php';
	
	global $db;				global $db_name;
	
	$_SESSION['usuarios'] = $_POST['ref'];

	$tabla1 = $_SESSION['clave'].$_POST['ref'];
	$tabla1 = strtolower($tabla1);
	global $vname;			$vname ="`". $tabla1."_".date('Y')."`";

	$sqla = "INSERT INTO `$db_name`.$vname (`ref`, `Nombre`, `Apellidos`, `din`, `tin`, `dout`, `tout`, `ttot`) VALUES ('$_POST[ref]', '$_POST[name1]', '$_POST[name2]', '$_POST[din]', '$_POST[tin]', '$_POST[dout]', '$_POST[tout]', '$_POST[ttot]')";
		
	if(mysqli_query($db, $sqla)){ 
		
			print($TablaIn);

			global $dir;		$dir = "../Users/".$_SESSION['usuarios']."/mrficha";

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
		
	}else{ 	print("* MODIFIQUE LA ENTRADA L.1151: ".mysqli_error($db));
			show_form2();
			show_form ();
			global $texerror;			$texerror = PHP_EOL."\t ".mysqli_error($db);
	}
	
}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_todo(){
		
	global $db;				global $db_name;
	
	global $dyt;			$dyt = date('Y');
	global $dm;				$dm = "-".date('m')."-";
	global $dd;				$dd = '';
	global $fil;			$fil = $dyt.$dm."%";

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;			$vname = "`".$tabla1."_".$dyt."`";

	global $ruta;			$ruta = '../';
	require '../fichar/Inc_Suma_Todo.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form2($errorsp=''){
	
	if(isset($_POST['pin'])){
		$defaults = $_POST;
	}else{$defaults = array ('pin' => '');}
	
	if($errorsp){
		print("<div class='centradiv alertdiv'>
						<!--
						<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font><br>
						-->
						<font color='#F1BD2D'>ERROR ACCESO PIN</font>");
			
		/*
		for($a=0; $c=count($errorsp), $a<$c; $a++){
			print("<font color='#F1BD2D'>**</font>  ".$errorsp [$a]."<br>");
			}
		*/
		print("</div>
				<audio src='../audi/pin_error.mp3' autoplay></audio>");
	}
	
	print("<div class='centradiv' >
					<a href='indexcam.php'>
								GO TO QR SCANNER CAM
						</a>
			</div>"); 
	
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>
