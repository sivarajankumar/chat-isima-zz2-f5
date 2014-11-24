var ajax = angular.module('services', []);

ajax.factory
(
	'Ajax',
	[
	 	'$http',
	 	function($http)
	 	{
	 		$http.defaults.headers.common = {'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8'};
	 		$http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
	 		
	 		var get = function(url, callback)
	 		{
	 			$http.get(url)
	 			.success
	 			(
	 					function(data, status)
	 					{
	 						callback(data, status);
	 					}
	 			)
	 			.error
	 			(
	 					function(error, status)
	 					{
	 						callback(error, status);
	 					}
	 			);
	 		};
	 		
	 		var post = function(url, params, callback)
	 		{
	 			console.log("Post");
	 			console.log(params);
	 			$http.post(url, $.param(params))
	 			.success
	 			(
	 					function(data, status)
	 					{
	 						callback(data, status);
	 					}
				)
				.error
				(
						function(error, status)
						{
							callback(error, status);
						}
				);
	 		};
	 		
	 		return{	post: post, get: get }
	 	}
	]
);