<?php
session_start();

	// SE CANCELA ESTE SCRIPT...
	// CONSTRUYE LOS VALANCES DEL USUARIO CON SESIÓN ABIERTA...

	global $balances;			$balances = 1;
	global $balancesOtros;		$balancesOtros = 0;
	//require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

	// $_SESSION['usuarios'] = '';
	unset($_SESSION['usuarios']);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['todo'])){	show_form();							
								ver_todo();
	}else{ 	show_form();	
			ver_todo();
	}

}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	if(isset($_POST['todo'])){ $defaults = $_POST; } 
	
		
	$dm = array('' => 'MES TODOS','01' => 'ENERO','02' => 'FEBRERO',
				'03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO',
				'06' => 'JUNIO','07' => 'JULIO','08' => 'AGOSTO',
				'09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE',
				'12' => 'DICIEMBRE');
	
	$ordenar = array('`din` ASC' => 'Fecha In Asc',
					'`din` DESC' => 'Fecha In Desc',
					'`dout` ASC' => 'Fecha Out Asc',
					'`dout` DESC' => 'Fecha Out Desc');
	
	require "../Users/".$_SESSION['ref']."/ayear.php";
	global $Titulo;			$Titulo = "FILTRO GRAFICAS DE HORARIOS";
	require 'Inc_Filtro_Balance.php';
	
}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function botones(){
	
	require 'Inc_Graf_Button.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	unset ($_SESSION['coor_x']);

	if(file_exists('grafico_01.php')){
			//global $filename;
			//$filename = 'grafico_01.php';
			//clearstatcache ($clear_realpath_cache = true, $filename );
			clearstatcache ();
	}

	global $db;
	global $orden;
	require '../Inclu/orden.php';

	global $dyt1;			global $dm1;
	
	if($_POST['dy'] == ''){ $dy1 = date('Y');
							$dyt1 = date('Y');	
							$_SESSION['gyear'] = date('Y');
	}else{	$dy1 = "20".$_POST['dy'];
			$dyt1 = "20".$_POST['dy'];
			$_SESSION['gyear'] = "20".$_POST['dy'];									
	}
	
	if($_POST['dm'] == ''){ $dm1 = '';
							$_SESSION['gtime'] = '';
	}else{	//global $dd1;
			//$dd1 = '';
			$dm1 = "-".$_POST['dm']."-";
			$_SESSION['gtime'] = $_POST['dm'];	
	}
	
	global $fil;			$fil = "%".$dy1.$dm1."%";
	
	/*
	if(($_POST['dm'] == '')&&($_POST['dd'] != '')){$dm1 = '';
													$dd1 = $_POST['dd'];
													global $fil;
													$fil = "%".$dy1."-%".$dm1."%-".$dd1."%";
	}
	*/
	global $tabla1;			$tabla1 = strtolower($_SESSION['clave'].$_SESSION['ref']);
	global $vname;			$vname = "`".$tabla1."_".$dyt1."`";

	require 'calc_anu_mes.php';
			
	require 'Inc_Suma_Todob.php';

	global $qb;			global $sqlb;
	//$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' ORDER BY $orden ";
	$sqlb =  "SELECT * FROM $vname WHERE (`din` LIKE '$fil' AND `ttot` <> '00:00:00') ORDER BY $orden ";
	$qb = mysqli_query($db, $sqlb);
	
	global $pdm;				$pdm = "";
	global $name1;				$name1 = $_SESSION['Nombre'];
	global $name2;				$name2 = $_SESSION['Apellidos'];
	global $refses;				$refses = $_SESSION['ref'];
	global $nodata;				$nodata = "NO HAY DATOS";
	global $twhile;				global $ycons;
	if($_POST['dy'] == ''){ $ycons = date('Y'); }else{ $ycons =	"20".$_POST['dy']; }

	$twhile = "<tr>
				<td colspan=6>".$name1." ".$name2.". Ref: ".$refses." RESULTADOS</td></tr><tr>
				<td colspan=6 class='BorderInf'>".$ycons." / ".$_POST['dm']." - TOTALES</td>
			</tr>";

	global $tdplus;				$tdplus = "";
	global $feedtot;			$feedtot = "";
	global $formularioh;		$formularioh = "";
	global $formulariof;		$formulariof = "";
	global $colspana;			$colspana = "6";
	global $colspanb;			$colspanb = "4";

	require 'Inc_Fichar_While_Totalb.php';

			////////////////////		**********  		////////////////////
	
}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function master_index(){
		
	require '../Inclu_MInd/rutabalances.php';
	require '../Inclu_MInd/Master_Index.php';
		
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