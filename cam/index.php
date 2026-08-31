<?php
session_start();

	//require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Inclu/mydni.php';

	require '../Conections/conection.php';
	require '../Conections/conect.php';
	

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

function tcl(){
	
	require '../config/ConfigTcl.php';

} // FIN function tcl()
					
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ayear(){
	
	require '../config/ConfigYear.php';

} // FIN ayear()

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
	
	global $db;			global $db_name;		global $qrp;
	
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
	
	//$tabla1 = strtolower($_SESSION['clave'].$rp['ref']);
	global $vname;		$vname = "`".strtolower($_SESSION['clave']."horarios_").date('Y')."`";

	// FICHA ENTRADA O SALIDA.
	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE `ref` = '$rp[ref]' AND `dout` = '' AND `tout` = '00:00:00' ";
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

	//$tabla1 = strtolower($_SESSION['clave'].$_POST['ref']);
	global $vname;		$vname = "`".strtolower($_SESSION['clave']."horarios_").date('Y')."`";

	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE `ref` = '$_SESSION[usuarios]' AND $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
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

	global $vname;		$vname = "`".strtolower($_SESSION['clave']."horarios_").date('Y')."`";

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

	//$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;		$vname = "`".strtolower($_SESSION['clave']."horarios_").$dyt."`";

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

/* Creado por © Juan Barros Pazos 2020/26 Licencia CC BY-NC-SA */

?>
