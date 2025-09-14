<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

	/*
		global $table_name_a;
		$table_name_a = "`".$_SESSION['clave']."admin`";
		$sqld =  "SELECT * FROM $table_name_a WHERE `ref` = '$_SESSION[ref]' AND `Usuario` = '$_SESSION[Usuario]'";
		$qd = mysqli_query($db, $sqld);
		$rowd = mysqli_fetch_assoc($qd);
	*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if(($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')){
 					
	master_index();

	if(isset($_POST['entrada'])){
								entrada();
								errors();
								info();
	}elseif(isset($_POST['salida'])){
					salida();
					errors();
					info();
	}else{	show_form();
			errors();
	}

}else{ require '../Inclu/tabla_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function errors(){
	
	global $db; 	global $db_name; 	global $sesus;

	if(isset($_SESSION['usuarios'])){
				$sesus = $_SESSION['usuarios'];
	}else{ $sesus = $_SESSION['ref']; }

	require 'Inc_errors.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function entrada(){
	
	global $tabla;
	$tabla = "<table align='center' style='margin-top:10px' width=320px >
				<tr>
					<th colspan=4 class='BorderInf'>
						HA FICHADO LA ENTRADA </br>".$_POST['name1']." ".$_POST['name2']."
					</th>
				</tr>
				<tr>
					<td>REFERENCIA</td><td>".$_POST['ref']."</td>
				</tr>
				<tr>
					<td>FECHA ENTRADA</td><td>".$_POST['din']."</td>
				</tr>
				<tr>
					<td>HORA ENTRADA</td><td>".$_POST['tin']."</td>
				</tr>
				<tr>
					<td colspan=2 class='BorderSup' align='center'>
						<form name='fichatodos' action='$_SERVER[PHP_SELF]'>
							<input type='submit' value='VOLVER PANTALLA INICIO' class='botonnaranja' />
							<input type='hidden' name='volver' value=1 />
						</form>
					</td>
				</tr>
			</table>
			<embed src='../audi/entrada.mp3' autostart='true' loop='false' ></embed>
			<script type='text/javascript'>
				function redir(){window.location.href='fichar_Crear_tds.php';}
					setTimeout('redir()',8000);
			</script>";	
	
	global $db; 			global $db_name;

	$tabla1 = $_SESSION['clave'].$_SESSION['usuarios'];
	$tabla1 = strtolower($tabla1);
	global $vname;			$vname = "`".$tabla1."_".date('Y')."`";

	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);
	
	if($count1 > 0){ 
		print("<table align='center' style='margin-top:10px' width=320px >
				<tr>
					<th colspan=4 class='BorderInf'>
						<font color='#FF0000'>
							ERROR YA HA FICHADO LA ENTRADA </br>".$_POST['name1']." ".$_POST['name2']."
						</font>
					</th>
				</tr>
			</table>".$tabla);
	}else{
	
		$sqla = "INSERT INTO `$db_name`.$vname (`ref`, `Nombre`, `Apellidos`, `din`, `tin`, `dout`, `tout`, `ttot`) VALUES ('$_POST[ref]', '$_POST[name1]', '$_POST[name2]', '$_POST[din]', '$_POST[tin]', '$_POST[dout]', '$_POST[tout]', '$_POST[ttot]')";
			
		if(mysqli_query($db, $sqla)){ 
				
			print($tabla); 
				
			global $dir;			$dir = "../Users/".$_SESSION['usuarios']."/mrficha";

			global $text;
			$text = PHP_EOL."\t- NOMBRE: ".$_POST['name1']." ".$_POST['name2'];
			$text = $text.PHP_EOL."\t- USER REF: ".$_POST['ref'];
			$text = $text.PHP_EOL."** FICHA ENTRADA ".$_POST['din']." / ".$_POST['tin'];
				
			$rmfdocu = $_SESSION['usuarios'];
			$rmfdate = date('Y_m');
			$rmftext = $text.PHP_EOL;
			$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
			$rmf = fopen($filename, 'ab+');
			fwrite($rmf, $rmftext);
			fclose($rmf);
		
		}else{ 	print("* MODIFIQUE LA ENTRADA L.212: ".mysqli_error($db));
				show_form ();
				global $texerror;			$texerror = PHP_EOL."\t ".mysqli_error($db);
		}
	}
	
} // FIN FUNCTION entrada();

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
	
	global $db;			global $db_name;

	global $table_name_a; 	$table_name_a = "`".$_SESSION['clave']."admin`";

	if(isset($_POST['volver'])){ unset($_SESSION['usuarios']); }

	if(isset($_POST['oculto1'])){	
				$_SESSION['usuarios'] = $_POST['usuarios'];
				$defaults = $_POST;
				//print("* ".$_SESSION['usuarios']);
	}else{
		if(($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')){ 
			$sqlb =  "SELECT * FROM $table_name_a ORDER BY `id` ASC ";
			$qb = mysqli_query($db, $sqlb);
		}
	
		if(!$qb){
			print("<font color='#FF0000'>Modifique la entrada L.265: </font></br>".mysqli_error($db)."</br>");
		}else{
			if(mysqli_num_rows($qb)== 0){
				print ("<table align='center'>
							<tr>
								<td><font color='#FF0000'>NO HAY DATOS</font></td>
							</tr>
						</table>");
			}else{

				global $ficharCrear;		$ficharCrear = 2;
				require 'fichar_Crear_Botonera.php';

				unset($_SESSION['usuarios']);
				print ("<table align='center'>
							<tr>
								<th colspan=5 class='BorderInf'>
							SELECCIONE SU USUARIO Y FICHE ENTRADA O SALIDA.
								</th>
							</tr>
							<tr>
								<th colspan=5 class='BorderInf'>
							Todos los usuarios : ".mysqli_num_rows($qb)." Resultados.
								</th>
							</tr>
							<tr>
								<th class='BorderInfDch'></th>
								<th class='BorderInfDch'>Referencia</th>
								<th class='BorderInfDch'>Nombre</th>
								<th class='BorderInfDch'>Apellidos</th>
								<th class='BorderInf'></th>
							</tr>");
			
	while($rowb = mysqli_fetch_assoc($qb)){
 			
		print("<tr align='center'>
				<td class='BorderInfDch'>
		<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
			<input name='id' type='hidden' value='".$rowb['id']."' />
			<input name='myimg' type='hidden' value='".$rowb['myimg']."' />
				<img src='../Users/".$rowb['ref']."/img_admin/".$rowb['myimg']."' height='40px' width='30px' />
				</td>
				<td class='BorderInfDch'>
			<input name='usuarios' type='hidden' value='".$rowb['ref']."' />".strtoupper($rowb['ref'])."
				</td>
				<td class='BorderInfDch'>
			<input name='name1' type='hidden' value='".$rowb['Nombre']."' />".$rowb['Nombre']."
				</td>
				<td class='BorderInfDch'>
			<input name='name2' type='hidden' value='".$rowb['Apellidos']."' />".$rowb['Apellidos']."
				</td>
				<td align='right' class='BorderInf'>
			<input type='submit' value='SELECCIONAR USUARIO ".strtoupper($rowb['ref'])."' class='botonlila' />
			<input type='hidden' name='oculto1' value=1 />
		</form>
				</td>
		</tr>");
	} // Fin while. 

	print("</table>");
			
			} // Fin else 3. 
		} // Fin else 2.
	} // Fin else 1.
	
			////////////////////		**********  		////////////////////
			
	if(isset($_POST['oculto1'])){
		if($_SESSION['usuarios'] == ''){ 
			print("<table align='center' style=\"margin-top:20px;margin-bottom:20px\">
					<tr align='center'>
						<td><font color='red'>SELECCIONE UN USUARIO</font></td>
					</tr>
				</table>");
		}

		if($_SESSION['usuarios'] != ''){
		
			$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
			global $vname;			$vname = "`".$tabla1."_".date('Y')."`";
		
			$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1";
			$q1 = mysqli_query($db, $sql1);
			$count1 = mysqli_num_rows($q1);
			//print($count1);
			
		if($count1 < 1){
			global $din;			$din = date('Y-m-d');
			global $tin;
		/*
			HORA ORIGINAL DE ENTRADA DEL SCRIPT
			$tin = date('H:i:s');
		*/

		require 'fichar_redondeo_in.php';

		global $dout; 			$dout = '';
		global $tout; 			$tout = '00:00:00';
		global $ttot;			$ttot = '00:00:00';
		
		print("<table align='center' style=\"margin-top:10px\">
				<tr>
					<td>
			<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$_POST['myimg']."' height='40px' width='30px' />
					</td>
					<td>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
			<input type='hidden' id='ref' name='ref' value='".$_SESSION['usuarios']."' />".strtoupper($_SESSION['usuarios'])."
					</td>
					<td>
			<input type='hidden' id='name1' name='name1' value='".$_POST['name1']."' />
			<input type='hidden' id='name2' name='name2' value='".$_POST['name2']."' />
				".strtoupper($_POST['name1'])." ".strtoupper($_POST['name2'])."
					</td>
			<input type='hidden' id='din' name='din' value='".$din."' />
			<input type='hidden' id='tin' name='tin' value='".$tin."' />
			<input type='hidden' id='dout' name='dout' value='".$dout."' />
			<input type='hidden' id='tout' name='tout' value='".$tout."' />
			<input type='hidden' id='ttot' name='ttot' value='".$ttot."' />
					<td valign='middle'  align='center'>
			<input type='submit' value='FICHAR ENTRADA' class='botonverde' />
			<input type='hidden' name='entrada' value=1 />
		</form>														
					</td>
					<td valign='middle'  align='center'>
			<form name='volver' action='$_SERVER[PHP_SELF]' >
				<input type='submit' value='CANCELAR Y VOLVER' class='botonnaranja' />
				<input type='hidden' name='volver' value=1 />
			</form>
				</td>
			</tr></table>"); 
		}elseif($count1 > 0){
		
			global $dout;	$dout = date('Y-m-d'); 	global $tout; 	global $ttot;
			/*
				HORA ORIGINAL DE SALIDA DEL SCRIPT
				$tout = date('H:i:s');
			*/

			require 'fichar_redondeo_out.php';

			print("<table align='center' style=\"margin-top:10px\">
					<tr>
						<td>
				<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$_POST['myimg']."' height='40px' width='30px' />
						</td>
						<td>
				<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
					<input type='hidden' id='ref' name='ref' value='".$_SESSION['usuarios']."' />".strtoupper($_SESSION['usuarios'])."
						</td>
						<td>
					<input type='hidden' id='name1' name='name1' value='".$_POST['name1']."' />
					<input type='hidden' id='name2' name='name2' value='".$_POST['name2']."' />
						".strtoupper($_POST['name1'])." ".strtoupper($_POST['name2'])."
						</td>
					<input type='hidden' id='dout' name='dout' value='".$dout."' />
					<input type='hidden' id='tout' name='tout' value='".$tout."' />
						<td valign='middle'  align='center'>
					<input type='submit' value='FICHAR SALIDA' class='boton' class='botonverde' />
					<input type='hidden' name='salida' value=1 />
				</form>														
						</td>
						<td valign='middle'  align='center'>
				<form name='volver' action='$_SERVER[PHP_SELF]' >
					<input type='submit' value='CANCELAR Y VOLVER' class='botonnaranja' />
					<input type='hidden' name='volver' value=1 />
				</form>
						</td>
					</tr></table>"); 
			}
		} // fin 2º if
	} // fin 1º if
	
} // FIN FUNCTION show_form()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_todo(){
		
	global $db; 			global $db_name;
	global $dyt1; 			$dyt1 = date('Y');
	global $dm1; 			$dm1 = date('m');
	global $dd1; 			$dd1 = '';
	global $fil; 			$fil = "%".$dyt1."-%".$dm1."%-".$dd1."%";

	$tabla1 = $_SESSION['clave'].$_SESSION['usuarios'];
	$tabla1 = strtolower($tabla1);
	global $vname;			$vname = "`".$tabla1."_".$dyt1."`";

	global $ruta;			$ruta = '../';
	require 'Inc_Suma_Todo.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function salida(){
	
	global $db; 			global $db_name;
	$tabla1 = $_SESSION['clave'].$_SESSION['usuarios'];
	$tabla1 = strtolower($tabla1);
	global $vname; 			$vname = "`".$tabla1."_".date('Y')."`";

	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);
	$row1 = mysqli_fetch_assoc($q1);
	global $din; 			$din = trim($row1['din']);
	global $tin; 			$tin = trim($row1['tin']);
	global $in;				$in = $din." ".$tin;
	global $dout;			$dout = trim($_POST['dout']);
	global $tout;			$tout = trim($_POST['tout']);
	global $out;			$out = $dout." ".$tout;
	
	$fecha1 = new DateTime($in);//fecha inicial
	$fecha2 = new DateTime($out);//fecha de cierre

	global $difer;			$difer = $fecha1->diff($fecha2);
	//print ($difer);
	
	global $ttot;			$ttot = $difer->format('%H:%i:%s');
	
			////////////////////		**********  		////////////////////
	
	$ttot1 = $difer->format('%H:%i:%s');
	$ttoth = substr($ttot1,0,2);
	$ttoth = str_replace(":","",$ttoth);
	
	$ttot2 = $difer->format('%d-%H:%i:%s');
	$ttotd = substr($ttot2,0,2);
	$ttotd = str_replace("-","",$ttotd);

	if(($ttoth > 9)||($ttotd > 0)){
		print("<table align='center' style='margin-top:10px' width=450px >
				<tr>
					<th class='BorderInf'>
					<b>
					<font color='#FF0000'>
						NO PUEDE FICHAR MÁS DE 10 HORAS.
						</br>
						PONGASE EN CONTACTO CON ADMIN SYSTEM.
					</font>
					</b>
					</th>
				 </tr>
				</table>");
		
		global $ttot;			$ttot = '00:00:01';
		global $text;
		$text = PHP_EOL."*** ERROR CONSULTE ADMIN SYSTEM ***";
		$text = $text.PHP_EOL."  - FICHA SALIDA ".$_POST['dout']." / ".$_POST['tout'];
		$text = $text.PHP_EOL."  - N HORAS: ".$ttot;

	/* fin if >9 */
	}else{	global $ttot;
			global $text;
			$text = PHP_EOL."** FICHA SALIDA ".$_POST['dout']." / ".$_POST['tout'];
			$text = $text.PHP_EOL."  - N HORAS: ".$ttot;
	} /* Fin else >9 */
	
	$tabla = "<table align='center' style='margin-top:10px' width=320px >
				<tr>
					<th colspan=4 class='BorderInf'>
						HA FICHADO LA SALIDA </br>".$_POST['name1']." ".$_POST['name2']."
					</th>
				</tr>
				<tr>
					<td>REFERENCIA</td><td>".$_POST['ref']."</td>
				</tr>
				<tr>
					<td>FECHA ENTRADA</td><td>".$din."</td>
				</tr>
				<tr>
					<td>HORA ENTRADA</td><td>".$tin."</td>
				</tr>
				<tr>
					<td>FECHA SALIDA</td><td>".$_POST['dout']."</td>
				</tr>
				<tr>
					<td>HORA SALIDA</td><td>".$_POST['tout']."</td>
				</tr>
				<tr>
					<td>HORAS REALIZADAS</td><td>".$ttot."</td>
				</tr>
				<tr>
					<td colspan=2 class='BorderSup' align='center'>
						<form name='volver' action='$_SERVER[PHP_SELF]' >
							<input type='submit' value='VOLVER PANTALLA INICIO' class='botonnaranja' />
							<input type='hidden' name='volver' value=1 />
						</form>
					</td>
				</tr>
			</table>
			<embed src='../audi/salida.mp3' autostart='true' loop='false' ></embed>
			<script type='text/javascript'>
				function redir(){window.location.href='fichar_Crear_tds.php';}
				setTimeout('redir()',8000);
			</script>";	
		
	//print($in." / ".$out." / ".$ttot."</br>");
	//echo $difer->format('%Y años %m meses %d days %H horas %i minutos %s segundos');
						//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos

	$sqla = "UPDATE `$db_name`.$vname SET `dout` = '$_POST[dout]', `tout` = '$_POST[tout]', `ttot` =  '$ttot' WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
		
	if(mysqli_query($db, $sqla)){ 
			
		print($tabla);
		suma_todo();

		global $dir;			$dir = "../Users/".$_SESSION['usuarios']."/mrficha";
			
		global $sumatodo;
		global $text;
		$text = $text.PHP_EOL."** HORAS TOTALES MES: ".$sumatodo;
		$text = $text.PHP_EOL."\t**********".PHP_EOL;
		$rmfdocu = $_SESSION['usuarios'];
		$rmfdate = date('Y_m');
		$rmftext = $text.PHP_EOL;
		$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
		$rmf = fopen($filename, 'ab+');
		fwrite($rmf, $rmftext);
		fclose($rmf);

	}else{	print("* MODIFIQUE LA ENTRADA L.471 ".mysqli_error($db));
			show_form ();
			global $texerror;			$texerror = PHP_EOL."\t ".mysqli_error($db);
	}
	
} // FIN FUNCTION salida()

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

	global $db; 			global $text; 	
	global $dir; 			$dir = "../Users/".$_SESSION['ref']."/log";
	
	$logdocu = $_SESSION['ref'];
	$logdate = date('Y-m-d');
	$logtext = $text.PHP_EOL;
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function master_index(){
		
	require '../Inclu_MInd/rutafichar.php';
	require '../Inclu_MInd/Master_Index.php';
		
} /* Fin funcion master_index.*/

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';

					   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>