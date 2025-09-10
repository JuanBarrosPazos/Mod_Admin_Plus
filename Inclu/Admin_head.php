<!DOCTYPE html>
	
<head>
	
<?php

	global $rutarequir;		global $winini;
	global $rutameta;		global $meta2;		global $meta3;
	
	if(isset($playinclu)){ 	$rutarequir = "";
							$rutameta = "../";
							$meta2 = "";
							$winini = "";
	}elseif(isset($playini)){ 
		$rutameta = "";
		$rutarequir = "Inclu/";
		$meta2 = "<link href='".$rutameta."Inclu/playini.css' rel='stylesheet' type='text/css' />
				  <script src='".$rutameta."Inclu/playhora.js' type='text/javascript'></script>";
		$winini ="<div id='ventana-flotante'>
		<a class='cerrar' href='javascript:void(0);' onclick='document.getElementById(&apos;ventana-flotante&apos;).className = &apos;oculto&apos;'>X</a>
		<div class='contenido' style=\"text-align:center; padding-top:22px\">
		DOWNLOAD THIS APP FREE AND MORE IN:<br>
		<a href=\"http://juanbarrospazos.blogspot.com.es/\" target=\"_blank\" >	
		http://juanbarrospazos.blogspot.com.es/</a></div></div>";

	}else{ 
			if(isset($index)){	$rutarequir = "Inclu/"; 
								$rutameta = "";
			}else{ 	$rutarequir = "../Inclu/"; 
					$rutameta = "../";}
					$meta2 = "";
					$winini = ""; 
	}

	if(isset($popup)){
		$meta3 = "<script src='".$rutameta."img_change_jscss/jquery-3.4.1.min.js'></script>
		<script src='".$rutameta."img_change_jscss/inputfile-custom.js'></script>
		<link href='".$rutameta."img_change_jscss/inputfile.css' rel='stylesheet' type='text/css'/>";
	}else{ $meta3 = ""; }
								
	require $rutarequir.'playmeta.php';

?>
	

<!-- CIERRO AUTO LA VENTANA DESPUES DE 3 SEGUNDOS	
	
	<script type="text/javascript">
		
		setTimeout("window.self.close();", 3000);
		
	</script>

 -->
	
</head>
	
	<?php
		if(isset($playini)){ 
			echo "<body topmargin=\"0\" onload=\"hora()\">";
			//echo $winini; 
		}else{ echo "<body topmargin=\"0\" >";} 
	?>
	
	<div id="page" >

	<?php
		echo "<a href='".$rutameta."Licencia.pdf' target='_blanck'>
				<img id='licencia' src='".$rutameta."Images/CC-BY-NC-SA.jpg'>
			</a>";
	?>

	<div id="header"> 
				<span style="font-size:1.4em">© JUAN BARROS PAZOS</span>
			<br>
				<span style="font-size: 0.8em;">Licencia CC BY-NC-SA</span>
			</br>
				<span style="font-size:1.1em;">
					Design & Programming in Palma de Mallorca
				</span>
	</div>

  <div style="clear:both"></div>
   
   <div style="margin-top:2px; text-align:center" id="headerTitulo">
   
		<?php
			if(isset($playini)){ 
				echo "<font color=\"#59746A\"><span id=\"hora\">000000</span></font>";
			}else{ } 
		?>
    
	</div>
			  <div style="clear:both"></div>

  <div id="pageContenido">



