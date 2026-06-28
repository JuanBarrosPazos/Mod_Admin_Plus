<?php

    global $name1;		global $name2;		global $refses;		global $TablaTitulo;
	global $dy;			global $dyt1;		global $sumatodo;
	global $db;			global $qb;

	if(!$qb){
		print("* ERROR SQL L.82||85||88 Reg_Fichar_Ver.php".mysqli_error($db)."</br>");
	}else{
		if(mysqli_num_rows($qb) == 0){
			print ("<div class='centradiv alertdiv'>NO HAY DATOS</div>
					<audio src='../audi/no_files_for_query.mp3' autoplay></audio>");

		}else{ 
			if(($_POST['dd']=="")&&(!isset($_POST['cherror'])&&(!isset($_POST['chbin'])))){
				print ("<div class='centradiv alertdiv'>
							".$name1." ".$name2." Ref: ".$refses."<br>
							".$dyt1." TOTALES CONSULTA<br>
							".$sumatodo."<br>
							LOS ERRORES NO COMPUTAN
						</div>");
			}

			global $nombre_archivo;		$nombre_archivo = "reporte_consultas.csv";
			global $ruta_csv;			$ruta_csv = __DIR__ . '/' . $nombre_archivo;

			print "<div class='centradiv'>";
			if (file_exists($ruta_csv)){

			print "<a href='".$nombre_archivo."' download='Reporte_".$name1."_".$name2."_".date('Y-m-d').".csv'>
						Descargar CSV
					</a>";
			}
			print "</div>";

			print ("<table class='centradiv'>
						<tr>
							<td colspan=7 style='color:#F1BD2D;'>
								".$TablaTitulo.$name1." ".$name2.". Ref: ".$refses."
							</td>
						</tr>
						<tr>
							<td>ID</td>			<td>DATE IN</td>		
							<td>TIME IN</td>	<td>DATE OUT</td>										
							<td>TIME OUT</td>	<td>TIME TOT</td>
							<td></td>
						</tr>");
		
			global $action1;	global $action2;	global $botonTit1;		global $botonTit2;
			if((isset($_POST['chbin']))&&(!isset($_POST['cherror']))){
				//$action1 = "Reg_Fichar_Bin_Recuperar.php";
				$action1 = "Reg_Fichar_Borrar.php";
				$botonTit1 = "RECUPERAR REGISTRO";
				$input1 = "<input type='hidden' name='recupera' value='recupera' />";
				//$action2 = "Reg_Fichar_Bin_Borrar.php";
				$action2 = "Reg_Fichar_Borrar.php";
				$botonTit2 = "BORRAR PAPELERA";
				$input2 = "<input type='hidden' name='elimina' value='elimina' />";

				print("<audio src='../audi/files_in_bin.mp3' autoplay></audio>");

			}else{
				$action1 = "Reg_Fichar_Modificar.php";
				$botonTit1 = "MODIFICAR REGISTROS";
				$input1 = "";
				$action2 = "Reg_Fichar_Borrar.php";
				$botonTit2 = "BORRAR DATOS";
				$input2 = "";
				if((isset($_POST['cherror']))&&(!isset($_POST['chbin']))){
					print("<audio src='../audi/files_in_errors.mp3' autoplay></audio>");
				}else{
					print("<audio src='../audi/files_for_you_query.mp3' autoplay></audio>");
				}

			}
		
			$countbgc = 0;
			while($rowb = mysqli_fetch_assoc($qb)){
				global $sty;
				if($rowb['error'] == "true"){ 
						$sty = "color: #F1BD2D; font-weight: bold;";
				}else{ $sty = ""; }

				if(($countbgc%2)==0){
						$bgcolor ="background-color:#59746A;";
				}else{ 	$bgcolor =""; }

				global $vname;				global $dyt1;

				print ("<tr>
						<td align='center' style='".$sty.$bgcolor."'>
				<form name='modifica' action='".$action1."' method='POST' style='display:inline-block;'>
						".$rowb['id']."
						</td>
						<td style='".$sty.$bgcolor."'>".$rowb['din']."</td>
						<td style='".$sty.$bgcolor."'>".$rowb['tin']."</td>
						<td style='".$sty.$bgcolor."'>".$rowb['dout']."</td>
						<td style='".$sty.$bgcolor."'>".$rowb['tout']."</td>
						<td style='".$sty.$bgcolor."'>".$rowb['ttot']."</td>
						<td style='".$sty.$bgcolor."'>");
				
				require 'Inc_Input_Row_Total.php';

				print($input1."<button type='submit' title='".$botonTit1."' class='botonverde imgButIco Clock2Black' style='vertical-align:middle;' ></button>
					</form>

				<form name='modifica' action='".$action2."' method='POST' style='display:inline-block;'>");

				require 'Inc_Input_Row_Total.php';
				
				print($input2."<button type='submit' title='".$botonTit2."' class='botonrojo imgButIco DeleteBlack' style='vertical-align:middle;' ></button>
					</form>
						</td>
					</tr>");
				
				$countbgc = $countbgc+1;

			} /* FIN del while.*/

		print "</table>";

		// ARCHIVO DESCARGA DE LOS DATOS DE LA CONSULTA
		// 1. Definir la ruta automática del archivo en el mismo directorio del documento
		// LOS DEFINO EN: Inc_Fichar_While_Total.php...
		//$nombre_archivo = "reporte_consultas.csv";
		//$ruta_csv = __DIR__ . '/' . $nombre_archivo;

		// 2. Ejecutar la consulta SQL (Asegúrate de pasar los parámetros limpios)
		global $db;		global $sqlb;		global $fil;
		$qb = mysqli_query($db, $sqlb);

		// 3. Abrir el archivo CSV para escritura ('w' vacía el archivo si ya existe y lo sobrescribe)
		$archivo_csv = fopen($ruta_csv, 'w');
		
		// Usamos fwrite para escribir la cadena de texto exacta con un salto de línea al final
		$linea_comentario = "# ".$name1." ".$name2." || Ref: ".$refses." || ".$dyt1." ".$fil." || TOTALES CONSULTA: ".$sumatodo."\n";
		fwrite($archivo_csv, $linea_comentario);

		// Opcional: Agregar una fila de cabeceras al CSV
		fputcsv($archivo_csv, ['ID', 'Fecha Entrada', 'Hora Entrada', 'Fecha Salida', 'Hora Salida', 'Total'], ",", '"', "");

		// Almacenamos filas en un array temporal para no perder el puntero al pintar la tabla
		$filas_datos = [];

		while ($rowb = mysqli_fetch_assoc($qb)) {
			$filas_datos[] = $rowb;

			// 4. Preparar la estructura de datos que solicitaste
			$linea_csv = [
				$rowb['id'],
				$rowb['din'],
				$rowb['tin'],
				$rowb['dout'],
				$rowb['tout'],
				$rowb['ttot']
			];
			
			// 5. Guardar automáticamente la línea en el archivo CSV
			fputcsv($archivo_csv, $linea_csv, ",", '"', "");
		}
		
		// Cerrar el archivo de manera segura
		fclose($archivo_csv);
		
		// 6. Interfaz Web: Botón de descarga y visualización de resultados
		print "<div class='centradiv'>";
			if (file_exists($ruta_csv)){

				print "<a href='".$nombre_archivo."' download='Reporte_".$name1."_".$name2."_".date('Y-m-d').".csv'>
							Descargar CSV
						</a>";
			}
		print "</div>";

	} /* FIN segundo else anidado en if */

} /* FIN de primer else . */

?>