<?php

	global $db;					global $db_name;

	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";

    global $sqlWM;
    $sqlWM = "SELECT * FROM $table_name_a WHERE $table_name_a.`Nivel` = 'wmaster'";
	$qbWM = mysqli_query($db, $sqlWM);
    global $CountWM;
    $CountWM = mysqli_num_rows($qbWM);

    //echo $CountWM;

?>