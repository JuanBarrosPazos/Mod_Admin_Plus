<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

$_SESSION['usuarios'] = '';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if ($_SESSION['Nivel'] == 'admin'){

		master_index();

			if(isset($_POST['todo'])){ show_form();							
								ver_todo();
								}
			else {show_form();}
	} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	if(isset($_POST['todo'])){
		$defaults = $_POST;
		} 
	
	require "../Users/".$_SESSION['ref']."/ayear.php";
		
	$dm = array (	'' => 'MES TODOS',
					'01' => 'ENERO',
					'02' => 'FEBRERO',
					'03' => 'MARZO',
					'04' => 'ABRIL',
					'05' => 'MAYO',
					'06' => 'JUNIO',
					'07' => 'JULIO',
					'08' => 'AGOSTO',
					'09' => 'SEPTIEMBRE',
					'10' => 'OCTUBRE',
					'11' => 'NOVIEMBRE',
					'12' => 'DICIEMBRE');
	
	$ordenar = array (	'`din` ASC' => 'Fecha In Asc',
						'`din` DESC' => 'Fecha In Desc',
						'`dout` ASC' => 'Fecha Out Asc',
						'`dout` DESC' => 'Fecha Out Desc');
	
	print("<table align='center' style=\"border:0px;margin-top:4px\">
				<tr>
					<th colspan=3>
						GRAFICA DE HORARIOS
					</th>
				</tr>
				
				<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
		
				<tr>
					<td align='center' class='BorderSup'>
						<input type='submit' value='FILTRO BALANCES' class='botonverde' />
						<input type='hidden' name='todo' value=1 />
					</td>
					
					<td class='BorderSup'>	
						<div style='float:left'>
							<select name='Orden'>");
				foreach($ordenar as $option => $label){
					print ("<option value='".$option."' ");
					if($option == @$defaults['Orden']){print ("selected = 'selected'");}
													  print ("> $label </option>");
											}	
						
	print ("</select>
				</div>
					<div style='float:left'>
						<select name='dy'>");
				foreach($dy as $optiondy => $labeldy){
					print ("<option value='".$optiondy."' ");
					if($optiondy == @$defaults['dy']){print ("selected = 'selected'");}
													 print ("> $labeldy </option>");
											}	
																
	print ("</select>
				</div>
					<div style='float:left'>
						<select name='dm'>");

		foreach($dm as $optiondm => $labeldm){
			print ("<option value='".$optiondm."' ");
			if($optiondm == @$defaults['dm']){print ("selected = 'selected'");}
											 print ("> $labeldm </option>");
										}	
																
			print ("</select>
						</div>
					</form>											
				</td>
			</tr>
		</table>"); /* Fin del print */
	
	}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function botones(){
	
	print(" <table align='center' style=\"border:0px;margin-top:4px\">
				<tr>
		 			<td align='right' class='BorderInf'>

<div style='float:left; margin-right:16px;  margin-left:155px; margin-top:-16px'>
<form name='grafico' action='grafico_01.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\">
	
	<input name='time' type='hidden' value='".@$_SESSION['time']."' />

			<input type='submit' value='GRAFICA LINEAL' class='botonnaranja' />
			<input type='hidden' name='grafico' value=1 />
</form>	
</div>					
<div style='float:left; margin-top:-16px'>
<form name='grafico2' action='grafico_02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\">
	
	<input name='time' type='hidden' value='".@$_SESSION['time']."' />

			<input type='submit' value='GRAFICA BARRAS' class='botonnaranja' />
			<input type='hidden' name='grafico2' value=1 />
</form>	
</div>					
					</td>
				</tr>
	</table>");

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
	$orden = $_POST['Orden'];

	global $dyt1;
	global $dm1;
	
	if ($_POST['dy'] == ''){ $dy1 = date('Y');
							 $dyt1 = date('Y');	
							 $_SESSION['gyear'] = date('Y');} 
							 				else {	$dy1 = "20".$_POST['dy'];
													$dyt1 = "20".$_POST['dy'];
													$_SESSION['gyear'] = "20".$_POST['dy'];									
													}
	
	if ($_POST['dm'] == ''){ $dm1 = '';
							 $_SESSION['gtime'] = '';} 
							 				else {	//global $dd1;
													//$dd1 = '';
													$dm1 = "-".$_POST['dm']."-";
													$_SESSION['gtime'] = $_POST['dm'];	
													}
	
	global $fil;												
	$fil = "%".$dy1.$dm1."%";
	
	/*
	if (($_POST['dm'] == '')&&($_POST['dd'] != '')){$dm1 = '';
													$dd1 = $_POST['dd'];
													global $fil;
													$fil = "%".$dy1."-%".$dm1."%-".$dd1."%";
																					}
*/
	global $tabla1;
	$tabla1 = $_SESSION['clave'].$_SESSION['ref'];
	$tabla1 = strtolower($tabla1);
	global $vname;
	$vname = $tabla1."_".$dyt1;
	$vname = "`".$vname."`";

	require 'calc_anu_mes.php';
	
			///////////////////////			***********  		///////////////////////
			
	require 'Inc_Suma_Todob.php';

			///////////////////////			***********  		///////////////////////

	global $sqlb;
	global $qb;
	//$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' ORDER BY $orden ";
	$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	$qb = mysqli_query($db, $sqlb);
	
			////////////////////		**********  		////////////////////

	global $pdm;
	$pdm = "";
	global $name1;
	$name1 = $_SESSION['Nombre'];
	global $name2;
	$name2 = $_SESSION['Apellidos'];
	global $refses;
	$refses = $_SESSION['ref'];
	global $nodata;
	$nodata = "NO HAY DATOS";
	global $twhile;
	if($_POST['dy'] == ''){ global $ycons;
							$ycons = date('Y');
	}else{ global $ycons;
		   $ycons =	"20".$_POST['dy'];}
	$twhile = "<tr><th colspan=6 class='BorderInf'>".$name1." ".$name2.". Ref: ".$refses." RESULTADOS.</th></tr><tr><th colspan=6 class='BorderInf'>".$ycons." / ".$_POST['dm']." - TOTALES.</th></tr>";

	global $tdplus;
	$tdplus = "";
	global $feedtot;
	$feedtot = "";
	global $formularioh;
	$formularioh = "";
	global $formulariof;
	$formulariof = "";
	global $colspana;
	$colspana = "6";
	global $colspanb;
	$colspanb = "4";

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

/* Creado por Juan Barros Pazos 2021 */
?>