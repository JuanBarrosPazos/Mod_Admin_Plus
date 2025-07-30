<?php

		global $rutaJsRedir;
		$rutaJsRedir = '../index.php';
		global $redirphp;
		$redirphp ="<script type='text/javascript'>
						function redir(){
						window.location.href='".$rutaJsRedir."';
						} setTimeout('redir()',4000);
					</script>";

print("<table align='center' style=\"margin-top:100px;margin-bottom:100px\">
						<tr align='center'>
							<td>
								<font color='red'>
									<b>
										ACCESO RESTRINGIDO.
									</br>
										CONSULTE SUS PERMISOS ADMINISTRATIVOS.
									</b>
								</font>
							</td>
						</tr>
					</table>
					
					$redirphp
		");

?>