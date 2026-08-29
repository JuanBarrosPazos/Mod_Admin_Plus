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
	
function tcl(){
	
	require 'config/ConfigTcl.php';

} // FIN function tcl()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function ayear(){

	require 'config/ConfigYear.php';

} // FIN function ayear()

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

/* Creado por © Juan Barros Pazos 2020/26 Licencia CC BY-NC-SA */

?>
