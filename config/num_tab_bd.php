<?php

/* VERIFICO SI EXISTEN TABLAS EN LA BBDD */

    // SOLO SI ES CONFIG:
    if(isset($_POST['config'])){
        $db_host = $_POST['host']; 	$db_user = $_POST['user'];
        $db_pass = $_POST['pass']; 	$db_name = $_POST['name'];
    }else{ 
        require 'Conections/conection.php';
    }        
    
    global $db, $db_host, $db_user, $db_pass, $db_name;

    try{ 
        
        // Activamos reporte de errores mediante excepciones para capturar el fallo en el catch
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        // Restauramos el reporte a OFF para no alterar el resto del sistema
        mysqli_report(MYSQLI_REPORT_OFF);

        global $tablas;
        $tablas = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME LIKE '%'";

        $result = mysqli_query($db, $tablas); 	$totTablas = mysqli_num_rows($result);
        
        global $infoTBbdd;
        $infoTBbdd = "<p>TABLAS EN LA BASE DE DATOS: ".$totTablas."</p>";

    }catch(mysqli_sql_exception $e){

        mysqli_report(MYSQLI_REPORT_OFF);

        // En un fallo de conexión, $db se asegura como false/null
        $db = false;

        // ERROR: Se ejecuta la misma lógica de manejo de errores e historial
        global $text;       $text = $db_name . " * " . $e->getMessage();

        print("** NO CONECTA A BBDD " . $db_name . "</br>" . $e->getMessage());
		ini_log();

    }
/* FIN VERIFICACION DE TABLAS EN BBDD */

?>