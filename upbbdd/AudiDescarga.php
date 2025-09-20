<?php

	echo "<div id='audiDescarga'></div>";
	$Audio = '<audio src="../audi/'.$Audio.'" autostart="true" loop="false" ></audio>';
	$FunAudio = "<script type='text/javascript'>
					function FunAudio(){
						document.getElementById('audiDescarga').innerHTML = '".$Audio."';
					}
				</script>";
	print($FunAudio);

?>