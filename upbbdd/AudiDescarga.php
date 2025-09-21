<?php

	echo "<div id='audiDescarga'></div>";
	$AudioFrame = '<audio src="../audi/'.$Audio.'" autoplay></audio>';
	$FunAudio = "<script type='text/javascript'>
					function FunAudio(){
						document.getElementById('audiDescarga').innerHTML = '".$AudioFrame."';
					}
				</script>";
	print($FunAudio);
 
?>