<?php

	if($errors){
		print("	<table class='centradiv alertdiv'>
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