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
	 		
	 		var erase = function(url, callback)
	 		{
	 			$http.delete(url)
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
	 		}
	 		
	 		return{	post: post, get: get, delete: erase }
	 	}
	]
);