angular.module('chatApp', ['ngRoute'])

.config
(
	function($routeProvider)
	{
		$routeProvider
		.when
		(
			'/',
			{
				controller: 'connectController',
				templateUrl: 'views/connectForm.html'
			}
		)
		.when
		(
			'/home',
			{
				controller: 'homeController',
				templateUrl: 'views/home.html'
			}
		)
		.otherwise
		(
			{
				redirectTo: '/'
			}
		);
	}	
)

// Controller of connectForm.html
.controller
(
	'connectController', 
	function($scope, $http, $compile, $location)
	{
		// connectFormData : blank object to hold information of connectForm.html
		// $scope will allow this to pass between controller and view
		$scope.connectFormData = {};
		
		var cookie = getCookie("nickname");
		
		if( cookie != "" )
		{
			$scope.message = "Cookie : " + cookie;
			$location.path("/home");
		}
		
		// click on submit button
		$scope.connect = function()
		{			
			$http
			(
				{
					method	: 'POST',
					url		: 'php/register.php',
					data    : $.param($scope.connectFormData),
					headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8' }
				}
			)
			.success
			(
				function(data) 
				{
					console.log(data);
					
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
							$location.path("/home");
						}
					}
					
					$( "#errorForm" ).html( message );
					
					$scope.message = data;
				}
			);
		};	
	}
)

.controller
(
	'homeController',
	function($scope, $http)
	{
		function usersOnline()
		{
			
		};
		
		function getMessages()
		{
		};
		
		// mise à jour de l'affichage
		var usersTimer = setInterval(usersOnline, 10000);
		var messagesTimer = setInterval(getMessages, 5000);
		
		// envoie de message
		
	}
)

;
