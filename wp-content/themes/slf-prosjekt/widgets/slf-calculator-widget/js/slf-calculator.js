/*global angular */

var app = angular.module('slfCalculator', [])
	.controller('SLFCalculatorController', function ($scope) {
		"use strict";

		var calculate = function (multiplier) {
			return $scope.result.distanceCovered() * multiplier;
		};

		$scope.increase = function (variable) {
			$scope.input[variable] = $scope.input[variable] + 1;
		};

		$scope.decrease = function (variable) {
			$scope.input[variable] = $scope.input[variable] - 1;
		};

		$scope.result = {
			distanceCovered: function () {
				var distanceCovered = Number($scope.input.distanceToWork, 10) * 2;

				if ($scope.input.display === 'week' || $scope.input.display === 'year') {
					distanceCovered = distanceCovered * Number($scope.input.daysPerWeek);
				}

				if ($scope.input.display === 'year') {
					distanceCovered = distanceCovered * Number($scope.input.weeksPerYear);
				}

				return distanceCovered;
			},
			minutesExercised: function () {
				return calculate(Number($scope.input.constants.minutesExercisedPerKm, 10));
			},
			caloriesBurned: function () {
				return calculate(Number($scope.input.constants.caloriesBurnedPerKm, 10));
			},
			savedNOK: function () {
				return calculate(Number($scope.input.constants.savedNOKPerKm, 10));
			},
			reducedCO2Kg: function () {
				return calculate(Number($scope.input.constants.reducedCO2KgPerKm[$scope.input.carType], 10));
			},
			reducedNOXGram: function () {
				return calculate(Number($scope.input.constants.reducedNOXGramPerKm[$scope.input.carType], 10));
			},
			reducedDustGram: function () {
				return calculate(Number($scope.input.constants.reducedDustGramPerKm[$scope.input.carType], 10));
			}
		};
	});
angular.bootstrap(document, ['slfCalculator']);
