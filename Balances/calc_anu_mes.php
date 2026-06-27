<?php

global $db;          global $db_name;      global $vname;    global $table_admin;
global $dy1;         global $orden;

// Declaramos las variables globales de tiempo para que mantengan la compatibilidad externa
for ($m = 1; $m <= 12; $m++) {
    global ${"totaltime" . $m};
}
global $totym;

// Array para ir acumulando los resultados de cada mes
$total_times_array = [];

// Iteramos por los 12 meses del año
for ($mes = 1; $mes <= 12; $mes++) {
    
    // Formateamos el mes a dos dígitos (01, 02, etc.)
    $mes_formateado = str_pad($mes, 2, "0", STR_PAD_LEFT);
    
    $dm1ym = "-" . $mes_formateado . "-";
    $filym = "%" . $dy1 . $dm1ym . "%";
    
    $sql = "SELECT `ttot` FROM $vname WHERE `ref` = '$_SESSION[usuarios]' AND `din` LIKE '$filym' AND `ttot` <> '00:00:00' AND `error` = 'false' ORDER BY $orden";
    
    $qh = mysqli_query($db, $sql);
    
    if (!$qh) {
        print("*******************ERROR: " . mysqli_error($db) . ".</br>");
        ${"totaltime" . $mes} = "0.0"; // Valor por defecto en caso de error
        $total_times_array[] = "0.0";
        continue;
    }
    
    $totsec = 0;
    
    // Recorremos los resultados en un solo ciclo por mes
    while ($row = mysqli_fetch_array($qh)) {
        $ttot = $row['ttot']; // Formato HH:MM:SS
        
        // Extraemos partes simulando el comportamiento de tus substr originales
        $verh = (int)substr($ttot, 0, 2);
        $verm = (int)substr($ttot, 3, 2);
        $vers = (int)substr($ttot, -2);
        
        // Sumamos todo convertido a segundos
        $totsec += ($verh * 3600) + ($verm * 60) + $vers;
    }
    
    // Calculamos horas y minutos finales manteniendo tu lógica exacta
    $horas = floor($totsec / 3600);
    $minutos = floor(($totsec - ($horas * 3600)) / 60);
    
    // Asignamos a la variable dinámica global correspondiente ($totaltime1, $totaltime2, etc.)
    ${"totaltime" . $mes} = $horas . "." . $minutos;
    
    // Guardamos en el array para el archivo de texto final
    $total_times_array[] = ${"totaltime" . $mes};
}

// Generamos la cadena total idéntica con sus comas finales
$totym = implode(",", $total_times_array) . ",";

// Escritura del archivo
$dym = fopen('datosym.php', 'w+');
fwrite($dym, $totym);
fclose($dym);

/* Creado por © Juan Barros Pazos 2020/26 Licencia CC BY-NC-SA */

?>