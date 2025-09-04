<?php

session_start();

	require 'Inclu/error_hidden.php';
	require 'Inclu/Inclu_Menu_qr.php';
	require 'Inclu/misdatos.php';
	require 'Inclu/mydni.php';

	require 'Conections/conection.php';
	require 'Conections/conect.php';
	require 'Inclu/my_bbdd_clave.php';

	unset($_SESSION['usuarios']);

	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////
	/*
	require 'Inclu_MInd/rutaindex.php';
	require 'Inclu_MInd/Master_Index.php';
	*/

	if(isset($_POST['ocultop'])){
		
		if($form_errorsp = validate_formp()){
							show_form2($form_errorsp);
		}else{ process_pin(); }

	}else{ show_form2(); }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function process_pin(){
	
	global $phppin;				$phppin = $_POST['pin'];
	global $redir;
	$redir = "<script type='text/javascript'>
					function redir(){
					window.location.href='indexqr.php?pin='+$phppin;
				}
				setTimeout('redir()',1000);
			</script>";
	print ($redir);

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function validate_formp(){
	
	global $db;					global $db_name;

	global $table_name_a;		$table_name_a = "`".$_SESSION['clave']."admin`";

	$sqlp =  "SELECT * FROM `$db_name`.$table_name_a WHERE $table_name_a.`dni` = '$_POST[pin]' ";
	$qp = mysqli_query($db, $sqlp);
	$cp = mysqli_num_rows($qp);
	
	$errorsp = array();
	
	if(strlen(trim($_POST['pin'])) == 0){
		$errorsp [] = "PIN: Campo obligatorio.";
	}elseif (strlen(trim($_POST['pin'])) < 8){
		$errorsp [] = "PIN: Incorrecto.";
	}elseif (strlen(trim($_POST['pin'])) > 8){
		$errorsp [] = "PIN: Incorrecto.";
	}elseif (!preg_match('/^[A-Z\d]+$/',$_POST['pin'])){
		$errorsp [] = "PIN: Incorrecto.";
	}/*elseif (!preg_match('/^[^a-z@´`\'áéíóú#$&%<>:"·\(\)=¿?!¡\[\]\{\};,\/:\.\*]+$/',$_POST['pin'])){
		$errors [] = "PIN: Incorrecto.";
		}

	elseif (!preg_match('/^[^a-z]+$/',$_POST['pin'])){
		$errors [] = "PIN: Incorrecto.";
	}*/elseif($cp == 0){
		$errorsp [] = "PIN: Incorrecto.";
	}

	return $errorsp;

}

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

function show_form2($errorsp=''){
	
	if(isset($_POST['pin'])){
		$defaults = $_POST;
	}else{ $defaults = array ('pin' => ''); }
	
	if($errorsp){
		print("<div class='centradiv' style='border-color:#F1BD2D !important;'>
		<!--
			<font color='#F1BD2D'>* SOLUCIONE ESTOS ERRORES:</font><br/>
			<br>
		-->
			<font color='#F1BD2D'>ERROR ACCESO PIN</font>");
		/*	
		for($a=0; $c=count($errorsp), $a<$c; $a++){
			print("<font color='#F1BD2D'>**</font>  ".$errorsp [$a]."<br/>");
			}
		*/
		print("</div>
		<embed src='audi/pin_error.mp3' autostart='true' loop='false'></embed>");
	}else{ }
	
	print("<div class='centradiv' style='border:none;'>
		<form name='pin' method='post' action='$_SERVER[PHP_SELF]' style='display:inline-block;'>	

			<input type='Password' name='pin' size=16 maxlength=9 value='".$defaults['pin']."' placeholder='FICHAR CON PIN' required style='text-align:center; margin-top:0.4em;' />

			<button type='submit' title='FICHAR CON SU PIN' class='botonverde imgButIco Clock1Black' style='vertical-align:top;' ></button>

			<input type='hidden' name='ocultop' value=1 />

			<a href='index.php'>
				<button type='button' title='VOLVER INICIO' class='botonlila imgButIco HomeBlack' style='vertical-align:top;' ></button>
			</a>
		</form>
			</div>
		<div id='AudioQr' style='height:0.0em !important;'></div>");

		global $embedDelay;
		$embedDelay = "<script type='text/javascript'>
					function embedDelay(){
		document.getElementById('AudioQr').innerHTML = \"<embed src='audi/ScanYourQr.mp3' autostart='true' loop='false'></embed>\";
					}
					setTimeout('embedDelay()',3000);
				</script>";
		print ($embedDelay);

	
} // FIN function show_form2

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

?>
	
 					<!-- *************************** -->
<!-- *************************** -->		<!-- *************************** -->
					<!-- *************************** -->
	
 <div id="pageContenido" style="text-align: center">
	  
					<!-- *************************** -->
<!-- *************************** -->		<!-- *************************** -->
					<!-- *************************** -->

	<script type="text/javascript" src="cam/instascan.min.js"></script>
	<script type="text/javascript" src="cam/jquery.min.js"></script>
	<!--
	<script src="bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
	-->
	<script src="cam/bootstrap.min.js"></script>

    <style>
        #preview {
            width: 80%;
			max-width: 35em !important;
            height: auto;
			max-height: 35em !important;
            margin: 0.4em auto 0.4em auto;
        }
		.btn {	display: inline-block; 
				margin-bottom: 0;
				font-weight: 400;
				text-align: center;
				white-space: nowrap;
				vertical-align: middle;
				-ms-touch-action: manipulation;
				touch-action: manipulation;
				cursor: pointer;
				background-image: none;
				border: 1px solid transparent;
				padding: 6px 12px;
				font-size: 14px;
				line-height: 1.42857143;
				border-radius: 4px;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none
			}
			.btn-primary {
				color: #fff;
				background-color: #337ab7;
				border-color: #2e6da4
			}

			.btn-primary.focus,
			.btn-primary:focus {
				color: #fff;
				background-color: #286090;
				border-color: #122b40
			}
			.btn-primary:hover {
				color: #fff;
				background-color: #286090;
				border-color: #204d74
			}
    </style>

    <video id="preview"></video>

    <div style="margin-bottom: 1.2em;">
        <label class="btn btn-primary active">
            <input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
        </label>
	<!--
        <label class="btn btn-secondary">
            <input type="radio" name="options" value="2" autocomplete="off"> Back Camera 1
        </label>
		<label class="btn btn-secondary">
            <input type="radio" name="options" value="3" autocomplete="off"> Back Camera 2
        </label>
	-->
    </div>

    <script type="text/javascript">
        var scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            scanPeriod: 5,
            mirror: false
        });
        scanner.addListener('scan', function (content) {
            // alert("../../"+content);
            // window.location.href="../../"+content;
            window.location.href=content;
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
        //alert('Camaras: '+ cameras.length);
                scanner.start(cameras[0]);
                $('[name="options"]').on('change', function () {
                    if ($(this).val() == 1) {
                        if (cameras[0] != "") {
                            scanner.start(cameras[0]);
                        } else {
                            alert('No Front camera found!');
                        }
                    } else if ($(this).val() == 2) {
                        if (cameras[1] != "") {
                            scanner.start(cameras[1]);
                        } else {
                            alert('No Back camera 1 found!');
                        }
                    } else if ($(this).val() == 3) {
                        if (cameras[2] != "") {
                            scanner.start(cameras[2]);
                        } else {
                            alert('No Back camera 2 found!');
                        }
                    }
                });
            } else {
                console.error('No cameras found.');
                alert('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
            alert(e);
        });
    </script>

 					<!-- *************************** -->
<!-- *************************** -->		<!-- *************************** -->
					<!-- *************************** -->

  </div> <!-- FIN DIV JS CODE -->	

</div>  <!-- FIN DIV id="page"  -->
  
<div style="clear:both"></div>

<!-- Inicio footer -->
<div id="footer"><?php print($head_footer);?></div>
<!-- Fin footer -->

</div> <!-- FIN DIV id="pageContenido" -->

</body>

</html>
