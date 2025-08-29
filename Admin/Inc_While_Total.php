<?php

	if(!$qb){
			print("SQL ERROR: ".mysqli_error($db)."</br>");
			show_form();	
	}else{
		if(mysqli_num_rows($qb)== 0){
			print ("<div class='centradiv'>
						".$inicioadmincrear.$inciobajas."<hr>
							NO HAY DATOS
					</div>");
		}else{ global $page;
				if($page >= 1){ }else{ $page = 1; }

			if(isset($_POST['ocultoc'])){
				$defaults['Nombre'] = $_POST['Nombre'];
				$defaults['Apellidos'] = $_POST['Apellidos'];
				global $refrescaimg;
				$refrescaimg = "<form name='refresimg' action='".$ruta."Admin_Ver.php' method='POST' style='display: inline-block;' >
					<input type='hidden' name='Nombre' value='".@$defaults['Nombre']."' />
					<input type='hidden' name='Apellidos' value='".@$defaults['Apellidos']."' />
					<button type='submit' title='REFRESCAR DESPUES DE MODIFICAR DATOS' class='botonlila imgButIco CachedBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='ocultoc' value=1 />
								</form>";
			}else{ 	global $refrescaimg;
					$refrescaimg = "<form name='refresimg' action='".$ruta."Admin_Ver.php' style='display: inline-block;' >
				<button type='submit' title='REFRESCAR DESPUES DE MODIFICAR DATOS' class='botonlila imgButIco CachedBlack' style='vertical-align:top;' ></button>
					<input type='hidden' name='page' value=".$page." />
				</form>";
			}

		print ("<div class='centraWhileDatos'>
		<!--".$twhile.": ".mysqli_num_rows($qb).".-->".@$inicioadmincrear.@$inciobajas.$refrescaimg."<br>");
                  
		while($rowb = mysqli_fetch_assoc($qb)){
    
			global $formularioh;			global $formulariof;
			global $formulariohi;			global $formulariofi;
			global $formulariohe;			global $formulariofe;

		print ("<div class='CardWhileDatos'>
			<div class='whiletotalaimg'>
				<img src='".$rutaimg.$rowb['ref']."/img_admin/".$rowb['myimg']."' />
			</div>
			<div class='whiletotala'>
				<div class='DatLabel'>NOMBRE: </div><div class='Dato'>".$rowb['Nombre']."</div>
			</div>
			<div class='whiletotala'>
				<div class='DatLabel'>APELLIDO: </div><div class='Dato'>".$rowb['Apellidos']."</div>
			</div>
			<div class='whiletotala'>
				<div class='DatLabel'>NIVEL: </div><div class='Dato'>".$rowb['Nivel']."</div>
			</div>
			<div class='whiletotala'>
				<div class='DatLabel'>REF USER: </div><div class='Dato'>".$rowb['ref']."</div>
			</div>
			<div class='whiletotala'>
				<div class='DatLabel'>USER: </div><div class='Dato'>".$rowb['Usuario']."</div>
			</div>
			<div class='whiletotala'>
				<div class='DatLabel'>PASS: </div><div class='Dato'>".$rowb['Pass']."</div>
			</div>");

		if($Feedback==1){
			$BorradoD = substr($rowb['borrado'],0,10);
			$BorradoT = substr($rowb['borrado'],-8);
			print("
			<div class='whiletotala'>
				<div class='DatLabel'>Del Date: </div><div class='Dato'>".$BorradoD."</div>
			</div>
			<div class='whiletotala'>
				<div class='DatLabel'>Del Time: </div><div class='Dato'>".$BorradoT."</div>
			</div>");
		}else{ }

        print("<!-- AQUÍ VA LA BOTONERA -->
			<div style='text-align:center;'>".$formularioh);

			require 'rowbtotal.php';

			print($formulariof.$formulariohg);

			require 'rowbtotal.php';

			print($formulariofg.$formulariohi);
		
			require 'rowbtotal.php';
		
			print($formulariofi.$formulariohe);

		if(($_SESSION['Nivel'] == 'admin')&&($rowb['dni'] != $_SESSION['webmaster'])){

			global $formulariohe;
			$formulariohe = "<form style=\"display:inline-block;\" name='borra' action='".@$ruta."Admin_Borrar_02.php' method='POST'>";
			global $formulariofe;
			$formulariofe = "<button type='submit' title='DAR DE BAJA' class='botonrojo imgButIco DeleteBlack' style='vertical-align:top;' ></button>
				<input type='hidden' name='oculto2' value=1 />
				</form>";
			}else{	
				global $formulariohe;			$formulariohe = "";
				global $formulariofe;			$formulariofe = "";
			}

			print($formulariohe);
				require 'rowbtotal.php';
			print($formulariofe);
            
			print("</div></div>");// FIN div botonera y card datos.

			}  // FIN DEL WHILE

		print("</div>");

		} // FIN else else

		require 'Paginacion_Footter.php';
	
	} //FIN else

?>