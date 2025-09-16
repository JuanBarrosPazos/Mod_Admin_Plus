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

///////////////////////////////////////////////////////////////////////////////////////////////

if($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['oculto2'])){	info_01();
									show_form();
	}elseif(isset($_POST['oculto'])){	process_form();
										info_02();
	}else{ show_form(); }

}else{ require '../Inclu/tabla_permisos.php'; } 

//////////////////////////////////////////////////////////////////////////////////////////////

function suma_todo(){
		
	global $db;				global $db_name;
	
	global $nm;
	$nm = substr($_POST['din'],5,2);
	$nm = str_replace(":","",$nm);

	global $dyt;			$dyt = date('Y');
	global $dm;				$dm = "-".$nm."-";
	global $dd;				$dd = '';
	global $fil;			$fil = $dyt.$dm."%";

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;			$vname = "`".$tabla1."_".date('Y')."`";

	global $ruta;			$ruta = '../';
	require 'Inc_Suma_Todo.php';

}

//////////////////////////////////////////////////////////////////////////////////////////////

function process_form(){
	
	global $db;				global $db_name;	
	
	$tabla = "<table class='TFormAdmin'>
				<tr>
					<th colspan=2>
						HA BORRADO ".$_POST['name1']." ".$_POST['name2']."
					</th>
				</tr>
				<tr>
					<td>ID</td><td>".$_POST['id']."</td>
				</tr>
				<tr>
					<td>REFERENCIA</td><td>".$_SESSION['usuarios']."</td>
				</tr>
				<tr>
					<td>FECHA ENTRADA</td><td>".$_POST['din']."</td>
				</tr>
				<tr>
					<td>HORA ENTRADA</td><td>".$_POST['tin']."</td>
				</tr>
				<tr>
					<td>FECHA SALIDA</td><td>".$_POST['dout']."</td>
				</tr>
				<tr>
					<td>HORA SALIDA</td><td>".$_POST['tout']."</td>
				</tr>
				<tr>
					<td>HORAS REALIZADAS</td><td>".$_POST['ttot']."</td>
				</tr>
				<tr>
					<td colspan=2>".$_SESSION['modifeo']."</td>
				</tr>
			</table>
			<embed src='../audi/delete_file.mp3' autostart='true' loop='false' ></embed>
			<script type='text/javascript'>
				function redir(){window.location.href='Reg_Fichar_Modificar.php';}
				setTimeout('redir()',8000);
			</script>";	
		
	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;			$vname = "`".$tabla1."_".date('Y')."`";

	$sql = "DELETE FROM `$db_name`.$vname WHERE $vname.`id` = '$_POST[id]' LIMIT 1 ";
	
	if(mysqli_query($db, $sql)){ 
			feedback();
			print($tabla);
			suma_todo();
			global $dir;
			$dir = "../Users/".$_SESSION['usuarios']."/mrficha";
			global $nm;
			$nm = substr($_POST['din'],5,2);
			$nm = str_replace(":","",$nm);

			global $sumatodo;
			global $text;
			$text = "** HORARIO MODIFICADO FECHA: ".date('Y_m_d / H:i:s').".";
			$text = $text.PHP_EOL."** HORARIO ELIMINADO: ";
			$text = $text.PHP_EOL."** ENTRADA: ".$_POST['din']." / ".$_POST['tin'].".";
			$text = $text.PHP_EOL."** SALIDA: ".$_POST['dout']." / ".$_POST['tout'].".";
			$text = $text.PHP_EOL."** TOTAL TIME: ".$_POST['ttot'].".";
			
			$text = $text.PHP_EOL."** HORAS TOTALES MES ".date('Y')."-".$nm.": ".$sumatodo;
			$text = $text.PHP_EOL."\t**********".PHP_EOL;
			$rmfdocu = $_SESSION['usuarios'];
			$rmfdate = date('Y_').$nm;
			$rmftext = $text.PHP_EOL;
			$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
			$rmf = fopen($filename, 'ab+');
			fwrite($rmf, $rmftext);
			fclose($rmf);

	}else{	print("ERROR SQL ".mysqli_error($db))."</br>";
			show_form ();
	}
	
} // FIN fucntion process_form

//////////////////////////////////////////////////////////////////////////////////////////////

function show_form(){

	global $db;				global $db_name;
	
	if(isset($_POST['oculto'])){
		$defaults = $_POST;
	}elseif(isset($_POST['oculto2'])){
		$defaults = array (	'id' => $_POST['id'],
						   'ref' => $_SESSION['usuarios'],
							'name1' => $_POST['name1'],
							'name2' => $_POST['name2'],
							'din' => $_POST['din'],
							'tin' => $_POST['tin'],
							'dout' => $_POST['dout'],
							'tout' => $_POST['tout'],
							'ttot' => $_POST['ttot']);
	}

	print("<table class='TFormAdmin'>
			<tr>
				<td>ID</td>
				<td>
		<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]'>
					".$defaults['id']."
				</td>
			</tr>
			<tr>
				<td>USER REF</td>
				<td>".$_SESSION['usuarios']."</td>
			</tr>
			<tr>
				<td>NOMBRE</td>
				<td>".$defaults['name1']."</td>
				
			</tr>
			<tr>
				<td>APELLIDOS</td>
				<td>".$defaults['name2']."</td>
			</tr>
			<tr>
				<td>DATE IN</td>
				<td>".$defaults['din']."</td>
			</tr>
			<tr>
				<td>TIME IN</td>
				<td>".$defaults['tin']."</td>
				
			</tr>
			<tr>
				<td>DATE OUT</td>
				<td>".$defaults['dout']."</td>
			</tr>
			<tr>
				<td>TIME OUT</td>
				<td>".$defaults['tout']."</td>
			</tr>
			<tr>
				<td>TIME TOTAL</td>
				<td>".$defaults['ttot']."</td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='hidden' name='id' value='".$defaults['id']."' />
					<input type='hidden' id='ref' name='ref' value='".$_SESSION['usuarios']."' />
					<input type='hidden' name='name1' value='".$defaults['name1']."' />
					<input type='hidden' name='name2' value='".$defaults['name2']."' />
					<input name='din' type='hidden' value='".$defaults['din']."' />
					<input name='tin' type='hidden' value='".$defaults['tin']."' />
					<input name='dout' type='hidden' value='".$defaults['dout']."' />
					<input name='tout' type='hidden' value='".$defaults['tout']."' />
					<input name='ttot' type='hidden' value='".$defaults['ttot']."' />
					<input type='hidden' name='oculto' value=1 />
				<button type='submit' title='BORRAR DATOS' class='botonrojo imgButIco DeleteBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
		</form>	
			<a href='Reg_Fichar_Modificar.php'>
				<button type='button' title='FICHAR FILTRO DE EMPLEADOS' class='botonazul imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			</a>												
				</td>
			</tr>
		</table>"); 
}

/////////////////////////////////////////////////////////////////////////////////////////////////

function feedback(){
	
	global $db;				global $db_name;
	global $tfeed;			$dfeed = date('Y-m-d');
	global $tfeed;			$tfeed = date('H:i:s');

	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;			$vname = "`".$tabla1."_feed`";

	$sqla = "INSERT INTO `$db_name`.$vname (`ref`, `Nombre`, `Apellidos`, `din`, `tin`, `dout`, `tout`, `ttot`, `dfeed`, `tfeed`) VALUES ('$_POST[ref]', '$_POST[name1]', '$_POST[name2]', '$_POST[din]', '$_POST[tin]', '$_POST[dout]', '$_POST[tout]', '$_POST[ttot]', '$dfeed', '$tfeed')";
		
	if(mysqli_query($db, $sqla)){ 
	}else{	print("* MODIFIQUE LA ENTRADA L.308: ".mysqli_error($db));
			global $texerror;			$texerror = PHP_EOL."\t ".mysqli_error($db);
	}
	
}	

/////////////////////////////////////////////////////////////////////////////////////////////////

function info_01(){

    global $orden;
	require '../Inclu/orden.php';
		
	global $ttot;

	$ActionTime = date('H:i:s');

	global $dir;			$dir = "../Users/".$_SESSION['usuarios']."/log";

	global $text;
	$text = PHP_EOL."- JORNADA LABORAL BORRAR SELECCIONADO ".$ActionTime;
	$text = $text.PHP_EOL."\tNº REF: ".$_SESSION['usuarios'];
	$text = $text.PHP_EOL."\tNOMBRE: ".$_POST['name1'];
	$text = $text.PHP_EOL."\tAPELLIDOS: ".$_POST['name2'];
	$text = $text.PHP_EOL."\tID: ".$_POST['id'];
	$text = $text.PHP_EOL."\tDATE IN: ".$_POST['din'];
	$text = $text.PHP_EOL."\tTIME IN: ".$_POST['tin'];
	$text = $text.PHP_EOL."\tDATE OUT: ".$_POST['dout'];
	$text = $text.PHP_EOL."\tTIME OUT: ".$_POST['tout'];
	$text = $text.PHP_EOL."\tTIME TOTAL: ".$ttot;

	$logdocu = $_SESSION['usuarios'];
	$logdate = date('Y-m-d');
	$logtext = $text.PHP_EOL;
	$filename = $dir."/".$logdate."_".$logdocu.".log";
	$log = fopen($filename, 'ab+');
	fwrite($log, $logtext);
	fclose($log);

}

/////////////////////////////////////////////////////////////////////////////////////////////////

function info_02(){

		global $ttot;

		$ActionTime = date('H:i:s');

		global $dir;				$dir = "../Users/".$_SESSION['usuarios']."/log";
	
		global $text;
		$text = PHP_EOL."- JORNADA LABORAL BORRAR 2 ".$ActionTime;
		$text = $text.PHP_EOL."\tNº REF: ".$_SESSION['usuarios'];
		$text = $text.PHP_EOL."\tNOMBRE: ".$_POST['name1'];
		$text = $text.PHP_EOL."\tAPELLIDOS: ".$_POST['name2'];
		$text = $text.PHP_EOL."\tID: ".$_POST['id'];
		$text = $text.PHP_EOL."\tDATE IN: ".$_POST['din'];
		$text = $text.PHP_EOL."\tTIME IN: ".$_POST['tin'];
		$text = $text.PHP_EOL."\tDATE OUT: ".$_POST['dout'];
		$text = $text.PHP_EOL."\tTIME OUT: ".$_POST['tout'];
		$text = $text.PHP_EOL."\tTIME TOTAL: ".$ttot;

		$logname = $_SESSION['Nombre'];	
		$logape = $_SESSION['Apellidos'];	
		$logname = trim($logname);	
		$logape = trim($logape);	
		$logdocu = $_SESSION['usuarios'];
		$logdate = date('Y-m-d');
		$logtext = $text.PHP_EOL;
		$filename = $dir."/".$logdate."_".$logdocu.".log";
		$log = fopen($filename, 'ab+');
		fwrite($log, $logtext);
		fclose($log);

}

/////////////////////////////////////////////////////////////////////////////////////////////////
	
function master_index(){
		
	require '../Inclu_MInd/rutafichar.php';
	require '../Inclu_MInd/Master_Index.php';
		
} /* Fin funcion master_index.*/

/////////////////////////////////////////////////////////////////////////////////////////////////

	require '../Inclu/Admin_Inclu_footer.php';

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>