<?php

	global $db;				global $db_name;			global $vname;

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* ENERO TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-01-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm1 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm1){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm1);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm1){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm1);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm1){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm1);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime1;
	$totaltime1 = $horas.".".$minutos;
	//print("</br>".$totaltime1);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* FEBRERO TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-02-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm2 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm2){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm2);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm2){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm2);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm2){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm2);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime2;
	$totaltime2 = $horas.".".$minutos;
	//print("</br>".$totaltime2);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* MARZO TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-03-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm3 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm3){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm3);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm3){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm3);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm3){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm3);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime3;
	$totaltime3 = $horas.".".$minutos;
	//print("</br>".$totaltime3);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* ABRIL TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-04-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm4 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm4){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm4);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm4){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm4);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm4){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm4);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;			$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime4;
	$totaltime4 = $horas.".".$minutos;
	//print("</br>".$totaltime4);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* MAYO TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-05-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm5 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm5){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm5);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			@$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm5){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm5);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			@$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm5){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm5);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			@$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime5;
	$totaltime5 = $horas.".".$minutos;
	//print("</br>".$totaltime5);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
/* JUNIO TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-06-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm6 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm6){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm6);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm6){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm6);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm6){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm6);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime6;
	$totaltime6 = $horas.".".$minutos;
	//print("</br>".$totaltime6);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
/* 	JULIO TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-07-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm7 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm7){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm7);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm7){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm7);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm7){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm7);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime7;
	$totaltime7 = $horas.".".$minutos;
	//print("</br>".$totaltime7);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
/* 	AGOSTO TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-08-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm8 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm8){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm8);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm8){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm8);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm8){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm8);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime8;
	$totaltime8 = $horas.".".$minutos;
	//print("</br>".$totaltime8);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
/* 	SEPTIEMBRE TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;				$dm1ym = "-09-";
	global $filym;				$filym = "%".$dy1.$dm1ym."%";
	
	$dm9 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm9){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm9);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm9){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm9);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm9){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm9);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime9;
	$totaltime9 = $horas.".".$minutos;
	//print("</br>".$totaltime9;

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
/* 	OCTUBRE TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;				$dm1ym = "-10-";
	global $filym;				$filym = "%".$dy1.$dm1ym."%";
	
	$dm10 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm10){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm10);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm10){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm10);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm10){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm10);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime10;
	$totaltime10 = $horas.".".$minutos;
	//print("</br>".$totaltime10);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
/* 	NOVIEMBRE TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-11-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm11 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm11){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm11);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm11){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm11);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm11){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm11);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;			$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime11;
	$totaltime11 = $horas.".".$minutos;
	//print("</br>".$totaltime11);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
/* 	DICIEMBRE TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/

	global $dm1ym;			$dm1ym = "-12-";
	global $filym;			$filym = "%".$dy1.$dm1ym."%";
	
	$dm12 =  "SELECT * FROM $vname WHERE `din` LIKE '$filym' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$dm12){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $dm12);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
			global $sumah;	
			$sumah = $sumah + $verh;
		}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$dm12){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $dm12);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			global $sumam;	
			$sumam = $sumam + $verm;
		}
	}
	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$dm12){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $dm12);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			global $sumas;	
			$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;			$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	$dias = floor($totsec/86400);
	$horas = floor($totsec/3600);
	$minutos = floor(($totsec-($horas*3600))/60);
	$segundos = $totsec-($horas*3600)-($minutos*60);
	global $totaltime12;
	$totaltime12 = $horas.".".$minutos;
	//print("</br>".$totaltime12);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	$dym = fopen('datosym.php','w+');
	//$l5 = substr($r2['ttot'],0,5).",";
	//$l5 = str_replace(":",".",$l5);
	global $totym;
	$totym = $totaltime1.",".$totaltime2.",".$totaltime3.",".$totaltime4.",".$totaltime5.",".$totaltime6.",".$totaltime7.",".$totaltime8.",".$totaltime9.",".$totaltime10.",".$totaltime11.",".$totaltime12.",";
	fwrite($dym, $totym);
	fclose($dym);

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>