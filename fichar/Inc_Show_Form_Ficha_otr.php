<?php

	global $db;				global $db_name; 
	
	if(isset($_POST['oculto1'])){	$_SESSION['usuarios'] = $_POST['usuarios'];
									$defaults = $_POST;
									//print("* ".$_SESSION['usuarios']);
	}elseif(isset($_SESSION['usuarios']) == ''){ }

	global $db;
	global $tablau;				$tablau = "`".$_SESSION['clave']."admin`";

	global $sqlu;
	$sqlu =  "SELECT * FROM $tablau WHERE `ref` <> '$_SESSION[ref]' ORDER BY `ref` ASC ";
	$qu = mysqli_query($db, $sqlu);
	if(mysqli_num_rows($qu)== 0){
		print ("<div class='centradiv' style='border-color:#F1BD2D; color:#F1BD2D'>
								NO EXISTEN OTROS USUARIOS
				</div>");
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
		if($_SESSION['usuarios'] == ''){ 
			print("<div class='centradiv' style='border-color:#F1BD2D; color:#F1BD2D'>
								SELECCIONE UN USUARIO
					</div>");
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

			require 'Fichar_Redondeo_in.php';

			global $dout;			$dout = '';
			global $tout;			$tout = '00:00:00';
			global $ttot;			$ttot = '00:00:00';
			
			print("<ul class='centradiv'>
					<li class='liCentra'>FICHE SU ENTRADA</li>
					<li class='liCentra'>
						<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$uimg."' />
					</li>
					<li class='liCentra'>
						".strtoupper($name1o)." ".strtoupper($name2o)."
					</li>
					<li class='liCentra'>REFER: ".strtoupper($_SESSION['usuarios'])."</li>
					<li class='liCentra'>
				<form name='volver' action='$_SERVER[PHP_SELF]' style='display:inline-block; margin-right:10%;' >
					<button type='submit' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
						<input type='hidden' name='volver' value=1 />
				</form>
				<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>
						<input type='hidden' id='ref' name='ref' value='".$_SESSION['usuarios']."' />
						<input type='hidden' id='name1' name='name1' value='".$name1o."' />
						<input type='hidden' id='name2' name='name2' value='".$name2o."' />
						<input type='hidden' id='din' name='din' value='".$din."' />
						<input type='hidden' id='tin' name='tin' value='".$tin."' />
						<input type='hidden' id='dout' name='dout' value='".$dout."' />
						<input type='hidden' id='tout' name='tout' value='".$tout."' />
						<input type='hidden' id='ttot' name='ttot' value='".$ttot."' />
						<button type='submit' title='FICHAR ENTRADA' class='botonverde imgButIco Clock1Black' style='vertical-align:top;' ></button>
						<input type='hidden' name='entrada' value=1 />
				</form>														
					</li>
			</ul>");

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

			print("<ul class='centradiv'>
					<li class='liCentra'>FICHE SU SALIDA</li>
					<li class='liCentra'>
				<img src='../Users/".$_SESSION['usuarios']."/img_admin/".$uimg."' />
					</li>
					<li class='liCentra'>".strtoupper($name1o)." ".strtoupper($name2o)."</li>
					<li class='liCentra'>REFER: ".strtoupper($_SESSION['usuarios'])."</li>
					<li class='liCentra'>
				<form name='volver' action='$_SERVER[PHP_SELF]' style='display: inline-block; margin-right:10%;' >
					<button type='submit' title='CANCELAR Y VOLVER' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='volver' value=1 />
				</form>
				<form name='form_datos' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>
					<input type='hidden' id='ref' name='ref' value='".$_SESSION['usuarios']."' />
					<input type='hidden' id='name1' name='name1' value='".$name1o."' />
					<input type='hidden' id='name2' name='name2' value='".$name2o."' />
					<input type='hidden' id='dout' name='dout' value='".$dout."' />
					<input type='hidden' id='tout' name='tout' value='".$tout."' />
						<button type='submit' title='FICHAR SALIDA' class='botonnaranja imgButIco Clock1Black' style='vertical-align:top;' ></button>
					<input type='hidden' name='salida' value=1 />
				</form>														
					</li>
				</ul>"); 
			}
		} // fin 2º if
	} // fin 1º if
} // condicional no hay usuarios

?>