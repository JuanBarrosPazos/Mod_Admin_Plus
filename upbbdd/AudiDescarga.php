<?php

	echo "<div id='audiDescarga'></div>";
	$embed = '<embed src="../audi/'.$Audio.'" autostart="true" loop="false" ></embed>';
	$FunEmbed = "<script type='text/javascript'>
					function FunEmbed(){
						document.getElementById('audiDescarga').innerHTML = '".$embed."';
					}
				</script>";
	print($FunEmbed);

?>