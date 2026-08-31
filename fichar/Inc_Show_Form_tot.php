<?php

	global $CheckDatos;		global $CheckBin;

	if(isset($_POST['oculto1'])){	
		$_SESSION['usuarios'] = $_POST['usuarios'];
		$defaults = $_POST;
		// print("* ".$_SESSION['usuarios']);
		if($_SESSION['usuarios'] == ''){ 
			print("<div class='centradiv alertdiv'>SELECCIONE UN USUARIO</div>
					<audio src='../audi/select_one_user.mp3' autoplay></audio>");
		}else{
			print("<audio src='../audi/filter_query_date.mp3' autoplay></audio>");
		}
	}elseif(isset($_POST['todo'])){

		if(!isset($_POST['cherror'])){ $CheckDatos = ""; }else{ $CheckDatos = "checked='checked'"; }
		if(!isset($_POST['chbin'])){ $CheckBin = ""; }else{ $CheckBin = "checked='checked'"; }
		//echo "*** ".$_POST['cherror']." *** ".$CheckDatos."<br>";
		$defaults = array ('id' => isset($_POST['id']),
							'dy' => $_POST['dy'],
							'dm' => $_POST['dm'],
							'dd' => $_POST['dd'],
							'Orden' => @$_POST['Orden'],
							'usuarios' => $_SESSION['usuarios'],
							'cherror' => @$_POST['cherror'],
							'chbin' => @$_POST['chbin'],);
	}else{
		print("<audio src='../audi/select_one_user.mp3' autoplay></audio>");
	}
	
	$dm = array('' => 'MONTH','01' => 'ENERO','02' => 'FEBRER','03' => 'MARZO',
				'04' => 'ABRIL','05' => 'MAYO','06' => 'JUNIO','07' => 'JULIO',
				'08' => 'AGOSTO','09' => 'SEPTIE','10' => 'OCTUBR','11' => 'NOVIEM',
				'12' => 'DICIEM');
	
	$dd = array('' => 'DAY','01' => '01','02' => '02','03' => '03',
				'04' => '04','05' => '05','06' => '06','07' => '07',
				'08' => '08','09' => '09','10' => '10','11' => '11',
				'12' => '12','13' => '13','14' => '14','15' => '15',
				'16' => '16','17' => '17','18' => '18','19' => '19',
				'20' => '20','21' => '21','22' => '22','23' => '23',
				'24' => '24','25' => '25','26' => '26','27' => '27',
				'28' => '28','29' => '29','30' => '30','31' => '31');
										
	$orden = array('`din` ASC' => 'Fecha In Asc',
					'`din` DESC' => 'Fecha In Desc',
					'`dout` ASC' => 'Fecha Out Asc',
					'`dout` DESC' => 'Fecha Out Desc',
					'`id` ASC' => 'ID Asc',
					'`id` DESC' => 'ID Desc');

	print("<div class='centradiv' style='padding:0.4em;'>
			<div style='margin:0.2em auto 0.4em auto;'>GESTIONAR REGISTROS HORARIOS</div>");

		global $db;
		global $tablau;			$tablau = "`".$_SESSION['clave']."admin`";
		global $sqlu;
		//$sqlu =  "SELECT * FROM $tablau WHERE (`del` = 'false' AND `nivel` <> 'locked') ORDER BY `ref` ASC ";
		$sqlu =  "SELECT * FROM $tablau WHERE `nivel` <> 'locked' ORDER BY `ref` ASC ";

		$qu = mysqli_query($db, $sqlu);
		if(!$qu){
				print("Modifique la entrada L.60 ".mysqli_error($db)."<br>");
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

		print("<form name='form_tabla' method='post' action='".$_SERVER['PHP_SELF']."' style='margin-right:6px'>
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

			///////////////////////			**********  		///////////////////////

	if((isset($_POST['oculto1']))||(isset($_POST['todo']))){

		global $CheckDatos;		global $CheckBin;		global $titulo;		global $dy;
		if($_SESSION['usuarios'] != ''){
			print("<div class='centradiv' style='padding:0.4em;'>
						<div style='margin:0.2em auto 0.4em auto;'>
							".$titulo." ".$_SESSION['usuarios']."
						</div>");
						
			print ("<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
						<select name='Orden'>");
							foreach($orden as $option => $label){
									print ("<option value='".$option."' ");
									if($option == ($defaults['Orden'] ?? '')){ print ("selected = 'selected'"); }
									print ("> $label </option>");
							}
				print ("</select>");

				require '../config/SelectAnhos.php';

				print ("<select name='dm'>");
							foreach($dm as $optiondm => $labeldm){
								print ("<option value='".$optiondm."' ");
								if($optiondm == ($defaults['dm'] ?? '')){ print ("selected = 'selected'"); }
								print ("> $labeldm </option>");
							}	
				print ("</select>
						<select name='dd'>");
							foreach($dd as $optiondd => $labeldd){
								print ("<option value='".$optiondd."' ");
								if($optiondd == ($defaults['dd'] ?? '')){ print ("selected = 'selected'"); }
								print ("> $labeldd </option>");
							}	
				print("</select>
				<input type='hidden' name='usuarios' value='".htmlspecialchars($defaults['usuarios'] ?? '')."' />
					<button type='submit' title='SELECCONAR USUARIO' class='botonverde imgButIco InicioBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
						<input type='hidden' name='todo' value=1 />

				<div style='clear:both'></div>");

				if(($CheckDatos!='')&&($CheckBin!='')){
					print("<div class='centradiv alertdiv'>SELECCIONE ERRORES, PAPELERA O NADA</div>");
					$CheckBin = '';			$CheckDatos = '';
				}

				print("
					<div style='display:inline-block; margin: 0.2em 0.4em;'>
						<font color='#F1BD2D'>* </font>
				<input type='checkbox' name='cherror' value='".htmlspecialchars($defaults['cherror'] ?? '')."' ".$CheckDatos." />
							VER ERRORES
					</div>
					<div style='display:inline-block; margin: 0.2em 0.4em;'>
						<font color='#F1BD2D'>* </font>
				<input type='checkbox' name='chbin' value='".htmlspecialchars($defaults['chbin'] ?? '')."' ".$CheckBin." />
							VER PAPELERA
					</div>
				</form>
			</div>"); /* FIN formulario */


		} // FIN 2º if
	} // FIN 1º if Nivel Usuarios

?>