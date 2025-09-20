<?php

	$countbgc = 0;
	while($archivo = readdir($directorio)){
		if(($countbgc%2)==0){
			$bgcolor ="background-color:#59746A;";
		}else{ $bgcolor =""; }

		if($archivo != ',' && $archivo != '.' && $archivo != '..'){
			print("<tr>
					<td style='".$bgcolor."'>
						<form name='delete' action='$_SERVER[PHP_SELF]' method='post'>
							<input type='hidden' name='tablas' value='".$_SESSION['tablas']."' />
							<input type='hidden' name='ruta' value='".$ruta.$archivo."'>
			<button type='submit' title='ELIMINAR ".strtoupper($archivo)."' class='botonrojo imgButIco DeleteBlack' style='vertical-align:top;' ></button>
							<input type='hidden' name='delete' value='1' >
						</form>
					</td>
					<td style='".$bgcolor."'>
						<form name='archivos' action='".$ruta.$archivo."' target='_blank' method='post'>
							<input type='hidden' name='tablas' value='".$_SESSION['tablas']."' />
			<button type='submit' title='DESCARGAR ".strtoupper($archivo)."' class='botonverde imgButIco DescargaBlack' style='vertical-align:top;' onclick='FunEmbed()' ></button>
						</form>
					</td>
					<td style='".$bgcolor."'>".strtoupper($archivo)."</td>");
		}else{}
		$countbgc = $countbgc+1;
	} // FIN DEL WHILE

?>