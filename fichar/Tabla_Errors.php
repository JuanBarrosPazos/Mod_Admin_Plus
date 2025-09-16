<?php

	if($errors){
		print("	<table class='centradiv' style='border-color:#F1BD2D; color:#F1BD2D;'>
					<tr>
						<th>SOLUCIONE ESTOS ERRORES</th>
					</tr>
					<tr>
						<td style='text-align:left !important'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("** ".$errors [$a]."<br>");
		}
		print("</td></tr></table>");
	}


?>