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