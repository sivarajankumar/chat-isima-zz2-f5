'use strict';

angular.module('chatApp.connectForm', ['ngRoute', 'services', 'translateModule', 'ngSanitize'])

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
	function($scope, $http, $location, Ajax, translationFactory)
	{
		// connectFormData : blank object to hold information of connectForm.html
		// $scope will allow this to pass between controller and view
		$scope.connectFormData = {};
		
		function connect_callback(data, status)
		{
			if( status == 200 )
			{
				var message = "";
				
				if( ! data.success )
				{
					message = "Pseudo déjà utilisé";
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
			}
		
		}
		
		function connection( $params )
		{
			Ajax.post('php/register.php', $params, connect_callback);
		}
		
		function session_callback(data, status)
		{
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
						$scope.connectFormData.rememberMe = true;

						var array = { nickname:nicknameCookie, password:passwordCookie };
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
			connection( $scope.connectFormData );
		};
		
		
		$scope.languages = ['Français', 'English'];
		
		var languageValue = getCookie("language");
		  
		if (languageValue){
			$scope.language = languageValue;
			translationFactory.getTranslation($scope, languageValue);
		}else{	  
			
			$scope.language = $scope.languages[0]; // Default the language to french
			setCookie("language", $scope.language, 30);
			translationFactory.getTranslation($scope, getCookie("language"));
			
		}
		
		$scope.$watch('language', function(newValue, oldValue) {
		  if ( newValue !== oldValue ) {
		  
		    if(getCookie("language")){
				deleteCookie("language");
			}
			setCookie("language", newValue, 30);
			console.log(getCookie("language"));
			translationFactory.getTranslation($scope, getCookie("language"));
		  }
		});
		
		translationFactory.getTranslation($scope, getCookie("language"));
	}
)

;
