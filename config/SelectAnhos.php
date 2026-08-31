<?php

	require '../Inclu/error_hidden.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	

global $db, $db_name;
global $nom;        
$nom = $_SESSION['clave'] . "horarios_%";

// Escapamos el patrón para evitar errores de sintaxis en la consulta
$nom_escapado = mysqli_real_escape_string($db, $nom);
$nom = "LIKE '$nom_escapado'";

// Consulta a INFORMATION_SCHEMA y guardamos los nombres en un array
$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom ORDER BY TABLE_NAME DESC";
$respuesta = mysqli_query($db, $consulta);

if (!$respuesta) {
    print("* ERROR SQL L.20 " . mysqli_error($db) . "</br>");
} else {  
    // Almacenamos los nombres de las tablas
    global $tablas;     
    $tablas = [];
    
    // Inicializamos el array $dy con su valor por defecto
    $dy = [
        '' => 'YEAR'
    ];

    $max_year = 0; // Para guardar el año más alto encontrado

    while ($fila_tabla = mysqli_fetch_row($respuesta)) {
        if (!empty($fila_tabla[0])) {
            $nombre_tabla = $fila_tabla[0];
            $tablas[] = $nombre_tabla;

            // Extraemos los últimos 4 dígitos (el año, ej: 2026) y los últimos 2 (ej: 26)
            if (preg_match('/(\d{4})$/', $nombre_tabla, $matches)) {
                $year_completo = $matches[1];             // "2026"
                $year_corto = substr($year_completo, -2); // "26"

                // Añadimos al array $dy con la estructura deseada
                $dy[$year_corto] = $year_completo;

                // Guardamos el año más alto
                if ((int)$year_completo > $max_year) {
                    $max_year = (int)$year_completo;
                }
            }
        }
    }

    // CONSTRUCCIÓN DEL SELECT
    print("<select name='dy'>");
    foreach ($dy as $optiondy => $labeldy) {
        // En PHP 8 usamos ?? '' en lugar de @$defaults['dy'] para evitar warnings
        $selected_val = $defaults['dy'] ?? '';
        $selected = ($optiondy == $selected_val) ? "selected='selected'" : "";

        print("<option value='" . $optiondy . "' $selected> $labeldy </option>");
    }   
    print("</select>");

} // Fin else...



?>