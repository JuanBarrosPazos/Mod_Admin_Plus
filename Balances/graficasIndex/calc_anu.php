<?php

    global $db;         global $db_name;

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
    */

	/*************		 CONSULTA TODAS LAS TABLAS DEL USUARIO CON SESION INICIADA		***************/
    global $nom;
    $nom = $_SESSION['clave'].$_SESSION['ref']."_%";
    $nom = "LIKE '$nom'";
	$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom";
    //echo $consulta."<br>";
    
	$respuesta = mysqli_query($db, $consulta);
	$count = mysqli_num_rows($respuesta);

	$consultaA = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME $nom";
    //echo $consulta."<br>";
	$respuestaA = mysqli_query($db, $consultaA);
	$countA = mysqli_num_rows($respuestaA);

	//print("* NUMERO TABLAS: ".$count."<br>");
	//print("* CLAVE TABLA USUARIO: ".$nom."<br>");

	//global $fila;
	//$fila = mysqli_fetch_row($respuesta);
    // echo " ".$fila[0]."<br>";

 global $totalHoras;         global $totalDias;

if(!$respuesta){

	print("ERROR SQL L.24 ".mysqli_error($db)."</br>");

}else{  
        while($filaA = mysqli_fetch_row($respuestaA)){

			if($filaA[0]){
                $sqlSumA = "SELECT SUM(TIME_TO_SEC(`ttot`)) AS 'totalA' FROM `$filaA[0]` WHERE (`ttot` <> '00:00:00' OR `ttot` <> '00:00:01')";
                $SumA = mysqli_query($db, $sqlSumA);
                $sumTotA = mysqli_fetch_assoc($SumA);

                // RESULTADO CONSULTA SUM() POR TABLA EN SEGUNDOS
                $totsecA = $sumTotA['totalA'];
                // PARA LOS DIAS
                $diasA = floor($totsecA/28800);
                // PARA 1H 3600S
                $horasA = floor($totsecA/3600);
                $totalDias += $diasA;
                //echo "** TOTAL DIAS: ".$totalDias."<br>";
                $totalHoras += $horasA;
                //echo "** TOTAL HORAS: ".$totalHoras."<br>";
			}else{ } // FIN IF $filaA[0]
		} // FIN WHILE
    
        // CONSTRUYO EL INCIO DE LA GRAFICA
        print ("<div style='clear:both'></div>
		        <div class='section centradiv' style='padding: 0.6em 0.2em 1.2em 0.2em;'>
                    GRAFICA HORAS ANUALES
					<ul class='timeline'>");

		while($fila = mysqli_fetch_row($respuesta)){
			if($fila[0]){

                $sqlSum = "SELECT SUM(TIME_TO_SEC(`ttot`)) AS 'total' FROM `$fila[0]` WHERE (`ttot` <> '00:00:00' OR `ttot` <> '00:00:01')";
                $Sum = mysqli_query($db, $sqlSum);
                $sumTot = mysqli_fetch_assoc($Sum);
                //echo "** ".$fila[0]." TOTAL SEGUNDOS: ".$sumTot['total']."<br>";

                global $totalHoras;         global $totalDias;
                // RESULTADO CONSULTA SUM() POR TABLA EN SEGUNDOS
                $totsec = $sumTot['total'];
                // PARA LOS DIAS
                $dias = floor($totsec/28800);
                // PARA 1H 3600S
                $horas = floor($totsec/3600);
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
                /////////////////////////////////////////////////

                $totaltime1 = number_format($horas ,2,".","");
                if($totaltime1 > 0){
                    $TotM1 = ($totaltime1*100)/$totalHoras;
                    $li1 = "<li>
                            <a href='#' title='AÑO ".$yr." ".(abs($totaltime1))." Hr'>
                                <span class='label'>".$yr."<br>".(abs($totaltime1))."</span>
                                <span class='count bgcolori' style='height: ".$TotM1."%'>(".$TotM1.")</span>
                            </a>
                        </li>";
                }else{ $TotM1 = 0.00; $li1 = ""; }
                
                print ($li1);



			}else{ } // FIN IF $FILA[0]
		} // FIN WHILE

        // CONSTRUYO EL FINAL DE LA GRAFICA
		print("<li>
				<a href='#' title='ANUAL TOT ".(abs($totalHoras))." Hr'>
					<span class='label'>TOT<br>".(abs($totalHoras))."</span>
					<span class='count bgcolord' style='height: ".$TotEi."%'>(".$TotEi.")</span>
				</a>
			</li>
            </ul>
		</div>");

} // FIN ELSE !$respuesta

?>