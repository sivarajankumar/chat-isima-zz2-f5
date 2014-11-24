'use strict';

angular.module('chatApp.home', ['ngRoute'])

.config
(
	function($routeProvider)
	{
		$routeProvider
		.when
		(
			'/home',
			{
				controller: 'homeController',
				templateUrl: 'views/home/home.html'
			}
		);
	}
)

.controller
(
	'homeController',
	function($scope, $http, $location)
	{
		// on verifie si on a une session ouverte sinon on retourne a l'accueil
		$http
		(
			{
				method	: 'POST',
				url		: 'php/getSession.php',
				headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8' }
			}
		)
		.success
		(
			function(data) 
			{
				if( data == "" )
				{
					$location.path("/connectForm");
				}
				else
				{
					console.log("data : " + data);
				}
			}
		);
	
		// deconnexion
		$scope.disconnect = function()
		{
			$http
			(
				{
					method	: 'POST',
					url		: 'php/deleteSession.php',
					headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8' }
				}
			);
			deleteCookie("nickname");
			$location.path("/connectForm");
		};

		function usersOnline()
		{
		};
		
		//envoi de message
		$scope.sendMessage = function()
		{
			//alert("Les temps ont changés");
			$http
			(
				{
					method	: 'POST',
					url		: 'php/messages.php',
					data    : $.param($scope.messageData),
					headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8' }
				}
			)
			.success
			(
				function(data) 
				{
					console.log(data.message);
					//$scope.newMessage = response.data;
					//console.log($scope.newMessage);
					
				}
			);
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