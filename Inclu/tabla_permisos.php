<?php

	global $playini;	global $rutaJsRedir;
	if($playini == 1){ $rutaJsRedir = 'index.php'; }else{ $rutaJsRedir = '../index.php'; }

	global $redirphp;
	$redirphp ="<script type='text/javascript'>
					function redir(){
					window.location.href='".$rutaJsRedir."';
					} setTimeout('redir()',4000);
				</script>";

	print("<table class='centradiv alertdiv'>
				<tr align='center'>
					<td>
						ACCESO RESTRINGIDO
					</br>
						CONSULTE SUS PERMISOS ADMINISTRATIVOS
					</td>
				</tr>
			</table>
		<audio src='audi/user_error.mp3' autoplay></audio>");

	print("$redirphp");	

?>