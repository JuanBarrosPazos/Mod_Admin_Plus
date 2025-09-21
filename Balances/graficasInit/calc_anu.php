<?php

    global $db;             global $db_name;
	global $balances;       global $balancesOtros;

	/*************		CONSULTAMOS TODAS LAS TABLAS DE USUARIOS Y SISTEMA		***************/

	/* Se busca las tablas en la base de datos */
	/* REFERENCIA DEL USUARIO O $_SESSION['iniref'] = $_POST['ref'] */
	/* $nom PARA LA CLAVE USUARIO ACOMPAÑANDA DE _ O NO */
	// $consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME $nom ";

	/*************		 CONSULTA TODAS LAS TABLAS CON CLAVE DE INSTALACION		***************/
	/*
 	global $nom;
	$nom = $_SESSION['clave']."%"; // SOLO COINCIDEN AL PRINCIPIO
	$nom = "LIKE '$nom'";
    $consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom";
    //print("* NUMERO TABLAS: ".$count."<br>");
	//print("* CLAVE TABLA USUARIO: ".$nom."<br>");
    */

	/*************		 CONSULTA TODAS LAS TABLAS DEL USUARIO CON SESION INICIADA		***************/
    global $nom;
    if($balancesOtros == 1){
        $nom = $_SESSION['clave'].$_SESSION['usuarios']."_%";
    }else{
       $nom = $_SESSION['clave'].$_SESSION['ref']."_%";
    }

    $nom = "LIKE '$nom'";
	$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom";
    //echo $consulta."<br>";
	$respuesta = mysqli_query($db, $consulta);
	$count = mysqli_num_rows($respuesta);

	$consultab = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom";
    //echo $consulta."<br>";
	$respuestab = mysqli_query($db, $consultab);
	$countb = mysqli_num_rows($respuestab);

	$consultac = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom";
    //echo $consulta."<br>";
	$respuestac = mysqli_query($db, $consultac);
	$countc = mysqli_num_rows($respuestac);
	//print("* NUMERO TABLAS: ".$countc."<br>");
	//print("* CLAVE TABLA USUARIO: ".$nom."<br>");

	//global $fila;
	//$fila = mysqli_fetch_row($respuesta);
    // echo " ".$fila[0]."<br>";

    global $totalHoras;         global $totalDias;

    if(!$respuesta){
        print("ERROR SQL L.32 ".mysqli_error($db)."</br>");
    }else{  

        $filab = mysqli_fetch_row($respuestab);      
        for($i=0; $i<$countb; $i++){
			if($filab[0]){
                $sqlSumb = "SELECT SUM(TIME_TO_SEC(`ttot`)) AS 'totalA' FROM `$filab[0]` WHERE (`ttot` <> '00:00:00' OR `error` <> 'true')";
                $Sumb = mysqli_query($db, $sqlSumb);
                $sumTotb = mysqli_fetch_assoc($Sumb);

                $totsecb = $sumTotb['totalA'];  // RESULTADO CONSULTA SUM() POR TABLA EN SEGUNDOS
                $diasb = floor($totsecb/28800); // PARA LOS DIAS
                $horasb = floor($totsecb/3600); // PARA 1H 3600S
                $totalDias += $diasb;           //echo "** TOTAL DIAS: ".$totalDias."<br>";
                $totalHoras += $horasb;         //echo "** TOTAL HORAS: ".$totalHoras."<br>";
                
			}else{ } // FIN IF $filab[0]
		} // FIN FOR
    
        // CENTRO LAS GRAFICAS FINALES
        print ("<div style='clear:both'></div>
		        <div class='centradiv' style='margin:0.2em auto; padding:0.2em;'>");

        // CONSTRUYO EL INCIO DE LA GRAFICA HORAS ANUALES PARA EL WHILE
        print ("<div style='clear:both'></div>
		        <div class='centradiv' style='display:inline-block; margin:0.2em 0.4em; padding: 0.6em 0.2em 1.2em 0.2em;'>
                    GRAFICA HORAS ANUALES
					<ul class='timeline'>");

		while($fila = mysqli_fetch_row($respuesta)){
			if($fila[0]){

                $sqlSum = "SELECT SUM(TIME_TO_SEC(`ttot`)) AS 'total' FROM `$fila[0]` WHERE (`ttot` <> '00:00:00' OR `error` <> 'true')";
                $Sum = mysqli_query($db, $sqlSum);
                $sumTot = mysqli_fetch_assoc($Sum);
                //echo "** ".$fila[0]." TOTAL SEGUNDOS: ".$sumTot['total']."<br>";

                global $totalHoras;         global $totalDias;
                $totsec = $sumTot['total'];     // RESULTADO CONSULTA SUM() POR TABLA EN SEGUNDOS
                $dias = floor($totsec/28800);   // PARA LOS DIAS
                $horas = floor($totsec/3600);   // PARA 1H 3600S
                // TOTAL SEGUNDOS MENOS ((HORAS X 3600S/H) ENTRE 60M/H)
                $minutos = floor(($totsec-($horas*3600))/60);
                // TOTAL SEGUNDOS MENOS (HORAS X 36OOS/H) - (MINUTOS X 60M/H))
                $segundos = $totsec-($horas*3600)-($minutos*60);
                // TOTAL HORAS Y MINUTOS DE CADA TABLA
                global $totalSuma;      $totalSuma = "DIAS: ".$dias." || HORAS: ".$horas.".".$minutos;
                $yr = substr($fila[0], -4);
                //echo "** AÑO: ".$yr." TOTAL TIME: ".$totalSuma."<br>";
                //echo "** TOTAL DIAS: ".$totalDias."<br>";
                //echo "** TOTAL HORAS: ".$totalHoras."<br>";

                $totaltime1 = number_format($horas ,2,".","");
                if($totaltime1 > 0){
                    $TotM1 = ($totaltime1*100)/$totalHoras;
                    $li1 = "<li>
                            <a href='#' title='AÑO ".$yr." ".(abs($totaltime1))." Horas'>
                                <span class='label'>".$yr."<br>".(abs($totaltime1))."</span>
                                <span class='count bgcolori' style='height: ".$TotM1."%'>(".$TotM1.")</span>
                            </a>
                        </li>";
                }else{ $TotM1 = 0.00; $li1 = ""; }
                
                print ($li1);

			}else{ } // FIN IF $FILA[0]
		} // FIN WHILE

        // CONSTRUYO EL FINAL DE LA GRAFICA HORAS ANUALES
		print("<li>
				<a href='#' title='ANUAL TOT ".(abs($totalHoras))." Horas'>
					<span class='label'>TOT<br>".(abs($totalHoras))."</span>
					<span class='count bgcolord' style='height: ".$TotEi."%'>(".$TotEi.")</span>
				</a>
			</li>
            </ul>
		</div>");

        // CONSTRUYO EL INCIO DE LA GRAFICA DIAS ANUALES PARA EL WHILE
        print ("<div class='centradiv' style='display:inline-block; margin:0.2em 0.4em; padding: 0.6em 0.2em 1.2em 0.2em;'>
                    GRAFICA DIAS ANUALES
					<ul class='timeline'>");

		while($filac = mysqli_fetch_row($respuestac)){
			if($filac[0]){

                $sqlSumc = "SELECT SUM(TIME_TO_SEC(`ttot`)) AS 'total' FROM `$filac[0]` WHERE (`ttot` <> '00:00:00' OR `error` <> 'true')";
                $Sumc = mysqli_query($db, $sqlSumc);
                $sumTotc = mysqli_fetch_assoc($Sumc);
                //echo "** ".$filac[0]." TOTAL SEGUNDOS: ".$sumTot['total']."<br>";

                global $totalHoras;         global $totalDias;
                $totsecc = $sumTotc['total'];       // RESULTADO CONSULTA SUM() POR TABLA EN SEGUNDOS
                $diasc = floor($totsecc/28800);     // PARA LOS DIAS
                $horasc = floor($totsecc/3600);     // PARA 1H 3600S
                // TOTAL SEGUNDOS MENOS ((HORAS X 3600S/H) ENTRE 60M/H)
                $minutosc = floor(($totsecc-($horasc*3600))/60);
                // TOTAL SEGUNDOS MENOS (HORAS X 36OOS/H) - (MINUTOS X 60M/H))
                $segundoss = $totsecc-($horasc*3600)-($minutosc*60);
                // TOTAL HORAS Y MINUTOS DE CADA TABLA
                //global $totalSuma;      $totalSuma = "DIAS: ".$diasc." || HORAS: ".$horasc.".".$minutosc;
                $yrc = substr($filac[0], -4);
                //echo "** AÑO: ".$yrc." TOTAL TIME: ".$totalSuma."<br>";
                //echo "** TOTAL DIAS: ".$totalDias."<br>";
                //echo "** TOTAL HORAS: ".$totalHoras."<br>";

                $totaltime2 = number_format($diasc ,2,".","");
                if($totaltime2 > 0){
                    $TotM2 = ($totaltime2*100)/$totalDias;
                    $li2 = "<li>
                            <a href='#' title='AÑO ".$yrc." ".(abs($totaltime2))." Dias'>
                                <span class='label'>".$yrc."<br>".(abs($totaltime2))."</span>
                                <span class='count bgcolorir' style='height: ".$TotM2."%'>(".$TotM2.")</span>
                            </a>
                        </li>";
                }else{ $TotM2 = 0.00; $li2 = ""; }
                
                print ($li2);

			}else{ } // FIN IF $filac[0]
		} // FIN WHILE

        // CONSTRUYO EL FINAL DE LA GRAFICA DIAS ANUALES
		print("<li>
				<a href='#' title='ANUAL TOT ".(abs($totalDias))." Dias'>
					<span class='label'>TOT<br>".(abs($totalDias))."</span>
					<span class='count bgcolori' style='height: ".$TotEi."%'>(".$TotEi.")</span>
				</a>
			</li>
            </ul>
		</div>");

        // CIERRO DIV CENTRA TALBAS
        print("</div></div>");

} // FIN ELSE !$respuesta

?>