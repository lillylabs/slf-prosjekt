<?php

$defaultsJSON = '
	{
		"distanceToWork": 5,
		"daysPerWeek": 2,
		"weeksPerYear": 20,
		"display": "year",
		"carType": "gasCar",
		"constants": {
			"minutesExercisedPerKm": 4,
			"caloriesBurnedPerKm": 27.2,
			"savedNOKPerKm": 25.37,
			"reducedCO2KgPerKm": {
				"gasCar": 0.194,
				"dieselCar": 0.155,
				"noCar": 0
			},
			"reducedNOXGramPerKm": {
				"gasCar": 0.07,
				"dieselCar": 0.522,
				"noCar": 0
			},
			"reducedDustGramPerKm": {
				"gasCar": 0.0007,
				"dieselCar": 0.0095,
				"noCar": 0
			}
		}
	}
';

$defaults = json_decode($defaultsJSON, true);
$constants = $defaults["constants"];
$kmInAYear = $defaults["distanceToWork"] * 2 * $defaults["daysPerWeek"] * $defaults["weeksPerYear"];

?>

<div class="slf-calculator"
	 ng-controller="SLFCalculatorController"
	 ng-init='input = <?php echo $defaultsJSON; ?>'>

	<div class="slf-calculator-form">
		<div class="slf-calculator-question slf-calculator-question-distance">
			<h5>Avstand til jobben</h5>
			<span>Antall km en vei:</span>
			<span class="spinner">
				<button ng-click="decrease('distanceToWork')">-</button>
				<input type="text"
					   pattern="[0-9]*"
					   value="<?php echo $defaults["distanceToWork"] ?>"
					   ng-model="input.distanceToWork" />
				<button ng-click="increase('distanceToWork')">+</button>
			</span>
		</div>
		<div class="slf-calculator-question slf-calculator-question-frequency">
			<h5>Hvor ofte vil du sykle?</h5>
			<span>Antall ganger i uken:</span>
			<span class="spinner">
				<button ng-click="decrease('daysPerWeek')">-</button>
				<input type="text"
					   pattern="[0-9]*"
					   value="<?php echo $defaults["daysPerWeek"] ?>"
					   ng-model="input.daysPerWeek" />
				<button ng-click="increase('daysPerWeek')">+</button>
			</span>
			<span>Antall uker per år:</span>
			<span class="spinner">
				<button ng-click="decrease('weeksPerYear')">-</button>
				<input type="text"
					   pattern="[0-9]*"
					   value="<?php echo $defaults["weeksPerYear"] ?>"
					   ng-model="input.weeksPerYear" />
				<button ng-click="increase('weeksPerYear')">+</button>
			</span>
		</div>
		<div class="slf-calculator-question slf-calculator-question-car-type">
			<h5>Hvilken bil har du?</h5>
			<label>
				<input type="radio" name="car" value="gasCar" checked="true" ng-model="input.carType" />
				<span>Bensin</span>
			</label>
			<label>
				<input type="radio" name="car" value="dieselCar" ng-model="input.carType" />
				<span>Diesel</span>
			</label>
			<label>
				<input type="radio" name="car" value="noCar" ng-model="input.carType" />
				<span>Ingen</span>
			</label>
		</div>
	</div>

	<div class="slf-calculator-result">

		<h5 ng-show="input.display === 'year'">Iløpet av et år vil du:</h5>
		<h5 ng-show="input.display === 'week'" class="ng-hide">Iløpet av en uke vil du:</h5>
		<h5 ng-show="input.display === 'day'" class="ng-hide">På en dag vil du:</h5>

		<ul>

			<li class="slf-calculator-result-distance-coverd">
				<span class="slf-calculator-key-word">Sykle</span>
				<span class="slf-calculator-number" ng-bind="result.distanceCovered() | number : 0">
					<?php echo number_format ( $kmInAYear, 0 , "," , " " ) ?>
				</span>
				<span>kilometer</span>.
			</li>

			<li class="slf-calculator-result-minutes-exercised">
				<span class="slf-calculator-key-word">Mosjonere</span>
				<span class="slf-calculator-number" ng-bind="result.minutesExercised() | number : 0">
					<?php echo number_format ( $kmInAYear * $constants["minutesExercisedPerKm"], 0 , "," , " " ) ?>
				</span>
				<span>minutter</span>.
			</li>

			<li class="slf-calculator-result-calories-burned">
				<span>Forbrenne</span>
				<span class="slf-calculator-number" ng-bind="result.caloriesBurned() | number : 0">
					<?php echo number_format ( $kmInAYear * $constants["caloriesBurnedPerKm"], 0 , "," , " " ) ?>
				</span>
				<span class="slf-calculator-key-word">kalorier</span>.
			</li>
		</ul>

		<h5>Du vil spare miljøet for:</h5>

		<ul>

			<li class="slf-calculator-reduced-co2">
				<span class="slf-calculator-number" ng-bind="result.reducedCO2Kg() | number : 2">
					<?php echo number_format ( $kmInAYear * $constants["reducedCO2KgPerKm"]["gasCar"], 2 , "," , " " ) ?>
				</span>
				kg CO2.
			</li>

			<li class="slf-calculator-reduced-nox">
				<span class="slf-calculator-number" ng-bind="result.reducedNOXGram() | number : 2">
					<?php echo number_format ( $kmInAYear * $constants["reducedNOXGramPerKm"]["gasCar"], 2 , "," , " " ) ?>
				</span>
				gram NOx.
			</li>

			<li class="slf-calculator-reduced-nox">
				<span class="slf-calculator-number" ng-bind="result.reducedDustGram() | number : 2">
					<?php echo number_format ( $kmInAYear * $constants["reducedDustGramPerKm"]["gasCar"], 2 , "," , " " ) ?>
				</span>
				gram svevestøv.
			</li>
		</ul>

		<h5>I tillegg sparer samfunnet<br/>
			<span class="slf-calculator-number" ng-bind="result.savedNOK() | number : 0">
				<?php echo number_format ( $kmInAYear * $constants["savedNOKPerKm"], 0 , "," , " " ) ?>
			</span>
			kroner.
		</h5>

		<div class="slf-calculator-result-tabs">
			<span class="slf-calculator-result-tabs-label">Vis resultat for:</span>
			<span class="slf-calculator-result-tabs-choices">
				<label>
					<input type="radio" name="display" value="year" checked="true" ng-model="input.display" />
					<span>et år</span>
				</label>
				<label>
					<input type="radio" name="display" value="week" ng-model="input.display" />
					<span>en uke</span>
				</label>
				<label>
					<input type="radio" name="display" value="day" ng-model="input.display" />
					<span>en dag</span>
				</label>
			</span>
		</div>

	</div>

</div>

<!-- to create defualt spaceing -->
<p></p>
