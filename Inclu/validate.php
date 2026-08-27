<?php

	//error_reporting (0);

	$errors = array();

	global $table_name_a;			$table_name_a = "`".$_SESSION['clave']."admin`";

						   /////////////////////////
	/////////////////////////					  /////////////////////////
						  /////////////////////////

	/* VALIDAMOS EL CAMPO NOMBRE. */
	if(strlen(trim($_POST['Nombre'])) == 0){
		$errors [] = "Nombre: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif(strlen(trim($_POST['Nombre'])) < 3){
		$errors [] = "Nombre: <font color='#F1BD2D'>Escriba más de dos carácteres.</font>";
	}elseif(!preg_match('/^[^0-9@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['Nombre'])){
		$errors [] = "Nombre: <font color='#F1BD2D'>Solo se admite texto, sin acentos.</font>";
	}
		
	/* VALIDAMOS EL CAMPO APELLIDOS. */
	if(strlen(trim($_POST['Apellidos'])) == 0){
		$errors [] = "Apellidos: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif(strlen(trim($_POST['Apellidos'])) < 4){
		$errors [] = "Apellidos: <font color='#F1BD2D'>Escriba más de 3 carácteres.</font>";
	}elseif(!preg_match('/^[^0-9@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:\.\*]+$/',$_POST['Apellidos'])){
		$errors [] = "Apellidos: <font color='#F1BD2D'>Solo se admite texto, sin acentos.</font>";
	}

						/////////////////////////
	/////////////////////////			/////////////////////////
					/////////////////////////

	/* VALIDAMOS EL CAMPO  NUMERO DNI/Nif*/
	global $db, $db_name;					global $sqldni;
	global $qdni;

	$sqldni =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$_POST[dni]'";
	$qdni = mysqli_query($db, $sqldni);

	if(!$qdni){ }else{ 
		$rowdni = mysqli_fetch_assoc($qdni);
		$countdni = mysqli_num_rows($qdni);
		}
	/*
	if(@$_POST['id'] == @$rowdni['id']){
	}elseif(mysqli_num_rows($qdni)!= 0){
		$errors [] = "N&uacute;mero DNI/NIF: <font color='#F1BD2D'>Ya Existe.</font>";
	}
	*/
		
	if($_POST['doc'] == 'DNI'){
		if(strlen(trim($_POST['dni'])) == 0){
			$errors [] = "N&uacute;mero DNI/NIF: <font color='#F1BD2D'>Campo Obligatorio.</font>";
		}elseif(!preg_match('/^[\d]+$/',$_POST['dni'])){
			$errors [] = "N&uacute;mero DNI/NIF: <font color='#F1BD2D'>Sólo Números.</font>";
		}elseif(strlen(trim($_POST['dni'])) < 8){
			$errors [] = "N&uacute;mero DNI/NIF: <font color='#F1BD2D'>Más de 7 Carácteres.</font>";
		}
	}
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////


/* Letra inicial válida (posición 0) para cada tipo de CIF */
$letraPorTipo = array(
    'NIFespecial' => array('K', 'L', 'M'),
    'NIFsa'       => array('A'),
    'NIFsrl'      => array('B'),
    'NIFscol'     => array('C'),
    'NIFscom'     => array('D'),
    'NIFcbhy'     => array('E'),
    'NIFscoop'    => array('F'),
    'NIFasoc'     => array('G'),
    'NIFcpph'     => array('H'),
    'NIFsccspj'   => array('J'),
    'NIFee'       => array('N'),
    'NIFcl'       => array('P'),
    'NIFop'       => array('Q'),
    'NIFcir'      => array('R'),
    'NIFoaeca'    => array('S'),
    'NIFute'      => array('U'),
    'NIFotnd'     => array('V'),
    'NIFepenr'    => array('W'),
);

/* Nombre "bonito" a mostrar en los mensajes de error para cada tipo */
$nombreTipo = array(
    'NIFespecial' => 'Especial',
    'NIFsa'       => 'Sociedad An&oacute;nima',
    'NIFsrl'      => 'Sociedad Respons Limitada',
    'NIFscol'     => 'Sociedad Colectiva',
    'NIFscom'     => 'Sociedad Comanditaria',
    'NIFcbhy'     => 'Comunidad Bienes y Herencias Yacentes',
    'NIFscoop'    => 'Sociedades Cooperativas',
    'NIFasoc'     => 'Asociaciones',
    'NIFcpph'     => 'Comunidad Propietarios Propiedad Horizontal',
    'NIFsccspj'   => 'Sociedad Civil, con o sin Personalidad Juridica',
    'NIFee'       => 'Entidad Extranjera',
    'NIFcl'       => 'Corporación Local',
    'NIFop'       => 'Organismo Publico',
    'NIFcir'      => 'Congregaciones Instituciones Religiosas',
    'NIFoaeca'    => 'Organos Admin Estado y Comunidades Autónomas',
    'NIFute'      => 'Unión Temporal de Empresas',
    'NIFotnd'     => 'Otros Tipos no Definidos',
    'NIFepenr'    => 'Establecimientos Permanentes Entidades no Residentes',
);

/* Tipos de CIF (entidades) cuyo carácter de control es SIEMPRE una letra
   -> usan el algoritmo CIF estándar (calcularControlCIF) */
$controlSoloLetra = array('NIFee', 'NIFcl', 'NIFop', 'NIFcir', 'NIFoaeca', 'NIFepenr');
/* Tipos de CIF (entidades) cuyo carácter de control es SIEMPRE un número
   -> usan el algoritmo CIF estándar (calcularControlCIF) */
$controlSoloNumero = array('NIFsa', 'NIFsrl', 'NIFscol', 'NIFscom', 'NIFcbhy', 'NIFscoop', 'NIFasoc', 'NIFcpph', 'NIFsccspj', 'NIFute', 'NIFotnd');
/* NIFespecial (K,L,M) es NIF de PERSONA FÍSICA, no de entidad: su letra de
   control se calcula igual que el DNI (módulo 23 sobre los 7 dígitos) */
$controlModulo23 = array('NIFespecial');


/* ------------------------------------------------------------
   FUNCIONES DE CÁLCULO (algoritmo oficial)
   ------------------------------------------------------------ */

/** Letra de control del DNI a partir de sus 8 dígitos numéricos */
function calcularLetraDNI($numeroDni) {
    $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
    $indice = intval($numeroDni) % 23;
    return $letras[$indice];
}

/** Letra de control del NIE. Recibe el NIE completo, p.ej. "X1234567" */
function calcularLetraNIE($nie) {
    $nie   = strtoupper(trim($nie));
    $map   = array('X' => '0', 'Y' => '1', 'Z' => '2');
    $inicial = substr($nie, 0, 1);
    $resto   = substr($nie, 1, 7);
    $numero  = (isset($map[$inicial]) ? $map[$inicial] : $inicial) . $resto;
    return calcularLetraDNI($numero);
}

/**
 * Dígito y letra de control de un CIF, a partir de sus 7 dígitos numéricos
 * (sin la letra inicial). Devuelve array('digito' => '5', 'letra' => 'E')
 */
function calcularControlCIF($sieteDigitos) {
    $sumaPar   = 0; // dígitos en posiciones 2,4,6 -> se suman tal cual
    $sumaImpar = 0; // dígitos en posiciones 1,3,5,7 -> se multiplican x2 y se suman sus cifras

    for ($i = 0; $i < 7; $i++) {
        $digito = (int) $sieteDigitos[$i];
        if ($i % 2 == 0) {            // posiciones impares (1,3,5,7 -> índices 0,2,4,6)
            $doble = $digito * 2;
            $sumaImpar += ($doble >= 10) ? ($doble - 9) : $doble;
        } else {                      // posiciones pares (2,4,6 -> índices 1,3,5)
            $sumaPar += $digito;
        }
    }

    $sumaTotal     = $sumaPar + $sumaImpar;
    $digitoControl = (10 - ($sumaTotal % 10)) % 10;
    $letrasControl = 'JABCDEFGHI';

    return array(
        'digito' => (string) $digitoControl,
        'letra'  => $letrasControl[$digitoControl],
    );
}


/* ------------------------------------------------------------
   VALIDACIÓN PRINCIPAL
   ------------------------------------------------------------ */

global $db, $db_name, $vname;

$doc  = isset($_POST['doc'])  ? $_POST['doc'] : '';
$dni  = isset($_POST['dni'])  ? strtoupper(trim($_POST['dni']))  : '';
$ldni = isset($_POST['ldni']) ? strtoupper(trim($_POST['ldni'])) : '';

if (!isset($errors)) {
    $errors = array();
}

/* --- Comprobamos si el número ya existe en BBDD (usando escape para evitar inyección SQL) --- */
$dniEscapado = mysqli_real_escape_string($db, $dni);
$sqldni  = "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$dniEscapado'";
$qdni    = mysqli_query($db, $sqldni);
$rowdni  = mysqli_fetch_assoc($qdni);
$countdni = mysqli_num_rows($qdni);

if (isset($_POST['id'])) {
    if ($_POST['id'] != @$rowdni['id'] && $countdni > 0) {
        $errors[] = "N&uacute;mero DNI/NIF: <font color='#F1BD2D'>Ya Existe.</font>";
    }
} else {
    if ($countdni > 0) {
        $errors[] = "N&uacute;mero DNI/NIF: <font color='#F1BD2D'>Ya Existe.</font>";
    }
}

/* ===================== DNI ===================== */
if ($doc == 'DNI') {

    if (strlen($dni) == 0) {
        $errors[] = "N&uacute;mero DNI/NIF: <font color='#F1BD2D'>Campo Obligatorio.</font>";
    } elseif (!preg_match('/^\d+$/', $dni)) {
        $errors[] = "N&uacute;mero DNI/NIF: <font color='#F1BD2D'>Sólo Números.</font>";
    } elseif (strlen($dni) < 8) {
        $errors[] = "N&uacute;mero DNI/NIF: <font color='#F1BD2D'>Más de 7 Carácteres.</font>";
    }

    if (strlen($ldni) == 0) {
        $errors[] = "Letra DNI: <font color='#F1BD2D'>Campo obligatorio.</font>";
    } elseif (!preg_match('/^[A-Z]$/', $ldni)) {
        $errors[] = "Letra Control DNI: <font color='#F1BD2D'>Sólo una letra mayúscula.</font>";
    } elseif (strlen($dni) == 8 && preg_match('/^\d+$/', $dni)) {
        $letraCorrecta = calcularLetraDNI($dni);
        if ($ldni != $letraCorrecta) {
            $errors[] = "Letra Control DNI: <font color='#F1BD2D'>Letra no correcta. $letraCorrecta is ok.</font>";
        }
    }

/* ===================== NIE ===================== */
} elseif ($doc == 'NIE') {

    if (strlen($dni) == 0) {
        $errors[] = "N&uacute;mero NIE/NIF: <font color='#F1BD2D'>Campo obligatorio.</font>";
    } elseif (strlen($dni) < 8) {
        $errors[] = "N&uacute;mero NIE/NIF: <font color='#F1BD2D'>Más de 7 carácteres.</font>";
    } elseif (!preg_match('/^[XYZ]\d{7}$/', $dni)) {
        $errors[] = "N&uacute;mero NIE/NIF: <font color='#F1BD2D'>Formato incorrecto. Debe ser X, Y o Z seguido de 7 números.</font>";
    }

    if (strlen($ldni) == 0) {
        $errors[] = "Letra Control NIE/NIF: <font color='#F1BD2D'>Campo obligatorio.</font>";
    } elseif (!preg_match('/^[A-Z]$/', $ldni)) {
        $errors[] = "Letra Control NIE/NIF: <font color='#F1BD2D'>Sólo una letra mayúscula.</font>";
    } elseif (preg_match('/^[XYZ]\d{7}$/', $dni)) {
        $letraCorrecta = calcularLetraNIE($dni);
        if ($ldni != $letraCorrecta) {
            $errors[] = "Letra Control NIE Extranjeros: <font color='#F1BD2D'>Letra no correcta. $letraCorrecta is ok.</font>";
        }
    }

/* ===================== CIF (personas jurídicas / entidades) ===================== */
} elseif (isset($letraPorTipo[$doc])) {

    $nombre        = $nombreTipo[$doc];
    $letrasValidas = $letraPorTipo[$doc];

    if (strlen($dni) == 0) {
        $errors[] = "N&uacute;mero $nombre: <font color='#F1BD2D'>Campo obligatorio.</font>";
    } elseif (strlen($dni) < 8) {
        $errors[] = "N&uacute;mero $nombre: <font color='#F1BD2D'>Más de 7 carácteres.</font>";
    } elseif (!preg_match('/^[A-Z]\d{7}$/', $dni)) {
        $errors[] = "N&uacute;mero $nombre: <font color='#F1BD2D'>Formato incorrecto. Debe ser 1 letra + 7 números.</font>";
    } elseif (!in_array($dni[0], $letrasValidas)) {
        $errors[] = "N&uacute;mero $nombre: <font color='#F1BD2D'>Letra Invalida. Solo " . implode(',', $letrasValidas) . ".</font>";
    }

    if (strlen($ldni) == 0) {
        $errors[] = "Letra Control NIE/NIF: <font color='#F1BD2D'>Campo obligatorio.</font>";
    } elseif (preg_match('/^[A-Z]\d{7}$/', $dni) && in_array($dni[0], $letrasValidas)) {

        if (in_array($doc, $controlModulo23)) {
            /* NIF especial de persona física (K,L,M): letra = módulo 23 de los 7 dígitos, como el DNI */
            $letraCorrecta = calcularLetraDNI(substr($dni, 1, 7));
            if (!preg_match('/^[A-Z]$/', $ldni)) {
                $errors[] = "Letra Control $nombre: <font color='#F1BD2D'>Solo mayusculas.</font>";
            } elseif ($ldni != $letraCorrecta) {
                $errors[] = "Letra Control $nombre: <font color='#F1BD2D'>Letra no correcta. $letraCorrecta is ok.</font>";
            }
        } else {
            $control = calcularControlCIF(substr($dni, 1, 7));

            if (in_array($doc, $controlSoloLetra)) {
                if (!preg_match('/^[A-Z]$/', $ldni)) {
                    $errors[] = "Letra Control $nombre: <font color='#F1BD2D'>Solo mayusculas.</font>";
                } elseif ($ldni != $control['letra']) {
                    $errors[] = "Letra Control $nombre: <font color='#F1BD2D'>Letra no correcta. {$control['letra']} is ok.</font>";
                }
            } elseif (in_array($doc, $controlSoloNumero)) {
                if (!preg_match('/^\d$/', $ldni)) {
                    $errors[] = "Numero Control $nombre: <font color='#F1BD2D'>Sólo números.</font>";
                } elseif ($ldni != $control['digito']) {
                    $errors[] = "Numero Control $nombre: <font color='#F1BD2D'>Numero incorrecto. {$control['digito']} is ok.</font>";
                }
            }
        }
    }
}
	
	






				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	/* Validamos el campo mail. */
	
	global $db;				global $db_name;
	global $qml;			global $sqlml;
	
	$sqlml =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`Email` = '$_POST[Email]'";
	$qml = mysqli_query($db, $sqlml);

	if(!$qml){ }else{ $rowml = mysqli_fetch_assoc($qml); }

	if(@$_POST['id'] == @$rowml['id']){
	}elseif(mysqli_num_rows($qml)!= 0){
		$errors [] = "Mail: <font color='#F1BD2D'>Ya Existe.</font>";
	}
		
	if(strlen(trim($_POST['Email'])) == 0){
		$errors [] = "Mail: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif(strlen(trim($_POST['Email'])) < 5 ){
		$errors [] = "Mail: <font color='#F1BD2D'>Escriba más de cinco carácteres.</font>";
	}elseif(!preg_match('/^[^A-Z]+$/',$_POST['Email'])){
		$errors [] = "Mail: <font color='#F1BD2D'>Solo Minusculas</font>";
	}elseif(!preg_match('/^[^@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,:*\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/',$_POST['Email'])){
		$errors [] = "Mail: <font color='#F1BD2D'>Esta dirección no es válida.</font>";
	}
		
/* if(trim($_POST['id'] == $rowd['id'])&&(!strcasecmp($_POST['Email'] , $rowd['Email']))){}
			elseif(!strcasecmp($_POST['Email'] , $rowd['Email'])){
				$errors [] = "Mail: <font color='#F1BD2D'>No se puede registrar con este Mail.</font>";
				}	
	
	elseif(!strcasecmp($_POST['Email'] , $rowd['Email'])){
		$errors [] = "Mail: <font color='#F1BD2D'>No se puede registrar con este Mail.</font>";
		}	
*/
						/////////////////////////
	/////////////////////////			/////////////////////////
					/////////////////////////

	/* VALIDAMOS EL CAMPO NIVEL. */
	
	if(strlen(trim($_POST['Nivel'])) == 0){
		$errors [] = "Nivel: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}
	
	/* Validamos el campo usuario. */
	
	global $db;				global $db_name;
	global $sqlus;			global $qus;

	$sqlus =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`Usuario` = '$_POST[Usuario]'";
	$qus = mysqli_query($db, $sqlus);

	if(!$qus){ }else{ $rowus = mysqli_fetch_assoc($qus); }

	if(@$_POST['id'] == @$rowus['id']){
	}elseif(mysqli_num_rows($qus)!= 0){
		$errors [] = "Usuario: <font color='#F1BD2D'>Ya Existe.</font>";
	}

	if(strlen(trim($_POST['Usuario'])) == 0){
		$errors [] = "Usuario: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif(strlen(trim($_POST['Usuario'])) < 3){
		$errors [] = "Usuario: <font color='#F1BD2D'>Escriba más de tres caracteres.</font>";
	}elseif(!preg_match('/^\b[^@#$%&<>\?\[\]\{\}\+\s]+$/',$_POST['Usuario'])){
		$errors [] = "Usuario: <font color='#F1BD2D'>No se admiten carácteres especiales.</font>";
	}elseif(trim($_POST['Usuario'] != $_POST['Usuario2'])){
		$errors [] = "Usuario: <font color='#F1BD2D'>No son iguales los dos campos usuario.</font>";
	}
		
/*	if(trim($_POST['id'] == $rowd['id'])&&(!strcasecmp($_POST['Usuario'] , $rowd['Usuario']))){}
			elseif(!strcasecmp($_POST['Usuario'] , $rowd['Usuario'])){
				$errors [] = "Usuario: <font color='#F1BD2D'>No se puede registrar con este nombre de usuario.</font>";
				}

	elseif(!strcasecmp($_POST['Usuario'] , $rowd['Usuario'])){
		$errors [] = "Usuario: <font color='#F1BD2D'>No se puede registrar con este nombre de usuario.</font>";
		}	
*/
						/////////////////////////
	/////////////////////////			/////////////////////////
					/////////////////////////

	/* Validamos el campo password. */
	
	if(strlen(trim($_POST['Password'])) == 0){
		$errors [] = "Password: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif(strlen(trim($_POST['Password'])) < 3){
		$errors [] = "Password: <font color='#F1BD2D'>Escriba más de tres caracteres.</font>";
	}elseif(!preg_match('/^\b[^@#$%&<>\?\[\]\{\}\+\s]+$/',$_POST['Password'])){
		$errors [] = "Password: <font color='#F1BD2D'>No se admiten carácteres especiales.</font>";
	}elseif(trim($_POST['Password'] != $_POST['Password2'])){
		$errors [] = "Password: <font color='#F1BD2D'>No son iguales los dos campos password.</font>";
	}

						/////////////////////////
	/////////////////////////			/////////////////////////
					/////////////////////////

	/* Validamos el campo Dirección. */
	
	if(strlen(trim($_POST['Direccion'])) == 0){
		$errors [] = "Dirección: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif(!preg_match('/^\b[^@#$%&<>\?\[\]\{\}\+]+$/',$_POST['Direccion'])){
		$errors [] = "Dirección: <font color='#F1BD2D'>No se admiten carácteres especiales.</font>";
	}
		
						/////////////////////////
	/////////////////////////			/////////////////////////
					/////////////////////////

	/* Validamos el campo Tlf1 */
	
	global $db;				global $db_name;

	$sqltlf1 =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`Tlf1` = '$_POST[Tlf1]' OR $table_name_a.`Tlf2` = '$_POST[Tlf1]' ";
	$qtlf1 = mysqli_query($db, $sqltlf1);

	if(!$qtlf1){ }else{ 
		$countlf1 = mysqli_num_rows($qtlf1);
		$rowtlf1 = mysqli_fetch_assoc($qtlf1);
	}

	if(@$_POST['id'] == @$rowtlf1['id']){
	}elseif($countlf1 != 0){
		$errors [] = "Teléfono 1: <font color='#F1BD2D'>YA EXISTE.</font>";
	}

	if(strlen(trim($_POST['Tlf1'])) == 0){
		$errors [] = "Teléfono 1: <font color='#F1BD2D'>Este campo es obligatorio.</font>";
	}elseif((trim($_POST['Tlf1'])) == (trim($_POST['Tlf2']))){
					$errors [] = "Teléfono 1 y 2: <font color='#F1BD2D'>SON IGUALES</font>";
	}elseif(!preg_match('/^[\d]+$/',$_POST['Tlf1'])){
		$errors [] = "Teléfono 1: <font color='#F1BD2D'>Sólo se admiten números.</font>";
	}elseif(strlen(trim($_POST['Tlf1'])) < 9){
		$errors [] = "Teléfono 1: <font color='#F1BD2D'>No menos de nueve números</font>";
	}
		
						/////////////////////////
	/////////////////////////			/////////////////////////
					/////////////////////////

	/* Validamos el campo Tlf2 */
	
	if(strlen(trim($_POST['Tlf2'])) > 0){

		$sqltlf2 =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`Tlf1` = '$_POST[Tlf2]' OR $table_name_a.`Tlf2` = '$_POST[Tlf2]'";
		$qtlf2 = mysqli_query($db, $sqltlf2);
		$rowtlf2 = mysqli_fetch_assoc($qtlf2);
		$countlf2 = mysqli_num_rows($qtlf2);
		
		if(@$_POST['id'] == @$rowtlf2['id']){
		}elseif($countlf2 > 0){
			$errors [] = "Teléfono 2: <font color='#F1BD2D'>YA EXISTE.</font>";
		}elseif(!preg_match('/^[\d]+$/',$_POST['Tlf2'])){
			$errors [] = "Teléfono 2: <font color='#F1BD2D'>Sólo se admiten números.</font>";
		}elseif(strlen(trim($_POST['Tlf2'])) < 9){
				$errors [] = "Teléfono 2: <font color='#F1BD2D'>No menos de nueve números</font>";
		}
	}

						/////////////////////////
	/////////////////////////			/////////////////////////
					/////////////////////////

		/* VALIDAMOS EL CAMPO my_img */

		$limite = 500 * 1024;
		
		$ext_permitidas = array('jpg','JPG','gif','GIF','png','PNG','bmp','BMP');
		// $extension = substr(@$_FILES['myimg']['name'],-3);
		$extension = substr($_FILES['myimg']['name'] ?? '', -3);
		// OPCIONES...
		// $extension = pathinfo($_FILES['myimg']['name'], PATHINFO_EXTENSION);
		
		// $parts = explode('.', $_FILES['myimg']['name']);
		// $extension = end($parts);

		// print($extension);
		$ext_correcta = in_array($extension, $ext_permitidas);

		/* $tipo_correcto = preg_match('/^image\/(gif|png|jpg|bmp)$/', $_POST['myimg']); */

		if(@$_POST['modifica']){
			if(strlen(trim ($_POST['myimg'])) == 0){
				$errors [] = "Ha de seleccionar un archivo.";
				global $img;		$img = $_SESSION['myimgcl'];
			}
		}

/* La función devuelve el array errors. */
	
/* Creado por © Juan Barros Pazos 2020/26 Licencia CC BY-NC-SA */

?>