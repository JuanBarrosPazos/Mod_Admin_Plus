<?php

// function tcl(){
	
	global $db_name; 			global $db;
	global $table_name_fk;		$table_name_fk = "`".$_SESSION['clave']."admin`";
	
	global $vname;		$vname = "`".strtolower($_SESSION['clave']."horarios_").date('Y')."`";
	
	$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname (
  `id` int NOT NULL auto_increment,
  `ref` varchar(20) collate utf8mb4_spanish2_ci NOT NULL,
  /*`Nombre` varchar(25) collate utf8mb4_spanish2_ci NOT NULL,*/
  /*`Apellidos` varchar(25) collate utf8mb4_spanish2_ci NOT NULL,*/
  `datein` DATE NOT NULL DEFAULT (CURRENT_DATE()),
  `timein` time NOT NULL,
  `dateout` DATE DEFAULT NULL,
  `timeout` time DEFAULT NULL,
  `hourstot` time DEFAULT NULL,
  `errorhourstot` varchar(5) NOT NULL default 'false',
  `del` varchar(5) NOT NULL default 'false',
  `deldate` DATE DEFAULT NULL,
  `deltime` time DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `ref` (`ref`),
  FOREIGN KEY (`ref`) REFERENCES ".$table_name_fk."(`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci AUTO_INCREMENT=1 ";
		
	global $dat3;
	if(mysqli_query($db , $tcl)){
		$dat3 = "\t* CREADA OK TABLA ADMIN ".$vname.PHP_EOL;
	}else{
		$dat3 = "\t* NO CREADA TABLA ADMIN. ".mysqli_error($db).PHP_EOL;
	}
	
// }


?>