<?php

	//error_reporting (0);
	
	$errors = array();

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";


				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

		
/*	CREAR LA REFERENCIA DE USUARIO	*/

	global $rf1; 	global $rf2; 	global $rf3; 	global $rf4;
	
if (preg_match('/^(\w{1})/',$_POST['Nombre'],$ref1)){	$rf1 = $ref1[1];
														$rf1 = trim($rf1);
														/*print($ref1[1]."</br>");*/
																				}
if (preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Nombre'],$ref2)){	$rf2 = $ref2[2];
																$rf2 = trim($rf2);
																/*print($ref2[2]."</br>");*/
																						}
if (preg_match('/^(\w{1})/',$_POST['Apellidos'],$ref3)){	$rf3 = $ref3[1];
															$rf3 = trim($rf3);
															/*print($ref3[1]."</br>");*/
																					}
if (preg_match('/^(\w{1})*(\s\w{1})/',$_POST['Apellidos'],$ref4)){	$rf4 = $ref4[2];
																	$rf4 = trim($rf4);
																	/*print($ref4[2]."</br>");*/
																							}

	global $rf;
	$rf = $rf1.$rf2.$rf3.$rf4.$_POST['dni'].$_POST['ldni'];
	$rf = trim($rf);
			
	/* COMPROBAMOS SI EXISTE EL ADMINISTRADOR */

		global $db; 	global $db_name;
		
		$admin =  "SELECT * FROM `$db_name`.$table_name_a WHERE `ref` = '$rf'";
		$qadmin = mysqli_query($db, $admin);
		$cadmin = mysqli_num_rows($qadmin);
		
	if($cadmin > 0){$errors [] = "YA EXISTE EL ADMINISTRADOR ".$rf;}
	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* VALIDAMOS EL CAMPO NOMBRE. */
	
	if(strlen(trim($_POST['Nombre'])) == 0){
		$errors [] = "NOMBRE: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}
	
	elseif (strlen(trim($_POST['Nombre'])) < 3){
		$errors [] = "NOMBRE: <font color='#FF0000'>MAS DE DOS CARACTERES</font>";
		}
		
	elseif (!preg_match('/^[^0-9@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['Nombre'])){
		$errors [] = "NOMBRE: <font color='#FF0000'>TEXOT SIN ACENTOS</font>";
		}
		
	/* VALIDAMOS EL CAMPO APELLIDOS. */
	
		if(strlen(trim($_POST['Apellidos'])) == 0){
		$errors [] = "APELLIDOS: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}
	
	elseif (strlen(trim($_POST['Apellidos'])) < 4){
		$errors [] = "APELLIDOS: <font color='#FF0000'>MAS DE TRES CARACTERES</font>";
		}
		
	elseif (!preg_match('/^[^0-9@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['Apellidos'])){
		$errors [] = "APELLIDOS: <font color='#FF0000'>TEXTO SIN ACENTOS</font>";
		}
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* VALIDAMOS EL CAMPO  NUMERO DNI/NIF */
	global $db; 	global $sqldni; 	global $qdni; 	global $db_name;

	$sqldni =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$_POST[dni]'";
	$qdni = mysqli_query($db, $sqldni);
	if(!$qdni){

	}else{ 
		$rowdni = mysqli_fetch_assoc($qdni);
	}

	
	if (isset($_POST['id']) == @$rowdni['id']){}
	elseif(mysqli_num_rows($qdni)!= 0){
		
		$errors [] = "NUMERO DNI/NIF: <font color='#FF0000'>YA EXISTE</font>";
		}
		
	if ($_POST['doc'] == 'DNI') {

		if(strlen(trim($_POST['dni'])) == 0){
		$errors [] = "NUMERO DNI/NIF: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}

	elseif (!preg_match('/^[\d]+$/',$_POST['dni'])){
		$errors [] = "NUMERO DNI/NIF: <font color='#FF0000'>SOLO NUMEROS</font>";
		}

	elseif (strlen(trim($_POST['dni'])) < 8){
		$errors [] = "NUMERO DNI/NIF: <font color='#FF0000'>MAS DE 7 CARACTERES</font>";
		}
	}
	
	/* VALIDAMOS EL CAMPO  
							NUMERO NIE/NIF  XYZ - 
							NIF ESPECIAL KLM - 
							NIF PERSONAS JURIDICAS Y ENTIDADES EN GENERAL 
	*/

	/* VALIDACION COMUN A TODAS LAS OPCIONES */
	
	if (($_POST['doc'] == 'NIE') || ($_POST['doc'] == 'NIFespecial') || ($_POST['doc'] == 'NIFsa') || ($_POST['doc'] == 'NIFsrl') || ($_POST['doc'] == 'NIFscol') || ($_POST['doc'] == 'NIFscom') || ($_POST['doc'] == 'NIFcbhy') || ($_POST['doc'] == 'NIFscoop') || ($_POST['doc'] == 'NIFasoc') || ($_POST['doc'] == 'NIFcpph') || ($_POST['doc'] == 'NIFsccspj') || ($_POST['doc'] == 'NIFee') || ($_POST['doc'] == 'NIFcl') || ($_POST['doc'] == 'NIFop') || ($_POST['doc'] == 'NIFcir') || ($_POST['doc'] == 'NIFoaeca') || ($_POST['doc'] == 'NIFute') || ($_POST['doc'] == 'NIFotnd') || ($_POST['doc'] == 'NIFepenr')) {

		if(strlen(trim($_POST['dni'])) == 0){
		$errors [] = "N&uacute;mero NIE/NIF: <font color='#FF0000'>Campo obligatorio.</font>";
		}

	elseif (strlen(trim($_POST['dni'])) < 8){
		$errors [] = "N&uacute;mero NIE/NIF: <font color='#FF0000'>Más de 7 carácteres.</font>";
		}
		
	elseif (!preg_match('/\b[a-zA-Z]/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIE/NIF: <font color='#FF0000'>Falta la Letra</font>";
		}
		
	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,\/:\.\*\s]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIE/NIF: <font color='#FF0000'>Sin caracteres especiales</font>";
		}

	elseif (!preg_match('/^[^a-z]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIE/NIF: <font color='#FF0000'>Solo mayusculas</font>";
		}
		
	/* SE VALIDAN LAS LETRAS DEL CAMPO NUMERO NIE/NIF */	
		
	elseif ($_POST['doc'] == 'NIE') {
		
		if (preg_match('/^[^XYZ]+$/',$_POST['dni'])){	// SOLO SE ADMINTE XYZ //
		$errors [] = "N&uacute;mero NIE/NIF: <font color='#FF0000'>Letra Invalida Solo X,Y,Z.</font>";
		}
			}
					
	elseif ($_POST['doc'] == 'NIFespecial') {	// SOLO SE ADMINTE KLM //
		
		if (preg_match('/^[^KLM]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Especial: <font color='#FF0000'>Letra Invalida Solo K,L,M.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFsa') {	// SOLO SE ADMITE A //
		
		if (preg_match('/^[^A]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Sociedad An&oacute;nima: <font color='#FF0000'>Letra Invalida Solo A.  </font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFsrl') {	// SOLO SE ADMITE B //
		
		if (preg_match('/^[^B]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Sociedad Respons Limitada: <font color='#FF0000'>Letra Invalida Solo B.</font>";
		}
			}
		
	elseif ($_POST['doc'] == 'NIFscol') {	// SOLO SE ADMITE C //
		
		if (preg_match('/^[^C]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Sociedad Colectiva: <font color='#FF0000'>Letra Invalida Solo C.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFscom') {	// SOLO SE ADMITE D //
		
		if (preg_match('/^[^D]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Sociedad Comanditaria: <font color='#FF0000'>Letra Invalida Solo D.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFcbhy') {	// SOLO SE ADMITE E //
		
		if (preg_match('/^[^E]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Comunidad Bienes y Herencias Yacentes: <font color='#FF0000'>Letra Invalida Solo E.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFscoop') {	// SOLO SE ADMITE F //
		
		if (preg_match('/^[^F]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Sociedades Cooperativas: <font color='#FF0000'>Letra Invalida Solo F.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFasoc') {	// SOLO SE ADMITE G //
		
		if (preg_match('/^[^G]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Asociaciones: <font color='#FF0000'>Letra Invalida Solo G.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFcpph') {	// SOLO SE ADMITE H //
		
		if (preg_match('/^[^H]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Comunidad Propietarios Propiedad Horizontal: <font color='#FF0000'>Letra Invalida Solo H.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFsccspj') {	// SOLO SE ADMITE J //
		
		if (preg_match('/^[^J]+$/',$_POST['dni'])){
	$errors [] = "N&uacute;mero NIF Sociedad Civil, con o sin Personalidad Juridica: <font color='#FF0000'>Letra Invalida Solo J.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFee') {	// SOLO SE ADMITE N //
		
		if (preg_match('/^[^N]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIF Entidad Extranjera: <font color='#FF0000'>Letra Invalida Solo N.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFcl') {	// SOLO SE ADMITE P //
		
		if (preg_match('/^[^P]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIF Corporación Local: <font color='#FF0000'>Letra Invalida Solo P.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFop') {	// SOLO SE ADMITE Q //
		
		if (preg_match('/^[^Q]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIF Organismo Publico: <font color='#FF0000'>Letra Invalida Solo Q.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFcir') {	// SOLO SE ADMITE R //
		
		if (preg_match('/^[^R]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIF Congregaciones Instituciones Religiosas: <font color='#FF0000'>Letra Invalida Solo R.</font>";
		}
			}
			
	elseif ($_POST['doc'] == 'NIFoaeca') {	// SOLO SE ADMITE S //
		
		if (preg_match('/^[^S]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIF Organos Admin Estado y Comunidades Autónomas: <font color='#FF0000'>Letra Invalida Solo S.</font>";
		}
			}
		
	elseif ($_POST['doc'] == 'NIFute') {	// SOLO SE ADMITE U //
		
		if (preg_match('/^[^U]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIF Unión Temporal de Empresas: <font color='#FF0000'>Letra Invalida Solo U.</font>";
		}
			}
		
	elseif ($_POST['doc'] == 'NIFotnd') {	// SOLO SE ADMITE V //
		
		if (preg_match('/^[^V]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIF Otros Tipos no Definidos: <font color='#FF0000'>Letra Invalida Solo V.</font>";
		}
			}
		
	elseif ($_POST['doc'] == 'NIFepenr') {	// SOLO SE ADMITE W //
		
		if (preg_match('/^[^W]+$/',$_POST['dni'])){
		$errors [] = "N&uacute;mero NIF Establecimientos Permanentes Entidades no Residentes: <font color='#FF0000'>Letra Invalida Solo W.</font>";
		}
			}
		
			} /* FIN PRIMER CONDICIONAL IF DEL CAMPO NUMERO */
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* VALIDAMOS LA LETRA DE CONTROL DEL DNI */

			/* DEFINO EL ALGORITMO PARA EL CALCULO DE LA LETRA CONTROL DEL DNI */
		
						$letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
						$dni = $_POST['dni'];
						$indice = intval($_POST['dni'])%23;
						$letra = $letras[$indice];
	
			/* FIN DEL ALGORITMO DE DEFINICION DEL LA LETRA CONTROL DEL DNI */
	
	if ($_POST['doc'] == 'DNI') {
		
		if(strlen(trim($_POST['ldni'])) == 0){
		$errors [] = "LETRA DNI: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}

	elseif (!preg_match('/^[^0-9@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['ldni'])){
		$errors [] = "LETRA CONTROL DNI: <font color='#FF0000'>SOLO TEXTO</font>";
		}

	elseif (!preg_match('/^[^a-z]+$/',$_POST['ldni'])){
		$errors [] = "LETRA CONTROL DNI: <font color='#FF0000'>SOLO MAYUSCULAS</font>";
		}

	elseif (trim($_POST['ldni'] != $letra)){
	$errors [] = "LETRA CONTROL DNI: <font color='#FF0000'>LETRA NO CORRECTA. $letra is ok.</font>";
		}
	}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* VALIDAMOS LA LETRA DE CONTROL DE NIE EXTRANJEROS NORMAL Y ESPECIALES */
	
		/* DEFINO DEL ALGORITMO PARA EL CALCULO DE LA LETRA CONTROL DEL NIE NORMAL */

		// Si es un NIE hay que cambiar la primera letra por 0, 1 ó 2 dependiendo de si es X, Y o Z.
					$dni2 = $_POST['dni'];
					$dni2 = strtoupper($dni2);
				 
					$letra2 = substr($dni2, -1, 1);
					$numero = substr($dni2, 0, 8);
 
		// Si es un NIE hay que cambiar la primera letra por 0, 1 ó 2 dependiendo de si es X, Y o Z.
	
					$numero = str_replace(array('X', 'Y', 'Z'), array(0, 1, 2), $numero);	
				 
					$modulo = (int) $numero % 23;
					$letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";
					$letra2 = substr($letras_validas, $modulo, 1);
		//	print ("ESTA ES LA LETRA NIE $letra2 </br>");
	
		/* FIN DE LA FUNCION PARA EL CALCULO DE LA LETRA CONTROL DEL NIE NORMAL */


		/* DEFINO EL ALGORITMO PARA EL CALCULO DE LA LETRA CONTROL DEL NIE/NIF ESPECIAL */

		if(strlen(trim($_POST['dni'])) == 0){ }
		else {	$dni3 = $_POST['dni'];
			
				$num1 = $dni3[1];
				$num2 = $dni3[2];
				$num3 = $dni3[3];
				$num4 = $dni3[4];
				$num5 = $dni3[5];
				$num6 = $dni3[6];
				$num7 = $dni3[7];
			}
			
			$sumaa = $num2 + $num4 + $num6 ;
			// print ("LA SUMA A: $num2 + $num4 + $num6 = $sumaa </br>");
			
			$sumab1 = $num1 * 2;
			$sumab1 = "$sumab1";
			if ($sumab1 < 10){ 	$sumab1st = "0$sumab1";
								$sumab1tot = ($sumab1st[0] + $sumab1st[1]);
														}
								elseif ($sumab1 > 9) { 	$sumab1st = "$sumab1";
														$sumab1tot = ($sumab1st[0] + $sumab1st[1]);}
			$sumab3 = $num3 * 2;
			$sumab3 = "$sumab3";
			if ($sumab3 < 10){ 	$sumab3st = "0$sumab3";
								$sumab3tot = ($sumab3st[0] + $sumab3st[1]);
														}
								elseif ($sumab3 > 9) { 	$sumab3st = "$sumab3";
														$sumab3tot = ($sumab3st[0] + $sumab3st[1]);}
			$sumab5 = $num5 * 2;
			$sumab5 = "$sumab5";
			if ($sumab5 < 10){ 	$sumab5st = "0$sumab5";
								$sumab5tot = ($sumab5st[0] + $sumab5st[1]);
														}
								elseif ($sumab5 > 9) { 	$sumab5st = "$sumab5";
														$sumab5tot = ($sumab5st[0] + $sumab5st[1]);}
			$sumab7 = $num7 * 2;
			$sumab7 = "$sumab7";
			if ($sumab7 < 10){ 	$sumab7st = "0$sumab7";
								$sumab7tot = ($sumab7st[0] + $sumab7st[1]);
														}
								elseif ($sumab7 > 9) { 	$sumab7st = "$sumab7";
														$sumab7tot = ($sumab7st[0] + $sumab7st[1]);}
			
			$sumab = $sumab1tot + $sumab3tot + $sumab5tot + $sumab7tot;
			
			/* 
			print ("LA SUMA B: ( $num1 x 2 = $sumab1 => $sumab1st[0] + $sumab1st[1] = $sumab1tot ) + ( $num3 x 2 = $sumab3 => $sumab3st[0] + $sumab3st[1] = $sumab3tot ) + ( $num5 x 2 = $sumab5 => $sumab5st[0] + $sumab5st[1] = $sumab5tot ) + ( $num7 x 2 = $sumab7 => $sumab7st[0] + $sumab7st[1] = $sumab7tot ) = ($sumab1tot + $sumab3tot + $sumab5tot + $sumab7tot) =$sumab </br>");
			*/
			
			$sumatot = $sumaa + $sumab;
			// print ("SUMA A $sumaa + SUMA B $sumab = SUMA TOTAL $sumatot </br>");
			
			$sumatotc = $sumatot;
			
			if (@$sumatotc[1] == 0) {	$sumacont = 0;
										// print ("TOTAL SUMA CONTROL = $sumacont </br>");
													}
													
				else {	$sumacont = 10 - $sumatotc[1];
								// print ("TOTAL SUMA CONTROL = 10 - $sumatotc[1] = $sumacont </br>");
														}
														
			$nifcontrolnumero = "0123456789";
			$nifcontrolletra = "JABCDEFGHI";
			 
			$nifnumero = $nifcontrolnumero[$sumacont];
			$nifletra = $nifcontrolletra[$sumacont];
			
			// print ("NUMERO: $nifnumero </br>");
			// print ("LETRA: $nifletra </br>");


		/* FIN DEL LA FUNCION PARA EL CALCULO DE LA LETRA CONTROL DEL NIE/NIF ESPECIAL */


		/* CONDICIONAL PARA TODOS LOS NIE/NIF */
		
	if (($_POST['doc'] == 'NIE') || ($_POST['doc'] == 'NIFespecial') || ($_POST['doc'] == 'NIFsa') || ($_POST['doc'] == 'NIFsrl') || ($_POST['doc'] == 'NIFscol') || ($_POST['doc'] == 'NIFscom') || ($_POST['doc'] == 'NIFcbhy') || ($_POST['doc'] == 'NIFscoop') || ($_POST['doc'] == 'NIFasoc') || ($_POST['doc'] == 'NIFcpph') || ($_POST['doc'] == 'NIFsccspj') || ($_POST['doc'] == 'NIFee') || ($_POST['doc'] == 'NIFcl') || ($_POST['doc'] == 'NIFop') || ($_POST['doc'] == 'NIFcir') || ($_POST['doc'] == 'NIFoaeca') || ($_POST['doc'] == 'NIFute') || ($_POST['doc'] == 'NIFotnd') || ($_POST['doc'] == 'NIFepenr')) 
	
	{
		if(strlen(trim($_POST['ldni'])) == 0){
		$errors [] = "LETRA CONTROL NIE/NIF: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}
		

		/* CONDICIONAL PARA TODOS LOS NIE/NIF CON LETRA DE CONTROL */
		
	elseif(($_POST['doc'] == 'NIE') || ($_POST['doc'] == 'NIFespecial') || ($_POST['doc'] == 'NIFee') || ($_POST['doc'] == 'NIFcl') || ($_POST['doc'] == 'NIFop') || ($_POST['doc'] == 'NIFcir') || ($_POST['doc'] == 'NIFoaeca') || ($_POST['doc'] == 'NIFepenr'))
	
	{		
		if (!preg_match('/^[^0-9@#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['ldni'])){
		$errors [] = "LETRA CONTROL NIE/NIF: <font color='#FF0000'>SOLO TEXTO</font>";
		}
		
	elseif (!preg_match('/^[^a-z]+$/',$_POST['ldni'])){
		$errors [] = "LETRA CONTROL NIE/NIF: <font color='#FF0000'>SOLO MAYUSCULAS</font>";
		}
		
		/* CONDICIONAL PARA VALIDAR LA LETRA CONTROL DEL NIE/NIF NORMAL*/
		
	elseif ($_POST['doc'] == 'NIE') {
		
		if (trim($_POST['ldni'] != $letra2)){
	$errors [] = "LETRA CONTROL NIE EXTRANJEROS: <font color='#FF0000'>LETRA NO CORRECTA</font>";
		}
	}
			
		/* CONDICIONAL PARA VALIDAR LA LETRA CONTROL DEL NIF ESPECIAL Y OTROS CON LETRA */
		
	elseif (($_POST['doc'] == 'NIFespecial') || ($_POST['doc'] == 'NIFee') || ($_POST['doc'] == 'NIFcl') || ($_POST['doc'] == 'NIFop') || ($_POST['doc'] == 'NIFcir') || ($_POST['doc'] == 'NIFoaeca') || ($_POST['doc'] == 'NIFepenr')) {
		
		if (trim($_POST['ldni'] != $nifletra)){
	$errors [] = "LETRA CONTROL NIF ESPECIAL: <font color='#FF0000'>LETRA NO CORRECTA</font>";
		}
			}
	} 		/* FIN CONDICIONAL PARA TODOS LOS NIE/NIF CON LETRA DE CONTROL */
				
				
		/* CONDICIONAL PARA TODOS LOS NIF CON NUMERO DE CONTROL */
		
	elseif (($_POST['doc'] == 'NIFsa') || ($_POST['doc'] == 'NIFsrl') || ($_POST['doc'] == 'NIFscol') || ($_POST['doc'] == 'NIFscom') || ($_POST['doc'] == 'NIFcbhy') || ($_POST['doc'] == 'NIFscoop') || ($_POST['doc'] == 'NIFasoc') || ($_POST['doc'] == 'NIFcpph') || ($_POST['doc'] == 'NIFsccspj') || ($_POST['doc'] == 'NIFute') || ($_POST['doc'] == 'NIFotnd')) {
		
		if (!preg_match('/^[\d]+$/',$_POST['ldni'])){
		$errors [] = "NUMERO CONTROL NIF ESPECIAL: <font color='#FF0000'>SOLO NUMEROS</font>";
		}
		
			/* CONDICIONAL PARA VALIDAR EL NUMERO DE CONTROL */
		
	else {
		
		if (trim($_POST['ldni'] != $nifnumero)){
	$errors [] = "NUMERO CONTROL NIF ESPECIAL: <font color='#FF0000'>NUMERO INCORRECTO</font>";
		}

	}
			} 		/* fIN CONDICIONAL PARA TODOS LOS NIF CON NUMERO DE CONTROL */

			} /* FIN PRIMER IF */
		
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* VALIDAMOS EL CAMPO NIVEL. */
	
	if(strlen(trim($_POST['Nivel'])) == 0){
		$errors [] = "NIVEL: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}
	
	/* Validamos el campo mail. */
	
	global $db;
	global $sqlml;
	global $qml;
	global $db_name;

	$sqlml =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`Email` = '$_POST[Email]'";
	$qml = mysqli_query($db, $sqlml);
	if(!$qml){ }else{ 
		$rowml = mysqli_fetch_assoc($qml); 
	}

	if (isset($_POST['id']) == @$rowml['id']){}
	elseif(mysqli_num_rows($qml)!= 0){
		$errors [] = "MAIL: <font color='#FF0000'>YA EXISTE</font>";
		}
		
	if(strlen(trim($_POST['Email'])) == 0){
		$errors [] = "MAIL: <font color='#FF0000'>CAMPO OBLIGATORIOfont>";
		}
	
	elseif (strlen(trim($_POST['Email'])) < 5 ){
		$errors [] = "MAIL: <font color='#FF0000'>MAS DE CINCO CARACTERES</font>";
		}
		
	elseif (!preg_match('/^[^A-Z]+$/',$_POST['Email'])){
		$errors [] = "MAIL: <font color='#FF0000'>SOLO MINUSCULAS</font>";
		}

	elseif (!preg_match('/^[^@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:*\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/',$_POST['Email'])){
		$errors [] = "MAIL: <font color='#FF0000'>DIRECCION NO VALIDA</font>";
		}
		
/* if(trim($_POST['id'] == $rowd['id'])&&(!strcasecmp($_POST['Email'] , $rowd['Email']))){}
			elseif(!strcasecmp($_POST['Email'] , $rowd['Email'])){
				$errors [] = "MAIL: <font color='#FF0000'>NO PERMITIDO</font>";
				}	
	
	elseif(!strcasecmp($_POST['Email'] , $rowd['Email'])){
		$errors [] = "MAIL: <font color='#FF0000'>NO PERMITIDO</font>";
		}	
*/
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* Validamos el campo usuario. */
	
	global $db; 	global $sqlus; 	global $qus; 	global $db_name;

	$sqlus =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`Usuario` = '$_POST[Usuario]'";
	$qus = mysqli_query($db, $sqlus);
	if(!$qus){ }else{ $rowus = mysqli_fetch_assoc($qus); }

	if (isset($_POST['id']) == @$rowus['id']){}
	elseif(mysqli_num_rows($qus)!= 0){
		$errors [] = "NICK: <font color='#FF0000'>YA EXISTE</font>";
		}

	if(strlen(trim($_POST['Usuario'])) == 0){
		$errors [] = "NICK: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}
	
	elseif (strlen(trim($_POST['Usuario'])) < 3){
		$errors [] = "NICK: <font color='#FF0000'>MAS DE TRES CARACTERES</font>";
		}
			
	elseif (!preg_match('/^\b[^@#$%&<>\?\[\]\{\}\+\s]+$/',$_POST['Usuario'])){
		$errors [] = "NICK: <font color='#FF0000'>SIN CARACTERES ESPECIALES</font>";
		}

	elseif(trim($_POST['Usuario'] != $_POST['Usuario2'])){
		$errors [] = "NICK: <font color='#FF0000'>NO SON IGUALES</font>";
		}
		
		
/*	if(trim($_POST['id'] == $rowd['id'])&&(!strcasecmp($_POST['Usuario'] , $rowd['Usuario']))){}
			elseif(!strcasecmp($_POST['Usuario'] , $rowd['Usuario'])){
				$errors [] = "NICK: <font color='#FF0000'>NICK NO PERMITIDO</font>";
				}

	elseif(!strcasecmp($_POST['Usuario'] , $rowd['Usuario'])){
		$errors [] = "NICK: <font color='#FF0000'>NICK NO PERMITIDO</font>";
		}	
*/
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* Validamos el campo password. */
	
		if(strlen(trim($_POST['Password'])) == 0){
		$errors [] = "PASSWORD: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}
	
	elseif (strlen(trim($_POST['Password'])) < 3){
		$errors [] = "PASSWORD: <font color='#FF0000'>MAS DE TRES CARACTERES</font>";
		}
			
	elseif (!preg_match('/^\b[^@#$%&<>\?\[\]\{\}\+\s]+$/',$_POST['Password'])){
		$errors [] = "PASSWORD: <font color='#FF0000'>SIN CARACTERES ESPECIALES</font>";
		}

	elseif(trim($_POST['Password'] != $_POST['Password2'])){
		$errors [] = "PASSWORD: <font color='#FF0000'>NO SON IGUALES</font>";
		}
	

	/* Validamos el campo Dirección. */
	
		if(strlen(trim($_POST['Direccion'])) == 0){
		$errors [] = "DIRECCION: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}
	
	elseif (!preg_match('/^\b[^@#$%&<>\?\[\]\{\}\+]+$/',$_POST['Direccion'])){
		$errors [] = "DIRECCION: <font color='#FF0000'>SIN CARACTERES ESPECIALES</font>";
		}
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* Validamos el campo Tlf1 */
	
	global $db;
	global $db_name;

	$sqltlf1 =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`Tlf1` = '$_POST[Tlf1]' OR $table_name_a.`Tlf2` = '$_POST[Tlf1]' ";
	$qtlf1 = mysqli_query($db, $sqltlf1);
	if(!$qtlf1){ }else{ 
		$countlf1 = mysqli_num_rows($qtlf1);
		$rowtlf1 = mysqli_fetch_assoc($qtlf1);
	}

	if (isset($_POST['id']) == @$rowtlf1['id']){}
	elseif($countlf1 != 0){
		$errors [] = "TELEFONO 1: <font color='#FF0000'>YA EXISTE</font>";
		}

	if(strlen(trim($_POST['Tlf1'])) == 0){
		$errors [] = "TELEFONO 1: <font color='#FF0000'>CAMPO OBLIGATORIO</font>";
		}
	
	elseif ((trim($_POST['Tlf1'])) == (trim($_POST['Tlf2']))){
					$errors [] = "TELEFONO 1 y 2: <font color='#FF0000'>SON IGUALES</font>";
		}

	elseif (!preg_match('/^[\d]+$/',$_POST['Tlf1'])){
		$errors [] = "TELEFONO 1: <font color='#FF0000'>SOLO NUMEROS</font>";
		}

	elseif (strlen(trim($_POST['Tlf1'])) < 9){
		$errors [] = "TELEFONO 1: <font color='#FF0000'>NUEVE NUMEROS</font>";
		}
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* Validamos el campo Tlf2 */
	
	if(strlen(trim($_POST['Tlf2'])) > 0){

		$sqltlf2 =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`Tlf1` = '$_POST[Tlf2]' OR $table_name_a.`Tlf2` = '$_POST[Tlf2]'";
		$qtlf2 = mysqli_query($db, $sqltlf2);
		if(!$qtlf2){ }else{ 
			$rowtlf2 = mysqli_fetch_assoc($qtlf2);
			$countlf2 = mysqli_num_rows($qtlf2);
		}
		
		if (isset($_POST['id']) == @$rowtlf2['id']){}
		elseif($countlf2 > 0){
			$errors [] = "TELEFONO 2: <font color='#FF0000'>YA EXISTE</font>";
			}
				
		elseif (!preg_match('/^[\d]+$/',$_POST['Tlf2'])){
			$errors [] = "TELEFONO 2: <font color='#FF0000'>SOLO NUMEROS</font>";
			}
		
		elseif (strlen(trim($_POST['Tlf2'])) < 9){
			$errors [] = "TELEFONO 2: <font color='#FF0000'>9 NUMEROS</font>";
			}

		}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	// VALIDAMOS LA IMAGEN DE USUARIO.

	$limite = 500 * 1024;
	
	$ext_permitidas = array('jpg','JPG','gif','GIF','png','PNG','bmp','BMP');
	$extension = substr($_FILES['myimg']['name'],-3);
	// print($extension);
	// PRESUNTAMENTE DEPRECATED
	// $extension = end(explode('.', $_FILES['myimg']['name']) );
	$ext_correcta = in_array($extension, $ext_permitidas);

	// $tipo_correcto = preg_match('/^image\/(gif|png|jpg|bmp)$/', $_FILES['myimg']['type']);

		if($_FILES['myimg']['size'] == 0){
			$errors [] = "SELECCIONE UNA FOTOGRAFIA";
			global $img2;
			$img2 = 'untitled.png';
		}
		 
		elseif(!$ext_correcta){
			$errors [] = "EXTENSION NO ADMITIDA: ".$_FILES['myimg']['name'];
			global $img2;
			$img2 = 'untitled.png';
			}
	/*
		elseif(!$tipo_correcto){
			$errors [] = "ARCHIVO NO ADMITIDO: ".$_FILES['myimg']['name'];
			global $img2;
			$img2 = 'untitled.png';
			}
	*/
		elseif ($_FILES['myimg']['size'] > $limite){
		$tamanho = $_FILES['myimg']['size'] / 1024;
		$errors [] = $_FILES['myimg']['name']." MAYOR DE 500 KBytes. ".$tamanho." KB";
		global $img2;
		$img2 = 'untitled.png';
			}
		
			elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_PARTIAL){
				$errors [] = "LA CARGA DEL ARCHIVO SE HA INTERRUMPIDO.";
				global $img2;
				$img2 = 'untitled.png';
				}
				
				elseif ($_FILES['myimg']['error'] == UPLOAD_ERR_NO_FILE){
					$errors [] = "EL ARCHIVO NO SE HA CARGADO";
					global $img2;
					$img2 = 'untitled.png';
					}

/* La función devuelve el array errors. */
	
/* Creado por Juan Barros Pazos 2021 */
?>