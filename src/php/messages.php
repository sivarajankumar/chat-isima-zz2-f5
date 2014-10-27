<?php

	session_start();
	
	if( isset($_SESSION['nickname']) )
	{
		echo 'coucou ' . $_SESSION['nickname'];
	}
	else if( isset($_COOKIE['nickname']) )
	{
		echo 'COOKIE coucou ' . $_COOKIE['nickname'];
	}

?>