<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';

	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['todo'])){ show_form();							
							   ver_todo();
							   info();
	}else{ show_form(); }
								
}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $titulo;			$titulo = "FILTRO REGISTROS ";
	require 'Inc_Show_Form_tot.php';

}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $db;
	global $orden;
	require '../Inclu/orden.php';

	global $dyt1;		global $dy1;	global $dm1;		global $dd1;
	
	if($_POST['dy'] == ''){ $dy1 = '';
							$dyt1 = date('Y');	
							$_SESSION['gyear'] = date('Y');
	}else{	$dy1 = $_POST['dy'];
			$dyt1 = "20".$_POST['dy'];
			$_SESSION['gyear'] = "20".$_POST['dy'];									
	}

	if($_POST['dm'] == ''){ //$dm1 = '';
							$dm1 = "-".date('m')."-";
							$dm1 = "-%-";
							$_SESSION['gtime'] = '';
	}else{	$dm1 = "-".$_POST['dm']."-";
			$_SESSION['gtime'] = $_POST['dm'];	
	}

	if($_POST['dd'] == ''){ $dd1 = ''; }else{ $dd1 = $_POST['dd']; }
	
	global $fil;
	if(($_POST['dm'] == '')&&($_POST['dd'] != '')){	$dm1 = date('m');
													$dd1 = $_POST['dd'];
													$fil = $dy1."-%".$dm1."%-".$dd1."%";
	}else{ $fil = "%".$dy1.$dm1.$dd1."%"; }

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;		$vname = "`".$tabla1."_".$dyt1."`";

	global $ruta;		$ruta = '../';
	require 'Inc_Suma_Todo.php';

	global $sqlb;		global $TablaTitulo;
	if((isset($_POST['cherror']))&&(!isset($_POST['chbin']))){
		$sqlb =  "SELECT * FROM $vname WHERE (`din` LIKE '$fil' AND `ttot` = '00:00:01' AND `del` = 'false') ORDER BY $orden ";
		$TablaTitulo = "ERRORES ".$dyt1.": ";
	}elseif((isset($_POST['chbin']))&&(!isset($_POST['cherror']))){
		$sqlb =  "SELECT * FROM $vname WHERE (`din` LIKE '$fil' AND `del` = 'true') ORDER BY $orden ";
		$TablaTitulo = "PAPELERA ".$dyt1.": ";
	}else{
		$sqlb = "SELECT * FROM $vname WHERE (`din` LIKE '$fil' AND `dout` <> '' AND `del` = 'false') ORDER BY $orden ";
		$TablaTitulo = "TODO: ";
	}
	echo "** ".$sqlb."<br>";
	global $qb;
	$qb = mysqli_query($db, $sqlb);
	
			////////////////////		**********  		////////////////////

	global $refses;			$refses = $_SESSION['usuarios'];

	global $tablau;
	$sqlun =  "SELECT * FROM $tablau WHERE `ref` = '$refses' LIMIT 1 ";
	$qun = mysqli_query($db, $sqlun);

	global $name1;		global $name2;
	if(!$qun){ print("ERROR SQL L.100 ".mysqli_error($db)."</br>");
	}else{
		while($rowun = mysqli_fetch_assoc($qun)){
				$name1 = strtoupper($rowun['Nombre']);
				$name2 = strtoupper($rowun['Apellidos']);
		}
	}

	global $ycons;
	if($_POST['dy'] == ''){ $ycons = date('Y'); }else{ $ycons =	"20".$_POST['dy']; }

	require 'Inc_Fichar_While_Total.php';

}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
	require '../Inclu_MInd/rutafichar.php';
	require '../Inclu_MInd/Master_Index.php';
		
		} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $dd;
	if($_POST['dd'] == ''){ $dd = "DIA TODOS"; }else{ $dd = $_POST['dd']; }
	global $dm;
	if($_POST['dm'] == ''){ $dm = "MES ACTUAL"; }else{ $dm = $_POST['dm']; }
	global $dy;
	if($_POST['dy'] == ''){ $dy = date('Y'); }else{ $dy = "20".$_POST['dy']; }
	
	global $db;

	global $orden;
	require '../Inclu/orden.php';
	
	if(isset($_POST['todo'])){
		$filtro = PHP_EOL."\tFiltro => CONSULTAR TODOS MODIFICAR. ".$orden;
		$filtro = $filtro.PHP_EOL."\tDATE: ".$dy."/".$dm."/".$dd.".";
	}

	$ActionTime = date('H:i:s');

	global $dir;
	if($_SESSION['Nivel'] == 'admin'){ $dir = "../Users/".$_SESSION['ref']."/log"; }
	
	global $text;
	$text = PHP_EOL."- CONSULTAR TODOS MODIFICAR ".$_SESSION['usuarios'].". ".$ActionTime.$filtro;
	
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

	require '../Inclu/Admin_Inclu_footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */
?>