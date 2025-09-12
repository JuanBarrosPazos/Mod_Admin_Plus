<?php

	print("<div class='centradiv ocultagraf' style='border:none !important'>
			<form name='grafico' action='grafico_01.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display:inline-block;'>
				<input type='hidden' name='time' value='".@$_SESSION['time']."' />
				<button type='submit' title='VER GRAFICA LINEAL' class='botonverde imgButIco GrafLineBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
				<input type='hidden' name='grafico' value=1 />
			</form>	
			<form name='grafico2' action='grafico_02.php' target='popup' method='POST' onsubmit=\"window.open('', 'popup', 'width=1000px,height=600px')\" style='display:inline-block;'>
				<input type='hidden' name='time' value='".@$_SESSION['time']."' />
				<button type='submit' title='VER GRAFICA DE BARRAS' class='botonverde imgButIco GrafBarBlack' style='vertical-align:top;display:inline-block;margin-top:-0.1em;' ></button>
				<input type='hidden' name='grafico2' value=1 />
			</form>	
		</div>");


?>