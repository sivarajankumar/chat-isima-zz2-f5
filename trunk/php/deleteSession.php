<?php
	session_start();
	
	if( isset($_SESSION['nickname']) )
		unset($_SESSION['nickname']);
?>