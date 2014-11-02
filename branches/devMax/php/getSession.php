<?php
	session_start();
	
	if( !isset($_SESSION['nickname']) )
		echo "";
	else
		echo $_SESSION['nickname'];
?>