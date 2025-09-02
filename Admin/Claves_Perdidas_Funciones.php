<?php

 function validate_form(){
	  
	global $db;			global $db_name;
	global $q;			global $sql;		global $row;	
	
	$errors = array();
		 
	/* Validamos el campo mail. */
	
	if(strlen(trim($_POST['Email'])) == 0){
		$errors [] = "Mail: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif(strlen(trim($_POST['Email'])) < 5 ){
		$errors [] = "Mail: <font color='#F1BD2D'>Escriba más de cinco carácteres.</font>";
	}elseif(!preg_match('/^[^@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.*\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/',$_POST['Email'])){
		$errors [] = "Mail: <font color='#F1BD2D'>Esta dirección no es válida.</font>";
	}else{ }
		
	/* Validamos el campo dni */
	
	if(strlen(trim($_POST['dni'])) == 0){
		$errors [] = "Nº DNI: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif(!preg_match('/^[\d]+$/',$_POST['dni'])){
		$errors [] = "Nº DNI: <font color='#F1BD2D'>Sólo se admiten números.</font>";
	}elseif(strlen(trim($_POST['dni'])) < 8){
		$errors [] = "Nº DNI: <font color='#F1BD2D'>Más de 7 digitos.</font>";
	}else{ }

	/* Validamos el campo ldni */
	
	if(strlen(trim($_POST['ldni'])) == 0){
		$errors [] = "Letra DNI: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif(!preg_match('/^[^0-9@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['ldni'])){
		$errors [] = "Letra DNI: <font color='#F1BD2D'>Solo texto</font>";
	}elseif(!preg_match('/^[^a-z]+$/',$_POST['ldni'])){
		$errors [] = "Letra DNI: <font color='#F1BD2D'>Solo mayusculas</font>";
	}else{ }

	/* Realizamos un condicional de validacion de campos Nombre y dni.*/
		
	global $table_name_a;			$table_name_a = "`".$_SESSION['clave']."admin`";

	$sql =  "SELECT * FROM `$db_name`.$table_name_a WHERE `Email` = '$_POST[Email]' AND `dni` = '$_POST[dni]' AND `ldni` = '$_POST[ldni]' ";
 	
	$q = mysqli_query($db, $sql);
	$row = mysqli_fetch_assoc($q);
	$_SESSION['L_Email'] = @$row['Email'];
	$_SESSION['L_dni'] = @$row['dni'];
	$_SESSION['L_ldni'] = @$row['ldni'];

	if(trim($_POST['Email'] != $_SESSION['L_Email'])){
		$errors [] = "Email, Nº DNI o Letra.";
	}elseif(trim($_POST['dni'] != $_SESSION['L_dni'])){
		$errors [] = "Email, Nº DNI o Letra.";
	}elseif(trim($_POST['ldni'] != $_SESSION['L_ldni'])){
		$errors [] = "Email, Nº DNI o Letra.";
	}elseif (@$row['Nivel'] == 'locked'){
		$errors [] = "ACCESO RESTRINGIDO POR EL WEB MASTER";
	}elseif (@$row['del'] == 'true'){
		$errors [] = "ACCESO RESTRINGIDO POR EL WEB MASTER";
	}else{ }
	 
	return $errors;
 			
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){
	
	global $sql;		global $q;			global $row;
	
	if(isset($_POST['oculto2'])){
				$defaults = array (	'Asunto' => 'SUS CLAVES DE ACCESO',
									'Email' => $_POST['Email'],
									'dni' => isset($_POST['dni']),	
									'ldni' => isset($_POST['ldni']));
	}else{ }
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
	}else{
		$defaults = array (	'Asunto' => 'SUS CLAVES DE ACCESO',
							'Email' => '',
							'dni' => '',
							'ldni' => isset($_POST['ldni']));
	}
	
	if($errors){
		print("<div class='centradiv' style='border-color:#F1BD2D; color:#F1BD2D;'>
				* SOLUCIONE ESTOS ERRORES.<br>");
		
		for($a=0; $c=count($errors), $a<$c; $a++){
				//print("<font color='#F1BD2D'>* </font>".$errors [$a]."<br>");
			}

		print("DATOS INCORRECTOS<br>
			</div>
		<embed src='../audi/user_lost.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
		</embed>");

		}elseif(isset($_POST['oculto2']) != 1){
		print("<embed src='../audi/claves_lost_2.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
				</embed>");
				}
	
	print("<div class='centradiv'>

	<form name='Perdidos' method='post' action='$_SERVER[PHP_SELF]'>
		<input name='Asunto' type='hidden' value='".$defaults['Asunto']."' />".$defaults['Asunto']."
		<br>
			<input type='text' name='Email' size=30 value='".$defaults['Email']."' placeholder='EMAIL' required />
		<br>
			<input type='text' name='dni' size=30 maxlength=8 value='".$defaults['dni']."' placeholder='DNI' required />
		<br>
			<input type='text' name='ldni' size=16 maxlength=1 value='".$defaults['ldni']."' placeholder='LETRA CONTROL' required />

			<button type='submit' title='ENVIAR MIS CLAVES' class='botonlila imgButIco OpenBlack' style='vertical-align:top; margin-left:8%;' ></button>

		<input type='hidden' name='oculto' value=1 />

			<a href='../index.php'>
				<button type='button' title='VOLVER AL INICIO' class='botonverde imgButIco HomeBlack' style='vertical-align:top;' ></button>
			</a>
	</form>	
	</div>"); /* Fin del print */

	}	/* Fin de la función show_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;				global $db_name;

	global $table_name_a;	$table_name_a = "`".$_SESSION['clave']."admin`";

	//$eml = "%".$_POST['Email']."%";
	$sqlc =  "SELECT * FROM `$db_name`.$table_name_a WHERE `Email` = '$_POST[Email]' AND `dni` = '$_POST[dni]' AND `ldni` = '$_POST[ldni]' ";
	$qc = mysqli_query($db, $sqlc);
	
	if(!$qc){ print("ERROR L.143: ".mysqli_error($db)."<br><br>");
			
	}else{	
		if(mysqli_num_rows($qc)== 0){
			print ("<div class='centradiv' style='color:#F1BD2D;border-color:#F1BD2D;'>
						NO HAY DATOS
					</div>");
		}else{ 	
			print ("<div class='centradiv'>
				<form name='modifica' action='$_SERVER[PHP_SELF]' method='POST'>
					<input type='hidden' name='Asunto' value='".$_POST['Asunto']."' />".$_POST['Asunto']."<br>");
			
			while($rowc = mysqli_fetch_assoc($qc)){
										
				print ("<input type='hidden' name='Email' value='".$rowc['Email']."' />
						<input type='hidden' name='Usuario' value='".$rowc['Usuario']."' />
						<!-- \$rowc['Password'] PASA UN HASH \$rowc['Pass'] PASA EL PASWORD -->
						<input type='hidden' name='Password' value='".$rowc['Pass']."' />
						<input type='hidden' name='Nombre' value='".$rowc['Nombre']."' />
						<input name='Apellidos' type='hidden' value='".$rowc['Apellidos']."' />
			<img src='../Users/".$rowc['ref']."/img_admin/".$rowc['myimg']."' height='60px' width='45px' />
				<br>".strtoupper($rowc['Nombre'])." ".strtoupper($rowc['Apellidos']).".
					<!--	
						<br>USER: ".strtoupper($rowc['Usuario'])."
						<br>PASS HASH: ".$rowc['Password']."
						<br>PASS: ".strtoupper($rowc['Pass'])."</td>
					-->");
			} /* Fin del while.*/

			print("<br>
				<button type='submit' title='CONFIRMAR Y ENVIAR MIS DATOS VIA MAIL' class='botonlila imgButIco OpenBlack' style='vertical-align:top; margin-left:72%;' ></button>

				<input type='hidden' name='oculto2' value=1 />

				<a href='../index.php'>
					<button type='button' title='VOLVER AL INICIO' class='botonverde imgButIco HomeBlack' style='vertical-align:top; float:left;' ></button>
				</a>
			</form>
			</div>");
		} /* FIN segundo else anidado en if */

	} /* FIN primer else */

}	/* FIN function process_form(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

 function process_Mail(){	 

	global $mensaje;
	$mensaje = '<html lang="es">
					<head>
					<meta charset="UTF-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<title>Document</title>
					<style>
						body {
							font-family: "Times New Roman", Times, serif;
						}
						body a {
							text-decoration:none;
						}
						table a {
							color: #666666;
							text-decoration: none;
							font-family: "Times New Roman", Times, serif;
						}
						table a:hover {
							color: #FF9900;
							text-decoration: none;
						}
						tr {
							margin: 0px;
							padding: 0px;
						}
						td {
							margin: 0px;
							padding: 6px;
						}
						th {
							padding: 6px;
							margin: 0px;
							text-align: center;
							color: #666666;
						}
					</style>
				  	</head>
				<body bgcolor="#D7F0E7">
	<table font-family="Times New Roman" width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<th colspan="3">'.$_POST['Asunto'].'</th>
				</tr>
				<tr>
					<td align="right">Nombre:</td>
					<td width="12">&nbsp;</td>
					<td align="left">'.$_POST['Nombre'].'</td>
				</tr>
				<tr>
					<td align="right">Apellidos:</td>
					<td>&nbsp;</td>
					<td align="left">'.$_POST['Apellidos'].'</td>
				</tr>
				<tr>
					<td align="right">Email:</td>
					<td>&nbsp;</td>
					<td align="left">'.$_POST['Email'].'</td>
				</tr>
				<tr>
					<td align="right">Nombre de Usuario:</td>
					<td>&nbsp;</td>
					<td align="left">'.$_POST['Usuario'].'</td>
				</tr>
				<tr>
					<td align="right">Password:</td>
					<td>&nbsp;</td>
					<td align="left">'.$_POST['Password'].'</td>
				</tr>
				<tr>
				  	<td colspan="3" style="font-size:11px">
						<b>AVISO LEGAL</b>
						<br>
		Este mensaje y los archivos que en su caso lleve adjuntos son privados y confidenciales y se dirigen exclusivamente a su destinatario. Por ello, se informa a quien lo reciba por error de que la informaci&oacute;n contenida en el mismo es reservada y su utilizaci&oacute;n, copia odistribuci&oacute;n est&aacute; prohibida, por lo que, en tal caso, le rogamos nos lo comunique por esta misma v&iacute;a o por tel&eacute;fono al n&uacute;mero 654 639 155 de Espa&ntilde;a y proceda a borrarlo de inmediato. JuanBarros.es advierte expresamente que el env&iacute;o de correos electr&oacute;nicos a trav&eacute;s de Internet no garantiza la confidencialidad de los mensajes ni su integridad y correcta recepci&oacute;n, por lo que JuanBarros.es no asume responsabilidad alguna en relaci&oacute;n con dichas circunstancias.
	<br>
		Gracias.
	<br>
	<br>
		 <b>DISCLAIMER</b>
	<br>
		This message and the attached files are private and confidential and intended exclusively for the addressee. As such, JuanBarros.es informs to whom it may receive it in error that it contains privileged information and its use, copy or distribution is prohibited. If it  has been received by error, please notify us via e-mail or by telephone 654 639 155 Spain  and delete it immediately. JuanBarros.es expressly warns that the use of Internet e-mail neither guarantees the confidentiality of the messages nor its integrity and proper receipt, and ,therefore, JuanBarros.es does not assume any responsibilities for those circumstances.
	<br>
		 Thank you.
	<td>
	</tr>	
	</table>
		</body>
			</html>';
			
		# datos del mensaje
		global $destinatario;
		$destinatario = $_POST['Email'];
		$titulo = $_POST['Asunto'];
		$remite = 'juanbarrospazos@hotmail.es';
		//$remitente= 'ADMINISTRADOR SISTEMA'; //sin tilde para evitar errores de servidor

		# cabeceras
	// PASO LAS CABECERAS EN UNA SOLO VARIABLE
	global $cabecera;
	//$cabecera = "Date: ".date("l j F Y, G:i")."\nMIME-Version: 1.0\nContent-type: text/html; charset=UTF-8\nFrom: ".$remite."<".$remite.">\nReply-To: ".$remite."\n";

	$cabecera = 'Content-type: text/html; charset=UTF-8'."\n";				
	//$cabecera ="Content-Type: multipart/mixed;"."\n";
	$cabecera .="MIME-Version: 1.0\n";
	//$cabecera .= 'MIME-Version: 1.0' . "\r\n";
	$cabecera .= "Date: ".date("l j F Y, G:i")."\n";
	//$cabecera .= "From: ".$remite."<".$remite.">\n";
	$cabecera .= "Bcc: manuelpazos02@gmail.com \n";
	//$cabecera .="Return-path: ". $remite."\n";
	//$cabecera .="Reply-To: ".$remite."\n";
	$cabecera .="X-Mailer: PHP/". phpversion()."\n";
				
	/* SOLO PARA ARCHIVOS ADJUNTOS. 
	Adjuntamos una imagen en el mensaje. 
	$adj1 = "\n"."--$separador"."\n"; 
				
	$adj1 .="Content-Type: image/gif;";
	$adj1 .=" name=\"Degra3A.gif\""."\n";
	$adj1 .="Content-Disposition: attachment; ";
	$adj1 .="filename=\"Degra3A.gif\""."\n";
	$adj1 .="Content-Transfer-Encoding: base64"."\r\n\r\n";
				
	$fp = fopen("Degra3A.gif", "r");
	$buff = fread($fp, filesize("Degra3A.gif"));
	fclose($fp);
				
	$adj1 .=chunk_split(base64_encode($buff));
	*/
								
	/* 
	Le pasamos a la variable $mensaje el valor de $texto_html y $adj1, que es la imagen
	$mensaje= $texto_html.$adj1;
	*/
				
	if( mail($destinatario, $titulo, $mensaje, $cabecera)){
		print("<div class='centradiv'>
				<font color='#0080C0'>
					SUS DATOS HAN SIDO ENVIADOS.
					<br>
					MUCHAS GRACIAS ".$_POST['Nombre']." ".$_POST['Apellidos'].".
				</font>
				<br>
				<a href='../index.php'>
					<button type='button' title='VOLVER AL INICIO' class='botonverde imgButIco HomeBlack' style='vertical-align:top;' ></button>
				</a>
			</div>
		<embed src='../audi/claves_lost_3.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
		</embed>");

	}else{	
		print("<div class='centradiv' style='border-color:#F1BD2D; color:#F1BD2D;'>
				EL MENSAJE NO HA PODIDO ENVIARSE.
					<br>
				<a href='http://juanbarrospazos.blogspot.com.es/' target='_blank'>
					<button type='button' title='CONTACTOS WEB MASTER' class='botonverde imgButIco WebBlack' style='vertical-align:top;' ></button>
				</a>
				<a href='../index.php'>
					<button type='button' title='VOLVER AL INICIO' class='botonverde imgButIco HomeBlack' style='vertical-align:top;' ></button>
				</a>
			</div>
		<embed src='../audi/claves_lost_4.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
		</embed>");
		
	} /*FIN else mail*/

		global $redir;
		$redir = "<script type='text/javascript'>
					function redir(){
					window.location.href='../index.php';
				}
				setTimeout('redir()',12000);
				</script>";
		print ($redir);
														
}	/* Fin funcion process_Mail(); */
			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	function master_index(){
		
		require '../Inclu_MInd/rutaadmin.php';
		require '../Inclu_MInd/Master_Index.php';
		
	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
?>