<?php
session_start();

	global $playinclu;			$playinclu = 1;

	//require 'error_hidden.php';
	require 'Admin_head.php';
	require 'webmaster.php';
	require 'nemp.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require 'my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if($_SESSION['Nivel'] == 'admin'){

	master_index();

	global $InfoLog;
	if(isset($_POST['oculto'])){
		if($form_errors = validate_form()){ show_form($form_errors);
		}else{  process_form();
				show_form();
				$InfoLog = $_POST['nemp'];
				UserLog(); }

	}else{ 	show_form();
			$InfoLog = $_SESSION['nuser'];
			UserLog(); }

}else{ require 'tabla_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();
	
	/* VALIDAMOS EL CAMPO NIVEL. */
	if(strlen(trim($_POST['nemp'])) == 0){
		$errors [] = "<font color='#F1BD2D'>SELECCIONE NUMERO EMPLEADOS</font>";
	}
	
	return $errors;

} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	// CREA EL ARCHIVO MYDNI.TXT $_SESSION['webmaster'].
	$filename = "nemp.php";
	$fw2 = fopen($filename, 'w+');
	$mydni = '<?php $_SESSION[\'nuser\'] = '.$_POST['nemp'].'; ?>';
	fwrite($fw2, $mydni);
	fclose($fw2);
	
	$_SESSION['nuser'] = $_POST['nemp'];

	print( "<div class='centradiv' style='padding:0.6em;'>
				SE HA GRABADO CORRETAMENTE
				<br>
				Nº EMPLEADOS PERMITIDOS: ".$_POST['nemp'].
			"</div>");

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	if(isset($_POST['oculto'])){
			$defaults = $_POST;
	}else{ $defaults = array ( 'nemp' => $_SESSION['nuser']); }
	
	require '../Admin/tabla_errors.php';

	global $array_nemp;			$array_nemp = 1;
	
	require '../Admin/admin_array_total.php';

		print("<div class='centradiv' style='padding:0.6em;'>
				<div style='display:inline-block; margin: 0.1em auto 0.6em auto;'>
					Nº EMPLEADOS PERMITIDOS: ".$_SESSION['nuser']."
				</div>
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' >
				<select name='nemp'>");
				foreach($nemp as $optionnv => $labelnv){
					print ("<option value='".$optionnv."' ");
					if($optionnv == $defaults['nemp']){ print ("selected = 'selected'"); }
					print ("> $labelnv </option>");
				}	
		print ("</select>
			<button type='submit' title='GRABAR Nº EMPLEADOS PERMITIDOS' class='botonverde imgButIco SaveBlack' style='vertical-align:top;display:inline-block;' ></button>
				<input type='hidden' name='oculto' value=1 />
			</form>														
				</div>"); 
	
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function UserLog(){

	$ActionTime = date('H:i:s');
	global $InfoLog;
	global $dir;				$dir = "../Users/".$_SESSION['ref']."/log";

	global $text;
	$text = PHP_EOL."** NUMERO USUARIOS ACCESO: ".$ActionTime.PHP_EOL."\t Nº EMPLEADOS: ".$InfoLog;

	require '../Admin/log_write.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		require '../Inclu_MInd/rutainclu.php';
		require '../Inclu_MInd/Master_Index.php';
		
	} 

/////////////////////////////////////////////////////////////////////////////////////////////////

	require '../Inclu/Admin_Inclu_footer.php';
		
/* Creado por © Juan Barros Pazos 2021/25 */
?>
