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
	}else{ show_form(); }

}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	if(isset($_POST['todo'])){ $defaults = $_POST; } 
	
	require "../Users/".$_SESSION['ref']."/ayear.php";
		
	$dm = array('' => 'MES TODOS','01' => 'ENERO','02' => 'FEBRERO',
				'03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO',
				'06' => 'JUNIO','07' => 'JULIO','08' => 'AGOSTO',
				'09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE',
				'12' => 'DICIEMBRE');
	
	$ordenar = array('`din` ASC' => 'Fecha In Asc',
					'`din` DESC' => 'Fecha In Desc',
					'`dout` ASC' => 'Fecha Out Asc',
					'`dout` DESC' => 'Fecha Out Desc');
	
	print("<div class='centradiv' style='padding:0.6em;'>
			GRAFICA DE HORARIOS
			<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
				<select name='Orden'>");
					foreach($ordenar as $option => $label){
							print ("<option value='".$option."' ");
							if($option == @$defaults['Orden']){ print ("selected = 'selected'"); }
							print ("> $label </option>");
					}	
		print("</select>
				<select name='dy'>");
					foreach($dy as $optiondy => $labeldy){
							print ("<option value='".$optiondy."' ");
							if($optiondy == @$defaults['dy']){ print ("selected = 'selected'"); }
							print ("> $labeldy </option>");
					}	
		print ("</select>
				<select name='dm'>");
					foreach($dm as $optiondm => $labeldm){
							print ("<option value='".$optiondm."' ");
							if($optiondm == @$defaults['dm']){ print ("selected = 'selected'"); }
							print ("> $labeldm </option>");
					}	
		print ("</select>
				<button type='submit' title='FILTRO BALANCES' class='botonverde imgButIco BuscaBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
					<input type='hidden' name='todo' value=1 />
			</form>											
		</div>"); /* Fin del print */
	
}	/* Fin show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function botones(){
	
	print("<div class='centradiv' style='border:none !important'>
			<form name='grafico' action='grafico_01.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display:inline-block;'>
				<input type='hidden' name='time' value='".@$_SESSION['time']."' />
				<button type='submit' title='VER GRAFICA LINEAL' class='botonverde imgButIco GrafLineBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
				<input type='hidden' name='grafico' value=1 />
			</form>	
			<form name='grafico2' action='grafico_02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display:inline-block;'>
				<input type='hidden' name='time' value='".@$_SESSION['time']."' />
				<button type='submit' title='VER GRAFICA DE BARRAS' class='botonverde imgButIco GrafBarBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
				<input type='hidden' name='grafico2' value=1 />
			</form>	
		</div>");

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
	$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	$qb = mysqli_query($db, $sqlb);
	
	global $pdm;				$pdm = "";
	global $name1;				$name1 = $_SESSION['Nombre'];
	global $name2;				$name2 = $_SESSION['Apellidos'];
	global $refses;				$refses = $_SESSION['ref'];
	global $nodata;				$nodata = "NO HAY DATOS";
	global $twhile;				global $ycons;
	if($_POST['dy'] == ''){ $ycons = date('Y'); }else{ $ycons =	"20".$_POST['dy'];}

	$twhile = "<tr>
				<td colspan=6>".$name1." ".$name2.". Ref: ".$refses." RESULTADOS.</td></tr><tr>
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

/* Creado por © Juan Barros Pazos 2021/25 */

?>