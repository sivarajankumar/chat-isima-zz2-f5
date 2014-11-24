<?php
	require 'usersManager.php';

	session_start();
	
	header('Content-type: application/json; charset=UTF-8');
	
	$errors	= array();	// array to hold validation errors
	$data	= array();	// array to pass back data
	
	if( ! isset($_POST['nickname']) || empty($_POST['nickname']) )
	{
		$errors['nickname'] = 1;	
	}

	if( ! empty($errors) )
	{
		$data['success'] = false;
		$data['errors'] = $errors;
	}
	else
	{
		$nickname = $_POST['nickname'];
		
		if( ! usersExists($nickname) )
		{
			if( ! isset($_POST['rememberMe']) || empty($_POST['rememberMe']) )
			{
				$rememberMe = false;
			}
			else
			{
				$rememberMe = $_POST['rememberMe'];
			}
		
			$_SESSION['nickname'] = $nickname;
			
			addUsers($nickname, $rememberMe);
			
			$data['success'] = true;
		}
		else
		{
			$data['success'] = false;
			$data['errors'] = array('nickname' => 2);
		}
	}

	// return all our data to an AJAX call
	echo json_encode($data);

?>
