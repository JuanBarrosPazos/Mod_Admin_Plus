<?php

	global $CheckDatos;

	if(isset($_POST['oculto1'])){	$_SESSION['usuarios'] = $_POST['usuarios'];
									$defaults = $_POST;
									// print("* ".$_SESSION['usuarios']);
	}elseif(isset($_POST['todo'])){

		if(!isset($_POST['cherror'])){ $CheckDatos = ""; }else{ $CheckDatos = "checked='checked'"; }
		//echo "*** ".$_POST['cherror']." *** ".$CheckDatos."<br>";
		$defaults = array ('id' => isset($_POST['id']),
							'dy' => $_POST['dy'],
							'dm' => $_POST['dm'],
							'dd' => $_POST['dd'],
							'Orden' => @$_POST['Orden'],
							'usuarios' => $_SESSION['usuarios'],
							'cherror' => @$_POST['cherror'],);
	}
	
	$dm = array('' => 'MONTH','01' => 'ENERO','02' => 'FEBRER','03' => 'MARZO',
				'04' => 'ABRIL','05' => 'MAYO','06' => 'JUNIO','07' => 'JULIO',
				'08' => 'AGOSTO','09' => 'SEPTIE','10' => 'OCTUBR','11' => 'NOVIEM',
				'12' => 'DICIEM');
	
	$dd = array('' => 'DAY','01' => '01','02' => '02','03' => '03',
				'04' => '04','05' => '05','06' => '06','07' => '07',
				'08' => '08','09' => '09','10' => '10','11' => '11',
				'12' => '12','13' => '13','14' => '14','15' => '15',
				'16' => '16','17' => '17','18' => '18','19' => '19',
				'20' => '20','21' => '21','22' => '22','23' => '23',
				'24' => '24','25' => '25','26' => '26','27' => '27',
				'28' => '28','29' => '29','30' => '30','31' => '31');
										
	$orden = array('`din` ASC' => 'Fecha In Asc',
					'`din` DESC' => 'Fecha In Desc',
					'`dout` ASC' => 'Fecha Out Asc',
					'`dout` DESC' => 'Fecha Out Desc',
					'`id` ASC' => 'ID Asc',
					'`id` DESC' => 'ID Desc');
	
	print("<div class='centradiv' style='padding:0.4em;'>
			<div style='margin:0.2em auto 0.4em auto;'>GESTIONAR REGISTROS HORARIOS</div>
		<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]' style='margin-right:6px'>
			<input type='hidden' name='ref' value='".@$_SESSION['usuarios']."' />
				<select name='usuarios' style='vertical-align:middle;'>
					<!--  --><option value=''>SELECCIONE UN USUARIO</option> ");

		global $db;
		global $tablau;			$tablau = "`".$_SESSION['clave']."admin`";
		global $sqlu;
		//$sqlu =  "SELECT * FROM $tablau WHERE (`del` = 'false' AND `nivel` <> 'locked') ORDER BY `ref` ASC ";
		$sqlu =  "SELECT * FROM $tablau WHERE `nivel` <> 'locked' ORDER BY `ref` ASC ";

		$qu = mysqli_query($db, $sqlu);
		if(!$qu){
				print("Modifique la entrada L.49 ".mysqli_error($db)."<br>");
		}else{
			while($rowu = mysqli_fetch_assoc($qu)){
				print ("<option value='".$rowu['ref']."' ");
				if($rowu['ref'] == @$defaults['usuarios']){
									print ("selected = 'selected'");
				}
				print ("> ".$rowu['Apellidos'].", ".$rowu['Nombre']." </option>");
			}
		}  

		print ("</select>
					<button type='submit' title='SELECCIONE UN USUARIO' class='botonverde imgButIco InicioBlack' style='vertical-align:middle;display:inline-block;' ></button>
				<input type='hidden' name='oculto1' value=1 />
			</form>
				</div>"); 
				
	if((isset($_POST['oculto1']))||(isset($_POST['todo']))){

		if($_SESSION['usuarios'] == ''){ 
			print("<div class='centradiv alertdiv'>SELECCIONE UN USUARIO</div>");
		}

		global $CheckDatos;
		if($_SESSION['usuarios'] != ''){
			require "../Users/".$_SESSION['usuarios']."/ayear.php";
			print("<div class='centradiv' style='padding:0.4em;'>
						<div style='margin:0.2em auto 0.4em auto;'>
							".$titulo." ".$_SESSION['usuarios']."
						</div>");
						
			print ("<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
						<select name='Orden'>");
							foreach($orden as $option => $label){
									print ("<option value='".$option."' ");
									if($option == @$defaults['Orden']){ print ("selected = 'selected'"); }
									print ("> $label </option>");
							}
				print ("</select>
						<select name='dy'>");
							foreach($dy as $optiondy => $labeldy){
								print ("<option value='".$optiondy."' ");
								if($optiondy == @$defaults['dy']){ print ("selected = 'selected'"); }
								print ("> $labeldy </option>");
							}	
				print ("</select>
						<select name='dm'>");
							foreach($dm as $optiondm => $labeldm){
								print ("<option value='".$optiondm."' ");
								if($optiondm == @$defaults['dm']){ print ("selected = 'selected'"); }
								print ("> $labeldm </option>");
							}	
				print ("</select>
						<select name='dd'>");
							foreach($dd as $optiondd => $labeldd){
								print ("<option value='".$optiondd."' ");
								if($optiondd == @$defaults['dd']){ print ("selected = 'selected'"); }
								print ("> $labeldd </option>");
							}	
				print ("</select>
						<input type='hidden' name='usuarios' value='".$defaults['usuarios']."' />
					<button type='submit' title='SELECCONAR USUARIO' class='botonverde imgButIco InicioBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
						<input type='hidden' name='todo' value=1 />

				<div style='text-align:left; margin: 0.2em 0.4em;'>
					<font color='#F1BD2D'>* </font>
					<input type='checkbox' name='cherror' value='".@$defaults['cherror']."' ".$CheckDatos." />
						VER SÓLO ERRORES
				</div>
					</form>
						</div>"); /* FIN print */
		} // FIN 2º if
	} // FIN 1º if Nivel Usuarios

?>