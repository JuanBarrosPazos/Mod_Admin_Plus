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

if(($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')){

		master_index();

		if(isset($_POST['todo'])){ show_form();							
									ver_todo();
									info();
									}
				else {	show_form();}
								
		}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
	
	global $titulo;
	$titulo = "CONSULTAR  REGISTRO JORNADA EMPLEADOS";

	require 'Inc_Show_Form_tot.php';

	}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $db;					global $db_name;
	global $orden;
	require '../Inclu/orden.php';

	global $dyt1;			global $dm1;			global $dd1;
	
	if($_POST['dy'] == ''){ $dy1 = date('Y');
							 $dyt1 = date('Y');	
							 $_SESSION['gyear'] = date('Y');} 
							 				else {	$dy1 = "20".$_POST['dy'];
													$dyt1 = "20".$_POST['dy'];
													$_SESSION['gyear'] = "20".$_POST['dy'];									
													}
	if($_POST['dm'] == ''){ $dm1 = '';
							 $_SESSION['gtime'] = '';} 
							 				else {	$dm1 = "-".$_POST['dm']."-";
													$_SESSION['gtime'] = $_POST['dm'];	
													}
	if($_POST['dd'] == ''){ $dd1 = '';}else{	$dd1 = $_POST['dd'];}
	
	/**/
	if(($_POST['dm'] == '')&&($_POST['dd'] != '')){$dm1 = date('m');
													$dd1 = $_POST['dd'];
													global $fil;
													$fil = $dy1."-%".$dm1."%-".$dd1."%";
																					}
												else{ global $fil;												
													  $fil = "%".$dy1.$dm1.$dd1."%";
														}
	global $vname;
	$tabla1 = $_SESSION['clave'].$_SESSION['usuarios'];
	$tabla1 = strtolower($tabla1);
	$vname = $tabla1."_".$dyt1;
	$vname = "`".$vname."`";

			///////////////////////			***********  		///////////////////////
			
	global $ruta;		$ruta = '../';
	require 'Inc_Suma_Todo.php';

			///////////////////////			***********  		///////////////////////

	global $sqlb;
	global $qb;
	$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' AND `ttot` <> '' ORDER BY $orden ";
	$qb = mysqli_query($db, $sqlb);

			////////////////////		**********  		////////////////////

	global $refses;
	$refses = $_SESSION['usuarios'];

	global $tablau;
	$sqlun =  "SELECT * FROM $tablau WHERE `ref` = '$refses' LIMIT 1 ";
	$qun = mysqli_query($db, $sqlun);
	if(!$qun){print("<font color='#FF0000'>Se ha producido un error L.308: </font>
					</br>".mysqli_error($db)."</br>");
		}else{
			while($rowun = mysqli_fetch_assoc($qun)){
					global $name1;
					$name1 = $rowun['Nombre'];
					global $name2;
					$name2 = $rowun['Apellidos'];
						}
					}

	global $pdm;
	$pdm = "";
	global $feedtot;
	//$feedtot = "nofeed";
	$feedtot = "";
	global $nodata;
	$nodata = "NO HAY DATOS PARA ".$_POST['usuarios'];
	if($_POST['dy'] == ''){ global $ycons;
							$ycons = date('Y');
	}else{ global $ycons;
		   $ycons =	"20".$_POST['dy'];}

	if($_POST['dm'] == ''){ global $mcons;
							$mcons = date('m');
	}else{ global $mcons;
		   $mcons =	$_POST['dm'];}
	
	global $twhile;
	$twhile = "<tr><th colspan=6 class='BorderInf'>".$name1." ".$name2.". Ref: ".$refses." RESULTADOS.</th></tr><tr><th colspan=6 class='BorderInf'>".$ycons." / ".$mcons." - TOTALES.</th></tr>";

	global $tdplus;
	$tdplus = "";
	global $formularioh;
	$formularioh = "";
	global $formulariof;
	$formulariof = "";
	global $colspana;
	$colspana = "6";
	global $colspanb;
	$colspanb = "4";

	require 'Inc_Fichar_While_Total.php';

			////////////////////		**********  		////////////////////

		if($_SESSION['gtime']==''){$_SESSION['gtime']='';}
		elseif($_SESSION['gtime']=='01'){$_SESSION['gtime']='ENERO';}
		elseif($_SESSION['gtime']=='02'){$_SESSION['gtime']='FEBRERO';}
		elseif($_SESSION['gtime']=='03'){$_SESSION['gtime']='MARZO';}
		elseif($_SESSION['gtime']=='04'){$_SESSION['gtime']='ABRIL';}
		elseif($_SESSION['gtime']=='05'){$_SESSION['gtime']='MAYO';}
		elseif($_SESSION['gtime']=='06'){$_SESSION['gtime']='JUNIO';}
		elseif($_SESSION['gtime']=='07'){$_SESSION['gtime']='JULIO';}
		elseif($_SESSION['gtime']=='08'){$_SESSION['gtime']='AGOSTO';}
		elseif($_SESSION['gtime']=='09'){$_SESSION['gtime']='SEPTIEMBRE';}
		elseif($_SESSION['gtime']=='10'){$_SESSION['gtime']='OCTUBRE';}
		elseif($_SESSION['gtime']=='11'){$_SESSION['gtime']='NOVIEMBRE';}
		elseif($_SESSION['gtime']=='12'){$_SESSION['gtime']='DICIEMBRE';}
	
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
	if($_POST['dm'] == ''){ $dm = "MES TODOS"; }else{ $dm = $_POST['dm']; }
	global $dy;
	if($_POST['dy'] == ''){ $dy = date('Y'); }else{ $dy = "20".$_POST['dy']; }
	
	global $orden;
	require '../Inclu/orden.php';
	
	if(isset($_POST['todo'])){
		$filtro = PHP_EOL."\tFiltro => TODAS LAS JORNADAS LABORALES. ".$orden;
		$filtro = $filtro.PHP_EOL."\tDATE: ".$dy."/".$dm."/".$dd.".";
	}

	$ActionTime = date('H:i:s');

	global $dir;				$dir = "../Users/".$_SESSION['ref']."/log";
	
	global $text;
	$text = PHP_EOL."** JORNADA LABORAL CONSULTAR USUARIO ".$_SESSION['usuarios'].". ".$ActionTime.$filtro;
	
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