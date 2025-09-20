<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';

	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if($_SESSION['Nivel'] == 'admin'){

	master_index();

	if(isset($_POST['oculto2'])){	info_01();
									show_form();
	}elseif(isset($_POST['oculto'])){	process_form();
										info_02();
	}else{ show_form(); }

}else{ require '../Inclu/tabla_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

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

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;				global $db_name;

	global $diny;			$diny = substr($_POST['din'],0,4);
	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;			$vname = "`".$tabla1."_".$diny ."`";
	// SOLO EL AÑO ACTUAL		$vname = "`".$tabla1."_".date('Y')."`";

	global $FBaja;		$FBaja = date('Y-m-d');
	global $TBaja;		$TBaja = date('H:i:s');
	global $Titulo;		global $audioAudi;
	global $sql;
	if(isset($_POST['recupera'])){
		$Titulo = "RECUPERADO EL REGISTRO";
		$sql = "UPDATE `$db_name`.$vname SET `del`='false',`dfeed`='$FBaja',`tfeed`='$TBaja' WHERE $vname.`id`='$_POST[id]' LIMIT 1 ";
		$audioAudi = "file_recovered.mp3";
	}elseif(isset($_POST['elimina'])){
		$Titulo = "ELIMINADO EL REGISTRO";
		$sql = "DELETE FROM `$db_name`.$vname WHERE $vname.`id`='$_POST[id]' LIMIT 1 ";
		$audioAudi = "file_deleted.mp3";
	}else{ 
		$Titulo = "REGISTRO BORRADO";
		$sql = "UPDATE `$db_name`.$vname SET `del`='true',`dfeed`='$FBaja',`tfeed`='$TBaja' WHERE $vname.`id`='$_POST[id]' LIMIT 1 ";
		$audioAudi = "file_bin.mp3";
	}

	$tabla = "<table class='TFormAdmin alertdiv'>
				<tr>
					<td colspan=2 style='text-align:center !important;color:#F1BD2D;'>
						".$Titulo."
					</td>
				</tr>
				<tr>
					<td>USER NAME</td>
					<td>".$_POST['name1']." ".$_POST['name2']."</td>
				</tr>
				<tr>
					<td>ID</td><td>".$_POST['id']."</td>
				</tr>
				<tr>
					<td>USER REF</td><td>".$_SESSION['usuarios']."</td>
				</tr>
				<tr>
					<td>DATE IN</td><td>".$_POST['din']."</td>
				</tr>
				<tr>
					<td>TIME IN</td><td>".$_POST['tin']."</td>
				</tr>
				<tr>
					<td>DATE OUT</td><td>".$_POST['dout']."</td>
				</tr>
				<tr>
					<td>TIME OUT</td><td>".$_POST['tout']."</td>
				</tr>
				<tr>
					<td>TIME TOTAL</td><td>".$_POST['ttot']."</td>
				</tr>
				<tr>
					<td colspan=2>
						<form name='volver' action='Reg_Fichar_Ver.php'>
				<button type='submit' title='INICIO FICHAR FILTRO DE EMPLEADOS' class='botonazul imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
						</form>
					</td>
				</tr>
			</table>
				<audio src='../audi/".$audioAudi."' autoplay></audio>
			<script type='text/javascript'>
				function redir(){window.location.href='Reg_Fichar_Ver.php';}
				setTimeout('redir()',8000);
			</script>";
	
	echo "** ".$sql."<br>";
	
	if(mysqli_query($db, $sql)){

			print($tabla);
			suma_todo();
			global $dir;			$dir = "../Users/".$_SESSION['usuarios']."/mrficha";
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

	}else{	print("ERROR SQL L.102 ".mysqli_error($db))."</br>";
			show_form ();
	}
	
} // FIN fucntion process_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $db;				global $db_name;
	global $recupera;		global $elimina;		global $Titulo;
	global $input1;			global $input2;			
	global $ButtonIco;		global $ButtonColor;	global $defaults;

	if(isset($_POST['oculto'])){
		$defaults = $_POST;
	}elseif(isset($_POST['oculto2'])){

		if(isset($_POST['recupera'])){
			$recupera = $_POST['recupera'];
			$elimina = "";
			$input1 = "<input type='hidden' name='recupera' value='".$defaults['recupera']."' />";
			$Titulo = "RECUPERAR REGISTRO";
			$ButtonIco = "Clock2Black";
			$ButtonColor = "botonverde";
			print("<audio src='../audi/file_for_recovered.mp3' autoplay></audio>");
		}elseif(isset($_POST['elimina'])){
			$recupera = "";
			$elimina = $_POST['elimina'];
			$input2 = "<input type='hidden' name='elimina' value='".$defaults['elimina']."' />";
			$Titulo = "ELIMINAR REGISTRO";
			$ButtonIco = "DeleteBlack";
			$ButtonColor = "botonrojo";
			print("<audio src='../audi/file_for_deleted.mp3' autoplay></audio>");
		}else{ 
			$elimina = "";			$recupera = "";
			$input1 = "";			$input2 = "";
			$Titulo = "BORRAR ENTRADA";
			$ButtonIco = "DeleteBlack";
			$ButtonColor = "botonnaranja";
			print("<audio src='../audi/file_for_bin.mp3' autoplay></audio>");
		}

		$defaults = array (	'id' => $_POST['id'],
						   	'ref' => $_SESSION['usuarios'],
							'name1' => $_POST['name1'],
							'name2' => $_POST['name2'],
							'din' => $_POST['din'],
							'tin' => $_POST['tin'],
							'dout' => $_POST['dout'],
							'tout' => $_POST['tout'],
							'ttot' => $_POST['ttot'],
							'recupera' => $recupera,
							'elimina' => $elimina,);
	}

	print("<table class='TFormAdmin'>
			<tr>
				<td colspan=2 style='text-align:center !important;color:#F1BD2D;'>
					".$Titulo."
				</td>
			</tr>
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
					<input type='hidden' name='din' value='".$defaults['din']."' />
					<input type='hidden' name='tin' value='".$defaults['tin']."' />
					<input type='hidden' name='dout' value='".$defaults['dout']."' />
					<input type='hidden' name='tout' value='".$defaults['tout']."' />
					<input type='hidden' name='ttot' value='".$defaults['ttot']."' />
					".$input1.$input2."
					<input type='hidden' name='oculto' value=1 />
				<button type='submit' title='".$Titulo."' class='".$ButtonColor." imgButIco ".$ButtonIco."' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
		</form>	
			<a href='Reg_Fichar_Ver.php'>
				<button type='button' title='INICIO FICHAR FILTRO DE EMPLEADOS' class='botonazul imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			</a>											
				</td>
			</tr>
		</table>");

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

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

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

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

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */

?>