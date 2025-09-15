<?php

    global $userdir;
    if($_SESSION['usuarios']==""){ $userdir = $_SESSION['ref'];; 
    }else{ $userdir = $_SESSION['usuarios'];}

	$dir = "../Users/".$userdir."/mrficha";
	$text = PHP_EOL."\t- NOMBRE: ".$_POST['name1']." ".$_POST['name2'];
	$text = $text.PHP_EOL."\t- USER REF: ".$_POST['ref'];
	$text = $text.PHP_EOL."** FICHA ENTRADA ".$_POST['din']." / ".$_POST['tin'];
				
	$rmfdocu = $userdir;
	$rmfdate = date('Y_m');
	$rmftext = $text.PHP_EOL;
	$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
	$rmf = fopen($filename, 'ab+');
	fwrite($rmf, $rmftext);
	fclose($rmf);

?>