<?php
//session_start();

	require 'Mac_Cliente.php';

	global $playinclu;		$playinclu = 1;

	require 'error_hidden.php';
	require 'Admin_head.php';
	require 'webmaster.php';
	require 'nemp.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require 'my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if(isset($_POST['oculto'])){

	if($form_errors = validate_form()){
					show_form($form_errors);
	}else{ print("<div class='centradiv' style=border-color:#0080C0;color:#0080C0;padding:0.6em;'>
							PETICIÓN PROCESADA CORRECTAMENTE
				</div>
		<audio src='../audi/ip_confirm_unlock.mp3' autoplay></audio>");
			process_form();
	}

/* FIN del if $_POST['oculto']*/
}elseif(isset($_POST['oculto2'])){ 
					desbloqueo();
}else{	show_form();
		global $text;
		if(isset($_POST['cancel'])){
				$text = "!! CANCELADO DESBLOQUEO IP".PHP_EOL." NUEVO ACCESO AL FORMULARIO INICIAL".PHP_EOL;
		}else{
				$text = "!! DESBLOQUEO IP ACCESO A FORMULARIO".PHP_EOL;
		}
		// PASO LOGS DE DESBLOQUEO
		ini_log();
}
												
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

 function validate_form(){
	 
	global $db;				global $db_name;			global $sql;
	global $table_name_a;	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sql =  "SELECT * FROM `$db_name`.$table_name_a WHERE `Email` = '$_POST[Email]' AND `dni` = '$_POST[dni]' AND `ldni` = '$_POST[ldni]' ";
 	
	global $q;				$q = mysqli_query($db, $sql);
	global $row;			$row = mysqli_fetch_assoc($q);
	@$_SESSION['L_Email'] = $row['Email'];
	@$_SESSION['L_dni'] = $row['dni'];
	@$_SESSION['L_ldni'] = $row['ldni'];

	@$errors = array();
		
	if((@$row['Nivel'] == 'locked')||(@$row['Nivel'] == 'user')||(@$row['del'] == 'true')){
			@$errors [] = "ACCESO RESTRINGIDO POR EL WEB MASTER";
	}elseif(strlen(trim($_POST['Email'])) == 0){
	/* VALIDAMOS EL CAMPO EMAIL */		
	/*$errors [] = "Mail: <font color='#F1BD2D'>CAMPO OBLIGATORIO.</font>";*/
		$errors [] = "@ / Nº / LETRA";
	}elseif(strlen(trim($_POST['Email'])) < 5 ){
		/*$errors [] = "Mail: <font color='#F1BD2D'>MÁS DE 5 CARÁCTERES.</font>";*/
		$errors [] = "@ / Nº / LETRA";
	}elseif(!preg_match('/^[^@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.*\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/',$_POST['Email'])){
		/*$errors [] = "Mail: <font color='#F1BD2D'>@ NO VÁLIDO</font>";*/
		$errors [] = "@ / Nº / LETRA";
	}elseif(strlen(trim($_POST['dni'])) == 0){
	/* VALIDAMOS CAMPO DNI */
		/*$errors [] = "Nº DNI: <font color='#F1BD2D'>CAMPO OBLIGATORIO.</font>";*/
		$errors [] = "@ / Nº / LETRA";
	}elseif(!preg_match('/^[A-Z\d]+$/',$_POST['dni'])){
		/*$errors [] = "Nº DNI: <font color='#F1BD2D'>SÓLO NÚMEROS O LETRAS MAYÚSCULAS</font>";*/
		$errors [] = "@ / Nº / LETRA";
	}elseif(strlen(trim($_POST['dni'])) < 8){
		/*$errors [] = "Nº DNI: <font color='#F1BD2D'>MAS DE 7 DÍGITOS</font>";*/
		$errors [] = "@ / Nº / LETRA";
	}elseif(strlen(trim($_POST['ldni'])) == 0){
	/* VALIDAMOS CAMPO LDNI */
		/*$errors [] = "Letra DNI: <font color='#F1BD2D'>CAMPO OBLIGATORIO</font>";*/
		$errors [] = "@ / Nº / LETRA";
	}elseif(!preg_match('/^[^0-9@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['ldni'])){
		/*$errors [] = "Letra DNI: <font color='#F1BD2D'>SÓLO TEXTO</font>";*/
		$errors [] = "@ / Nº / LETRA";
	}elseif(!preg_match('/^[^a-z]+$/',$_POST['ldni'])){
		/*$errors [] = "Letra DNI: <font color='#F1BD2D'>SÓLO MAYÚSCULAS</font>";*/
		$errors [] = "@ / Nº / LETRA";
	}elseif(trim($_POST['Email'] != $_SESSION['L_Email'])){
	/* VALIDACION DE NOMBRE Y DNI */
		$errors [] = "@ / Nº / LETRA";
	}elseif(trim($_POST['dni'] != $_SESSION['L_dni'])){
		$errors [] = "@ / Nº / LETRA";
	}elseif(trim($_POST['ldni'] != $_SESSION['L_ldni'])){
		$errors [] = "@ / Nº / LETRA";
	}else{ }
	 
	return $errors;
	 
} // FIN function validate_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	global $sql;			global $q;			global $row;
	
	if(isset($_POST['oculto2'])){
		$defaults = array (	'Asunto' => 'FORMULARIO DESBLOQUEO IP',
							'Email' => $_POST['Email'],
							'dni' => $_POST['dni'],	
							'ldni' => $_POST['ldni']);
	}elseif(isset($_POST['oculto'])){
			$defaults = $_POST;
	}else{	$defaults = array (	'Asunto' => 'FORMULARIO DESBLOQUEO IP',
								'Email' => '',
								'dni' => '',
								'ldni' => isset($_POST['ldni']));
	}
	
	if($errors){
		print("<table class='centradiv alertdiv'>
				<tr>
					<th>SOLUCIONE ESTOS ERRORES</th>
				</tr>
				<tr>
					<td style='text-align:left !important'>");
		
		// PASO LOGS DE FORMULARIO DESBLOQUEO IP
		global $text;
		$text = "!! ERRORES VALIDACION FORMULARIO DESBLOQUEO IP".PHP_EOL;
		ini_log();

		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#F1BD2D'>* </font>".$errors [$a]."<br>	");
				// ESCRIBE ERRORES EN INI_LOG
				global $text;
				$text = $errors[$a];
				$logdate = date('Y-m-d');
				$logtext = "\t ** ".$text.PHP_EOL;
				$filename = "../LogsAcceso/LogsAcceso_".$logdate.".log";
				$log = fopen($filename, 'ab+');
				fwrite($log, $logtext);
				fclose($log);
				}
		print("</td>
				</tr>
			</table>
		<audio src='../audi/user_lost.mp3' autoplay></audio>");

		}elseif(isset($_POST['oculto2']) != 1){
			print("<audio src='../audi/ip_unlock_form.mp3' autoplay></audio>");
		}
	
	print("<table class='centradiv'>
				<tr>
					<th>
			<form name='Perdidos' method='post' action='$_SERVER[PHP_SELF]'>
		<input type='hidden' name='Asunto' value='".$defaults['Asunto']."' />".$defaults['Asunto']."
					</th>
				</tr>
				<tr>
					<td>
		<input type='text' name='Email' size=30 value='".$defaults['Email']."' placeholder='EMAIL' required />
					</td>
				</tr>
				<tr>
					<td>
		<input type='text' name='dni' size=30 maxlength=8 value='".$defaults['dni']."' placeholder='DNI' required/>
					</td>
				</tr>
				<tr>
					<td>
		<input type='text' name='ldni' size=30 maxlength=1 value='".$defaults['ldni']."' placeholder='LETRA DNI' required />
					</td>
				</tr>
				<tr>
					<td>
			<button type='submit' title='SOLICITAR DEBLOQUEO DE SU IP' class='botonverde imgButIco Clock1Black' style='vertical-align:top;' ></button>
			<input type='hidden' name='oculto' value=1 />
		</form>	
			<a href='../index.php'>
				<button type='button' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='cancel' value=1 />
			</a>
					</td>
				</tr>
		</table>"); /* FIN del print */

	}	/* FIN de la función show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;					global $db_name;
	
	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";

	// print ("* ".$_POST['Email']." / ".$_POST[dni].$_POST[ldni].". ".$_SESSION['refdesb']." / ".$_SESSION['nivdesb']);
	
	$sqlc =  "SELECT * FROM `$db_name`.$table_name_a WHERE `Email` = '$_POST[Email]' AND `dni` = '$_POST[dni]' AND `ldni` = '$_POST[ldni]' ";
	$qc = mysqli_query($db, $sqlc);
	$rowqc = mysqli_fetch_assoc($qc);
	$_SESSION['refdesb'] = $rowqc['ref'];
	$_SESSION['nivdesb'] = $rowqc['Nivel'];
	
	if(!$qc){
		print("Se ha producido un error: ".mysqli_error($db)."<br><br>");
	}else{	
			if(mysqli_num_rows($qc) == 0){
					print ("No hay datos.");
				// PASO LOGS DE DESBLOQUEO
				global $text;
				$text = "!! NO HAY DATOS DE LA CONSULTA.".PHP_EOL;

			}else{ 
				print ("<div class='centradiv'>
					<div>CONFIRME DESBLOQUEO IP</div>
					<div>
			<img src='../Users/".$rowqc['ref']."/img_admin/".$rowqc['myimg']."' height='60px' width='45px' />
					</div>
					<div>".$rowqc['Nombre']." ".$rowqc['Apellidos']."</div>
					<div>
			<form name='modifica' action='$_SERVER[PHP_SELF]' method='POST' style='display:inline-block;'>
				<button type='submit' title='DESBLOQUEAR SU IP' class='botonverde imgButIco Clock1Black' style='vertical-align:top;' ></button>
					<input type='hidden' name='oculto2' value=1 />
					<input type='hidden' name='refdesb' value=".$rowqc['ref']." />
					<input type='hidden' name='nivdesb' value=".$rowqc['Nivel']." />
			</form>
			<a  href='../index.php'>
				<button type='button' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
			</a>
				</div>
			</div>");
				// PASO LOGS DE DESBLOQUEO
				global $text;
				$text = "!! SOLICITUD CONFIRMACION DESBLOQUEO IP".PHP_EOL."\t\tUSUARIO: ".$rowqc['Nombre']." ".$rowqc['Apellidos'].PHP_EOL."\t\tREFERENCIA: ".$rowqc['ref']." NIVEL: ".$rowqc['Nivel'].PHP_EOL;
				
			} /* FIN segundo else anidado en if */

			ini_log();

		} /* FIN de primer else */

	} /* FINal de la función process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function desbloqueo(){
	
	require '../Inclu/ipCliente.php';

	global $db;			global $db_name;

	/*
		<input type='hidden' name='refdesb' value=".$rowqc['ref']." />
		<input type='hidden' name='nivdesb' value=".$rowqc['Nivel']." />
	*/
	
	// DESBLOQUEO TODAS LAS IPs IGUALES A LA MIA
	global $table_name_b;			$table_name_b = "`".$_SESSION['clave']."ipcontrol`";

	$desb = "UPDATE `$db_name`.$table_name_b SET `ref` = '$_POST[refdesb]', `nivel` = '$_POST[nivdesb]', `error` = 'des', `acceso` = 'des' WHERE $table_name_b.`ipn` = '$ipCliente' AND $table_name_b.`acceso` = 'x' OR $table_name_b.`acceso` = '0' ";
	if(mysqli_query($db, $desb)){ $_SESSION['showf'] = 0;
		print("<div class='centradiv alertdiv'>
						SU IP ".$ipCliente." HA SIDO DESBLOQUEADA
						<br>
					<a href='../index.php'>
				<button type='button' title='VOLVER A ADMIN ACCESS' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
					</a>
				</div>
		<audio src='../audi/ip_unlocked_ok.mp3' autoplay></audio>");
			
			// PASO LOGS DE DESBLOQUEO
			global $text;
			$text = "!! CONFIRMACION DESBLOQUEO IP: ".$ipCliente.PHP_EOL."\t\tREFERENCIA: ".$_POST['refdesb']." NIVEL: ".$_POST['nivdesb'].PHP_EOL;
			ini_log();
					 
		 	global $redir;
			$redir = "<script type='text/javascript'>
							function redir(){
							window.location.href='../index.php';
						}
						setTimeout('redir()',4000);
						</script>";
			print($redir);

		}else{ print("* ERROR ENTRADA 355: ".mysqli_error($db))."."; }
	
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ini_log(){

	$ActionTime = date('H:i:s');

	global $text;

    $logdate = date('Y-m-d');

    $logtext = "** ".$ActionTime.PHP_EOL."\t ** ".$text.PHP_EOL;
    $filename = "../LogsAcceso/LogsAcceso_".$logdate.".log";
    $log = fopen($filename, 'ab+');
    fwrite($log, $logtext);
    fclose($log);

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	require 'Admin_Inclu_footer.php';

					   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>
