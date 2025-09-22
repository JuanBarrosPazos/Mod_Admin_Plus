<?php

	global $name1;		global $name2;		global $ref;		global $din;	global $tin;
	global $dout;		global $tout;		global $ttot;
	global $rutaHome;	global $rutaRedir;	global $rutaAudio;	global $imgTabla;

	global $tablaModif;	global $TablaTitulo;	
	
	if($tablaModif == 1){
		$TablaTitulo = "HA MODIFICADO LA SALIDA";
	}else{
		$TablaTitulo = "HA FICHADO LA SALIDA";
	}

	if(isset($rp['Nombre'])){
		$name1 = $rp['Nombre'];
	}elseif(isset($_POST['name1'])){ 
		$name1 = $_POST['name1'];
	}

	if(isset($rp['Apellidos'])){
		$name2 = $rp['Apellidos'];
	}elseif(isset($_POST['name2'])){ 
		$name2 = $_POST['name2'];
	}

	if(isset($rp['ref'])){
		$ref = $rp['ref'];
	}elseif(isset($_POST['ref'])){
		$ref = $_POST['ref'];
	}elseif(isset($_SESSION['usuarios'])){
		$ref = $_SESSION['usuarios'];
	}else{ $ref = $_SESSION['ref']; }

	if(isset($_POST['din'])){
		$din = $_POST['din'];
	}

	if(isset($_POST['tin'])){
		$tin = $_POST['tin'];
	}

	if(isset($_POST['dout'])){
		$dout = $_POST['dout'];
	}

	if(isset($_POST['tout'])){
		$tout = $_POST['tout'];
	}

	if(isset($_POST['id'])){
		$RegId = "<li>
					<div>ID: </div><div>".$_POST['id']."</div>
				</li>";
	}else{ $RegId = ""; }

	$TablaIn = "<ul class='centradiv'>
			<li class='liCentra'>HA FICHADO LA ENTRADA</li>
			<li class='liCentra'>".strtoupper($name1)." ".strtoupper($name2)."</li>
			".$imgTabla.$RegId."
			<li>
				<div>REFERENCIA: </div><div>".$ref."</div>
			</li>
			<li>
				<div>FECHA ENTRADA: </div><div>".$din."</div>
			</li>
			<li>
				<div>HORA ENTRADA: </div><div>".$tin."</div>
			</li>
			<li class='liCentra'>
				<a href='".$rutaHome."' >
					<button type='button' title='VOLVER INICIO' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
				</a>
			</li>
				</ul>
			<script type='text/javascript'>
				function redir(){window.location.href='".$rutaRedir."';}
					setTimeout('redir()',8000);
			</script>".$rutaAudio;

	$TablaOut = "<ul class='centradiv'>
			<li class='liCentra'>".$TablaTitulo."</li>
			<li class='liCentra'>".strtoupper($name1)." ".strtoupper($name2)."</li>
			<li>
				<div>REFERENCIA: </div><div>".$ref."</div>
			</li>
			<li>
				<div>FECHA ENTRADA: </div><div>".$din."</div>
			</li>
			<li>
				<div>HORA ENTRADA: </div><div>".$tin."</div>
			</li>
			<li>
				<div>FECHA SALIDA: </div><div>".$dout."</div>
			</li>
			<li>	
				<div>HORA SALIDA: </div><div>".$tout."</div>
			</li>
			<li>
				<div>H. REALIZADAS: </div><div>".$ttot."</div>
			</li>
			<li class='liCentra'>
				<a href='".$rutaHome."'>
					<button type='button' title='VOLVER INICIO' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
				</a>	
			</li>
					</ul>
				<script type='text/javascript'>
					function redir(){window.location.href='".$rutaRedir."';}
					setTimeout('redir()',8000);
				</script>".$rutaAudio;	

?>