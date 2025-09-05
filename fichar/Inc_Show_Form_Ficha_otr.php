<?php

	global $db;				global $db_name;
	
	if(isset($_POST['oculto1'])){	$_SESSION['usuarios'] = $_POST['usuarios'];
									$defaults = $_POST;
									//print("* ".$_SESSION['usuarios']);
	}elseif(isset($_SESSION['usuarios']) == '') {}

	global $db;
	global $tablau;				$tablau = "`".$_SESSION['clave']."admin`";

	global $sqlu;
	$sqlu =  "SELECT * FROM $tablau WHERE `ref` <> '$_SESSION[ref]' ORDER BY `ref` ASC ";
	$qu = mysqli_query($db, $sqlu);
	if(mysqli_num_rows($qu)== 0){
		print ("<table align='center'>
					<tr>
						<td>
							<font color='#FF0000'>
								NO EXISTEN OTROS USUARIOS
							</font>
						</td>
					</tr>
				</table>");
	}else{
		print(" <table align='center' style='border:1; margin-top:2px' width='auto'>
				<tr>
					<td align='center'>".$titulo."</td>
				</tr>		
				<tr>
					<td>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
					<div style='float:left; margin-right:6px'>
						<input type='submit' value='SELECCIONE UN USUARIO' class='botonlila' />
						<input type='hidden' name='oculto1' value=1 />
					</div>
					<div style='float:left'>
						<select name='usuarios'>
					<!-- <option value=''>SELECCIONE UN USUARIO</option> --> ");

		if(!$qu){ print("Modifique la entrada L.288: ".mysqli_error($db)."<br>");
		}else{
			while($rowu = mysqli_fetch_assoc($qu)){
						print ("<option value='".$rowu['ref']."' ");
					if($rowu['ref'] == @$defaults['usuarios']){ print ("selected = 'selected'"); }
					print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
			}
		}  
	
		print ("</select>
					</div>
				</form>	
						</td>
					</tr>
				</table>"); 

			///////////////////////			**********  		///////////////////////
	
	if(isset($_POST['oculto1'])){
		if($_SESSION['usuarios'] == ''){ 
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
			global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";
			$sqln =  "SELECT * FROM $table_name_a WHERE `ref` = '$_SESSION[usuarios]'";
			$q1n = mysqli_query($db, $sqln);
			$rn = mysqli_fetch_assoc($q1n);
			global $name1o;				$name1o = $rn['Nombre'];
			global $name2o;				$name2o = $rn['Apellidos'];
			global $uimg;				$uimg = $rn['myimg'];
	
			$tabla1 = strtolower($_SESSION['clave'].$_SESSION['usuarios']);
			global $vname;				$vname = "`".$tabla1."_".date('Y')."`";
		
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

			global $dout;			$dout = '';
			global $tout;			$tout = '00:00:00';
			global $ttot;			$ttot = '00:00:00';
			
			print("<table align='center' style=\"margin-top:10px\">
					<tr>
						<td  align='center' rowspan=2>
				<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$uimg."' height='54px' width='38px' />
						</td>
						<td>".$name1o." ".$name2o.". Ref: ".$_SESSION['usuarios']."
						</td>
					</tr>
					<tr>
						<td valign='middle' align='center'>
				<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
						<input type='hidden' id='ref' name='ref' value='".$_SESSION['usuarios']."' />
						<input type='hidden' id='name1' name='name1' value='".$name1o."' />
						<input type='hidden' id='name2' name='name2' value='".$name2o."' />
						<input type='hidden' id='din' name='din' value='".$din."' />
						<input type='hidden' id='tin' name='tin' value='".$tin."' />
						<input type='hidden' id='dout' name='dout' value='".$dout."' />
						<input type='hidden' id='tout' name='tout' value='".$tout."' />
						<input type='hidden' id='ttot' name='ttot' value='".$ttot."' />
						<input type='submit' value='FICHAR ENTRADA' class='botonverde' />
						<input type='hidden' name='entrada' value=1 />
				</form>														
						</td>
					</tr>
			</table>");

		}elseif($count1 > 0){
			
			global $name1o;				global $name2o;
			global $uimg;				global $dout;
			global $tout;
			global $ttot;				$dout = date('Y-m-d');
			/*
				HORA ORIGINAL DE SALIDA DEL SCRIPT
				$tout = date('H:i:s');
			*/

			require 'fichar_redondeo_out.php';

			print("<table align='center' style=\"margin-top:10px\">
					<tr>
						<td  align='center' rowspan=2>
				<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$uimg."' height='54px' width='38px' />
						</td>
						<td>".$name1o." ".$name2o.". Ref: ".$_SESSION['usuarios']."
						</td>
					</tr>

					<tr>
						<td valign='middle'  align='center'>
				<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
					<input type='hidden' id='ref' name='ref' value='".$_SESSION['usuarios']."' />
					<input type='hidden' id='name1' name='name1' value='".$name1o."' />
					<input type='hidden' id='name2' name='name2' value='".$name2o."' />
					<input type='hidden' id='dout' name='dout' value='".$dout."' />
					<input type='hidden' id='tout' name='tout' value='".$tout."' />
					<input type='submit' value='FICHAR SALIDA' class='botonverde' />
					<input type='hidden' name='salida' value=1 />
				</form>														
						</td>
					</tr>
				</table>"); 
			}
		} // fin 2º if
	} // fin 1º if
} // condicional no hay usuarios

?>