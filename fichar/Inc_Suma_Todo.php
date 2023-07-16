<?php

/* TOTALES HORAS MINUTOS Y SEGUNDOS DE LA CONSULTA*/
	
    if(!isset($_POST['Orden'])){global $orden;
                                $orden = "`id` ASC";}
      elseif(isset($_POST['Orden'])){global $orden;
                                     $orden = $_POST['Orden'];
                                             }
    
			///////////////////////			***********  		///////////////////////
	
    //$sh =  "SELECT * FROM `$db_name`.$vname WHERE `din` LIKE '$fil' ";
	global $sh; 	global $db; 	global $db_name;	global $vname;
	$sh =  "SELECT * FROM $vname WHERE `din` LIKE '$fil' AND `ttot` <> '00:00:00' ORDER BY $orden ";

			///////////////////////			***********  		///////////////////////

    /* SOLO PARA MODIFICAR 01 / FICHAR VER / FICHAR VER OTRO / BORRAR 01 */
        if(!$sh){print(mysqli_error($db).".</br>");
        } 
        else {	$qn1 = mysqli_query($db,$sh);
				$count = mysqli_num_rows($qn1);
				if($count > 0){
					$qn2 = mysqli_fetch_assoc($qn1);
					global $name1;
					$name1 = $qn2['Nombre'];
					global $name2;
					$name2 = $qn2['Apellidos'];
				}else{ }
                    }
    /* SOLO PARA MODIFICAR 01 / FICHAR VER / FICHAR VER OTRO / BORRAR 01 */

			///////////////////////			***********  		///////////////////////

			///////////////////////			***********  		///////////////////////

/* CALCULAMOS LAS HORAS TOTALES Y LAS PASAMOS A SEGUNDOS. */
	if(!$sh){print(mysqli_error($db).".</br>");
	}
	else{
		$qh = mysqli_query($db, $sh);
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
	if(!$sh){print(mysqli_error($db).".</br>");
	}
	else{
		$qm = mysqli_query($db, $sh);
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
	if(!$sh){print(mysqli_error($db).".</br>");
	}
	else{
		$qs = mysqli_query($db, $sh);
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
	
	global $totsec;
	$totsec = $hortosec + $mintosec + $sumas;
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

	if($dias == 1){ global $t;
				   $t = " DIA LABORAL || ";}
	elseif($dias != 1 ){ global $t;
							$t = " DIAS LABORALES || ";}
							
	global $sumatodo;
	$sumatodo = "".$dias.$t.$horas." Horas / ".$minutos." Min / ".$segundos." Segs.";
	//print("</br>".$sumatodo);

			///////////////////////			***********  		///////////////////////

?>