<?php

        global $balancesOtros;      global $inputUsuarios;

        if($balancesOtros == 1){
                $inputUsuarios = "<input type='hidden' name='usuarios' value='".$defaults['usuarios']."' />";
        }else{
                $inputUsuarios = "";
        }
		print("<div class='centradiv filtroGraf' style='padding:0.6em;'>
				".$Titulo."
			<form name='todo' method='post' action='$_SERVER[PHP_SELF]' >
                ".$inputUsuarios."
				<select name='Orden'>");
					foreach($ordenar as $option => $label){
							print ("<option value='".$option."' ");
							if($option == @$defaults['Orden']){ print ("selected = 'selected'"); }
							print ("> $label </option>");
					}	
		print("</select>
				<select name='dy'>");
					foreach($dy as $optiondy => $labeldy){
							print ("<option value='".$optiondy."' ");
							if($optiondy == @$defaults['dy']){ print ("selected = 'selected'"); }
							print ("> $labeldy </option>");
					}	
		print ("</select>
				<select name='dm'>");
					foreach($dm as $optiondm => $labeldm){
							print ("<option value='".$optiondm."' ");
							if($optiondm == @$defaults['dm']){ print ("selected = 'selected'"); }
							print ("> $labeldm </option>");
					}	
		print ("</select>
				<button type='submit' title='FILTRO BALANCES' class='botonverde imgButIco BuscaBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
					<input type='hidden' name='todo' value=1 />
			</form>											
		</div>"); /* Fin del print */


?>