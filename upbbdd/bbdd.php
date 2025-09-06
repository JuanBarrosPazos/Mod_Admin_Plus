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

	if(isset($_POST['delete'])){
						delete();
						show_form();
					 	listfiles();
	}elseif(isset($_POST['oculto2'])){	show_form();
								  		ver_todo();
							  			listfiles();

	}else{	show_form();
			listfiles();
	}
								
}else{ require '../Inclu/tabla_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form(){

	global $db;				global $db_name;
	
	if((isset($_POST['oculto1']))||(isset($_POST['oculto2']))||(isset($_POST['delete']))){
					$_SESSION['tablas'] = strtolower($_POST['tablas']);
					$defaults = array ('Orden' => isset($ordenar),
								   	   'tablas' => strtolower($_POST['tablas']),);
					// print($_SESSION['tablas']);
	}else{ unset($_SESSION['tablas']); }
	
	if($_SESSION['Nivel'] == 'user'){
		print("<table align='center' style='border:1; margin-top:2px' width='auto'>
				<tr>
					<td align='center'>
							TABLAS EXPORTABLES PARA BBDD ".$_SESSION['ref'].".
					</td> 
				</tr>
			</table>");	
	}

	if($_SESSION['Nivel'] == 'admin'){
		print("<table class='centradiv'>
				<tr>
					<th>EXPORTE TABLAS BBDD<br>SELECCIONE UN USUARIO</th>
				</tr>		
				<tr>
					<td>
			<form name='form_tabla' method='post' action='$_SERVER[PHP_SELF]'>
				<input type='hidden' name='Orden' value='".@$defaults['Orden']."' />
					<div style='float:left; margin-right:6px''>
				<button type='submit' title='SELECCIONE USUARIO / TABLA' class='botonlila imgButIco InicioBlack' style='vertical-align:top;' ></button>
						<input type='hidden' name='oculto1' value=1 />
					</div>
					<div style='float:left'>
						<select name='tablas'>
				<!-- -->	<option value=''");
		if(@$defaults['tablas'] == ''){
					print ("selected = 'selected'");
		}
					print(">LAS TABLAS O USUARIO</option>
				<option value = 'admin'");
		if(@$defaults['tablas'] == 'admin'){
					print ("selected = 'selected'");
		}
							/* */
					print("> Tabla Admin Sistem </option>");
							
		global $db;
		global $tablau;				$tablau = "`".$_SESSION['clave']."admin`";
		$sqlu =  "SELECT * FROM $tablau ORDER BY `ref` ASC ";
		$qu = mysqli_query($db, $sqlu);
		if(!$qu){
				print("ERROR SQL L.85 ".mysqli_error($db)."<br>");
		}else{
			while($rowu = mysqli_fetch_assoc($qu)){
				print ("<option value='".strtolower($_SESSION['clave'].$rowu['ref'])."' ");
				if(strtolower($_SESSION['clave'].$rowu['ref']) == @$defaults['tablas']){
						print ("selected = 'selected'");
				}
						print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
			}
		}  
		print ("</select>
					</div>
						</form>	
					</td>
				</tr>
			</table>"); 
	}
	
			////////////////////		**********  		////////////////////

	if((isset($_POST['oculto1']))||(isset($_POST['todo']))){
			
		if($_SESSION['tablas'] == '') { 
			print("<div class='centradiv' style='border-color:#F1BD2D;color:#F1BD2D;padding:0.6em;'>
							SELECCIONE UNA TABLA O NOMBRE DE USUARIO
					</div>");
		}	
					
		if($_SESSION['tablas'] != ''){

			global $nom; 			$nom = strtolower($_SESSION['tablas']);
			if(strtolower($_SESSION['tablas']) == 'admin'){ $nom = "%".$nom."%"; 
			}else{ $nom = "%".$nom."%"; }
			$nom = "LIKE '$nom'";
	
			/* Se busca las tablas en la base de datos */

			//$consulta = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES ";
			$consulta = "SHOW TABLES FROM $db_name $nom";
			$respuesta = mysqli_query($db, $consulta);
			if(!$respuesta){
				print("ERROR SQL L.127 ".mysqli_error($db)."</br>");
			}else{	
				print("<table class='TFormAdmin'>
						<tr>
							<th colspan=2>
								TABLAS EXPORTABLES ".mysqli_num_rows($respuesta)."
							</th>
						</tr>");
				while ($fila = mysqli_fetch_row($respuesta)){
					if($fila[0]){
						print("<tr>
							<td>".$fila[0]."</td>
							<td>
						<form name='exporta' action='$_SERVER[PHP_SELF]' method='POST'>
							<input type='hidden' name='tablas' value='".$defaults['tablas']."' />
							<input type='hidden' name='tabla' value='".$fila[0]."' />
				<button type='submit' title='EXPORTA TABLA ".strtoupper($fila[0])."' class='botonverde imgButIco OpenBlack' style='vertical-align:top;' ></button>
							<input type='hidden' name='oculto2' value=1 />
						</form>
							</td>
						<tr>");
					}
				}
			print("</table>");		
			}
		}
	}
	
} // FIN function show_fomr

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function ver_todo(){
	
		require 'export_bbdd.php';

}	/* Final ver_todo(); */

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function listfiles(){
	
	global $ruta;			$ruta ="bbdd/";
	
	$directorio = opendir($ruta);
	global $num;			$num=count(glob("bbdd/{*}",GLOB_BRACE));
	if($num < 1){
		print ("<table class='centradiv' style='border-color:#F1BD2D;color:#F1BD2D;padding:0.8em;'>
			<tr><td>NO HAY ARCHIVOS PARA DESCARGAR</td></tr>");
	}else{
		print ("<table class='TFormAdmin'>
			<tr><th align='center' colspan='3'>ARCHIVOS RESPALDO BBDD</th></tr>");
		while($archivo = readdir($directorio)){
			if($archivo != ',' && $archivo != '.' && $archivo != '..'){
				print("<tr>
				<td>
					<form name='delete' action='$_SERVER[PHP_SELF]' method='post'>
						<input type='hidden' name='tablas' value='".isset($_SESSION['tablas'])."' />
						<input type='hidden' name='ruta' value='".$ruta.$archivo."'>
				<button type='submit' title='ELIMINAR ".strtoupper($archivo)."' class='botonrojo imgButIco DeleteBlack' style='vertical-align:top;' ></button>
						<input type='hidden' name='delete' value='1' >
					</form>
				</td>
				<td>
					<form name='archivos' action='".$ruta.$archivo."' target='_blank' method='post'>
						<input type='hidden' name='tablas' value='".isset($_SESSION['tablas'])."' />
				<button type='submit' title='DESCARGAR ".strtoupper($archivo)."' class='botonverde imgButIco OpenBlack' style='vertical-align:top;' ></button>
					</form>
				</td>
				<td>".strtoupper($archivo)."</td>");
			}else{ }
		} // FIN DEL WHILE
	}
	closedir($directorio);
	print("</table>");
}

function delete(){ unlink($_POST['ruta']); }
	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function master_index(){
		
	require '../Inclu_MInd/rutaupbbdd.php';
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