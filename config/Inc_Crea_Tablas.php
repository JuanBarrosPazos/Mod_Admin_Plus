<?php
 
	/* CREA LAS TABLAS BÁSICAS DEL SISTEMA */
	
	global $db;	 		global $db_host; 		global $db_user; 		global $db_pass;
	global $db_name; 	global $dbconecterror;
	
	/************** CREAMOS LA TABLA ADMIN ***************/

	global $table_name_a;
	$table_name_a = "`".$_SESSION['clave']."admin`";

	$admin = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_a (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL,
  `Nivel` varchar(8) collate utf16_spanish2_ci NOT NULL default 'amd',
  `Nombre` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `Apellidos` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `myimg` varchar(30) collate utf16_spanish2_ci NOT NULL default 'untitled.png',
  `doc` varchar(11) collate utf16_spanish2_ci NOT NULL,
  `dni` varchar(8) collate utf16_spanish2_ci NOT NULL,
  `ldni` varchar(1) collate utf16_spanish2_ci NOT NULL,
  `Email` varchar(50) collate utf16_spanish2_ci NOT NULL,
  `Usuario` varchar(10) collate utf16_spanish2_ci NOT NULL,
  `Password` varchar(100) collate utf16_spanish2_ci NOT NULL,
  `Pass` varchar(10) collate utf16_spanish2_ci NOT NULL,
  `Direccion` varchar(60) collate utf16_spanish2_ci NOT NULL,
  `Tlf1` int(9) NOT NULL default 0,
  `Tlf2` int(9) NOT NULL default 0,
  `lastin` datetime collate utf16_spanish2_ci NOT NULL default CURRENT_TIMESTAMP,
  `lastout` datetime collate utf16_spanish2_ci NOT NULL default CURRENT_TIMESTAMP,
  `visitadmin` int(4) collate utf16_spanish2_ci NOT NULL default '0',
  `del` varchar(5) NOT NULL default 'false',
  `borrado` datetime collate utf16_spanish2_ci NULL,
  `recuper` datetime collate utf16_spanish2_ci NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `ref` (`ref`),
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";

	global $table1;		
	if(mysqli_query($db , $admin)){
		$table1 = "\t* CREADA OK TABLA ADMIN.".PHP_EOL;
	}else{
		$table1 = "\t* NO CREADA TABLA ADMIN. ".mysqli_error($db).PHP_EOL;
	}

	/************* CREAMOS LA TABLA IP CONTROL ****************/

	global $table_name_b;
	$table_name_b = "`".$_SESSION['clave']."ipcontrol`";

	$ipcontrol = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_b (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL default 'anonimo',
  `nivel` varchar(8) collate utf16_spanish2_ci NOT NULL default 'anonimo',
  `ipn` varchar(22) collate utf16_spanish2_ci NOT NULL default 'lost',
  `error`varchar(4) collate utf16_spanish2_ci NOT NULL default '1',
  `acceso` varchar(4) collate utf16_spanish2_ci NOT NULL default '0',
  `date` date collate utf16_spanish2_ci NOT NULL DEFAULT '2021-12-20',
  `time` time collate utf16_spanish2_ci NOT NULL DEFAULT '00:00:00',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";

	global $table2;		
	if(mysqli_query($db, $ipcontrol)){
		$table2 = "\t* OK TABLA IP CONTROL. \n";
	}else{
		$table2 = "\t* NO OK TABLA IP CONTROL. ".mysqli_error($db)." \n";
	}
					
	/************* CREAMOS LA TABLA VISITAS ADMIN ****************/

	global $table_name_c;
	$table_name_c = "`".$_SESSION['clave']."visitasadmin`";

	$visitas = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_c (
  `idv` int(2) NOT NULL,
  `visita` int(10) NOT NULL,
  `admin` int(10) NOT NULL,
  `deneg` int(10) NOT NULL,
  `acceso` int(10) NOT NULL,
  PRIMARY KEY  (`idv`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

global $table3;		global $table4;		
if(mysqli_query($db, $visitas)){
	global $link;
	print ("<table align='center'>".$link."</table>");		
			$table3 = "\t* CREADA OK TABLA VISITAS ADMIN.".PHP_EOL;

	$vd = "INSERT INTO `$db_name`.$table_name_c (`idv`, `visita`, `admin`, `deneg`, `acceso`) VALUES
	(68, 0, 0, 0, 0)";
		if(mysqli_query($db, $vd)){
				$table4 = "\t* CREADOS OK INIT VALUES EN VISITAS ADMIN.".PHP_EOL;
		}else{ 
				$table4 = "\t* NO CREADOS INIT VALUES EN VISITAS ADMIN. ".mysqli_error($db).PHP_EOL;
		}

}else{	$table3 = "\t* NO CREADA TABLA VISITAS ADMIN. ".mysqli_error($db).PHP_EOL;
		$table4 = "\t* NO CREADOS INIT VALUES EN VISITAS ADMIN. ".mysqli_error($db).PHP_EOL;
}


	/************* CREAMOS LA TABLA REGISTRO HORARIOS ****************/

	global $table_name_fk;
	$table_name_fk = "`".$_SESSION['clave']."admin`";
	
	global $table_name_d;
	$table_name_d = "`".$_SESSION['clave']."horarios_".date('Y')."`";
	
	$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$table_name_d (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL,
  `din` varchar(10) collate utf16_spanish2_ci NOT NULL,
  `tin` time NOT NULL,
  `dout` varchar(10) collate utf16_spanish2_ci NULL,
  `tout` time NULL,
  `ttot` time NULL,
  `error` varchar(5) NOT NULL default 'false',
  `del` varchar(5) NOT NULL default 'false',
  `dfeed` varchar(10) collate utf16_spanish2_ci NULL,
  `tfeed` time NULL,
  UNIQUE KEY `id` (`id`),
  KEY `ref` (`ref`),
  FOREIGN KEY (`ref`) REFERENCES ".$table_name_fk."(`ref`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	global $table5;
	if(mysqli_query($db , $tcl)){
		$table5 = "\t* CREADA OK TABLA REGISTRO HORARIOS.".PHP_EOL;
	}else{
		$table5 = "\t* NO CREADA TABLA REGISTRO HORARIOS".PHP_EOL;
	}

	/************	PASAMOS LOS PARAMETROS A .LOG	*****************/
	
		global $data0;
		global $cfone;
		$datein = date('Y-m-d/H:i:s');

		global $text;
		$text = $cfone.PHP_EOL;
		$text = $text.PHP_EOL."- CONFIG INIT ".$datein;
		$text = $text.PHP_EOL." * ".$db_name;
		$text = $text.PHP_EOL." * ".$db_host;
		$text = $text.PHP_EOL." * ".$db_user;
		$text = $text.PHP_EOL." * ".$db_pass;
		$text = $text.PHP_EOL.$dbconecterror;
		$text = $text.PHP_EOL.$data0.$table1.$table2.$table3.$table4.$table5.PHP_EOL;

		ini_log();
		
	/************	COMPROBAMOS LAS TABLAS AGENDA	*****************/

	global $tablasAgendaLog; 
	if(file_exists("../Mod_Agenda/Integra_Admin/CreaTablasAgenda.php")){
		require "../Mod_Agenda/Integra_Admin/CreaTablasAgenda.php";
	}else{ $tablasAgendaLog = "\tNO EXISTE EL MODULO AGENDA\n"; }

	/************	COMPROBAMOS LAS TABLAS CONTACTO	*****************/

	global $tablasContactoLog; 
	if(file_exists("../Mod_Contacto/Integra_Admin/CreaTablasContacto.php")){
		require "../Mod_Contacto/Integra_Admin/CreaTablasContacto.php";
	}else{ $tablasContactoLog = "\tNO EXISTE EL MODULO CONTACTO\n"; }

	/************	COMPROBAMOS LAS TABLAS CONTA BASIC	*****************/

	global $tablasContaLog;
	if(file_exists("../Mod_Conta/Integra_Admin/CreaTablasConta.php")){
		require "../Mod_Conta/Integra_Admin/CreaTablasConta.php";
		global $text;
		$tablasContaLog = "\t** SE CREAN LOS LOG DEL CBJ EN: ../Mod_Conta/config/logs/".PHP_EOL.$text.PHP_EOL;
	}else{ $tablasContaLog = "\tNO EXISTE EL MODULO CONTA BASIC\n"; } 

	/************	SI EXISTE EL CONSTRUCTOR DE TABLAS ARTICULOS	*****************/
	
	global $tblArtic;		
	if(file_exists('../Mod_Contenidos/Integra_Admin/CreaTablasContenido.php')){
		require '../Mod_Contenidos/Integra_Admin/CreaTablasContenido.php';
		global $text;
		$tblArtic = $text.PHP_EOL;
	}else{ /* NO EXISTE EL ARCHIVO */ $tblArtic = "\tNO EXISTE EL MODULO ARTICULOS\n";}

	/************	PASAMOS LOS PARAMETROS A .LOG	*****************/

	$text = $tablasAgendaLog.$tablasContactoLog.$tablasContaLog.$tblArtic.PHP_EOL;

	ini_log();

?>