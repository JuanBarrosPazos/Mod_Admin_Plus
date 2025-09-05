<?php

	/*
		HORA ORIGINAL DE ENTRADA DEL SCRIPT
			$tin = date('H:i:s');
    */
    
			////////////////////		***********  		////////////////////
            
// SI NO QUIERO REDONDEO DE HORARIO COMENTAR DESDE AQUÍ ...

	// REDONDEO DE LA HORA ENTRADA
        /* HORA MODIFICADA */
            global $h;
            $h = date('H');
            global $m;
            $m = date('i');

    // REDONDEO LOS SEGUNDOS A 00 SIEMPRE
        global $s;
        $s = "00";

        // REDONDEO LOS MINUTOS DE ENTRADA PENALIZANDO DE 10 EN 10
        if(($m > 2)&&($m <= 10)){ $m = 10; }
        elseif(($m > 10)&&($m <= 20)){  global $m;
                                        $m = 20;
                                        }
        elseif(($m > 20)&&($m <= 32)){  global $m;
                                        $m = 30;
                                        }
        // REDONDEO LOS MINUTOS DE ENTRADA PENALIZANDO DE 20
        elseif(($m > 33)&&($m < 50)){ global $m;
                                      $m = 40;
                                      }
        // REDONDEO DOS MINUTOS DE EMPUNTO A 00
        elseif($m <= 2){ $m = "00"; }

        // SI FALTAN 10 MINUTOS PARA EMPUNTO REDONDEO LA HORA A LA SIGUIENTE Y MINUTOS A 00
            if($m >= 50){  global $h;
                            $h = date('H')+1;
                            global $m;
                            $m = 00;
                            }

        global $tin;
        $tin = $h.":".$m.":".$s;
        //print ($tin);

    // FIN REDONDEO HORA DE ENTRADA

// SI NO QUIERO REDONDEO DE HORARIO COMENTAR HASTA AQUÍ ...

			////////////////////		***********  		////////////////////

?>