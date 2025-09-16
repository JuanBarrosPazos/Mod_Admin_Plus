<?php    
	session_start();

	require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Inclu/mydni.php';
	require '../Inclu/nemp.php';

	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

	require '../Inclu_MInd/rutaqrgen.php';
	require '../Inclu_MInd/Master_Index.php';

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
	global $num;		$num = count(glob("temp/{*}",GLOB_BRACE));

	if($num > 1){ deletemp(); }else{ }

	global $num2;		$num2 = count(glob("qrimg/{*}",GLOB_BRACE));

	//print($_SESSION['nuser']);
	if($num2 >= ($_SESSION['nuser']*2+6)){ deleqrimg(); }else{ }

	if(isset($_POST['oculto'])){

		if($form_errors = validate_form()){ qrsize();
											show_form($form_errors);
											listfiles();
		}else{	qrsize();
				process_form();
				qrimg();
				show_form();
				listfiles();
		}

	}elseif(isset($_POST['delete'])){	qrsize();
										show_form();
										delete(); 
										listfiles();

	}elseif(isset($_POST['downl'])){	qrsize();
										//qrimg();
										show_form();
										download();
										listfiles();
	}else{	qrsize();
			//qrimg();
			show_form();
			listfiles();	
	}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function qrsize(){

	if(isset($_REQUEST['level']) && (in_array($_REQUEST['level'], array('L','M','Q','H')))){
		global $errorCorrectionLevel;
        $errorCorrectionLevel = $_REQUEST['level']; 
	   
	}else{	global $errorCorrectionLevel;
			$errorCorrectionLevel = 'Q';
	}

    if(isset($_REQUEST['size'])){
		global $matrixPointSize;
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

	}else{	global $matrixPointSize;
    		$matrixPointSize = 6;
	}

} // FIN function qrsize

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function download(){

	global $a;				$a = 1;
	// Redirección de la imagen a otra pestaña...
	global $redir;
	$redir = "<script type='text/javascript'>
				function redir(){
				window.open ('".$_POST['downlRuta']."', '_blank') ;
				}
				setTimeout('redir()',400);
			  </script>";
	print($redir);

}
				
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_form(){

    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
	//html PNG location prefix
	global $PNG_WEB_DIR;			$PNG_WEB_DIR = 'temp/';

	include "phpqrcode.php";
    
    //ofcourse we need rights to create temp dir
    if(!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
	
	global $filename;				$filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
	//remember to sanitize user input in real-life solution !!!

	global $errorCorrectionLevel;
	global $matrixPointSize;

    if((isset($_REQUEST['metodo']))&&(isset($_REQUEST['usercod']))) { 
		if($_REQUEST['metodo'] == 'index.php?pin=' ){ 
			global $metodo;
			$metodo = 'CONFIRM_';
		}else{
			global $metodo;
			$metodo = 'AUTO_';
		}
		global $data;			$data = $_REQUEST['metodo'].$_REQUEST['usercod'];
		//print ($data);
        //it's very important!
        if(trim($data) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
    $filename = $PNG_TEMP_DIR.'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
	//print("<br>".$filename."<br>".$metodo.$_REQUEST['usercod']);

	if(strlen(trim($_POST['imgname'])) == 0){
		global $metodo;
		global $imgname;				$imgname = $metodo.$_REQUEST['usercod'];

		if(file_exists("qrimg/".$imgname.".png")){unlink("qrimg/".$imgname.".png");}else{}

		if(file_exists($filename)){copy($filename, "qrimg/".$imgname.".png");}else{}
		}else{
			global $imgname;		$imgname = str_replace(' ', '_',$_POST['imgname']);
		  	global $data;
			if(file_exists("qrimg/".$imgname.".png")){ unlink("qrimg/".$imgname.".png"); }else{}
			if(file_exists($filename)){copy($filename, "qrimg/".$imgname.".png");}else{}
		}
 
    }else{    
        //default data
		/*
			echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a>'; 
		*/   
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
    }    

} //Fin function process_form

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_form(){
	
	$errors = array();

	if(strlen(trim($_POST['metodo'])) == 0){
		$errors [] = "METODO: <font color='#F1BD2D'> es obligatorio.</font>";
	}

	if(strlen(trim($_POST['usercod'])) == 0){
		$errors [] = "USUARIO: <font color='#F1BD2D'> es obligatorio.</font>";
	}

	return $errors;

} 

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function qrimg(){
	
	global $PNG_WEB_DIR;
	global $filename;
	//display generated file
	print("	<div style='text-align: center'>
				<img src='".$PNG_WEB_DIR.basename($filename)."' />
			</div>");  
}  

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function Show_form($errors=[]){	

	if(isset($_POST['downl'])){
		print("<embed src='../audi/file_exp_ok.mp3' autostart='true' loop='false' ></embed>");
	}

	global $errorCorrectionLevel;			global $matrixPointSize;

	if(isset($_POST['oculto'])){ $defaults = $_POST;

	}else{	$defaults = array( 'metodo' => isset($_REQUEST['metodo']),
								'usercod' => isset($_REQUEST['usercod']),
								'imgname' => isset($_REQUEST['imgname']),);
	}

	if($errors){
		global $a;		$a = 1;
		print("<div class='centradiv'>
				<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font><br>");
		for($a=0; $c=count($errors), $a<$c; $a++){
				print("<font color='#F1BD2D'>**</font>  ".$errors [$a]."<br>");
		}
		print("</div>
		<embed src='../audi/error_form.mp3' autostart='true' loop='false' ></embed>");

	}else{	global $a;		$a = 0; }

	$metodo = array('' => 'METODO EN QUE EL QR ACTUA',
					'index.php?pin=' => 'CONFIRMACION DATOS USUARIO',
					'indexqr.php?pin=' => 'FICHAR AUTO SIN CONFIRMACION');

	print("<div class='centradiv'>
			<form action='$_SERVER[PHP_SELF]' method='post'>
				<select name='metodo' class='botonlila' style='margin:0.4em;'>");
				foreach($metodo as $option => $label){
					print ("<option value='".$option."' ");
					if($option == $defaults['metodo']){	print ("selected = 'selected'");}
														print ("> $label </option>");
				}	
					
		print ("</select>
				<br>
       		<div style='display:inline-block;vertical-align:middle;margin:0.4em;'>QR FOR: </div>
				<select name='usercod' class='botonlila' style='vertical-align:middle;'>
				<option value=''>SELECCIONE UN USUARIO</option><!-- --> ");

	global $db;
	global $tablau;			$tablau = "`".$_SESSION['clave']."admin`";

	$sqlu =  "SELECT * FROM $tablau ORDER BY `ref` ASC ";
	$qu = mysqli_query($db, $sqlu);

	if(!$qu){
			print("SQL ERROR L.266 ".mysqli_error($db)."<br>");
	}else{
		while($rowu = mysqli_fetch_assoc($qu)){
			print ("<option value='".$rowu['dni']."' ");
			if($rowu['dni'] == $defaults['usercod']){
				print ("selected = 'selected'");
			}
			print ("> ".$rowu['Nombre']." ".$rowu['Apellidos']." </option>");
		}
	}  

	print("</select><br>
				<div style='display:block;margin:0.4em;'>CALIDAD Y DEFINICION DEL QR </div>
				<div style='display:inline-block; vertical-align:middle;margin:0.4em;'>ECC: </div> ");
	
	echo'<select name="level" class="botonlila" style="vertical-align:middle;">
			<option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
			<option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
			<option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
			<option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
		  </select>';
		  
	print("<div style='display:inline-block;vertical-align:middle;margin:0.4em;'> SIZE: </div>
			<select name='size' class='botonlila' style='vertical-align:middle;'>");

	for($i=1;$i<=10;$i++){
		echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
	}

	print ("</select> 
				<br>
			<input name='imgname' size=32 maxlength=14 value='".$defaults['imgname']."' placeholder='OPCIONAL NAME FOR IMAGE' style='margin:0.9em;text-align:center;' />
			<button type='submit' title='GENERATE QR CODE FOR USER' class='botonverde imgButIco SaveBlack' style='vertical-align:top;margin:0.5em;' ></button>
				<input type='hidden' name='oculto' value=1 />
		</form>
	</div>");

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function deletemp(){

	global $ruta;		$ruta = "temp/";
	if(file_exists($ruta)){  
		$dir = $ruta."/";
		$handle = opendir($dir);
		while ($file = readdir($handle)){
			if(is_file($dir.$file)){
				unlink($dir.$file);}
			}
	}else{ }
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function deleqrimg(){

	global $ruta;			$ruta = "qrimg/";
	if(file_exists($ruta)){ 
		$dir = $ruta."/";
		$handle = opendir($dir);
		while ($file = readdir($handle)){
			if(is_file($dir.$file)){
					unlink($dir.$file);
			}
		}
	}else{ }
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	
function listfiles(){
	
	global $num3;			$num3=count(glob("qrimg/{*}",GLOB_BRACE));

	global $ruta;			$ruta ="qrimg/";
	//print("RUTA: ".$ruta.".</br>");
	
	global $rutag;			$rutag = "qrimg/{*}";
	//print("RUTA G: ".$rutag.".</br>");
		
	$directorio = opendir($ruta);
	global $num;			$num=count(glob($rutag,GLOB_BRACE));
	global $a;

	if($num < 1){
		
		if($a == 0){
			print("<embed src='../audi/no_file.mp3' autostart='true' loop='false' ></embed>");
		}
		
		print ("<div class='centradiv' style='border-color:#F1BD2D; color:#F1BD2D;padding:0.8em;'>
					NO HAY ARCHIVOS PARA DESCARGAR
				</div>");

	}else{

		if($a == 0){
			print("<embed src='../audi/files_for_exp.mp3' autostart='true' loop='false' ></embed>");
		}

		print("<div class='centradiv' style='border:none !important'>
                <a href='../cam/indexcam.php'>
                    <button type='button' title='QR SCANNER READER' class='botonverde imgButIco FotoBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
                </a>    
                <!--
                <a href='indexqrg.php'>
                    <button type='button' title='QR USER CREATOR' class='botonverde imgButIco QrBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
                </a>   
                -->
                <a href='../Admin/Admin_Ver.php'>
                    <input type='hidden' name='time' value='".@$_SESSION['time']."' />
                    <button type='submit' title='FICHAR FILTRO DE EMPLEADOS' class='botonverde imgButIco HomeBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
                    <input type='hidden' name='grafico2' value=1 />
                </a>    
            </div>");

		print("<ul class='centradiv' style='padding:0.4em;'>
				<div>QR CODES FOR EXPORT  ".$num3."</div> 
				<div style='margin:0.4em auto;'>IF > ".(($_SESSION['nuser']*2+6))." AUTO DELETE QR FILES</div>");

		$countbgc = 0;
		while($archivo = readdir($directorio)){

			if(($countbgc%2) == 0){ 
				$bgcolor ="background-color:#59746A;"; 
			}else{ $bgcolor =""; }

			if($archivo != ',' && $archivo != '.' && $archivo != '..'){

		print("<li style='min-height:2.6em; list-style-type:none;clear:both;padding-top:0.4em;".$bgcolor."'>
			<form name='delete' action='$_SERVER[PHP_SELF]' method='post' style='display:inline-block; float:left;'>
				<input type='hidden' name='downlRuta' value='".$ruta.$archivo."'>
					<button type='submit' title='ELIMINAR' class='botonrojo imgButIco DeleteBlack' style='vertical-align:middle;margin-left:0.4em;' ></button>
				<input type='hidden' name='delete' value='1' >
			</form>
			<form name='archivos' action='$_SERVER[PHP_SELF]' method='POST' style='display:inline-block; float:left; margin-left:0.4em;'>
				<input type='hidden' name='downlRuta' value='".$ruta.$archivo."'>
				<input type='hidden' name='downlDir' value='".$ruta."'>
				<input type='hidden' name='downlFile' value='".$archivo."'>
					<button type='submit' title='DESCARGAR' class='botonverde imgButIco DescargaBlack' style='vertical-align:middle;'></button>
				<input type='hidden' name='downl' value='1' >
			</form>
			<div style='display:inline-block; float:left; margin:0.5em 0.1em 0.1em 0.4em;'>
				".strtoupper($archivo)."
			</div>
				</li>");
			}else{ }
		
			$countbgc = $countbgc+1;

		} // FIN DEL WHILE

	closedir($directorio);
	print("</ul>");

	}
}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
					
function delete(){
	global $a;			$a = 1;
	unlink($_POST['downlRuta']);
	print("<embed src='../audi/deleteqr.mp3' autostart='true' loop='false'></embed>");
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
