<?php

	global $db;				global $db_name; 
	
	if(isset($_POST['oculto1'])){	$_SESSION['usuarios'] = $_POST['usuarios'];
									$defaults = $_POST;
									//print("* ".$_SESSION['usuarios']);
		if($_SESSION['usuarios'] == ''){ 
			print("<div class='centradiv alertdiv'>SELECCIONE UN USUARIO</div>");
			print("<audio src='../audi/select_one_user.mp3' autoplay></audio>");
		}
	}elseif(!isset($_SESSION['usuarios'])){ 
		print("<audio src='../audi/select_one_user.mp3' autoplay></audio>");
	}

	global $db;
	global $tablau;				$tablau = "`".$_SESSION['clave']."admin`";

	global $sqlu;
	$sqlu =  "SELECT * FROM $tablau WHERE `ref` <> '$_SESSION[ref]' ORDER BY `ref` ASC ";
	$qu = mysqli_query($db, $sqlu);
	if(mysqli_num_rows($qu)== 0){
		print ("<div class='centradiv alertdiv'>NO EXISTEN OTROS USUARIOS</div>");
	}else{
		print("<div class='centradiv' style='padding:0.6em;'>
					<div style='margin: 0.3em auto'>".$titulo."</div>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]' >
						<select name='usuarios'>
					<!--  --><option value=''>SELECCIONE UN USUARIO</option> ");

		if(!$qu){ print("Modifique la entrada L.288: ".mysqli_error($db)."<br>");
		}else{
			while($rowu = mysqli_fetch_assoc($qu)){
						print ("<option value='".$rowu['ref']."' ");
					if($rowu['ref'] == @$defaults['usuarios']){ print ("selected = 'selected'"); }
					print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
			}
		}  
	
		print ("</select>
				<button type='submit' title='SELECCIONE UN USUARIO' class='botonverde imgButIco BuscaBlack' style='vertical-align:top;margin-top:-0.01em;' > </button>
						<input type='hidden' name='oculto1' value=1 />
				</form>	
				</div>");

		global $ficharCrear;		$ficharCrear = 3;
		require 'Fichar_Crear_Botonera.php';

			///////////////////////			**********  		///////////////////////
	
	if(isset($_POST['oculto1'])){
		
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

				require 'Fichar_Redondeo_in.php';

				global $dout;			$dout = '';
				global $tout;			$tout = '00:00:00';
				global $ttot;			$ttot = '00:00:00';
				
				global $Action;			$Action = "action='$_SERVER[PHP_SELF]'";
				global $ImgForm;
				$ImgForm = "<li class='liCentra'>
								<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$uimg."' />
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
			
				global $name1o;				global $name2o;
				global $uimg;				global $dout;
				global $tout;
				global $ttot;				$dout = date('Y-m-d');
				/*
					HORA ORIGINAL DE SALIDA DEL SCRIPT
					$tout = date('H:i:s');
				*/

				require 'Fichar_Redondeo_out.php'; 

				global $Action;			$Action = "action='$_SERVER[PHP_SELF]'";
				global $ImgForm;
				$ImgForm = "<li class='liCentra'>
								<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$uimg."' />
							</li>";
				global $FormButtonHome;
				$FormButtonHome = "<form name='volver' action='$_SERVER[PHP_SELF]' style='display: inline-block; margin-right:10%;' >
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
} // condicional no hay usuarios

?>