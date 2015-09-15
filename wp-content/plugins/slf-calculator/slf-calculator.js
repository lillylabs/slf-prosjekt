/*global angular */

var app = angular.module('slfCalculatorWidget', [])
	.controller('SLFCalculatorController', function ($scope) {
		"use strict";

		var calculate = function (multiplier) {
			return $scope.result.distanceCovered() * multiplier;
		};

		var validate = function (variable, max) {
			var number = Number($scope.data.input[variable], 10);

			if(number < 1) {
				number = 1;
			}

			if(number > max) {
				number = max;
			}

			if(isNaN(number)) {
				number = 9;
			}

			$scope.data.input[variable] = number;
		};

		$scope.$watch('data.input.distanceToWork', function() {
       		validate("distanceToWork", 99);
   		});

		$scope.$watch('data.input.daysPerWeek', function() {
       		validate("daysPerWeek", 7);
   		});

		$scope.$watch('data.input.weeksPerYear', function() {
       		validate("weeksPerYear", 52);
   		});

		$scope.increase = function (variable) {
			$scope.data.input[variable] = $scope.data.input[variable] + 1;
		};

		$scope.decrease = function (variable) {
			$scope.data.input[variable] = $scope.data.input[variable] - 1;
		};

		$scope.result = {
			distanceCovered: function () {
				var distanceCovered = Number($scope.data.input.distanceToWork, 10) * 2;

				if ($scope.data.input.display === 'week' || $scope.data.input.display === 'year') {
					distanceCovered = distanceCovered * Number($scope.data.input.daysPerWeek);
				}

				if ($scope.data.input.display === 'year') {
					distanceCovered = distanceCovered * Number($scope.data.input.weeksPerYear);
				}

				return distanceCovered;
			},
			minutesExercised: function () {
				return calculate(Number($scope.data.constants.minutesExercisedPerKm, 10));
			},
			caloriesBurned: function () {
				return calculate(Number($scope.data.constants.caloriesBurnedPerKm, 10));
			},
			savedNOK: function () {
				return calculate(Number($scope.data.constants.savedNOKPerKm, 10));
			},
			reducedCO2Kg: function () {
				return calculate(Number($scope.data.constants.reducedCO2KgPerKm[$scope.data.input.carType], 10));
			},
			reducedNOXGram: function () {
				return calculate(Number($scope.data.constants.reducedNOXGramPerKm[$scope.data.input.carType], 10));
			},
			reducedDustGram: function () {
				return calculate(Number($scope.data.constants.reducedDustGramPerKm[$scope.data.input.carType], 10));
			}
		};
	});

angular.element(document).ready(function() {
	angular.bootstrap(document, ['slfCalculatorWidget']);
});
