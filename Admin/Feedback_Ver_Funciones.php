<?php

function validate_form(){
	
	$errors = array();
	
	if((strlen(trim($_POST['Nombre'])) == 0)&&(strlen(trim($_POST['Apellidos'])) == 0)){
		$errors [] = " <font color='#F1BD2D'>UNO DE LOS DOS CAMPOS OBLIGATORIO</font>";
	}else{ }
	
	return $errors;

} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;
	global $nombre;				$nombre = $_POST['Nombre'];
	global $apellido;			$apellido = $_POST['Apellidos'];
	global $Feedback;			$Feedback = 1;
	
	show_form();
		
	$nom = "%".$_POST['Nombre']."%";
	$ape = "%".$_POST['Apellidos']."%";
	global $orden;				$orden = @$_POST['Orden'];
		
	if (strlen(trim($_POST['Apellidos'])) == 0){$ape = $nom;}
	if (strlen(trim($_POST['Nombre'])) == 0){ $nom = $ape;}

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqlb =  "SELECT * FROM $table_name_a WHERE (`Nombre` LIKE '$nom' OR `Apellidos` LIKE '$ape') AND $table_name_a.`del` = 'true' ORDER BY `Nombre` ASC ";
 	
	$qb = mysqli_query($db, $sqlb);
	
			////////////////////		**********  		////////////////////

	global $twhile;			$twhile = "FILTRO USUARIOS BAJAS CONSULTAR";

	require 'Admin_Botonera.php';
	require 'Inc_While_Form.php';
	global $ruta;			$ruta = "";
	global $rutaimg;		$rutaimg = "../Users/";
	require 'Inc_While_Total.php';

} // FIN function process_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=''){
	
	global $titulo;			$titulo = "FILTRO BAJAS TEMPORALES";
	global $boton;			$boton = "BAJAS VER TODAS";
	require 'Inc_Show_Form_01.php';
	
}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $db;
	global $Feedback;		$Feedback = 1;

	if (($_SESSION['Nivel'] == 'admin')){ 

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

		if(isset($_POST['Orden'])){	global $orden;
									$orden = $_POST['Orden'];
		}elseif((isset($_GET['page']))||(isset($_POST['page']))) {
									global $orden;
									$orden = $_SESSION['Orden']; 
		}else{ 	global $orden;
				$orden ='`id` ASC';}

	require 'Paginacion_Head.php';

	$sqlb =  "SELECT * FROM $table_name_a WHERE $table_name_a.`del` = 'true' ORDER BY $orden $limit";
	/* $sqlb =  "SELECT * FROM $table_name_a ORDER BY $orden "; */
	$qb = mysqli_query($db, $sqlb);

	}
	
			////////////////////		**********  		////////////////////

	global $twhile;			$twhile = "TODOS USUARIOS BAJAS";

	require 'Admin_Botonera.php'; 
	require 'Inc_While_Form.php';
	global $ruta;				$ruta = "";
	global $rutaimg;			$rutaimg = "../Users/";
	global $pagedest;			$pagedest = "Feedback_Ver.php";
	require 'Inc_While_Total.php';

} // FIN function ver_todo

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

	global $orden;
	$orden = @$_POST['Orden'];
	
	if (@$_POST['todo']){$nombre = "TODOS LOS USUARIOS ".$orden;};	

	global $rf;
	$rf = @$_POST['ref'];
	global $nombre;
	$nombre = @$_POST['Nombre'];
	global $apellido;
	$apellido = @$_POST['Apellidos'];
		
	$ActionTime = date('H:i:s');

	global $dir;
	$dir = "../Users/".$_SESSION['ref']."/log";

	global $text;
	$text = PHP_EOL."** USER BAJAS BUSQUEDA ".$ActionTime.PHP_EOL."\t Filtro => ".$nombre." ".$apellido;

	require 'log_write.php';

	}

?>