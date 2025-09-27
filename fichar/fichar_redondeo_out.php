<?php
    
	/*
		HORA ORIGINAL DE SALIDA DEL SCRIPT
        global $tout;       $tout = date('H:i:s');
	*/

			////////////////////		***********  		////////////////////

	/*
        REDONDEO SOLO LOS SEGUNDOS
        global $s;          $s = "00";
        global $tout;       $tout = date('H:i').":".$s;
	*/

			////////////////////		***********  		////////////////////
            
// SI NO QUIERO REDONDEO DE HORARIO COMENTAR DESDE AQUÍ ...

    // CALCULO LA HORA Y MINUTOS DE ENTRADA
        $qtimein = mysqli_fetch_assoc($q1);
        //print("* Time in: ".$qtimein['tin']);
    
        $verhorain = substr($qtimein['tin'],0,2);
        $verhorain = str_replace(":","",$verhorain);
        //print("<br>- Hora in: ".$verhorain);

        $verminuin = substr($qtimein['tin'],3,2);
        $verminuin = str_replace(":","",$verminuin);
        //print("<br>- Minuto in: ".$verminuin);

    // FIN CALCULO HORA Y MINUTOS ENTRADA

   // REDONDEO DE LA HORA SALIDA

        /* HORA MODIFICADA */
            global $h;      $h = date('H');
            global $m;      $m = date('i');
            
    // REDONDEO LOS SEGUNDOS A 00 SIEMPRE
            global $s;      $s = "00";

        // SI PASAN MENOS DE 25 MINUTOS DE EMPUNTO REDONDEO LOS MINUTOS A 00
        if($m <= 25){  global $m;       $m = "00";
        }elseif(($m >= 26)&&($m <= 54)){ 
            /*  SI FALTAN MAS || = DE 6 MINUTOS PARA EN PUNTO 
                O PASA DE 25 MINUTOS, REDONDEO LOS MINUTOS A 30 */
            global $m;      $m = 30;
         }elseif($m >= 55){   
            /* SI FALTAN 5 MINUTOS PARA EN PUNTO REDONDEO LA HORA DE SALIDA +1 Y MINUTOS 00 */
            global $h;      $h = date('H')+1;
            global $m;      $m = "00";
        }
                                
        if($verhorain < $h){ 
            // SI LA HORA DE ENTRADA ES MENOR QUE LA DE REDONDEO
        }elseif(($verhorain > $h)&&($verminuin == "00")){  
            // SI LA HORA DE ENTRADA ES MAYOR QUE LA DE REDONDEO
                global $h;      $h = date('H')+1;
                global $m;      $m = "00";
        }elseif(($verhorain == $h)&&($verminuin == "00")){ 
            // SI LA HORA DE ENTRADA ES IGUAL QUE LA DE REDONDEO
                global $m;      $m = "00";
        }elseif(($verhorain == $h)&&($verminuin >= $m)){ 
            // SI LA HORA DE ENTRADA ES LA MISMA QUE EL REDONDEO
            // Y LOS MINUTOS DE REDONDEO SON MENORES O IGUALES QUE LOS DE ENTRADA
                global $x;          $x = date('i');
            if($verminuin > $x){ 
                // SI LOS MINUTOS DE REDONDEO SON MENORES QUE LOS ACTUALES
                    global $m;          $m = $verminuin;
            }else{  global $m;          $m = date('i');}
        }else{ }

    // PASO LOS VALORES DEL REDONDEO A LA VARIABLE.
        global $tout;       $tout = $h.":".$m.":".$s;
        //print("<br>* Redondeo Salida: ".$tout);
        //print("<br>* Hora Real: ".date('H:i:s'));

    // FIN REDONDEO HORA DE SALIDA

// SI NO QUIERO REDONDEO DE HORARIO COMENTAR HASTA AQUÍ ...

			////////////////////		***********  		////////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>