'use strict';

angular.module('chatApp.connectForm', ['ngRoute', 'services'])

.config
(
	function($routeProvider)
	{
		$routeProvider
		.when
		(
			'/connectForm',
			{
				controller: 'connectController',
				templateUrl: 'views/connectForm/connectForm.html'
			}
		);
	}
)

// Controller of connectForm.html
.controller
(
	'connectController', 
	function($scope, $http, $location, Ajax)
	{
		// connectFormData : blank object to hold information of connectForm.html
		// $scope will allow this to pass between controller and view
		$scope.connectFormData = {};
		
		function connect_callback(data, status)
		{
			if( status == 200 )
			{
				console.log(data);
				$( "#error" ).html(data);
				var message = "";
				
				if( ! data.success )
				{
					if( data.errors.nickname == 2 )
					{
						message = "Pseudo déjà utilisé";
					}
				}
				else
				{
					if( $scope.connectFormData.rememberMe )
					{
						setCookie("nickname", $scope.connectFormData.nickname, 30);
						setCookie("password", data.password, 30);
					}
					$location.path("/home");
				}
				
				$( "#errorForm" ).html( message );
				
				$scope.message = data;
			}
		
		}
		
		function connection( $params )
		{
			Ajax.post('php/register.php', $params, connect_callback);
		}
		
		function session_callback(data, status)
		{
			console.log(data);
			if( status == 200 )
			{
				if( data['nickname'] != "" )
				{
					$location.path("/home");
				}
				else
				{
					var nicknameCookie = getCookie("nickname");
					var passwordCookie = getCookie("password");
					
					if( nicknameCookie != "" && passwordCookie != "" )
					{
						$scope.connectFormData.nickname = nicknameCookie;
						console.log("connexioon");
						$scope.connectFormData.rememberMe = true;

						var array = { nickname:nicknameCookie, password:passwordCookie };
						console.log(array);
						connection( array );
					}
				}
			}
		}
		
		
		// Check if user have a session
		Ajax.get('php/session.php', session_callback);
		
		// click on submit button
		$scope.connect = function()
		{	
			console.log( $scope.connectFormData );
			connection( $scope.connectFormData );
		};
	}
)

;
