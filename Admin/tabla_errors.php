<?php

	if ($errors){
		print("	<table class='centradiv'>
					<tr>
						<th style='text-align:center;color:#F1BD2D;'>
							* SOLUCIONE ESTOS ERRORES
						</th>
					</tr>
					<tr>
						<td style='text-align:left !important'>");
			
		for($a=0; $c=count($errors), $a<$c; $a++){
			print("<font color='#F1BD2D'>**</font> ".$errors [$a]."<br/>");
			}
		print("</td></tr></table>");
	}

?>