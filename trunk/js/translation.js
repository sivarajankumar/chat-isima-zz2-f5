var translate = angular.module('translateModule', ['ngResource']);

translate.service('translationFactory', function($resource) {  
        this.getTranslation = function($scope, language) {
            var languageFilePath = 'translations/' + language + '.json'; //path of the tranlation file of the language choosed by the users
            $resource(languageFilePath).get(function (data) {
                $scope.translation = data;//we get the translations from the file and we put them into the $scope object
            });
        };
    });