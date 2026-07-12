<?php

    global $db;             global $db_name;
	global $balances;       global $balancesOtros;

	/*************		 CONSULTA TODAS LAS TABLAS DEL USUARIO CON SESION INICIADA		***************/

    global $nom;        $nom = $_SESSION['clave']."horarios_%";
    
    global $userBbdd;
    if($balancesOtros == 1){
        $userBbdd = $_SESSION['usuarios'];
    }else{
        $userBbdd = $_SESSION['ref'];
    }

    $nom = "LIKE '$nom'";

    // Consulta a INFORMATION_SCHEMA y guardamos los nombres en un array
	$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom";
	$respuesta = mysqli_query($db, $consulta);

    global $totalHoras;         global $totalDias;

    if(!$respuesta){
        print("* ERROR SQL L.20 ".mysqli_error($db)."</br>");
    }else{  
        
        // Almacenamos los nombres de las tablas para no repetir consultas pesadas
        global $tablas;     $tablas = [];
        while($fila_tabla = mysqli_fetch_row($respuesta)){
            if(!empty($fila_tabla[0])){
                $tablas[] = $fila_tabla[0];
            }
        }
        
        global $countc;     $countc = count($tablas);

        // 1. PRIMER BUCLE: Cálculo de totales acumulados
        foreach($tablas as $tabla_nombre){
            $sqlSumb = "SELECT SUM(TIME_TO_SEC(`ttot`)) AS 'totalA' FROM `$tabla_nombre` WHERE `ref` = '$userBbdd' AND (`ttot` <> '00:00:00' AND `error` = 'false')";
            $Sumb = mysqli_query($db, $sqlSumb);
            $sumTotb = mysqli_fetch_assoc($Sumb);

            $totsecb = $sumTotb['totalA'] ?? 0;  // Prevenimos nulos con operador de fusión de esquema
            $diasb = floor($totsecb/28800); 
            $horasb = floor($totsecb/3600); 
            $totalDias += $diasb;           
            $totalHoras += $horasb;         
		}
    
        // CENTRO LAS GRAFICAS FINALES
        print ("<div style='clear:both'></div>
		        <div class='centradiv' style='margin:0.2em auto; padding:0.2em;'>");

        // CONSTRUYO EL INCIO DE LA GRAFICA HORAS ANUALES
        print ("<div style='clear:both'></div>
		        <div class='centradiv' style='display:inline-block; margin:0.2em 0.4em; padding: 0.6em 0.2em 1.2em 0.2em;'>
                    GRAFICA HORAS ANUALES
					<ul class='timeline'>");

        // 2. SEGUNDO BUCLE: Renderizado de gráfica de horas
		foreach($tablas as $tabla_nombre){
            $sqlSum = "SELECT SUM(TIME_TO_SEC(`ttot`)) AS 'totalB' FROM `$tabla_nombre` WHERE `ref` = '$userBbdd' AND (`ttot` <> '00:00:00' AND `error` = 'false')";
            $Sum = mysqli_query($db, $sqlSum);
            $sumTot = mysqli_fetch_assoc($Sum);

            global $totalHoras;         global $totalDias;
            $totsec = $sumTot['totalB'] ?? 0; 
            $dias = floor($totsec/28800);   
            $horas = floor($totsec/3600);
            
            $minutos = floor(($totsec-($horas*3600))/60);
            $segundos = $totsec-($horas*3600)-($minutos*60);
            
            global $totalSuma;      $totalSuma = "DIAS: ".$dias." || HORAS: ".$horas.".".$minutos;
            $yr = substr($tabla_nombre, -4);

            $totaltime1 = number_format($horas ,2,".","");
            if($totaltime1 > 0){
                // Evitamos división por cero si $totalHoras es 0
                $TotM1 = ($totalHoras > 0) ? ($totaltime1*100)/$totalHoras : 0;
                $li1 = "<li>
                        <a href='#' title='AÑO ".$yr." ".(abs($totaltime1))." Horas'>
                            <span class='label'>".$yr."<br>".(abs($totaltime1))."</span>
                            <span class='count bgcolord' style='height: ".$TotM1."%'>(".$TotM1.")</span>
                        </a>
                    </li>";
            }else{ $TotM1 = 0.00; $li1 = ""; }
            
            print ($li1);
		}

        // CONSTRUYO EL FINAL DE LA GRAFICA HORAS ANUALES
        global $TotEi;
        if($TotEi > 0){
				$TotEi = ((abs($totalHoras))*100)/(abs(1736*$countc));
		}else{ 	$TotEi = 0.00; }
		print("<li>
				<a href='#' title='ANUAL TOT ".(abs($totalHoras))." Horas'>
					<span class='label'>TOT<br>".(abs($totalHoras))."</span>
					<span class='count bgcolori' style='height: ".$TotEi."%'>(".$TotEi.")</span>
				</a>
			</li>
            </ul>
		</div>");

        // CONSTRUYO EL INCIO DE LA GRAFICA DIAS ANUALES
        print ("<div class='centradiv' style='display:inline-block; margin:0.2em 0.4em; padding: 0.6em 0.2em 1.2em 0.2em;'>
                    GRAFICA DIAS ANUALES
					<ul class='timeline'>");

        global $DVTotal;        global $DErrorTot;
        
        // 3. TERCER BUCLE: Renderizado de gráfica de días trabajado/error
		foreach($tablas as $tabla_nombre){
            $sql = "SELECT COUNT(DISTINCT CASE WHEN `error` = 'false' THEN `din` END) AS dias_validos, COUNT(DISTINCT CASE WHEN `error` = 'true' THEN `din` END) AS dias_error FROM `$tabla_nombre` WHERE `ref` = '$userBbdd' AND `ttot` <> '00:00:00'";
            $resultado = mysqli_query($db, $sql);

            global $DiasValidos;        global $DiasValidosTotal;
            global $DiasError;          global $DiasErrorTotales;			global $DiasTotal;

            if ($resultado) {
                $fila_dias = mysqli_fetch_assoc($resultado);
                $DiasValidos = $fila_dias['dias_validos'] ?? 0;
                $DiasValidosTotal = $DiasValidos + $DiasValidosTotal;
                $DiasError = $fila_dias['dias_error'] ?? 0;
                $DiasErrorTotales = $DiasError + $DiasError;
                $DiasTotal = $DiasValidos + $DiasError;
            } else {
                echo "* Error SQL L.114 " . mysqli_error($db);
            }

            $yrc = substr($tabla_nombre, -4);
            // Evitamos división por cero si $countc es 0
            //$DVTotal = ($countc > 0) ? $totalDias / $countc : 0;
            //$DVTotal = ($countc > 0) ? $totalDias : 0;
            //$DVTotal = ($countc > 0) ? 365 : 0; //Dias del año...

            
            if($DiasValidos > 0){
                //$TotM2 = ($DVTotal > 0) ? ($DiasValidos*100)/$DVTotal : 0;
                $TotM2 = ($totalDias > 0) ? ($DiasValidos*100)/217 : 0; //Dias del año...
              
                $li2 = "<li>
                        <a href='#' title='AÑO ".$yrc." ".(abs($DiasValidos))." Dias de 217 dias laborales'>
                            <span class='label'>".$yrc."<br>".(abs($DiasValidos))."</span>
                            <span class='count bgcolorir' style='height: ".$TotM2."%'>(".$TotM2.")</span>
                        </a>
                    </li>";
            }else{ $TotM2 = 0.00; $li2 = ""; }
            
            print ($li2);
		} // FIN FOREACH

        // CONSTRUYO EL FINAL DE LA GRAFICA DIAS ANUALES
        $DVTotal = ($countc > 0) ? ($totalDias*100) / (217*$countc) : 0;
		print("<li>
				<a href='#' title='ANUAL TOT ".(abs($DiasValidosTotal))." Dias de ".(217*$countc)." dias laborales en ".$countc." años'>
					<span class='label'>TOT<br>".(abs($DiasValidosTotal))."</span>
					<span class='count bgcolori' style='height: ".$DVTotal."%'>(".$DVTotal.")</span>
				</a>
			   </li>");

            $DErrorTot = ($DiasErrorTotales > 0) ? ($DiasErrorTotales*100)/(217*$countc) : 0;
        if($DiasErrorTotales>0){
            print("   <li>
				<a href='#' title='ERRORES TOT ".(abs($DiasErrorTotales))." Dias de ".(217*$countc)." dias laborales en ".$countc." años'>
					<span class='label'>ERR<br>".(abs($DiasErrorTotales))."</span>
					<span class='count bgcolorr' style='height: ".$DErrorTot."%'>(".$DErrorTot.")</span>
				</a>
			   </li>");
        }else{ }

        print("</ul></div>");

        // CIERRO DIV CENTRA TABLAS 
        print("</div></div>");
        
} // FIN ELSE !$respuesta

?>