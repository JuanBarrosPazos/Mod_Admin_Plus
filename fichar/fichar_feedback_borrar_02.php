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

if ($_SESSION['Nivel'] == 'admin'){

					master_index();

						if($_POST['oculto2']){	info_01();
												show_form();}
						elseif($_POST['oculto']){							
											process_form();
											info_02();
							
							} else {show_form();}
					} else { require '../Inclu/table_permisos.php'; } 

//////////////////////////////////////////////////////////////////////////////////////////////

function process_form(){
	
	global $db;
	global $db_name;	
	
	$tabla = "<table align='center' style='margin-top:10px' width=450px >
				<tr>
					<th colspan=4 class='BorderInf'>
						HA BORRADO: ".$_POST['name1']." ".$_POST['name2']."
					</th>
				</tr>
												
				<tr>
					<td>
						ID
					</td>
					<td>"
						.$_POST['id'].
					"</td>
				</tr>
				
				<tr>
					<td>
						REFERENCIA
					</td>
					<td>"
						.$_SESSION['usuarios'].
					"</td>
				</tr>
				
				<tr>
					<td>	
						FECHA ENTRADA
					</td>
					<td>"
						.$_POST['din'].
					"</td>
				</tr>
				
				<tr>
					<td>
						HORA ENTRADA
					</td>
					<td>"
						.$_POST['tin'].
					"</td>
				</tr>
								
				<tr>
					<td>	
						FECHA SALIDA
					</td>
					<td>"
						.$_POST['dout'].
					"</td>
				</tr>
				
				<tr>
					<td>
						HORA SALIDA
					</td>
					<td>"
						.$_POST['tout'].
					"</td>
				</tr>
								
				<tr>
					<td>
						HORAS REALIZADAS
					</td>
					<td>"
						.$_POST['ttot'].
					"</td>
				</tr>
								
			</table>
				
		";	
		
	global $vname;
	$tabla1 = $_SESSION['clave'].$_SESSION['usuarios'];
	$tabla1 = strtolower($tabla1);
	$vname = $tabla1."_feed";
	$vname = "`".$vname."`";

	$sql = "DELETE FROM `$db_name`.$vname WHERE $vname.`id` = '$_POST[id]' LIMIT 1 ";

	if(mysqli_query($db, $sql)){
								print($tabla);
				} else {
				print("<font color='#FF0000'>
						Modifique la entrada L.133 </font></br>".mysqli_error($db))."</br>";
						show_form ();
						
							}

} 

//////////////////////////////////////////////////////////////////////////////////////////////

function show_form(){

	global $db;
	global $db_name;
	
	if($_POST['oculto']){
		$defaults = $_POST;
		} elseif($_POST['oculto2']){
				$defaults = array (	'id' => $_POST['id'],
								    'ref' => $_SESSION['usuarios'],
									'name1' => $_POST['name1'],
									'name2' => $_POST['name2'],
									'din' => $_POST['din'],
									'tin' => $_POST['tin'],
									'dout' => $_POST['dout'],
									'tout' => $_POST['tout'],
									'ttot' => $_POST['ttot']
																);
								}

	print("<table align='center' style='margin-top:10px' width=300px >
	
<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>

				<tr>
					<td>
						ID
					</td>
					<td>
	<input type='hidden' name='id' value='".$defaults['id']."' />".$defaults['id']."
					</td>
				</tr>
									
				<tr>
					<td>
						USER REF
					</td>
					<td>
	<input type='hidden' name='ref' value='".$_SESSION['usuarios']."' />".$_SESSION['usuarios']."
					</td>
				</tr>
									
				<tr>
					<td>
						NOMBRE
					</td>
					<td>
	<input type='hidden' name='name1' value='".$defaults['name1']."' />".$defaults['name1']."
					</td>
				</tr>
									
				<tr>
					<td>						
						APELLIDOS
					</td>
					<td>
	<input type='hidden' name='name2' value='".$defaults['name2']."' />".$defaults['name2']."
					</td>
					
				</tr>
									
				<tr>
					<td>						
						DATE IN
					</td>
					<td>
	<input type='hidden' name='din' value='".$defaults['din']."' />".$defaults['din']."
					</td>
				</tr>
					
				<tr>
					<td>						
						TIME IN
					</td>
					<td>
	<input type='hidden' name='tin' value='".$defaults['tin']."' />".$defaults['tin']."
					</td>
				</tr>
					
				<tr>
					<td>						
						DATE OUT
					</td>
					<td>
	<input type='hidden' name='dout' value='".$defaults['dout']."' />".$defaults['dout']."
					</td>
				</tr>
					
				<tr>
					<td>						
						TIME OUT
					</td>
					<td>
	<input type='hidden' name='tout' value='".$defaults['tout']."' />".$defaults['tout']."
					</td>
				</tr>
					
				<tr>
					<td>						
						TIME TOTAL
					</td>
					<td>
	<input type='hidden' name='ttot' value='".$defaults['ttot']."' />".$defaults['ttot']."
					</td>
				</tr>

				<tr>
					<td colspan='2' align='right' valign='middle'  class='BorderSup'>
						<input type='submit' value='ELIMINAR DATOS' class='botonrojo' />
						<input type='hidden' name='oculto' value=1 />
					</td>
				</tr>
				
		</form>														
			
			</table>				
						"); 
		}

/////////////////////////////////////////////////////////////////////////////////////////////////

function info_01(){

		global $ttot;

		global $orden;
		$orden = $_POST['Orden'];

		$ActionTime = date('H:i:s');

		global $dir;
		$dir = "../Users/".$_SESSION['usuarios']."/log";

		global $text;
		$text = PHP_EOL."- JORNADA LABORAL FEEDBACK BORRAR SELECCIONADO ".$ActionTime;
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

		global $db;
		global $ttot;

		$ActionTime = date('H:i:s');

		global $dir;
		$dir = "../Users/".$_SESSION['usuarios']."/log";
	
		global $text;
		$text = PHP_EOL."- JORNADA LABORAL FEEDBACK BORRAR 2 ".$ActionTime;
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

/* Creado por Juan Barros Pazos 2021 */
?>