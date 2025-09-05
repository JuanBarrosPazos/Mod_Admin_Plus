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

	if(isset($_POST['entrada'])){ entrada();
								  errors();
								  info();
	}elseif(isset($_POST['salida'])){ 
							salida();
							errors();
							info();
	}else{ 	show_form();
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
					<td class='BorderInf'>HORA ENTRADA</td>
					<td class='BorderInf'>".$_POST['tin']."</td>
				</tr>
				<tr>
					<td valign='middle' colspan=4 align='center'>
						<form name='volver' action='$_SERVER[PHP_SELF]' >
									<input type='submit' value='VOLVER FICHAR OTROS' class='botonverde' />
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
	
	global $db;				global $db_name;

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
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
			$text = PHP_EOL."** NOMBRE: ".$_POST['name1']." ".$_POST['name2'];
			$text = $text.PHP_EOL."\t- USER REF: ".isset($_POST['usuarios']);
			$text = $text.PHP_EOL."\t- FICHA ENTRADA ".$_POST['din']." / ".$_POST['tin'];
				
			$rmfdocu = $_SESSION['usuarios'];
			$rmfdate = date('Y_m');
			$rmftext = $text.PHP_EOL;
			$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
			$rmf = fopen($filename, 'ab+');
			fwrite($rmf, $rmftext);
			fclose($rmf);
		
		}else{	print("* MODIFIQUE LA ENTRADA L.211: ".mysqli_error($db));
				show_form ();
				global $texerror;			$texerror = PHP_EOL."\t ".mysqli_error($db);
		}
	}
	
} // FIN function entrada

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){
	
	global $titulo;			$titulo = "FICHAR JORNADA OTROS EMPLEADOS";

	unset($_SESSION['usuarios']);

	require 'Inc_Show_Form_Ficha_otr.php';

}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_todo(){
		
	global $db;				global $db_name;
	
	global $dyt;			$dyt = date('Y');
	global $dm;				$dm = "-".date('m')."-";
	global $dd;				$dd = '';
	global $fil;			$fil = $dyt.$dm."%";

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;			$vname = "`".$tabla1."_".$dyt."`";

	global $ruta;			$ruta = '../';
	require 'Inc_Suma_Todo.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function salida(){
	
	global $db;				global $db_name;

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;
	$vname = "`".$tabla1."_".date('Y')."`";

	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);
	$row1 = mysqli_fetch_assoc($q1);
	global $din;			$din = trim($row1['din']);
	global $tin;			$tin = trim($row1['tin']);
	global $in;				$in = $din." ".$tin;
	global $dout;			$dout = trim($_POST['dout']);
	global $tout;			$tout = trim($_POST['tout']);
	global $out;			$out = $dout." ".$tout;
	
	$fecha1 = new DateTime($in);//fecha inicial
	$fecha2 = new DateTime($out);//fecha de cierre

	global $difer;			$difer = $fecha1->diff($fecha2);
	//print ($difer);
	
	global $ttot;			$ttot = $difer->format('%H:%i:%s');

			///////////////////////			**********  		///////////////////////
	
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
		
		global $ttot;			$ttot = '68:68:68';
		global $text;
		$text = PHP_EOL."*** ERROR CONSULTE ADMIN SYSTEM ***";
		$text = $text.PHP_EOL."** NOMBRE: ".$_POST['name1']." ".$_POST['name2'];
		$text = $text.PHP_EOL."\t- FICHA SALIDA ".$_POST['dout']." / ".$_POST['tout'];
		$text = $text.PHP_EOL."\t- N HORAS: ".$ttot;
	/* Fin if >9 */			
	}else{	global $ttot;
			global $text;
			$text = PHP_EOL."** NOMBRE: ".$_POST['name1']." ".$_POST['name2'];
			$text = $text.PHP_EOL."\t- FICHA SALIDA ".$_POST['dout']." / ".$_POST['tout'];
			$text = $text.PHP_EOL."\t- N HORAS: ".$ttot;
	} /* Fin else >9 */
	
			///////////////////////			*********   		///////////////////////
	
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
					<td class='BorderInf'>HORAS REALIZADAS</td>
					<td class='BorderInf'>".$ttot."</td>
				</tr>
				<tr>
					<td valign='middle' colspan=4 align='center'>
						<form name='volver' action='$_SERVER[PHP_SELF]' >
							<input type='submit' value='VOLVER FICHAR OTROS' class='botonnaranja' />
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
		$text = $text.PHP_EOL."*** HORAS TOTALES MES ".date('Y')."-".date('m').": ".$sumatodo." ***";
		$text = $text.PHP_EOL."\t**********".PHP_EOL;
		$rmfdocu = $_SESSION['usuarios'];
		$rmfdate = date('Y_m');
		$rmftext = $text.PHP_EOL;
		$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
		$rmf = fopen($filename, 'ab+');
		fwrite($rmf, $rmftext);
		fclose($rmf);
			
	}else{ 	print("* MODIFIQUE LA ENTRADA L.698: ".mysqli_error($db));
			show_form ();
			global $texerror;			$texerror = PHP_EOL."\t ".mysqli_error($db);
	}
	
}	

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info(){

		//$ActionTime = date('H:i:s');

		global $dir;			$dir = "../Users/".$_SESSION['ref']."/log";
		global $text;

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

/* Creado por Juan Barros Pazos 2021/25 */

?>