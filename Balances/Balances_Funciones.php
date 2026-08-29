<?php

function show_form(){

	global $defaults;
	if(isset($_POST['oculto1'])){	
		$_SESSION['usuarios'] = $_POST['usuarios'];
		$defaults = $_POST;
	}elseif(isset($_POST['todo'])){	
		$_SESSION['usuarios'] = $_POST['usuarios'];
		$defaults = $_POST;
	}else{
		$_SESSION['usuarios'] = $_SESSION['ref'];
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
	
	global $db;		
	global $tablau;			
	$tablau = "`".$_SESSION['clave']."admin`";
	
	global $sqlu;
	if($_SESSION['Nivel'] == 'wmaster'){
		$sqlu = "SELECT * FROM $tablau ORDER BY `ref` ASC";
	}else{
		$sqlu = "SELECT * FROM $tablau WHERE `Nivel` <> 'wmaster' ORDER BY `ref` ASC";
	}

	$qu = mysqli_query($db, $sqlu);

	if(!$qu){
		print("ERROR SQL L.33/35 ".mysqli_error($db)."<br>");
		global $redir;
		$redir = "<script type='text/javascript'>
					function redir(){
						window.location.href='../Admin/Admin_Ver.php';
					}
					setTimeout('redir()',8000);
				</script>";
		print($redir);

	}else{
		// Función interna para normalizar texto eliminando tildes/acentos
		if (!function_exists('quitarAcentos')) {
			function quitarAcentos($cadena) {
				$unwanted_array = array(
					'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
					'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
					'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
					'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
					'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'Ñ'=>'N', 'ñ'=>'n'
				);
				return strtr($cadena, $unwanted_array);
			}
		}

		$selected_name = "";
		$options_html = "";
		$usuario_actual = $defaults['usuarios'] ?? $_SESSION['usuarios'] ?? '';

		while($rowu = mysqli_fetch_assoc($qu)){
			$ref = htmlspecialchars($rowu['ref'], ENT_QUOTES);
			$nombre_completo = htmlspecialchars(trim($rowu['Nombre']." ".$rowu['Apellidos']), ENT_QUOTES);
			$nombre_sin_acento = quitarAcentos($nombre_completo);

			if($rowu['ref'] == $usuario_actual){
				$selected_name = $nombre_completo;
			}

			if ($nombre_completo !== $nombre_sin_acento) {
				$options_html .= "<option data-ref='".$ref."' value='".$nombre_completo."' label='".$nombre_sin_acento."'></option>";
				$options_html .= "<option data-ref='".$ref."' value='".$nombre_sin_acento."' label='".$nombre_completo."'></option>";
			} else {
				$options_html .= "<option data-ref='".$ref."' value='".$nombre_completo."'></option>";
			}
		}

		print("<div class='centradiv' style='padding:0.6em;'>
				<form name='form_tabla' method='post' action='".$_SERVER['PHP_SELF']."'>
					<input type='hidden' name='ref' value='".htmlspecialchars($_SESSION['usuarios'] ?? '', ENT_QUOTES)."' />
					<input type='hidden' name='usuarios' id='usuarios_hidden' value='".htmlspecialchars($usuario_actual, ENT_QUOTES)."' />
					
					<input list='list_usuarios' id='input_usuarios' class='botonlila' placeholder='SELECCIONE USUARIO...' value='".htmlspecialchars($selected_name, ENT_QUOTES)."' autocomplete='off' style='padding:0.3em;'>
					
					<datalist id='list_usuarios'>
						".$options_html."
					</datalist>

					<button type='submit' title='SELECCIONE UN USUARIO' class='botonverde imgButIco InicioBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;'></button>
					<input type='hidden' name='oculto1' value=1 />
				</form>	

				<script>
					function removerAcentos(texto) {
						return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
					}

					document.getElementById('input_usuarios').addEventListener('input', function() {
						var valBusqueda = removerAcentos(this.value.toLowerCase().trim());
						var opts = document.getElementById('list_usuarios').children;
						var hiddenInput = document.getElementById('usuarios_hidden');
						
						hiddenInput.value = '';

						for (var i = 0; i < opts.length; i++) {
							var valOption = removerAcentos(opts[i].value.toLowerCase().trim());
							var labelOption = opts[i].getAttribute('label') ? removerAcentos(opts[i].getAttribute('label').toLowerCase().trim()) : '';

							if (valOption === valBusqueda || labelOption === valBusqueda) {
								hiddenInput.value = opts[i].getAttribute('data-ref');
								break;
							}
						}
					});
				</script>
				</div>");
	}

	if((isset($_POST['oculto1']))||(isset($_POST['todo']))){

		if($_SESSION['usuarios'] == ''){
			print("<div class='centradiv alertdiv'>
							ERROR SELECCIONE UN USUARIO
					</div>");
		}elseif($_SESSION['usuarios'] != ''){

		global $Titulo;			$Titulo = "FILTRO GRAFICAS HORARIOS ".$_SESSION['usuarios'];
		require 'Inc_Filtro_Balance.php';

		} // fin 2º if
	} // fin 1º if

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

	global $db;			global $dyt1;			global $dm1;		global $orden;
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
	//$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $table_admin;	$table_admin = "`".$_SESSION['clave']."admin`";
	global $vname;			$vname = "`".strtolower($_SESSION['clave']."horarios_").$dyt1."`";

	require 'calc_anu_mes.php';
	
			///////////////////////			***********  		///////////////////////
		
	require 'Inc_Suma_Todob.php';

			///////////////////////			***********  		///////////////////////

	global $sqlb;			global $qb;
	//$sqlb =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' ORDER BY $orden ";
	$sqlb =  "SELECT * FROM $vname WHERE `ref` = '$_SESSION[usuarios]' AND `din` LIKE '$fil' AND `ttot` <> '00:00:00' ORDER BY $orden ";

	//echo "<br>".$sqlb."<br>";
	$qb = mysqli_query($db, $sqlb);
	if(!$qb){print("<font color='#F1BD2D'>* Balances/Balances_Funciones.php ERROR L.152: </font>
					</br>".mysqli_error($db)."</br>");
	}else{ }

			////////////////////		**********  		////////////////////

	global $refses;			$refses = $_SESSION['usuarios'];

	global $tablau;
	$sqlun =  "SELECT * FROM $tablau WHERE `ref` = '$refses' LIMIT 1 ";
	$qun = mysqli_query($db, $sqlun);
	if(!$qun){print("<font color='#F1BD2D'>* Balances/Balances_Funciones.php ERROR L.165: </font>
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

?>