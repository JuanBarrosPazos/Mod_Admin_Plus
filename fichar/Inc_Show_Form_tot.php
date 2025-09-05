<?php

	if(isset($_POST['oculto1'])){	$_SESSION['usuarios'] = $_POST['usuarios'];
									$defaults = $_POST;
									// print("* ".$_SESSION['usuarios']);
									}
	elseif(isset($_POST['todo'])){
		$defaults = array ('id' => isset($_POST['id']),
							'dy' => $_POST['dy'],
							'dm' => $_POST['dm'],
							'dd' => $_POST['dd'],
							'Orden' => isset($ordenar),
							'usuarios' => $_SESSION['usuarios']);
								} 
	
	$dm = array (	'' => 'MONTH',
					'01' => 'ENERO',
					'02' => 'FEBRER',
					'03' => 'MARZO',
					'04' => 'ABRIL',
					'05' => 'MAYO',
					'06' => 'JUNIO',
					'07' => 'JULIO',
					'08' => 'AGOSTO',
					'09' => 'SEPTIE',
					'10' => 'OCTUBR',
					'11' => 'NOVIEM',
					'12' => 'DICIEM');
	
	$dd = array (	'' => 'DAY',
					'01' => '01',
					'02' => '02',
					'03' => '03',
					'04' => '04',
					'05' => '05',
					'06' => '06',
					'07' => '07',
					'08' => '08',
					'09' => '09',
					'10' => '10',
					'11' => '11',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20',
					'21' => '21',
					'22' => '22',
					'23' => '23',
					'24' => '24',
					'25' => '25',
					'26' => '26',
					'27' => '27',
					'28' => '28',
					'29' => '29',
					'30' => '30',
					'31' => '31');
										
	$ordenar = array (	'`din` ASC' => 'Fecha In Asc',
						'`din` DESC' => 'Fecha In Desc',
						'`dout` ASC' => 'Fecha Out Asc',
						'`dout` DESC' => 'Fecha Out Desc',
						'`id` ASC' => 'ID Asc',
						'`id` DESC' => 'ID Desc');
	
	print("	<table align='center' style='border:1; margin-top:2px' width='auto'>

			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<input type='hidden' name='ref' value='".@$_SESSION['usuarios']."' />

					<tr>
						<td align='center'>
							".$titulo."
						</td>
					</tr>		
					<tr>
						<td>
						<div style='float:left; margin-right:6px'>
							<input type='submit' value='SELECCIONE UN USUARIO' class='botonlila' />
							<input type='hidden' name='oculto1' value=1 />
						</div>
						<div style='float:left'>

							<select name='usuarios'>
						<!-- <option value=''>SELECCIONE UN USUARIO</option> --> ");

	global $db;
	global $tablau;
	$tablau = $_SESSION['clave']."admin";
	$tablau = "`".$tablau."`";

	global $sqlu;
	$sqlu =  "SELECT * FROM $tablau ORDER BY `ref` ASC ";
	$qu = mysqli_query($db, $sqlu);
	if(!$qu){
			print("Modifique la entrada L.142 ".mysqli_error($db)."<br/>");
	}else{
		while($rowu = mysqli_fetch_assoc($qu)){
					print ("<option value='".$rowu['ref']."' ");
					if($rowu['ref'] == @$defaults['usuarios']){
										print ("selected = 'selected'");
													}
						print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
					}
				}  

		print ("</select>
					</div>
						</form>
							</td>
						</tr>
					</table>"); 

	if((isset($_POST['oculto1'])) || (isset($_POST['todo']))) {
		if($_SESSION['usuarios'] == '') { 
						print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
									<tr align='center'>
										<td>
											<font color='red'>
										SELECCIONE UN USUARIO
											</font>
										</td>
									</tr>
								</table>");
					}	
		if($_SESSION['usuarios'] != '') {

	require "../Users/".$_SESSION['usuarios']."/ayear.php";
			
	print("	<table align='center' style=\"border:0px;margin-top:4px\">
				<tr>
					<th colspan=2 class='BorderSup'>
					".$titulo." ".$_SESSION['usuarios']."
					</th>
				</tr>");
						
			///////////////////////			**********   		///////////////////////

	print ("<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
		<input type='hidden' name='usuarios' value='".$defaults['usuarios']."' />
				<tr>
					<td align='center' class='BorderSup'>
						<input type='submit' value='TODAS JORNADAS LABORALES' class='botonlila' />
						<input type='hidden' name='todo' value=1 />
					</td>
					<td class='BorderSup'>	

					<div style='float:left'>
						<select name='Orden'>");
						
				foreach($ordenar as $option => $label){
					print ("<option value='".$option."' ");
					if($option == @$defaults['Orden']){ print ("selected = 'selected'"); }
													print ("> $label </option>");
												}	
		print ("</select>
					</div>
						<div style='float:left'>
							<select name='dy'>");
					foreach($dy as $optiondy => $labeldy){
						print ("<option value='".$optiondy."' ");
						if($optiondy == @$defaults['dy']){ print ("selected = 'selected'"); }
														print ("> $labeldy </option>");
													}	
																
	print ("</select>
				</div>
					<div style='float:left'>
						<select name='dm'>");
				foreach($dm as $optiondm => $labeldm){
					print ("<option value='".$optiondm."' ");
					if($optiondm == @$defaults['dm']){ print ("selected = 'selected'"); }
													  print ("> $labeldm </option>");
														}	
																
	print ("</select>
				</div>
					<div style='float:left'>
						<select name='dd'>");
				foreach($dd as $optiondd => $labeldd){
					print ("<option value='".$optiondd."' ");
					if($optiondd == @$defaults['dd']){ print ("selected = 'selected'"); }
													print ("> $labeldd </option>");
														}	
																
	print ("</select>
				</div>
					</form>
						</td>
					</tr>
				</table>"); /* Fin del print */

					} // fin 2º if
			} // fin 1º if

?>