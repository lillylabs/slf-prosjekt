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

function format($number, $decimals) {
	return number_format ( $number, $decimals , "," , " " );
}

?>

<div class="slf-calculator"
	 ng-controller="SLFCalculatorController"
	 ng-init='input = <?php echo $defaultsJSON; ?>'
	 >

	<h3 class="widget-title">Sykkelkalkulator</h3>
	<p class="widget-text">Regn ut hva det betyr for deg å sykle.</p>

	<div class="slf-calculator-container">

		<form>
			<div class="slf-calculator-question slf-calculator-question-distance">
				<span>Avstand til jobben:</span>
				<span>
					<input type="number"
						   value="<?php echo $defaults["distanceToWork"] ?>"
						   ng-model="input.distanceToWork" /> kilometer
				</span>
			</div>
			<div class="slf-calculator-question slf-calculator-question-frequency">
				<span>Hvor ofte vil du sykle?</span>
				<span>
					<input type="number"
						   value="<?php echo $defaults["daysPerWeek"] ?>"
						   ng-model="input.daysPerWeek" /> ganger per uke
				</span>
				<span>
					<input type="number"
						   value="<?php echo $defaults["weeksPerYear"] ?>"
						   ng-model="input.weeksPerYear" /> uker per år
				</span>
			</div>
			<div class="slf-calculator-question slf-calculator-question-car-type">
				<span>Hvilken bil har du?</span>
				<label>
					<input type="radio" value="gasCar" checked="true" ng-model="input.carType" /> Bensin
				</label>
				<label>
					<input type="radio" value="dieselCar" ng-model="input.carType" /> Diesel
				</label>
				<label>
					<input type="radio" value="noCar" ng-model="input.carType" /> Ingen
				</label>
			</div>
		</form>

		<div class="slf-calculator-result">
			<h5 ng-show="input.display === 'year'">Iløpet av et år vil du:</h5>
			<h5 ng-show="input.display === 'week'" class="ng-hide">Iløpet av en uke vil du:</h5>
			<h5 ng-show="input.display === 'day'" class="ng-hide">På en dag vil du:</h5>

			<ul class="slf-calculator-result-content">

				<li class="slf-calculator-result-distance-coverd">
					<span class="slf-calculator-key-word">Sykle</span>
					<span class="slf-calculator-number" ng-bind="result.distanceCovered() | number : 0">
						<?php echo format($kmInAYear, 0) ?>
					</span>
					<span>kilometer</span>.
				</li>

				<li class="slf-calculator-result-minutes-exercised">
					<span class="slf-calculator-key-word">Mosjonere</span>
					<span class="slf-calculator-number" ng-bind="result.minutesExercised() | number : 0">
						<?php echo format($kmInAYear * $constants["minutesExercisedPerKm"], 0) ?>
					</span>
					<span>minutter</span>.
				</li>

				<li class="slf-calculator-result-calories-burned">
					<span>Forbrenne</span>
					<span class="slf-calculator-number" ng-bind="result.caloriesBurned() | number : 0">
						<?php echo format($kmInAYear * $constants["caloriesBurnedPerKm"], 0) ?>
					</span>
					<span class="slf-calculator-key-word">kalorier</span>.
				</li>

				<li class="slf-calculator-saved-nok">
					Spare <span class="slf-calculator-key-word">samfunnet</span>
					<span class="slf-calculator-number" ng-bind="result.savedNOK() | number : 2">
						<?php echo format($kmInAYear * $constants["savedNOKPerKm"], 2) ?>
					</span>
					kroner.
				</li>

				<li class="slf-calculator-reduced-co2">
					<span class="slf-calculator-key-word">Redusere CO2</span> utslippet med
					<span class="slf-calculator-number" ng-bind="result.reducedCO2Kg() | number : 2">
						<?php echo format($kmInAYear * $constants["reducedCO2KgPerKm"]["gasCar"], 2) ?>
					</span>
					kg.
				</li>

				<li class="slf-calculator-reduced-nox">
					Spare <span class="slf-calculator-key-word">miljøet</span> for
					<span class="slf-calculator-number" ng-bind="result.reducedNOXGram() | number : 2">
						<?php echo format($kmInAYear * $constants["reducedNOXGramPerKm"]["gasCar"], 2) ?>
					</span>
					gram NOx.
				</li>

				<li class="slf-calculator-reduced-nox">
					Spare <span class="slf-calculator-key-word">miljøet</span> for
					<span class="slf-calculator-number" ng-bind="result.reducedDustGram() | number : 2">
						<?php echo format($kmInAYear * $constants["reducedDustGramPerKm"]["gasCar"], 2) ?>
					</span>
					gram svevestøv.
				</li>

			</ul>

			<div class="slf-calculator-result-tabs">
				Vis resultat for:
				<label>
					<input type="radio" value="year" checked="true" ng-model="input.display" /> et år
				</label>
				<label>
					<input type="radio" value="week" ng-model="input.display" /> en uke
				</label>
				<label>
					<input type="radio" value="day" ng-model="input.display" /> en dag
				</label>
			</div>

		</div>

	</div>
</div>
