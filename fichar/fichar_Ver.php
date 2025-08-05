<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';

	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

	unset($_SESSION['usuarios']);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'user') || ($_SESSION['Nivel'] == 'plus')){

	master_index();

	if(isset($_POST['todo'])){ show_form();							
								ver_todo();
								info();
								}
		else { show_form();
			   	}
								
	} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
	
	if(isset($_POST['todo'])){
		$defaults = $_POST;
			} 
	
	require "../Users/".$_SESSION['ref']."/ayear.php";
		
	$dm = array (	'' => 'MES TODOS','01' => 'ENERO','02' => 'FEBRERO',
					'03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO',
					'06' => 'JUNIO','07' => 'JULIO','08' => 'AGOSTO',
					'09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE',
					'12' => 'DICIEMBRE');
	
	$dd = array (	'' => 'DÍA TODOS','01' => '01','02' => '02','03' => '03',
					'04' => '04','05' => '05','06' => '06','07' => '07',
					'08' => '08','09' => '09','10' => '10','11' => '11',
					'12' => '12','13' => '13','14' => '14','15' => '15',
					'16' => '16','17' => '17','18' => '18','19' => '19',
					'20' => '20','21' => '21','22' => '22','23' => '23',
					'24' => '24','25' => '25','26' => '26','27' => '27',
					'28' => '28','29' => '29','30' => '30','31' => '31');
										
	
	$ordenar = array (	'`din` ASC' => 'Fecha In Asc',
						'`din` DESC' => 'Fecha In Desc',
						'`dout` ASC' => 'Fecha Out Asc',
						'`dout` DESC' => 'Fecha Out Desc',
						'`id` ASC' => 'ID Asc',
						'`id` DESC' => 'ID Desc');
	
	print("<table align='center' style=\"border:0px;margin-top:4px\">
				<tr>
					<th colspan=2>
						CONSULTAR JORNADAS LABORALES
					</th>
				</tr>");
				
			///////////////////////			**********  		///////////////////////

	print ("<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
				<tr>
					<td align='center' class='BorderSup'>
						<input type='submit' value='CONSULTA JORNADAS LABORALES' class='botonlila' />
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
					<div style='float:left'>
						<select name='dd'>");
				foreach($dd as $optiondd => $labeldd){
					print ("<option value='".$optiondd."' ");
					if($optiondd == @$defaults['dd']){print ("selected = 'selected'");}
													print ("> $labeldd </option>");
												}	
																
	print ("</select>
					</div>
				</form>														
					</td>
				</tr>
			</table>"); /* Fin del print */
	
	}	/* Fin show_form(); */

			///////////////////////			**********  		///////////////////////

function ver_todo(){
		
	global $db; 	global $db_name;
	//$orden = $_POST['Orden'];

	global $dyt1; 		global $dm1; 		global $dd1;
	
	if ($_POST['dy'] == ''){ $dy1 = date('Y');
							 $dyt1 = date('Y');	
							 $_SESSION['gyear'] = date('Y');} 
							 				else {	$dy1 = "20".$_POST['dy'];
													$dyt1 = "20".$_POST['dy'];
													$_SESSION['gyear'] = "20".$_POST['dy'];									
													}
	if ($_POST['dm'] == ''){ $dm1 = '';
							 $_SESSION['gtime'] = '';} 
							 				else {	$dm1 = "-".$_POST['dm']."-";
													$_SESSION['gtime'] = $_POST['dm'];	
													}
	if ($_POST['dd'] == ''){ $dd1 = '';} else {	$dd1 = $_POST['dd'];}
	
	/**/
	if (($_POST['dm'] == '')&&($_POST['dd'] != '')){$dm1 = date('m');
													$dd1 = $_POST['dd'];
													global $fil;
													$fil = $dy1."-%".$dm1."%-".$dd1."%";
																					}
												else{ global $fil;												
													  $fil = "%".$dy1.$dm1.$dd1."%";
														}
	global $vname;
	$tabla1 = $_SESSION['clave'].$_SESSION['ref'];
	$tabla1 = strtolower($tabla1);
	$vname = $tabla1."_".$dyt1;
	$vname = "`".$vname."`";

			///////////////////////			***********  		///////////////////////
			
	require 'Inc_Suma_Todo.php';

			///////////////////////			***********  		///////////////////////
	
	global $qb;		global $sqlb;
	$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' ORDER BY $orden ";
	$qb = mysqli_query($db, $sqlb);
	
			////////////////////		**********  		////////////////////

	global $pdm; 		$pdm = "";
	global $feedtot;
	//$feedtot = "nofeed";
	$feedtot = "";
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
	
		//print ("* ".$_SESSION['gtime']);
	
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
	if($_POST['dm'] == ''){$dm = "MES TODOS";}else{$dm = $_POST['dm'];}
	global $dy;
	if($_POST['dy'] == ''){ $dy = date('Y');} else{$dy = "20".$_POST['dy'];}
	
	global $db;
	global $orden;
	
	$orden = $_POST['Orden'];
	
	if ($_POST['todo']){$filtro = PHP_EOL."\tFiltro => TODAS LAS JORNADAS LABORALES. ".$orden;
						$filtro = $filtro.PHP_EOL."\tDATE: ".$dy."/".$dm."/".$dd.".";}

	$ActionTime = date('H:i:s');

	global $dir;
	$dir = "../Users/".$_SESSION['ref']."/log";
	
	global $text;
	$text = PHP_EOL."** JORNADA LABORAL CONSULTAR USUARIO ".$_SESSION['ref'].". ".$ActionTime.$filtro;
	
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

	/* Creado por Juan Barros Pazos 2021 */
?>