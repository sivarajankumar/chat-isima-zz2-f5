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
				$password = password_hash($nickname, PASSWORD_DEFAULT);
				$rememberMe = $password;
				$data['password'] = $password;
			}
		
			$_SESSION['nickname'] = $nickname;
			
			addUsers($nickname, $rememberMe);
			
			$data['success'] = true;
		}
		else
		{
			if( isset($_POST['password']) && ! empty($_POST['password']) )
			{
				
				if( verifyPassword($nickname, $_POST['password']) )
				{
					$data['success'] = true;
					$data['password'] = $_POST['password'];
					
					$_SESSION['nickname'] = $nickname;
				}
				else 
				{
					$data['success'] = false;
				}
			}
			else
			{
				$data['success'] = false;
				$data['errors'] = array('nickname' => 2);
			}
		}
	}

	// return all our data to an AJAX call
	echo json_encode($data);
?>
