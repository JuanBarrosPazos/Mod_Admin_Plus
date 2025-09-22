<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Inclu/webmaster.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

/*
	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";
	$sqld =  "SELECT * FROM $table_name_a WHERE `ref` = '$_SESSION[ref]' AND `Usuario` = '$_SESSION[Usuario]'";
	$qd = mysqli_query($db, $sqld);
	$rowd = mysqli_fetch_assoc($qd);
*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if(($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'user')||($_SESSION['Nivel'] == 'plus')){

	master_index();

	if(isset($_POST['entrada'])){
						entrada();
						errors();
						info();
	}elseif(isset($_POST['salida'])){
						salida();
						errors();
						info();
	}else{ 	show_form();
			errors();
	}

}else{ require '../Inclu/tabla_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function errors(){
	
	global $db;			global $db_name;
	global $sesus; 		$sesus = $_SESSION['ref'];

	require 'Inc_errors.php';

}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function entrada(){
	
	global $imgTabla;		$imgTabla = "";
	global $rutaAudio;		$rutaAudio = "<audio src='../audi/entrada.mp3' autoplay></audio>";
	global $rutaHome;		$rutaHome = "Fichar_Crear.php";
	global $rutaRedir;		$rutaRedir = "Fichar_Crear.php";
	global $TablaIn;
	require 'Tablas_Resum_Fichar.php';

	global $db;				global $db_name;

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['ref']);
	global $vname;			$vname = "`".$tabla1."_".date('Y')."`";

	$sqla = "INSERT INTO `$db_name`.$vname (`ref`, `Nombre`, `Apellidos`, `din`, `tin`, `dout`, `tout`, `ttot`) VALUES ('$_POST[ref]', '$_POST[name1]', '$_POST[name2]', '$_POST[din]', '$_POST[tin]', '$_POST[dout]', '$_POST[tout]', '$_POST[ttot]')";
		
	if(mysqli_query($db, $sqla)){ 
		
		print($TablaIn);
		
		global $dir;			global $text;
		require 'log_fichar_in.php';
	
	}else{ print("* MODIFIQUE LA ENTRADA L.187: ".mysqli_error($db));
			show_form ();
			global $texerror;			$texerror = PHP_EOL."\t ".mysqli_error($db);
	}
	
}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
	
	global $db;				global $db_name;
	
	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['ref']);
	global $vname;			$vname = "`".$tabla1."_".date('Y')."`";

	// FICHA ENTRADA O SALIDA.
	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' ";
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

		require 'Fichar_Redondeo_in.php';

			////////////////////		***********  		////////////////////

		global $dout;			$dout = '';
		global $tout;			$tout = '00:00:00';
		global $ttot;			$ttot = '00:00:00';
		
	print("<ul class='centradiv'>
			<li class='liCentra'>FICHE SU ENTRADA</li>
			<li class='liCentra'>
				".strtoupper($_SESSION['Nombre'])." ".strtoupper($_SESSION['Apellidos']).".
			</li>
			<li class='liCentra'>REFER: ".strtoupper($_SESSION['ref'])."</li>
			<li class='liCentra'>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data' style='display:inline-block;'>
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
			</li>
		</ul>
		<audio src='../audi/confirm_sign_entry.mp3' autoplay></audio>"); 
	
	}elseif($count1 > 0){ // FICHA SALIDA.
		global $dout;			$dout = date('Y-m-d');
		global $tout;			global $ttot;
		/*
			HORA ORIGINAL DE SALIDA DEL SCRIPT
			$tout = date('H:i:s');
		*/

		require 'Fichar_Redondeo_out.php';

			////////////////////		***********  		////////////////////

		print("<ul class='centradiv'>
		<li class='liCentra'>FICHE SU SALIDA</li>
		<li class='liCentra'>
			".strtoupper($_SESSION['Nombre'])." ".strtoupper($_SESSION['Apellidos'])."
		</li>
		<li class='liCentra'>REFER: ".strtoupper($_SESSION['ref'])."</li>
		<li class='liCentra'>
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data' style='display:inline-block;'>
				<input type='hidden' id='ref' name='ref' value='".$_SESSION['ref']."' />
				<input type='hidden' id='name1' name='name1' value='".$_SESSION['Nombre']."' />
				<input type='hidden' id='name2' name='name2' value='".$_SESSION['Apellidos']."' />
				<input type='hidden' id='dout' name='dout' value='".$dout."' />
				<input type='hidden' id='tout' name='tout' value='".$tout."' />
					<button type='submit' title='FICHAR SALIDA' class='botonnaranja imgButIco Clock1Black' style='vertical-align:top;' ></button>
					<input type='hidden' name='salida' value=1 />
			</form>
		</li>
		</ul>
		<audio src='../audi/confirm_sign_exit.mp3' autoplay></audio>"); 
	}

		global $ficharCrear;		$ficharCrear = 1;
		require 'Fichar_Crear_Botonera.php';
	
} // FIN function show_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_todo(){
		
	global $db;				global $db_name;
	global $dyt;			$dyt = date('Y');
	global $dm;				$dm = "-".date('m')."-";
	global $dd;				$dd = '';
	global $fil;			$fil = $dyt.$dm."%";

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['ref']);
	global $vname;			$vname = "`".$tabla1."_".$dyt."`";

	global $ruta;		$ruta = '../';
	require 'Inc_Suma_Todo.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function salida(){
	
	global $db;				global $db_name;

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['ref']);
	global $vname;			$vname = "`".$tabla1."_".date('Y')."`";

	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);
	$row1 = mysqli_fetch_assoc($q1);

	require 'Fichar_Salida.php';

	global $imgTabla;		$imgTabla = "";
	global $rutaAudio;		$rutaAudio = "<audio src='../audi/salida.mp3' autoplay></audio>";
	global $rutaHome;		$rutaHome = "Fichar_Crear.php";
	global $rutaRedir;		$rutaRedir = "Fichar_Crear.php";
	global $TablaOut;
	require 'Tablas_Resum_Fichar.php';

	//print($in." / ".$out." / ".$ttot."</br>");
	//echo $difer->format('%Y años %m meses %d days %H horas %i minutos %s segundos');
						//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos

	$sqla = "UPDATE `$db_name`.$vname SET `dout` = '$_POST[dout]', `tout` = '$_POST[tout]', `ttot` =  '$ttot', `error` = '$terror' WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
		
	if(mysqli_query($db, $sqla)){ 
			
		print($TablaOut); 
		suma_todo();

		global $dir;		global $sumatodo;		global $text;
		require 'log_fichar_out.php';
		
	}else{ 	print("* MODIFIQUE LA ENTRADA L.334 ".mysqli_error($db));
			show_form ();
			global $texerror;			$texerror = PHP_EOL."\t ".mysqli_error($db);
	}
	
} // FIN function salida()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	//$ActionTime = date('H:i:s');

	global $dir;			$dir = "../Users/".$_SESSION['ref']."/log";
	
	global $text;
	$logdocu = $_SESSION['ref'];
	$logdate = date('Y-m-d');
	$logtext = $text.PHP_EOL;
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function master_index(){
		
	require '../Inclu_MInd/rutafichar.php';
	require '../Inclu_MInd/Master_Index.php';
		
} /* Fin funcion master_index.*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */
?>