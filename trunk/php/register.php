<?php
	require 'nicknamesFile.php';

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
		
		if( ! nicknameExists($nickname) )
		{
			$rememberMe = false;
		
			$_SESSION['nickname'] = $nickname;
			
			addNickname($nickname);
			
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
