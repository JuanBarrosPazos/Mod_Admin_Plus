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

	if(isset($_POST['oculto2'])){ info_01();
								  show_form();
	}elseif(isset($_POST['oculto'])){
		if($form_errors = validate_form()){
					show_form($form_errors);
		}else{	process_form();
				info_02();
		}
	}else{ show_form(); }

}else{ require '../Inclu/tabla_permisos.php'; } 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function calc(){
	
	global $din;			$din = trim($_POST['din']);
	global $tin;			$tin = trim($_POST['tin']);
	global $in;				$in = $din." ".$tin;
	global $tinh;			$tinh = substr($_POST['tin'],0,2);
	
	global $dout;			$dout = trim($_POST['dout']);
	global $tout;			$tout = trim($_POST['tout']);
	global $out;			$out = $dout." ".$tout;
	
	$fecha1 = new DateTime($in);//fecha inicial
	$fecha2 = new DateTime($out);//fecha de cierre
	$difer = $fecha1->diff($fecha2);

	$ttot1 = $difer->format('%H:%i:%s');
	global $ttoth;
	$ttoth = substr($ttot1,0,2);
	$ttoth = str_replace(":","",$ttoth);
	$_SESSION['ttoth'] = $ttoth;

	$ttot2 = $difer->format('%d-%H:%i:%s');
	global $ttotd;
	$ttotd = substr($ttot2,0,2);
	$ttotd = str_replace("-","",$ttotd);
	$_SESSION['ttotd'] = $ttotd;

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
 
	global $sqld;			global $qd;
	//global $rowd;

	global $douty;			$douty = substr($_POST['dout'],0,4);
	global $datem;			$datem = date('m');
	global $doutm;			$doutm = substr($_POST['dout'],5,2);
	global $dated;			$dated = date('d');
	global $doutd;			$doutd = substr($_POST['dout'],-2);
	global $diny;			$diny = substr($_POST['din'],0,4);
	global $dind;			$dind = substr($_POST['din'],-2);
	global $dinm;			$dinm = substr($_POST['din'],5,2);

	/* 
	SOLO PERMITE MODIFICAR DATOS DEL AÑO CORRIENTE
	$datey = date('Y');
	SOLO PERMITE MODIFICAR DATOS SI EL AÑO ES EL MISMO QUE DE ENTRADA
	echo "* Year In: ".$datey."<br> * Year Out: ".$douty;
	 */
	global $datey;			$datey = substr($_POST['din'],0,4);
	global $th;				$th = 23;
	global $thms;			$thms = 59;
	global $touth;			$touth = substr($_POST['tout'],0,2);
	global $toutm;			$toutm = substr($_POST['tout'],3,2);
	global $touts;			$touts = substr($_POST['tout'],-2);

	global $din;			$din = trim($_POST['din']);
	global $tin;			$tin = trim($_POST['tin']);
	global $in;				$in = $din." ".$tin;
	global $tinh;			$tinh = substr($_POST['tin'],0,2);
	
	global $dout;			$dout = trim($_POST['dout']);
	global $tout;			$tout = trim($_POST['tout']);
	global $out;			$out = $dout." ".$tout;
	
			///////////////////////			**********   		///////////////////////
	
	$errors = array();
	
	/* VALIDAMOS QUE LOS DOS CAMPOS NO SON IGUALES */
	if(($_POST['din'] == $_POST['dout']) && ($_POST['tin'] == $_POST['tout']) ){
		$errors [] = "FECHA OUT / IN MISMA HORA Y FECHA";
	/* VALIDAMOS LOS FORMATOS */
	}elseif(!preg_match('/^\d{4}-\d{2}-\d{2}$/',$_POST['dout'])){
		$errors [] = "FECHA OUT 1 Formato incorrecto YYYY-MM-DD";
	}elseif(!preg_match('/^[0-9\-\s]+$/',$_POST['dout'])){
		$errors [] = "FECHA OUT 2 Formato incorrecto YYYY-MM-DD";
	}elseif(!preg_match('/^[^@´`\'áéíóú#$&%<>´"·\(\)=¿?!¡\[\]\{\};,:\.\*\']+$/',$_POST['dout'])){
		$errors [] = "FECHA OUT Caracteres no permitidos";
	}elseif(!preg_match('/^\d{2}:\d{2}:\d{2}$/',$_POST['tout'])){
		$errors [] = "TIME OUT 1 Formato incorrecto HH:MM:SS";
	}elseif(!preg_match('/^[0-9:\s]+$/',$_POST['tout'])){
		$errors [] = "TIME OUT 2 Formato incorrecto HH:MM:SS";
	}elseif(!preg_match('/^[^@´`\'áéíóú#$&%<>-´"·\(\)=¿?!¡\[\]\{\};,\.\*\']+$/',$_POST['tout'])){
		$errors [] = "TIME OUT Caracteres no permitidos";

		// SI LOS FORMATOS SON CORRECTOS:
	}else{ 	calc(); 
	
		/* VALIDAMOS EL CAMPO DATE OUT */
		if(strlen(trim($_POST['dout'])) == 0){
			$errors [] = "FECHA OUT Campo obligatorio";
		}elseif(strlen(trim($_POST['dout'])) < 10){
			$errors [] = "FECHA OUT Valores incorrectos YYYY-MM-DD";
		}elseif(strlen(trim($_POST['dout'])) > 10){
			$errors [] = "FECHA OUT Valores incorrectos YYYY-MM-DD";
		}elseif(trim($douty) != $datey){
			$errors [] = "FECHA OUT AÑO NO PERMITIDO";
		}/*elseif((trim($doutm) != $datem)||(trim($doutm) < $dinm)){
		Si el mes salida distinto al actual O el mes salida menor que el mes entrada 
				$errors [] = "FECHA OUT MES NO PERMITIDO";
		}*/elseif((trim($doutm) > $datem)||(trim($doutm) < $dinm)){
			/* Si el mes salida mayor que el actual O el mes salida menor que el mes entrada */
				$errors [] = "FECHA OUT MES NO PERMITIDO";
		}elseif(($doutm == $datem)AND(($doutd > $dated)||($doutd < $dind))){
		/* Si el mes igual este Y el dia de salida es mayor que hoy O el dia de salida menor a entrada */
				$errors [] = "FECHA OUT DIA NO PERMITIDO";
		}
		
		/* VALIDAMOS EL CAMPO TIME OUT */
		if(strlen(trim($_POST['tout'])) == 0){
			$errors [] = "TIME OUT Campo obligatorio";
		}elseif(strlen(trim($_POST['tout'])) < 8){
			$errors [] = "TIME OUT Valores incorrectos HH:MM:SS";
		}elseif(strlen(trim($_POST['tout'])) > 8){
			$errors [] = "TIME OUT Valores incorrectos HH:MM:SS";
		}elseif(($touth > $th)||($toutm > $thms)||($touts > $thms)){
				$errors [] = "TIME OUT HORA NO PERMITIDA MAX: 00:00:01";
		}elseif(($doutd == $dind)AND($tinh > $touth)){
			/* (Si el día de salida es igual al de entrada y la hora de salida es inferior a la de entrada */
				$errors [] = "TIME OUT HORA NO PERMITIDA";
		}elseif($_SESSION['ttotd'] > 0){
			$errors [] = "DATE OUT MÁS DE 24 HORAS";
		}elseif($_SESSION['ttoth'] > 9){
			$errors [] = "TIME OUT MÁS DE 10 HORAS";
		}
	}	// FIN ELSE SI TODOS LOS FORMATOS SON CORRECTOS
	 
	return $errors;

} 
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function suma_todo(){
		
	global $db;			global $db_name;
	
	global $nm;
	$nm = substr($_POST['din'],5,2);
	$nm = str_replace(":","",$nm);

	global $diny;
	global $dyt;		$dyt = $diny;		//$dyt = date('Y');
	global $dm;			$dm = "-".$nm."-";
	global $dd;			$dd = '';
	global $fil;		$fil = $dyt.$dm."%";

	/*
	PARA EL AÑO CORRIENTE
	$vname = $tabla1."_".date('Y');
	 */
	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;			$vname = "`".$tabla1."_".$diny."`";

	global $ruta;		$ruta = '../';
	require 'Inc_Suma_Todo.php';

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){
	
	global $db;			global $db_name;	
	global $diny;

	/* PARA EL AÑO CORRIENTE		$vname = $tabla1."_".date('Y'); */
	$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
	global $vname;			$vname = "`".$tabla1."_".$diny."`";

	global $din;			$din = trim($_POST['din']);
	global $tin;			$tin = trim($_POST['tin']);
	global $in;				$in = $din." ".$tin;
	global $dout;			$dout = trim($_POST['dout']);
	global $tout;			$tout = trim($_POST['tout']);
	global $out;			$out = $dout." ".$tout;
	
	$fecha1 = new DateTime($in);//fecha inicial
	$fecha2 = new DateTime($out);//fecha de cierre

	global $difer;			$difer = $fecha1->diff($fecha2);
	//print ($difer);
	
	global $ttot;			$ttot = $difer->format('%H:%i:%s');

	$tabla = "<table class='TFormAdmin'>
				<tr>
					<th colspan=2>
						HA MODIFICADO LA SALIDA</br>
					</th>
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
					<td>TEME IN</td><td>".$_POST['tin']."</td>
				</tr>
				<tr>
					<td>DATE OUT</td><td>".$_POST['dout']."</td>
				</tr>
				<tr>
					<td>TIME OUT</td><td>".$_POST['tout']."</td>
				</tr>
				<tr>
					<td>TIME TOTAL</td><td>".$ttot."</td>
				</tr>
				<tr>
					<td colspan=2>
						<form name='volver' action='Reg_Fichar_Ver.php'>
				<button type='submit' title='VOLVER A FICHAR MODIFICAR SALIDA' class='botonazul imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
						</form>					
					</td>
				</tr>
			</table>
			<embed src='../audi/salida.mp3' autostart='true' loop='false' ></embed>
			<script type='text/javascript'>
				function redir(){window.location.href='Reg_Fichar_Ver.php';}
				setTimeout('redir()',8000);
			</script>";	
		
	//print($in." / ".$out." / ".$ttot."</br>");
	//echo $difer->format('%Y años %m meses %d days %H horas %i minutos %s segundos');
						//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos

	$sqla = "UPDATE `$db_name`.$vname SET `dout` = '$_POST[dout]', `tout` = '$_POST[tout]', `ttot` =  '$ttot' WHERE $vname.`id` = '$_POST[id]' AND $vname.`ref` = '$_SESSION[usuarios]' LIMIT 1 ";
		
		if(mysqli_query($db, $sqla)){ 
			
			print($tabla); 
			suma_todo();
			
			global $dir;			$dir = "../Users/".$_SESSION['usuarios']."/mrficha";
			
			global $nm;
			$nm = substr($_POST['din'],5,2);
			$nm = str_replace(":","",$nm);

			global $sumatodo;
			global $text;
			$text = "** HORARIO MODIFICADO FECHA: ".date('Y_m_d / H:i:s').".";
			$text = $text.PHP_EOL."** HORARIO INICIAL ERRONEO: ";
			$text = $text.PHP_EOL."** ERROR ENTRADA: ".$_POST['din']." / ".$_POST['tin'].".";
			$text = $text.PHP_EOL."** ERROR SALIDA: ".$_SESSION['edout']." / ".$_SESSION['etout'].".";
			$text = $text.PHP_EOL."** ERROR TOTAL TIME: ".$_SESSION['ettot'].".";
			
			$text = $text.PHP_EOL."** HORARIO MODIFICADO: ".$_POST['din']." / ".$_POST['tin'].".";
			$text = $text.PHP_EOL."** MODIF. ENTRADA: ".$_POST['din']." / ".$_POST['tin'].".";
			$text = $text.PHP_EOL."** MODIF. SALIDA: ".$_POST['dout']." / ".$_POST['tout'].".";
			$text = $text.PHP_EOL."** MODIF. TOTAL TIME: ".$ttot.".";

			$text = $text.PHP_EOL."** HORAS TOTALES MES ".$diny."-".$nm.": ".$sumatodo;
			//$text = $text.PHP_EOL."** HORAS TOTALES MES ".date('Y')."-".$nm.": ".$sumatodo;
			$text = $text.PHP_EOL."\t**********".PHP_EOL;
			global $rmfdocu;		$rmfdocu = $_SESSION['usuarios'];
			global $rmfdate;		$rmfdate = $diny."_".$nm;		//$rmfdate = date('Y_').$nm;
			global $rmftext;		$rmftext = $text.PHP_EOL;
			global $filename;		$filename = $dir."/".$rmfdate."_".$rmfdocu.".txt";
			//if($diny == date('Y')){	}else{}
			global $rmf;			$rmf = fopen($filename, 'ab+');
			fwrite($rmf, $rmftext);
			fclose($rmf);

		}else{ 	print("* MODIFIQUE LA ENTRADA L.304: ".mysqli_error($db));
				show_form ();
				global $texerror;
				$texerror = PHP_EOL."\t ".mysqli_error($db);
		}

	} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form($errors=[]){

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

		$_SESSION['edout'] = $_POST['dout'];
		$_SESSION['etout'] = $_POST['tout'];
		$_SESSION['ettot'] = $_POST['ttot'];
	}

	require 'Tabla_Errors.php';

	print("<table class='TFormAdmin'>
				<tr>
					<td colspan=2 style='text-align:center !important;color:#F1BD2D;'>
						MODIFICAR REGISTRO
					</td>
				</tr>
				<tr>
					<td>ID</td>
					<td>
			<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' >
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
					<td>yyyy-mm-dd</br>
			<input type='date' name='dout' size=11 maxlength=10 value='".$defaults['dout']."' />
					</td>
				</tr>
				<tr>
					<td>TIME OUT</td>
					<td>hh:mm:ss</br>
			<input type='time' name='tout' size=11 maxlength=8 value='".$defaults['tout']."' />
					</td>
				</tr>
				<tr>
					<td>TIME TOTAL</td>
					<td>".$defaults['ttot']."</td>
				</tr>
				<tr>
					<td colspan='2' style='text-align:right !important;'>
						<input type='hidden' name='id' value='".$defaults['id']."' />
						<input type='hidden' id='ref' name='ref' value='".$_SESSION['usuarios']."' />
						<input type='hidden' name='name1' value='".$defaults['name1']."' />
						<input type='hidden' name='name2' value='".$defaults['name2']."' />
						<input type='hidden' name='din' value='".$defaults['din']."' />
						<input type='hidden' name='tin' value='".$defaults['tin']."' />
						<input type='hidden' name='ttot' value='".$defaults['ttot']."' />
				<button type='submit' title='MODIFICAR DATOS' class='botonverde imgButIco SaveBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
						<input type='hidden' name='oculto' value=1 />
			</form>

			<a href='Reg_Fichar_Ver.php'>
				<button type='button' title='FICHAR FILTRO DE EMPLEADOS' class='botonazul imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
			</a>												
					</td>
				</tr>
			</table>"); 

	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function info_01(){

		global $ttot;
		global $orden;
		require '../Inclu/orden.php';

		$ActionTime = date('H:i:s');

		global $dir;				$dir = "../Users/".$_SESSION['ref']."/log";

		global $text;
		$text = PHP_EOL."- JORNADA LABORAL MODIFICAR SELECCIONADO ".$ActionTime;
		$text = $text.PHP_EOL."\tNº REF: ".$_SESSION['usuarios'];
		$text = $text.PHP_EOL."\tNOMBRE: ".$_POST['name1'];
		$text = $text.PHP_EOL."\tAPELLIDOS: ".$_POST['name2'];
		$text = $text.PHP_EOL."\tID: ".$_POST['id'];
		$text = $text.PHP_EOL."\tDATE IN: ".$_POST['din'];
		$text = $text.PHP_EOL."\tTIME IN: ".$_POST['tin'];
		$text = $text.PHP_EOL."\tDATE OUT: ".$_POST['dout'];
		$text = $text.PHP_EOL."\tTIME OUT: ".$_POST['tout'];
		$text = $text.PHP_EOL."\tTIME TOTAL: ".$ttot;

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

function info_02(){

		global $ttot;

		$ActionTime = date('H:i:s');

		global $dir;				$dir = "../Users/".$_SESSION['ref']."/log";
	
		global $text;
		$text = PHP_EOL."- JORNADA LABORAL MODIFICAR 2 ".$ActionTime;
		$text = $text.PHP_EOL."\tNº REF: ".$_SESSION['usuarios'];
		$text = $text.PHP_EOL."\tNOMBRE: ".$_POST['name1'];
		$text = $text.PHP_EOL."\tAPELLIDOS: ".$_POST['name2'];
		$text = $text.PHP_EOL."\tID: ".$_POST['id'];
		$text = $text.PHP_EOL."\tDATE IN: ".$_POST['din'];
		$text = $text.PHP_EOL."\tTIME IN: ".$_POST['tin'];
		$text = $text.PHP_EOL."\tDATE OUT: ".$_POST['dout'];
		$text = $text.PHP_EOL."\tTIME OUT: ".$_POST['tout'];
		$text = $text.PHP_EOL."\tTIME TOTAL: ".$ttot;

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