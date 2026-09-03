<?php

	global $db;				global $db_name; 
	
	if(isset($_POST['oculto1'])){	$_SESSION['usuarios'] = $_POST['usuarios'];
									$defaults = $_POST;
									//print("* ".$_SESSION['usuarios']);
		if($_SESSION['usuarios'] == ''){ 
			print("<div class='centradiv alertdiv'>SELECCIONE UN USUARIO</div>");
			print("<audio src='../audi/select_one_user.mp3' autoplay></audio>");
		}
	}elseif(!isset($_SESSION['usuarios'])){ 
		print("<audio src='../audi/select_one_user.mp3' autoplay></audio>");
	}

	global $db, $db_name;
	global $tablau;				$tablau = "`".$_SESSION['clave']."admin`";

	global $sqlu;
	$sqlu =  "SELECT * FROM $tablau WHERE `ref` <> '$_SESSION[ref]' AND `nivel` <> 'locked' ORDER BY `ref` ASC ";
	$qu = mysqli_query($db, $sqlu);
	
	global $titulo;		global $defaults;
	if(!$qu){ print("Modifique la entrada L.60 ".mysqli_error($db)."<br>");
	}elseif(mysqli_num_rows($qu)== 0){
		print ("<div class='centradiv alertdiv'>NO EXISTEN OTROS USUARIOS</div>");
				global $ficharCrear;		$ficharCrear = 1;
		require 'Fichar_Crear_Botonera.php';

	}else{
		print("<div class='centradiv' style='padding:0.6em;'>
				<div style='margin: 0.3em auto'>".$titulo."</div>");


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

			///////////////////////			**********  		///////////////////////
				
		global $ficharCrear;		$ficharCrear = 3;
		require 'Fichar_Crear_Botonera.php';

			///////////////////////			**********  		///////////////////////
	
	if(isset($_POST['oculto1'])){
		
		if($_SESSION['usuarios'] != '') {
			global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";
			$sqln =  "SELECT * FROM $table_name_a WHERE `ref` = '$_SESSION[usuarios]'";
			$q1n = mysqli_query($db, $sqln);
			$rn = mysqli_fetch_assoc($q1n);
			global $name1o;				$name1o = $rn['Nombre'];
			global $name2o;				$name2o = $rn['Apellidos'];
			global $uimg;				$uimg = $rn['myimg'];
	
			//$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
			global $vname;		$vname = "`".strtolower($_SESSION['clave']."horarios_").date('Y')."`";
		
			$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE `ref` = '$_SESSION[usuarios]' AND `dout` IS NULL AND `ttot` = '00:00:00' LIMIT 1";
			$q1 = mysqli_query($db, $sql1);
			$count1 = mysqli_num_rows($q1);
			//print($count1);
			
			if($count1 < 1){
				
				global $din;			$din = date('Y-m-d');
				global $tin;
				/*
					HORA ORIGINAL DE ENTRADA DEL SCRIPT
					$tin = date('H:i:s');
				*/

				require 'Fichar_Redondeo_in.php';

				global $dout;			$dout = ($dout === '') ? null : $dout;
				global $tout;			$tout = '00:00:00';
				global $ttot;			$ttot = '00:00:00';
				
				global $Action;			$Action = "action='$_SERVER[PHP_SELF]'";
				global $ImgForm;
				$ImgForm = "<li class='liCentra'>
								<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$uimg."' />
							</li>";
				global $FormButtonHome;
				$FormButtonHome = "<form name='volver' action='$_SERVER[PHP_SELF]' style='display:inline-block; margin-right:10%;' >
						<button type='submit' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
							<input type='hidden' name='volver' value=1 />
					</form>";
				global $rutaAudio;
				$rutaAudio = "<audio src='../audi/conf_user_data.mp3' autoplay></audio>";
				require 'Fichar_Tablas_Form.php';
				global $FichaIn;		print($FichaIn);

			}elseif($count1 > 0){
			
				global $name1o;				global $name2o;
				global $uimg;				global $dout;
				global $tout;
				global $ttot;				$dout = date('Y-m-d');
				/*
					HORA ORIGINAL DE SALIDA DEL SCRIPT
					$tout = date('H:i:s');
				*/

				require 'Fichar_Redondeo_out.php'; 

				global $Action;			$Action = "action='$_SERVER[PHP_SELF]'";
				global $ImgForm;
				$ImgForm = "<li class='liCentra'>
								<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$uimg."' />
							</li>";
				global $FormButtonHome;
				$FormButtonHome = "<form name='volver' action='$_SERVER[PHP_SELF]' style='display: inline-block; margin-right:10%;' >
						<button type='submit' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
						<input type='hidden' name='volver' value=1 />
					</form>";
				global $rutaAudio;
				$rutaAudio = "<audio src='../audi/conf_user_data.mp3' autoplay></audio>";
				require 'Fichar_Tablas_Form.php';
				global $FichaOut;		print($FichaOut);

			}
		} // fin 2º if
	} // fin 1º if
} // condicional no hay usuarios

?>