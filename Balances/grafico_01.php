<?php
session_start();

//		ESTE SCRIPT FUNCIONA CON VARIABLES GLOBALES.

	require_once ('jpgraph/src/jpgraph.php');
	require_once ('jpgraph/src/jpgraph_line.php');

	require '../Inclu/error_hidden.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'user')){
				
		if($_POST['grafico']){	a();
								process_form();
								} 
			} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function a(){		///// DATOS MENSUALES TODOS LOS AÑOS //////

					global $docdat;
					$docdat = "datos.php";
					$datos = file_get_contents($docdat);
					$docdat_a = explode(',',$datos);
					$count = count($docdat_a);
					$rest = $count-1;
					unset($docdat_a[$rest]);
					//$_SESSION['G_MES_I'] = $docdat_a;
					global $dat1;
					$dat1 = $docdat_a;
				
					global $docdat2;
					$docdat2 = "datosym.php";
					$datos2 = file_get_contents($docdat2);
					$docdat2_a = explode(',',$datos2);
					$count2 = count($docdat2_a);
					$rest2 = $count2-1;
					unset($docdat2_a[$rest2]);
					//$_SESSION['G_MES_I'] = $docdat_a;
					global $dat2;
					$dat2 = $docdat2_a;
				
					global $docdatf;
					$docdatf = "datosf.php";
					$datosf = file_get_contents($docdatf);
					$docdatf_a = explode(',',$datosf);
					$count = count($docdatf_a);
					$rest = $count-1;
					unset($docdatf_a[$rest]);
					//$_SESSION['G_MES_G'] = $docdatf_a;
					global $datf1;
					$datf1 = $docdatf_a;
					
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){

	global $coordenadax;

	global $mensaje;
	if($_SESSION['usuarios'] == ''){
		$mensaje = "\nGRAFICA PARA DEL USUARIO ".$_SESSION['ref'].".\n\n";}
	elseif($_SESSION['usuarios'] != ''){
		$mensaje = "\nGRAFICA PARA DEL USUARIO ".$_SESSION['usuarios'].".\n\n";}
	
	
	global $dat1;		global $dat2;	global $datf1;		
		
global $timemes;
$timemes = trim($_SESSION['gtime']);
if ($timemes == '01'){$timemes = 'ENERO';}
elseif ($timemes == '02'){$timemes = 'FEBRERO';}
elseif ($timemes == '03'){$timemes = 'MARZO';}
elseif ($timemes == '04'){$timemes = 'ABRIL';}
elseif ($timemes == '05'){$timemes = 'MAYO';}
elseif ($timemes == '06'){$timemes = 'JUNIO';}
elseif ($timemes == '07'){$timemes = 'JULIO';}
elseif ($timemes == '08'){$timemes = 'AGOSTO';}
elseif ($timemes == '09'){$timemes = 'SEPTIEMBRE';}
elseif ($timemes == '10'){$timemes = 'OCTUBRE';}
elseif ($timemes == '11'){$timemes = 'NOVIEMBRE';}
elseif ($timemes == '12'){$timemes = 'DICIEMBRE';}

if($_SESSION['gtime'] == ""){ 
					global $timeanho;
					$timeanho = $_SESSION['gyear'];
					$titulo = 'ANUAL '.$timeanho;
			global $dat2;
			global $dat1;
			$dat1 = $dat2;
	$_SESSION['coor_x'] = array('ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
	$_SESSION['coor_xb'] = array('ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC');
}
	
elseif($_SESSION['gtime'] != ''){
				global $timeanho;
				$timeanho = $_SESSION['gyear'];
				global $timemes;
				$titulo = 'MENSUAL '.$timemes." / ".$timeanho;
			global $dat1;
			global $dat1;
			$dat1 = $dat1;
			global $datf1;
			global $dataf1;
			$dataf1 = $dataf1;
			$_SESSION['coor_x'] = $datf1;
			$_SESSION['coor_xb'] = $datf1;
								}

	$graph = new Graph(1000,600);
	$graph->SetScale("textlin");
	
	$theme_class=new UniversalTheme;
	$graph->SetTheme($theme_class);
	$graph->img->SetAntiAliasing(true);
	
	global $titulo1;
	$titulo1 = "HORARIOS BALANCE ".$titulo;
	$titulo2 = $mensaje.$titulo1;
	
	$graph->title->Set($titulo2);
	$graph->SetBox(false);
	$graph->img->SetAntiAliasing();
	$graph->yaxis->HideZeroLabel();
	$graph->yaxis->HideLine(false);
	$graph->yaxis->HideTicks(false,false);
	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle("solid");
	
	global $coordenadax;
	$coordenadax = $_SESSION['coor_x'];
	$graph->xaxis->SetTickLabels($coordenadax);
	$graph->xgrid->SetColor('#E3E3E3');
	
	global $dat1;
	//global $datag;<br>
	
	$p1 = new LinePlot($dat1);
	$graph->Add($p1);
	$p1->SetColor("#01DFD7");
	$p1->SetLegend('FECHA / HORAS.MINUTOS');
	// DEFINE LA POSICION DE LA LEYENDA INFERIOR
	$graph->legend->SetPos(0.5,0.94,'center','bottom');
	
	$graph->Stroke();	
		
		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
		
/* Creado por Juan Barros Pazos 2021/25 */
?>