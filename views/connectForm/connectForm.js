'use strict';

angular.module('chatApp.connectForm', ['ngRoute'])

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
	function($scope, $http, $location)
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
						}
						$location.path("/home");
					}
					
					$( "#errorForm" ).html( message );
					
					$scope.message = data;
				}
			);
		};	
	}
)

;