<?php

	$tablarin = "<ul class='centradiv'>
			<li class='liCentra'>HA FICHADO LA ENTRADA</li>
			<li class='liCentra'>".strtoupper($_POST['name1'])." ".strtoupper($_POST['name2'])."</li>
			<li>
				<div>REFERENCIA: </div><div>".$_POST['ref']."</div>
			</li>
			<li>
				<div>FECHA ENTRADA: </div><div>".$_POST['din']."</div>
			</li>
			<li>
				<div>HORA ENTRADA: </div><div>".$_POST['tin']."</div>
			</li>
			<li class='liCentra'>
				<a href='fichar_Crear.php' >
					<button type='button' title='VOLVER INICIO' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
				</a>
			</li>
				</ul>
			<embed src='../audi/entrada.mp3' autostart='true' loop='false' ></embed>
			<script type='text/javascript'>
				function redir(){window.location.href='fichar_Crear.php';}
					setTimeout('redir()',8000);
			</script>";	


	$tablarout = "<ul class='centradiv'>
		<li class='liCentra'>HA FICHADO LA SALIDA</li>
		<li class='liCentra'>".strtoupper($_POST['name1'])." ".strtoupper($_POST['name2'])."</li>
		<li>
			<div>REFERENCIA: </div><div>".$_POST['ref']."</div>
		</li>
		<li>
			<div>FECHA ENTRADA: </div><div>".$din."</div>
		</li>
		<li>
			<div>HORA ENTRADA: </div><div>".$tin."</div>
		</li>
		<li>
			<div>FECHA SALIDA: </div><div>".$_POST['dout']."</div>
		</li>
		<li>	
			<div>HORA SALIDA: </div><div>".$_POST['tout']."</div>
		</li>
		<li>
			<div>H. REALIZADAS: </div><div>".$ttot."</div>
		</li>
		<li class='liCentra'>
			<a href='fichar_Crear.php'>
				<button type='button' title='VOLVER INICIO' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
			</a>	
		</li>
				</ul>
		<embed src='../audi/salida.mp3' autostart='true' loop='false' ></embed>
			<script type='text/javascript'>
				function redir(){window.location.href='fichar_Crear.php';}
				setTimeout('redir()',8000);
			</script>";	

?>