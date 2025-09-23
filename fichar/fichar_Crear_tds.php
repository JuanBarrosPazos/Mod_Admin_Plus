<?php
session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Inclu/webmaster.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

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
	}elseif((isset($_GET['page']))||(isset($_POST['page']))) {
                                        show_form();
                                        errors();
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
	
	global $imgTabla;		$imgTabla = "";
	global $rutaAudio;		$rutaAudio = "<audio src='../audi/entrada.mp3' autoplay></audio>";
	global $rutaHome;		$rutaHome = "Fichar_Crear.php";
	global $rutaRedir;		$rutaRedir = "Fichar_Crear.php";
	global $TablaIn;
	require 'Fichar_Tablas_Resum.php';
	
	global $db; 			global $db_name;

	$tabla1 = $_SESSION['clave'].$_SESSION['usuarios'];
	$tabla1 = strtolower($tabla1);
	global $vname;			$vname = "`".$tabla1."_".date('Y')."`";

	$sql1 =  "SELECT * FROM `$db_name`.$vname WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1";
	$q1 = mysqli_query($db, $sql1);
	$count1 = mysqli_num_rows($q1);
	
	if($count1 > 0){ 
		print("<div class='centradiv alertdiv'>
					ERROR YA HA FICHADO LA ENTRADA </br>".$_POST['name1']." ".$_POST['name2']."
			</div>");
	}else{
	
		$sqla = "INSERT INTO `$db_name`.$vname (`ref`, `Nombre`, `Apellidos`, `din`, `tin`, `dout`, `tout`, `ttot`) VALUES ('$_POST[ref]', '$_POST[name1]', '$_POST[name2]', '$_POST[din]', '$_POST[tin]', '$_POST[dout]', '$_POST[tout]', '$_POST[ttot]')";
			
		if(mysqli_query($db, $sqla)){ 
				
			print($TablaIn); 
				
			global $dir;			global $text;
			require 'log_fichar_in.php';
		
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

	global $orden;
	require '../Inclu/orden.php';

	global $table_name_a; 	$table_name_a = "`".$_SESSION['clave']."admin`";

	if(isset($_POST['volver'])){ unset($_SESSION['usuarios']); }

	if(isset($_POST['oculto1'])){	
				$_SESSION['usuarios'] = $_POST['usuarios'];
				$defaults = $_POST;
				//print("* ".$_SESSION['usuarios']);
	}else{
		if(($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')){ 
			
			global $ficharCrear;		$ficharCrear = 2;
			require 'Fichar_Crear_Botonera.php';
			require 'Paginacion_Head.php';

			//$sqlb =  "SELECT * FROM $table_name_a ORDER BY `id` ASC ";
			$sqlb = "SELECT * FROM $table_name_a WHERE (`del` = 'false' AND `nivel` <> 'locked') ORDER BY $orden $limit ";
			$qb = mysqli_query($db, $sqlb);
		}
	
		if(!$qb){
			print("ERROR SQL L.121 ".mysqli_error($db)."</br>");
		}else{
			if(mysqli_num_rows($qb)== 0){
				print ("<div class='centradiv alertdiv'>NO HAY DATOS</div>");
			}else{

				unset($_SESSION['usuarios']);
				print ("<table class='centradiv'>
						<tr>
							<th colspan=4 style='color:#F1BD2D;' >
								GESTIÓN HORARIOS
							</th>
						<tr>
							<td></td>
							<td>REFERENCIA</td>
							<td>NOMBRE</td>
							<td></td>
						</tr>");

				$countbgc = 0;
				while($rowb = mysqli_fetch_assoc($qb)){

					$tablaUser = "`".strtolower($_SESSION['clave'].$rowb['ref'])."_".date('Y')."`";
					$sqlUser =  "SELECT * FROM `$db_name`.$tablaUser WHERE $tablaUser.`dout` = '' AND $tablaUser.`tout` = '00:00:00' LIMIT 1";
					$qrUser = mysqli_query($db,$sqlUser);
					$rowUser = mysqli_fetch_assoc($qrUser);
					if(($rowUser['dout']=='')&&($rowUser['tout']=='00:00:00')){
						$ButtonTitle = 'SING OUT USER ';
						$ButtonClass = 'botonnaranja';
					}else{
						$ButtonTitle = 'SING IN USER ';
						$ButtonClass = 'botonverde';
					}

					if(($countbgc%2)==0){
						$bgcolor ="background-color:#59746A;";
					}else{ $bgcolor =""; }

					print("<tr>
							<td style='".$bgcolor."' >
					<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
			<img src='../Users/".$rowb['ref']."/img_admin/".$rowb['myimg']."' style='height:4.0em; width:3.0em;vertical-align:middle;' />
							</td>
							<td style='".$bgcolor."' >".strtoupper($rowb['ref'])."</td>
							<td style='".$bgcolor."'>".$rowb['Nombre']." ".$rowb['Apellidos']."</td>
							<td style='".$bgcolor."'>
						<input type='hidden' name='id' value='".$rowb['id']."' />
						<input type='hidden' name='myimg' value='".$rowb['myimg']."' />
						<input type='hidden' name='usuarios' value='".$rowb['ref']."' />
						<input type='hidden' name='name1' value='".$rowb['Nombre']."' />
						<input type='hidden' name='name2' value='".$rowb['Apellidos']."' />						
							<button type='submit' title='".$ButtonTitle." ".strtoupper($rowb['ref'])."' class='".$ButtonClass." imgButIco Clock1Black' style='vertical-align:middle;display:inline-block;' ></button>
						<input type='hidden' name='oculto1' value=1 />
					</form>
							</td>
					</tr>");
					$countbgc = $countbgc+1;
				} // Fin while. 

				print("</table>
				<audio src='../audi/select_one_user.mp3' autoplay></audio>");

				require 'Paginacion_Footter.php';

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

			require 'Fichar_Redondeo_in.php';

			global $dout; 		$dout = '';
			global $tout; 		$tout = '00:00:00';
			global $ttot;		$ttot = '00:00:00';

			global $Action;		$Action = "action='$_SERVER[PHP_SELF]'";
			global $ImgForm;
			$ImgForm = "<li class='liCentra'>
							<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$_POST['myimg']."' />
						</li>";
			global $FormButtonHome;
			$FormButtonHome = "<form name='volver' action='$_SERVER[PHP_SELF]' style='display:inline-block; margin-right:10%;' >
					<button type='submit' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
						<input type='hidden' name='volver' value=1 />
				</form>";
			global $rutaAudio;
			$rutaAudio = "<audio src='../audi/conf_user_data.mp3' autoplay></audio>";
			require 'Fichar_Tablas_Form.php';
			print($FichaIn);

			}elseif($count1 > 0){
			
				global $dout;	$dout = date('Y-m-d'); 	global $tout; 	global $ttot;
				/*
					HORA ORIGINAL DE SALIDA DEL SCRIPT
					$tout = date('H:i:s');
				*/

				require 'Fichar_Redondeo_out.php';

				global $Action;		$Action = "action='$_SERVER[PHP_SELF]'";
				global $ImgForm;
				$ImgForm = "<li class='liCentra'>
								<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$_POST['myimg']."' />
							</li>";
				global $FormButtonHome;
				$FormButtonHome = "<form name='volver' action='$_SERVER[PHP_SELF]' style='display:inline-block; margin-right:10%;' >
						<button type='submit' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
							<input type='hidden' name='volver' value=1 />
					</form>";
				global $rutaAudio;
				$rutaAudio = "<audio src='../audi/conf_user_data.mp3' autoplay></audio>";
				require 'Fichar_Tablas_Form.php';
				print($FichaOut);
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

	require 'Fichar_Salida.php';

	global $imgTabla;		$imgTabla = "";
	global $rutaAudio;		$rutaAudio = "<audio src='../audi/salida.mp3' autoplay></audio>";
	global $rutaHome;		$rutaHome = "Fichar_Crear.php";
	global $rutaRedir;		$rutaRedir = "Fichar_Crear.php";
	global $TablaOut;
	require 'Fichar_Tablas_Resum.php';
		
	//print($in." / ".$out." / ".$ttot."</br>");
	//echo $difer->format('%Y años %m meses %d days %H horas %i minutos %s segundos');
						//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos

	$sqla = "UPDATE `$db_name`.$vname SET `dout` = '$_POST[dout]', `tout` = '$_POST[tout]', `ttot` =  '$ttot', `error` = '$terror' WHERE $vname.`dout` = '' AND $vname.`tout` = '00:00:00' LIMIT 1 ";
		
	if(mysqli_query($db, $sqla)){ 
			
		print($TablaOut);
		suma_todo();

		global $dir;		global $sumatodo;		global $text;
		require 'log_fichar_out.php';

	}else{	print("ERROR SQL L.382 ".mysqli_error($db));
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