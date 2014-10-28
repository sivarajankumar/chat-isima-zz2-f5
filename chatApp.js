'use strict';

angular.module
(
	'chatApp', 
	[
		'ngRoute',
		'chatApp.connectForm',
		'chatApp.home'
	]
)

.config
(
	function($routeProvider)
	{
		$routeProvider
		.when
		(
			'/',
			{
				redirectTo: '/connectForm'
			}
		)
		.otherwise
		(
			{
				redirectTo: '/connectForm'
			}
		);
	}	
)

;
