<?php

	global $playini;	global $rutaJsRedir;
	if($playini == 1){ $rutaJsRedir = 'index.php'; }else{ $rutaJsRedir = '../index.php'; }

	global $redirphp;
	$redirphp ="<script type='text/javascript'>
					function redir(){
					window.location.href='".$rutaJsRedir."';
					} setTimeout('redir()',4000);
				</script>";

	print("<table class='centradiv' style='color:#F1BD2D;border-color:#F1BD2D;'>
				<tr align='center'>
					<td>
						ACCESO RESTRINGIDO
					</br>
						CONSULTE SUS PERMISOS ADMINISTRATIVOS
					</td>
				</tr>
			</table>
		<embed src='audi/user_error.mp3' autostart='true' loop='false' width='0' height='0' hidden='true' >
		</embed>");

	print("$redirphp");	

?>