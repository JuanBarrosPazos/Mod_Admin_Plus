<?php

//function ayear(){

	global $db, $db_name;
	global $nom;        
	$nom = $_SESSION['clave'] . "horarios_%";

	// Escapamos el patrón para evitar errores en la consulta
	$nom_escapado = mysqli_real_escape_string($db, $nom);
	$nom = "LIKE '$nom_escapado'";

	// Consulta a INFORMATION_SCHEMA
	$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom ORDER BY TABLE_NAME DESC";
	$respuesta = mysqli_query($db, $consulta);

	if (!$respuesta) {
		print("* ERROR SQL L.707 " . mysqli_error($db) . "</br>");
	} else {  
		// Almacenamos los nombres de las tablas
		global $tablas;     
		$tablas = [];
		$max_year = 0; // Guardará el año más alto encontrado

		while ($fila_tabla = mysqli_fetch_row($respuesta)) {
			if (!empty($fila_tabla[0])) {
				$nombre_tabla = $fila_tabla[0];
				$tablas[] = $nombre_tabla;

				// Extraemos los últimos 4 dígitos del nombre de la tabla (ej: 2026)
				if (preg_match('/(\d{4})$/', $nombre_tabla, $matches)) {
					$year_encontrado = (int)$matches[1];

					if ($year_encontrado > $max_year) {
						$max_year = $year_encontrado;
					}
				}
			}
		}

		// COMPROBACIÓN DEL AÑO MÁS ALTO VS AÑO ACTUAL
		$anio_actual = (int)date('Y');

		if ($max_year !== $anio_actual) {
			print(" <div style='clear:both'></div>
					<div style='width:200px'>* EL AÑO HA CAMBIADO</div>");
					/*</br>&nbsp;&nbsp;&nbsp;".date('Y')." != ".$fget." */

			tcl();
		}

	} // Fin else...

//} // FIN function ayear

?>