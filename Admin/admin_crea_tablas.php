<?php
 
	// CREA EL DIRECTORIO DE USUARIO.
	global $carpeta;		$carpeta = "../Users/".$trf;

	if (!file_exists($carpeta)) {
		mkdir($carpeta, 0777, true);
		$data1 = "\t* OK DIRECTORIO USUARIO ".$carpeta."\n";
	}else{
		//print("* NO OK DIRECTORIO ".$carpeta."\n");
		$data1 = "\t* NO OK DIRECTORIO USUARIO ".$carpeta."\n";
	}

	if (file_exists($carpeta)){
		copy("../Images/untitled.png", $carpeta."/untitled.png");
		copy("../Images/pdf.png", $carpeta."/pdf.png");
		copy("../config/ayear_Init_System.php", $carpeta."/ayear.php");
		copy("../config/year.txt", $carpeta."/year.txt");
		copy("../config/SecureIndex2.php", $carpeta."/index.php");
		global $data1;			$data1 = $data1."\t* OK USER SYSTEM FILES ".$carpeta."\n";
		y();
		modif();
	}else{
		print("* NO OK USER SYSTEM FILES ".$carpeta."\n");
		global $data1;			$data1 = $data1."\t* NO OK USER SYSTEM FILES".$carpeta."\n";
		}

	/************** CREAMOS LA TABLA CONTROL USUARIO ***************/

	$vname1 = $_SESSION['clave'].$trf."_".date('Y');
	$vname1 = "`".$vname1."`";
	
	$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname1 (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL,
  `Nombre` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `Apellidos` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `din` varchar(10) collate utf16_spanish2_ci NOT NULL,
  `tin` time NOT NULL,
  `dout` varchar(10) collate utf16_spanish2_ci NULL,
  `tout` time NULL,
  `ttot` time NULL,
  `del` varchar(5) NOT NULL default 'false',
  `dfeed` varchar(10) collate utf16_spanish2_ci NULL,
  `tfeed` time NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
	if(mysqli_query($db , $tcl)){
		global $data5;			$data5 = "\t* OK TABLA FICHAR ".$vname1.".\n";
	}else{
		global $data5;			$data5 = "\t* NO OK TABLA FICHAR. ".mysqli_error($db)." \n";
	}

	/************** CREAMOS LA TABLA FEEDBACK CONTROL USUARIO ***************/

	$vname1 = $_SESSION['clave'].$trf."_feed";
	$vname1 = "`".$vname1."`";
	
	$tcl = "CREATE TABLE IF NOT EXISTS `$db_name`.$vname1 (
  `id` int(4) NOT NULL auto_increment,
  `ref` varchar(20) collate utf16_spanish2_ci NOT NULL,
  `Nombre` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `Apellidos` varchar(25) collate utf16_spanish2_ci NOT NULL,
  `din` varchar(10) collate utf16_spanish2_ci NOT NULL,
  `tin` time NOT NULL,
  `dout` varchar(10) collate utf16_spanish2_ci NULL,
  `tout` time NULL,
  `ttot` time NULL,
  `dfeed` varchar(10) collate utf16_spanish2_ci NULL,
  `tfeed` time NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_spanish2_ci AUTO_INCREMENT=1 ";
		
if(mysqli_query($db , $tcl)){
	global $data6;			$data6 = "\t* OK TABLA FEED FICHAR ".$vname1.".\n";
}else{
	global $data6;			$data6 = "\t* NO OK TABLA FEED FICHAR. ".mysqli_error($db)." \n";
}

	// CREA EL DIRECTORIO DE IMAGEN DE USUARIO.
	$vn1 = "img_admin";
	$carpetaimg = "../Users/".$trf."/".$vn1;
	if (!file_exists($carpetaimg)) {
		mkdir($carpetaimg, 0777, true);
		copy("../Images/untitled.png", $carpetaimg."/untitled.png");
		$data2 = "\t* OK DIRECTORIO ".$carpetaimg." \n";
	}else{print("* NO OK DIRECTORIO ".$carpetaimg."\n");
		$data2 = "\t* NO OK DIRECTORIO ".$carpetaimg."\n";
	}
	
	// CREA EL DIRECTORIO DE LOG DE USUARIO.
	$vn1 = "log";
	$carpetalog = "../Users/".$trf."/".$vn1;
	if (!file_exists($carpetalog)) {
		mkdir($carpetalog, 0777, true);
		$data3 = "\t* OK DIRECTORIO ".$carpetalog."\n";
	}else{print("* NO OK EL DIRECTORIO ".$carpetalog."\n");
		$data3 = "\t* NO OK DIRECTORIO ".$carpetalog."\n";
	}
	
	// CREA EL DIRECTORIO RESUMEN FICHAR MES.
	$vn1 = "mrficha";
	$carpetamrf = "../Users/".$trf."/".$vn1;
	if (!file_exists($carpetamrf)) {
		mkdir($carpetamrf, 0777, true);
		$data4 = "\t* OK DIRECTORIO ".$carpetamrf."\n";
	}else{print("* NO OK DIRECTORIO ".$carpetamrf."\n");
		$data4= "\t* NO OK DIRECTORIO ".$carpetamrf."\n";
	}

?>