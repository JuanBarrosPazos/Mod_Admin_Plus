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

if($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['todo'])){	show_form();							
								ver_todo();
	}else{	show_form(); }
								
}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	if(isset($_POST['oculto1'])){	$_SESSION['usuarios'] = $_POST['usuarios'];
									$defaults = $_POST;
									// print("* ".$_SESSION['usuarios']);
	}elseif(isset($_POST['todo'])){	$_SESSION['usuarios'] = $_POST['usuarios'];
									$defaults = $_POST;
	} 
	
	$dm = array('' => 'MES TODOS','01' => 'ENERO','02' => 'FEBRERO',
				'03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO',
				'06' => 'JUNIO','07' => 'JULIO','08' => 'AGOSTO',
				'09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE',
				'12' => 'DICIEMBRE');
	
	$ordenar = array('`din` ASC' => 'Fecha In Asc',
					'`din` DESC' => 'Fecha In Desc',
					'`dout` ASC' => 'Fecha Out Asc',
					'`dout` DESC' => 'Fecha Out Desc');
	
	print("<table align='center' style='border:1; margin-top:2px' width='auto'>
				
		<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
			<input type='hidden' name='ref' value='".$_SESSION['usuarios']."' />
				<tr>
					<td align='center'>
							CONSULTA BALANCE OTROS USUARIOS
					</td>
				</tr>		
				<tr>
					<td>
					<div style='float:left; margin-right:6px'>
						<input type='submit' value='SELECCIONE UN USUARIO' class='botonverde' />
						<input type='hidden' name='oculto1' value=1 />
					</div>
					<div style='float:left'>

						<select name='usuarios'>
					<!-- <option value=''>SELECCIONE UN USUARIO</option> --> ");

	global $db;
	global $tablau;
	$tablau = "`".$_SESSION['clave']."admin`";
	
	$sqlu =  "SELECT * FROM $tablau WHERE `ref` <> '$_SESSION[ref]' ORDER BY `ref` ASC ";
	$qu = mysqli_query($db, $sqlu);
	if(!$qu){
			print("* ".mysqli_error($db)."<br/>");
	}else{
					
		while($rowu = mysqli_fetch_assoc($qu)){
					
					print ("<option value='".$rowu['ref']."' ");
					
					if($rowu['ref'] == @$defaults['usuarios']){
										print ("selected = 'selected'");
																		}
						print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
		}
	}  

	print ("</select>
					</div>
				</td>
			</tr>
		</form>	
			</table>"); 

	if(isset($_POST['oculto1']) || isset($_POST['todo'])) {
		if($_SESSION['usuarios'] == '') { 
				print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
							<tr align='center'>
								<td>
									<font color='red'>
								SELECCIONE UN USUARIO
									</font>
								</td>
							</tr>
						</table>");
			}	
	if($_SESSION['usuarios'] != '') {

	require "../Users/".$_SESSION['usuarios']."/ayear.php";

	print("	<table align='center' style=\"border:0px;margin-top:4px\">
				<tr>
					<th colspan=2 class='BorderSup'>
						CONSULTAR JORNADA DEL USUARIO ".$_SESSION['usuarios']."
					</th>
				</tr>
				
				<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
	
		<input type='hidden' name='usuarios' value='".$defaults['usuarios']."' />
		
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
	
			} // fin 2º if
	} // fin 1º if

}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function botones(){
	
	print("<table align='center' style=\"border:0px;margin-top:0px\">
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

	global $db;			global $dyt1;			global $dm1;
	global $orden;
	require '../Inclu/orden.php';
	
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
	global $tabla1;			$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;			$vname = "`".$tabla1."_".$dyt1."`";

	require 'calc_anu_mes.php';
	
			///////////////////////			***********  		///////////////////////
			
	require 'Inc_Suma_Todob.php';

			///////////////////////			***********  		///////////////////////

	global $sqlb;			global $qb;
	//$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' ORDER BY $orden ";
	$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	$qb = mysqli_query($db, $sqlb);
	
			////////////////////		**********  		////////////////////

	global $refses;			$refses = $_SESSION['usuarios'];

	global $tablau;
	$sqlun =  "SELECT * FROM $tablau WHERE `ref` = '$refses' LIMIT 1 ";
	$qun = mysqli_query($db, $sqlun);
	if(!$qun){print("<font color='#FF0000'>Se ha producido un error L.308: </font>
					</br>".mysqli_error($db)."</br>");
	}else{
		global $name1;			global $name2;
		while($rowun = mysqli_fetch_assoc($qun)){	
					$name1 = $rowun['Nombre'];
					$name2 = $rowun['Apellidos'];
		}
	}

	global $pdm;			$pdm = "";
	global $feedtot;		$feedtot = "";
	global $nodata;			$nodata = "NO HAY DATOS PARA ".$_POST['usuarios'];
	global $ycons;
	if($_POST['dy'] == ''){ $ycons = date('Y');
	}else{ $ycons =	"20".$_POST['dy'];}

	global $twhile;
	$twhile = "<tr><th colspan=6 class='BorderInf'>".$name1." ".$name2.". Ref: ".$refses." RESULTADOS.</th></tr><tr><th colspan=6 class='BorderInf'>".$ycons." / ".$_POST['dm']." - TOTALES.</th></tr>";

	global $tdplus;			$tdplus = "";
	global $formularioh;	$formularioh = "";
	global $formulariof;	$formulariof = "";
	global $colspana;		$colspana = "6";
	global $colspanb;		$colspanb = "4";

	require 'Inc_Fichar_While_Totalb.php';

			////////////////////		**********  		////////////////////
	
}/* FIN ver_todo(); */

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

/* Creado por Juan Barros Pazos 2021/25 */

?>