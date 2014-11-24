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
				method	: 'GET',
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
		
		var usersTimer;
		var messagesTimer;
	
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
			
			clearInterval(usersTimer);
			clearInterval(messagesTimer);
			
			$location.path("/connectForm");
		};

		function usersOnline()
		{
			$http
			(
				{
					method	: 'GET',
					url		: 'php/users.php',
					headers : { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8' }
				}
			)
			.success
			(
				function(data) 
				{
					console.log(data);
					$( "#error" ).html( data );
				}
			);
		};
		
		function getMessages()
		{
		};
		
		getMessages();
		usersOnline();
		
		// mise à jour de l'affichage
		usersTimer = setInterval(usersOnline, 10000);
		messagesTimer = setInterval(getMessages, 5000);
		
		// envoie de message
		
	}
)

;