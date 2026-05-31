<?php

	global $trf;	global $rutCreaTablas;
	
	// CREA EL DIRECTORIO DE USUARIO.
	global $carpeta;		$carpeta = "../Users/".$trf;

	if(!file_exists($carpeta)) {
		mkdir($carpeta, 0777, true);
		$data1 = "\t* OK DIRECTORIO USUARIO ".$carpeta."\n";
	}else{
		//print("* NO OK DIRECTORIO ".$carpeta."\n");
		$data1 = "\t* NO OK DIRECTORIO USUARIO ".$carpeta."\n";
	}

	if(file_exists($carpeta)){
		copy("../Images/untitled.png", $carpeta."/untitled.png");
		copy("../Images/pdf.png", $carpeta."/pdf.png");
		copy($rutCreaTablas."ayear_Init_System.php", $carpeta."/ayear.php");
		copy($rutCreaTablas."year.txt", $carpeta."/year.txt");
		copy($rutCreaTablas."SecureIndex2.php", $carpeta."/index.php");
		global $data1;			$data1 = $data1."\t* OK USER SYSTEM FILES ".$carpeta."\n";
		y();
		modif();
	}else{
		print("* NO OK USER SYSTEM FILES ".$carpeta."\n");
		global $data1;			$data1 = $data1."\t* NO OK USER SYSTEM FILES".$carpeta."\n";
		}

	// CREA EL DIRECTORIO DE IMAGEN DE USUARIO.
	$vn1 = "img_admin";
	$carpetaimg = "../Users/".$trf."/".$vn1;
	if(!file_exists($carpetaimg)) {
		mkdir($carpetaimg, 0777, true);
		copy("../Images/untitled.png", $carpetaimg."/untitled.png");
		$data2 = "\t* OK DIRECTORIO ".$carpetaimg." \n";
	}else{print("* NO OK DIRECTORIO ".$carpetaimg."\n");
		$data2 = "\t* NO OK DIRECTORIO ".$carpetaimg."\n";
	}
	
	// CREA EL DIRECTORIO DE LOG DE USUARIO.
	$vn1 = "log";
	$carpetalog = "../Users/".$trf."/".$vn1;
	if(!file_exists($carpetalog)) {
		mkdir($carpetalog, 0777, true);
		$data3 = "\t* OK DIRECTORIO ".$carpetalog."\n";
	}else{print("* NO OK EL DIRECTORIO ".$carpetalog."\n");
		$data3 = "\t* NO OK DIRECTORIO ".$carpetalog."\n";
	}
	
	// CREA EL DIRECTORIO RESUMEN FICHAR MES.
	$vn1 = "mrficha";
	$carpetamrf = "../Users/".$trf."/".$vn1;
	if(!file_exists($carpetamrf)) {
		mkdir($carpetamrf, 0777, true);
		$data4 = "\t* OK DIRECTORIO ".$carpetamrf."\n";
	}else{print("* NO OK DIRECTORIO ".$carpetamrf."\n");
		$data4= "\t* NO OK DIRECTORIO ".$carpetamrf."\n";
	}

?>