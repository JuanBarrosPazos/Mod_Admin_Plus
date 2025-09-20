<?php

	echo "<div id='audiDescarga'></div>";
	$embed = '<audio src="../audi/'.$Audio.'" autostart="true" loop="false" ></audio>';
	$FunEmbed = "<script type='text/javascript'>
					function FunEmbed(){
						document.getElementById('audiDescarga').innerHTML = '".$embed."';
					}
				</script>";
	print($FunEmbed);

?>