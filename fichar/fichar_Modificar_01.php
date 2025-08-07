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

if ($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['todo'])){ show_form();							
							   ver_todo();
							   info();
								}
								
	else { show_form(); }
								
		} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $titulo;
	$titulo = "MODIFICAR  REGISTRO JORNADA";
	$_SESSION['modifeo'] = "<form name='volver' action='fichar_Modificar_01.php' \">
						<input type='submit' value='VOLVER A FICHAR MODIFICAR SALIDA' class='botonnaranja' />
							</form>";

	require 'Inc_Show_Form_tot.php';

	}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
		
	global $db;
	//$orden = $_POST['Orden'];

	global $dyt1;
	
	if ($_POST['dy'] == ''){ $dy1 = '';
							 $dyt1 = date('Y');	
							 $_SESSION['gyear'] = date('Y');} 
							 				else {	$dy1 = $_POST['dy'];
													$dyt1 = "20".$_POST['dy'];
													$_SESSION['gyear'] = "20".$_POST['dy'];									
													}
	if ($_POST['dm'] == ''){ //$dm1 = '';
							 $dm1 = "-".date('m')."-";
							 $_SESSION['gtime'] = '';} 
							 				else {	$dm1 = "-".$_POST['dm']."-";
													$_SESSION['gtime'] = $_POST['dm'];	
													}
	if ($_POST['dd'] == ''){ $dd1 = '';} else {	$dd1 = $_POST['dd'];}
	

	if (($_POST['dm'] == '')&&($_POST['dd'] != '')){$dm1 = date('m');
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
			
	require 'Inc_Suma_Todo.php';

			///////////////////////			***********  		///////////////////////

	global $sqlb;
	global $qb;
	$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' AND `dout` <> '' ORDER BY $orden ";
	$qb = mysqli_query($db, $sqlb);
	
			////////////////////		**********  		////////////////////

	global $refses;
	$refses = $_SESSION['usuarios'];

	global $tablau;
	$sqlun =  "SELECT * FROM $tablau WHERE `ref` = '$refses' LIMIT 1 ";
	$qun = mysqli_query($db, $sqlun);
	if(!$qun){print("<font color='#FF0000'>Se ha producido un error L.308: </font>
					</br>".mysqli_error($db)."</br>");
	} else {
		while($rowun = mysqli_fetch_assoc($qun)){	
				global $name1;
				$name1 = $rowun['Nombre'];
				global $name2;
				$name2 = $rowun['Apellidos'];
					}
				}

	global $pdm;
	$pdm = "pdm";
	global $feedtot;
	//$feedtot = "nofeed";
	$feedtot = "";
	global $nodata;
	$nodata = "NO HAY DATOS";
	if($_POST['dy'] == ''){ global $ycons;
							$ycons = date('Y');
	}else{ global $ycons;
		   $ycons =	"20".$_POST['dy'];}
	global $twhile;
	$twhile = "<tr><th colspan=7 class='BorderInf'>
				".$name1." ".$name2.". Ref: ".$refses."
				.</th></tr>";

	global $tdplus;
	$tdplus = "<th class='BorderInfDch'></th>";
	global $formularioh;
	$formularioh = "<form name='modifica' action='fichar_Modificar_02.php' method='POST'>";
	global $formulariof;
	$formulariof = "<td class='BorderInfDch' align='right'>
					<input type='submit' value='MODIF DATOS' class='botonnaranja' />
					<input type='hidden' name='oculto2' value=1 />
					</td>
					</form>";
	global $colspana;
	$colspana = "7";
	global $colspanb;
	$colspanb = "5";

	require 'Inc_Fichar_While_Total.php';

			////////////////////		**********  		////////////////////
	
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
	if($_POST['dd'] == ''){$dd = "DIA TODOS";}else{$dd = $_POST['dd'];}
	global $dm;
	if($_POST['dm'] == ''){$dm = "MES ACTUAL";}else{$dm = $_POST['dm'];}
	global $dy;
	if($_POST['dy'] == ''){ $dy = date('Y');} else{$dy = "20".$_POST['dy'];}
	
	global $db;
	global $orden;
	
	$orden = $_POST['Orden'];
	
	if ($_POST['todo']){$filtro = PHP_EOL."\tFiltro => JL CONSULTAR TODOS MODIFICAR. ".$orden;
						$filtro = $filtro.PHP_EOL."\tDATE: ".$dy."/".$dm."/".$dd.".";}

	$ActionTime = date('H:i:s');

	global $dir;
	if ($_SESSION['Nivel'] == 'admin'){$dir = "../Users/".$_SESSION['ref']."/log";}
	
	global $text;
	$text = PHP_EOL."- JL CONSULTAR TODOS MODIFICAR ".$_SESSION['usuarios'].". ".$ActionTime.$filtro;
	
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

/* Creado por Juan Barros Pazos 2021/25 */
?>