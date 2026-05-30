<?php

global $db;	 		global $db_host; 		global $db_user; 		global $db_pass;
global $db_name; 	global $dbconecterror;

$db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(!$db){ die ("Es imposible conectar con la bbdd ".$db_name."</br>".mysqli_connect_error());
            }
            
?>