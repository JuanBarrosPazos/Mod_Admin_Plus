<?php

if(isset($_POST['oculto'])){
	if($form_errors = validate_form()){
		print("<div class='centradiv' style='border-color:#F1BD2D; color:#F1BD2D;'>
				NO SE HA ENVIADO EL FORMULARIO.<br>
		<a href='http://juanbarrospazos.blogspot.com.es/' target='_blank'>
				<button type='submit' title='CONTACTOS WEB MASTER' class='botonnaranja imgButIco WebBlack' style='vertical-align:top;' ></button>
		</a>
			</div>");
												
		show_form($form_errors);
										
	}else{	print("<div class='centradiv' style='border-color:#0080C0; color:#0080C0;'>
					SE HA PROCESADO SU PETICION CORRECTAMENTE.<br>
					CONFIRME EL ENVIO DE SUS DATOS VIA MAIL.
				</div>
		<embed src='../audi/claves_lost_2.mp3' autostart='true' loop='false' ></embed>");
											
		process_form();
	}

	/* Fin del if $_POST['oculto']*/		
}elseif(isset($_POST['oculto2'])){
			show_form();
			process_Mail();
			unset($_SESSION['']);

}else{ show_form(); }

?>