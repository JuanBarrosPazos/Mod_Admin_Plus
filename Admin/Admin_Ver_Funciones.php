<?php

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
		
		require 'Inc_Show_Form_01_Val.php';
		
		return $errors;

} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;
	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];

	show_form();
		
	$nom = "%".$_POST['Nombre']."%";
	$ape = "%".$_POST['Apellidos']."%";

	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";

	if(strlen(trim($_POST['Apellidos'])) == 0){$ape = $nom;}
	if(strlen(trim($_POST['Nombre'])) == 0){ $nom = $ape;}
	
	//$orden = $_POST['Orden'];
	global $qb;
	if(($_SESSION['Nivel'] == 'admin')&&($_SESSION['dni'] == $_SESSION['webmaster'])){

		$sqlb =  "SELECT * FROM $table_name_a WHERE (`Nombre` LIKE '$nom' OR `Apellidos` LIKE '$ape') AND `del` = 'false' ORDER BY `Nombre` ASC  ";
		$qb = mysqli_query($db, $sqlb);
	
	}elseif(($_SESSION['Nivel'] == 'admin')&&($_SESSION['dni'] != $_SESSION['webmaster'])){ 

		$sqlb =  "SELECT * FROM $table_name_a WHERE (`dni` <> '$_SESSION[webmaster]' AND  `Nombre` LIKE '$nom' OR `dni` <> '$_SESSION[webmaster]' AND `Apellidos` LIKE '$ape') AND `del` = 'false' ORDER BY `Nombre` ASC  ";
		$qb = mysqli_query($db, $sqlb);
	}

			////////////////////		**********  		////////////////////

	global $twhile;				$twhile = "FILTRO USUARIOS CONSULTA";
	global $ruta;				$ruta = "";
	require 'Admin_Botonera.php';
	require 'Inc_While_Form.php';
	global $rutaimg;			$rutaimg = "../Users/";
	require 'Inc_While_Total.php';

} // FIN function process_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=''){

	global $titulo;				$titulo = "FILTRO USUARIOS";
	global $boton;				$boton = "VER TODOS";

	require 'Inc_Show_Form_01.php';
	
	}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $db;					global $db_name;
	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";
	global $Feedback;			$Feedback = 0;

	global $orden;
	require '../Inclu/orden.php';

	if(($_SESSION['Nivel'] == 'user')||($_SESSION['Nivel'] == 'plus')){ 
			$ref = $_SESSION['ref'];
			$sqlb =  "SELECT * FROM $table_name_a WHERE `ref` = '$ref'";
			$qb = mysqli_query($db, $sqlb);

	}elseif(($_SESSION['Nivel'] == 'admin') && ($_SESSION['dni'] == $_SESSION['webmaster'])) { 

			require 'Paginacion_Head.php';
			/*$sqlb =  "SELECT * FROM $table_name_a ORDER BY $orden ";*/
			//$sqlb =  "SELECT * FROM $table_name_a  ORDER BY `id` DESC $limit";
			$sqlb =  "SELECT * FROM $table_name_a WHERE $table_name_a.`del` = 'false' ORDER BY $orden $limit";
			$qb = mysqli_query($db, $sqlb);

	}elseif(($_SESSION['Nivel'] == 'admin')&&($_SESSION['dni'] != $_SESSION['webmaster'])){ 
			require 'Paginacion_Head.php';
			/*$sqlb =  "SELECT * FROM $table_name_a WHERE $table_name_a.`dni` <> '$_SESSION[webmaster]' ORDER BY $orden ";*/
			/*$sqlb =  "SELECT * FROM $table_name_a WHERE $table_name_a.`dni` <> '$_SESSION[webmaster]' ORDER BY  `id` DESC $limit";*/
			$sqlb =  "SELECT * FROM $table_name_a WHERE $table_name_a.`dni` <> '$_SESSION[webmaster]' AND $table_name_a.`del` = 'false'  ORDER BY  $orden $limit";
			$qb = mysqli_query($db, $sqlb);
	}

			////////////////////		**********  		////////////////////

		global $twhile;			$twhile = "";
		//$twhile = "TODOS USUARIOS CONSULTA";
	
		global $ruta;				$ruta = "";
		require 'Admin_Botonera.php';
		require 'Inc_While_Form.php';
		global $rutaimg;			$rutaimg = "../Users/";
		global $pagedest;			$pagedest = "Admin_Ver.php";
		require 'Inc_While_Total.php'; 

			////////////////////		**********  		////////////////////
		
	} // FIN FUNCTION

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

function UserLog(){

	global $nombre;				global $apellido;
	global $orden;
	require '../Inclu/orden.php';
	
	if(isset($_POST['todo'])){ $nombre = "TODOS LOS USUARIOS ".$orden; }

	if(($_SESSION['Nivel'] == 'user')||($_SESSION['Nivel'] == 'plus')){	
										$nombre = $_SESSION['Nombre'];
										$apellido = $_SESSION['Apellidos'];}
	
	$ActionTime = date('H:i:s');

	global $dir;				$dir = "../Users/".$_SESSION['ref']."/log";
	global $text;				
	$text = PHP_EOL."** ADMIN VER ".$ActionTime.PHP_EOL."\t Filtro => ".$nombre." ".$apellido;

	require 'log_write.php';

}

?>