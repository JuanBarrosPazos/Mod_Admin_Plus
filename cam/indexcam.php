<?php

session_start();

	//require '../Inclu/error_hidden.php';
	require '../Inclu_Fichar/Admin_Inclu_head.php';
	require '../Inclu/mydni.php';

	require '../Conections/conection.php';
	require '../Conections/conect.php';
	require '../Inclu/my_bbdd_clave.php';

	unset($_SESSION['usuarios']);

	
				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

if (($_SESSION['Nivel'] == 'admin') || ($_SESSION['Nivel'] == 'plus')){ 

	require '../Inclu_MInd/rutacam.php';
	require '../Inclu_MInd/Master_Index.php';

} else { require '../Inclu/table_permisos.php'; }

				   ////////////////////				   ////////////////////
////////////////////				////////////////////				////////////////////
				 ////////////////////				  ///////////////////

	?>
	
					<!-- *************************** -->
<!-- *************************** -->		<!-- *************************** -->
					<!-- *************************** -->


<div style="text-align: center;">

					<!-- *************************** -->
<!-- *************************** -->		<!-- *************************** -->
					<!-- *************************** -->

<script type="text/javascript" src="instascan.min.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
<!--
<script src="bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
-->
<script src="bootstrap.min.js"></script>

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

    <div style="margin-bottom: 2.0em;">
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

</div> <!-- FIN DIV id="Conte" -->

<div style="clear:both"></div>

<!-- Inicio footer -->
<div id="footer"><?php print($head_footer);?></div>
<!-- Fin footer -->

</div> <!-- FIN DIV id="Caja2Admin" -->

</body>


</html>
