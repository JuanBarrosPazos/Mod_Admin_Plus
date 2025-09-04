<?php

    global $orden;
	require '../Inclu/orden.php';

	/* TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/
	
	$sh =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' AND `ttot` <> '00:00:00' ORDER BY $orden ";
	
	/* GRABAMOS LAS FECHAS. */
	if(!$sh){print(mysqli_error($db).".</br>");
	}else{
        $datf = mysqli_query($db, $sh);
        $df = fopen('datosf.php','w+');
        $i=0;
		while($r1 = mysqli_fetch_array($datf)){
			$l1 = substr($r1['din'],7,3).",";
			$l1 = str_replace("-","D.",$l1);
			fwrite($df, $l1);
			$tot1[$i] = $r1['din'];
			$i++;
		}
		fclose($df);
	}

	/* GRABAMOS LOS DATOS. */
	if(!$sh){print(mysqli_error($db).".</br>");
	}else{
        $dat = mysqli_query($db, $sh);
        $d = fopen('datos.php','w+');
        $i=0;
		while($r2 = mysqli_fetch_array($dat)){
			$l2 = substr($r2['ttot'],0,5).",";
			$l2 = str_replace(":",".",$l2);
			fwrite($d, $l2);
			$tot2[$i] = $r2['ttot'];
			$i++;
		}
		fclose($d);
	}

    		////////////////////		**********  		////////////////////
	
	if(!$sh){print(mysqli_error($db).".</br>");
	}else{
        $qn1 = mysqli_query($db,$sh);
        $qn2 = mysqli_fetch_assoc($qn1);
        global $name1;			$name1 = $qn2['Nombre'];
        global $name2;			$name2 = $qn2['Apellidos'];
		}

    		////////////////////		**********  		////////////////////
        
	/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$sh){print(mysqli_error($db).".</br>");
	}else{
		$qh = mysqli_query($db, $sh);
		$qhr = mysqli_num_rows($qh);
		$sumah = 0;
		for($i=0; $i<$qhr; $i++){
			$verh = mysqli_fetch_array($qh);
			$verh = substr($verh['ttot'],0,2).",";
			$verh = str_replace(":","",$verh);
		global $sumah;			@$sumah = $sumah + $verh;
												}
	}
	$hortosec = $sumah * 3600;	
	//print ("</br>".$sumah);
	//print ("</br>".$hortosec);	
	
	/* CALCULAMOS LOS MINUTOS TOTALES Y LOS PASAMOS A SEGUNDOS. */
	if(!$sh){print(mysqli_error($db).".</br>");
	}else{
		$qm = mysqli_query($db, $sh);
		$qmr = mysqli_num_rows($qm);
		$sumam = 0;
		global $sumam;
		for($i=0; $i<$qmr; $i++){
			$verm = mysqli_fetch_array($qm);
			$verm = substr($verm['ttot'],3,2).",";
			$verm = str_replace(":","",$verm);
			@$sumam = $sumam + $verm;
		}
	}

	$mintosec = $sumam * 60;	
	//print ("</br>".$sumam);
	//print ("</br>".$mintosec);	

/* CALCULAMOS LOS SEGUNDOS TOTALES. */
	if(!$sh){print(mysqli_error($db).".</br>");
	}else{
		$qs = mysqli_query($db, $sh);
		$qsr = mysqli_num_rows($qs);
		$sumas = 0;
		global $sumas;	
		for($i=0; $i<$qsr; $i++){
			$vers = mysqli_fetch_array($qs);
			$vers = substr($vers['ttot'],-2).",";
			$vers = str_replace(":","",$vers);
			@$sumas = $sumas + $vers;
		}
	}
	//print ("</br>".$sumas);

/* SUMAMOS TODOS LOS SEGUNDOS. */	
	
	global $totsec;				$totsec = $hortosec + $mintosec + $sumas;
	//print ("</br>".$totsec);
	
/* PASAMOS LOS SEGUNDOS A HORAS:MINUTOS:SEGUNDOS */
	
	// PARA 24H 86400S
	//$dias = floor($totsec/86400);
	// PARA 8H LABORALES 28800S
	$dias = floor($totsec/28800);
	// PARA 1H 3600S
	$horas = floor($totsec/3600);
	// TOTAL SEGUNDOS MENOS ((HORAS X 3600S/H) ENTRE 60M/H)
	$minutos = floor(($totsec-($horas*3600))/60);
	// TOTAL SEGUNDOS MENOS (HORAS X 36OOS/H) - (MINUTOS X 60M/H))
	$segundos = $totsec-($horas*3600)-($minutos*60);

	global $t;
	if($dias == 1){  $t = " DIA LABORAL || ";}
	elseif($dias != 1 ){ $t = " DIAS LABORALES || ";}
							
	global $totaltime;
	$totaltime = "".$dias.$t.$horas." Horas / ".$minutos." Min / ".$segundos." Segs.";
	//print("</br>".$totaltime);

			///////////////////////			***********  		///////////////////////

?>