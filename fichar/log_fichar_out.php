<?php

    global $userdir;
    if($_SESSION['usuarios']==""){ $userdir = $_SESSION['ref'];; 
    }else{ $userdir = $_SESSION['usuarios'];}

	$dir = "../Users/".$userdir."/mrficha";
		
	$text = $text.PHP_EOL."** HORAS TOTALES MES: ".$sumatodo;
	$text = $text.PHP_EOL."\t**********".PHP_EOL;
	$rmfdocu = $userdir;
	$rmfdate = date('Y_m');
	$rmftext = $text.PHP_EOL;
	$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
	$rmf = fopen($filename, 'ab+');
	fwrite($rmf, $rmftext);
	fclose($rmf);

?>