'use strict';

angular.module('chatApp.home', ['ngRoute', 'services'])

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
	function($scope, $http, $location, Ajax)
	{
		// on verifie si on a une session ouverte sinon on retourne a l'accueil
		function checkSession(data, status)
		{
			if( data['nickname'] == "" )
			{
				$location.path("/connectForm");
			}
			else
			{
				console.log("Nickname : " + data['nickname']);
			}
		}
		
		Ajax.get('php/session.php', checkSession);
		
		var usersTimer;
		var messagesTimer;
	
		function disconnectCallback(data, status) 
		{
			deleteCookie("nickname");
			deleteCookie("password");
		
			$location.path("/connectForm");
		}
		
		// deconnexion
		$scope.disconnect = function()
		{
			clearInterval(usersTimer);
			clearInterval(messagesTimer);
			
			Ajax.delete('php/session.php', disconnectCallback);
		};
		
		function displayUsers(data, status)
		{
			$scope.users = data;
		}

		function usersOnline()
		{
			Ajax.get('php/users.php', displayUsers);
		};
		
		$scope.messageData = {}; //blank object to get all messages
		$scope.$on('$viewContentLoaded', getMessages());
		
		function displayMessages(data, status)
		{
			console.log(data['messages']['home']);
			$scope.messageData = data['messages']['home'];
			$( "#error" ).html( data );
		}
		
		function getMessages()
		{
			Ajax.get('php/messages.php', displayMessages);
		};
		
		$scope.formData = {}; //blank object to hold information of home.html

		getMessages();
		usersOnline();
		
		// mise à jour de l'affichage
		usersTimer = setInterval(usersOnline, 10000);
		messagesTimer = setInterval(getMessages, 5000);
		
		function sendCallback(data, status)
		{
			console.log("Send function " + data['success']);
		}
		
		// envoie de message
		$scope.sendMessage = function()
		{
			var array = { receiver:'home', message:$scope.formData.message};
			Ajax.post('php/messages.php', array, sendCallback);
			//the message area is set to empty when the message is sent
			$scope.formData = {};
		}
	}
)

;