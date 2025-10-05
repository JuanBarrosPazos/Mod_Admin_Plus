<?php
session_start();
 
	require '../Inclu/error_hidden.php';
	require '../Inclu/Admin_head.php';
	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

	global $userid;			$userid = $_SESSION['id'];
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if(($_SESSION['Nivel'] == 'wmaster')||($_SESSION['Nivel'] == 'admin')||($_SESSION['Nivel'] == 'plus')||($_SESSION['Nivel'] == 'user')){
 		
	if(isset($_POST['salir'])){ UserLog();
							  	salir();
	}elseif(isset($_POST['cerrar'])){ 	master_index();
										desconex(); 
	}

}else{ require '../Inclu/tabla_permisos.php';}
		
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function UserLog(){

	global $db;				global $db_name;			global $userid;
	global $dir;			$dir = "../Users/".$_SESSION['ref']."/log";
	global $dateadout;		$dateadout = date('Y-m-d H:i:s');
	global $table_name_a;	$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqladout = "UPDATE `$db_name`.$table_name_a SET `lastout` = '$dateadout' WHERE $table_name_a.`id` = '$userid' LIMIT 1 ";
		
	if(mysqli_query($db, $sqladout)){ }else{ 
		print("ERROR SQL L.36 ".mysqli_error($db))."</br>";
	}
	
	global $text;
	$text = "!! CIERRE SESION USUARIO: ".$_SESSION['Nombre']." ".$_SESSION['Apellidos']." => ".$dateadout.PHP_EOL."\t\tREFERENCIA: ".$_SESSION['ref']." NIVEL: ".$_SESSION['Nivel'].PHP_EOL;

	require 'log_write.php';

		// PASA LOG AL SISTEMA
		$ActionTime = date('H:i:s');
		$logdate = date('Y-m-d');
		$logtext = "** ".$ActionTime.PHP_EOL."\t ** ".$text.PHP_EOL;
		$filename = "../LogsAcceso/LogsAcceso_".$logdate.".log";
		$log = fopen($filename, 'ab+');
		fwrite($log, $logtext);
		fclose($log);

} // FIN FUNCION

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function master_index(){
		
	require '../Inclu_MInd/rutaadmin.php';
	require '../Inclu_MInd/Master_Index.php';
		
} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function desconex(){

	print("<div class='centradiv' style='border:none !important;'>
			<form name='salir' action='$_SERVER[PHP_SELF]' method='post'>
				<button type='submit' title='CONFIRME CERRAR SESION' class='botonrojo imgButIco CloseSessionBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='salir' value=1 />
			</form>	
		</div>
	<audio src='../audi/sesion_close_confirm.mp3' autoplay></audio>");
	
} 
			
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function salir() {	

	print("<div class='centradiv alertdiv'>
					HA CERRADO SESION
			</div>
	<audio src='../audi/sesion_close.mp3' autoplay></audio>");
				
	global $redir;
	// 600000 microsegundos 10 minutos
	// 60000 microsegundos 1 minuto
	$redir = "<script type='text/javascript'>
				function redir(){
					window.location.href='../index.php?salir=1';
				}
				setTimeout('redir()',3000);
			</script>";
	print($redir);
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	require '../Inclu/Admin_Inclu_footer.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

/* Creado por © Juan Barros Pazos 2020/25 Licencia CC BY-NC-SA */
?>