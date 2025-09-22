<?php

	global $din;			$din = trim($row1['din']);
	global $tin;			$tin = trim($row1['tin']);
	global $in;				$in = $din." ".$tin;
	
    global $dout;
    if(isset($_POST['dout'])){  $dout = trim($_POST['dout']);
    }elseif($dout != ""){  $dout = trim($dout);
    }else{ $dout = ""; }
				
	global $tout;
    if(isset($_POST['tout'])){ $tout = trim($_POST['tout']);
    }elseif($tout != ""){  $tout = trim($tout);
    }else{ $tout = ""; }
    
	global $out;			$out = $dout." ".$tout;

	$fecha1 = new DateTime($in);//fecha inicial
	$fecha2 = new DateTime($out);//fecha de cierre

	global $difer;			$difer = $fecha1->diff($fecha2);
	//print ($difer);
			
	global $ttot;			$ttot = $difer->format('%H:%i:%s');
	global $terror;			$terror = 'false';

	$ttot1 = $difer->format('%H:%i:%s');
	global $ttoth;
	$ttoth = substr($ttot1,0,2);
	$ttoth = str_replace(":","",$ttoth);
			
	$ttot2 = $difer->format('%d-%H:%i:%s');
	global $ttotd;
	$ttotd = substr($ttot2,0,2);
	$ttotd = str_replace("-","",$ttotd);
	
	global $text;
	if(($ttoth > 9)||($ttotd > 0)){
		print("<div class='centradiv alertdiv'>
				NO PUEDE FICHAR MÁS DE 10 HORAS.<br>PONGASE EN CONTACTO CON ADMIN SYSTEM.
		        </div>");
		
		global $ttot;				$ttot = '00:00:00';
		global $terror;				$terror = 'true';
		$text = PHP_EOL."*** ERROR CONSULTE ADMIN SYSTEM ***";
		$text = $text.PHP_EOL."\t- FICHA SALIDA ".$dout." / ".$tout;
		$text = $text.PHP_EOL."\t- N HORAS: ".$ttot;
		/* fin if >9 */
	}else{	
		global $ttot;
		$text = PHP_EOL."** F. SALIDA ".$dout." / ".$tout;
		$text = $text.PHP_EOL."\t- N HORAS: ".$ttot;
	} /* Fin else >9 */

?>