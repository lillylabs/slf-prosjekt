<div class="slf-calculator"
	 ng-controller="SLFCalculatorController"
	 ng-init='data = <?php $this->the_data_as_JSON() ?>'>

	<div class="slf-calculator-form">
		<div class="slf-calculator-question slf-calculator-question-distance">
			<h5>Avstand til jobben</h5>
			<span>Antall km en vei:</span>
			<span class="spinner">
				<button ng-click="decrease('distanceToWork')">-</button>
				<input type="text"
					   pattern="[0-9]*"
					   value="<?php $this->the_default_input('distanceToWork') ?>"
					   ng-model="data.input.distanceToWork" />
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
					   value="<?php $this->the_default_input('daysPerWeek') ?>"
					   ng-model="data.input.daysPerWeek" />
				<button ng-click="increase('daysPerWeek')">+</button>
			</span>
			<span>Antall uker per år:</span>
			<span class="spinner">
				<button ng-click="decrease('weeksPerYear')">-</button>
				<input type="text"
					   pattern="[0-9]*"
					   value="<?php $this->the_default_input('weeksPerYear') ?>"
					   ng-model="data.input.weeksPerYear" />
				<button ng-click="increase('weeksPerYear')">+</button>
			</span>
		</div>
		<div class="slf-calculator-question slf-calculator-question-car-type">
			<h5>Hvilken bil har du?</h5>
			<label>
				<input type="radio"
					   name="car"
					   value="gasCar"
					   <?php echo $this->is_default_car_type('gasCar') ? 'checked="true"' : '' ?>
					   ng-model="data.input.carType" />
				<span>Bensin</span>
			</label>
			<label>
				<input type="radio"
					   name="car"
					   value="dieselCar"
					   <?php echo $this->is_default_car_type('dieselCar') ? 'checked="true"' : '' ?>
					   ng-model="data.input.carType" />
				<span>Diesel</span>
			</label>
			<label>
				<input type="radio"
					   name="car"
					   value="noCar"
					   <?php echo $this->is_default_car_type('noCar') ? 'checked="true"' : '' ?>
					   ng-model="data.input.carType" />
				<span>Ingen</span>
			</label>
		</div>
	</div>

	<div class="slf-calculator-result">

		<h5 ng-show="data.input.display === 'year'" <?php echo !$this->is_default_display('year') ? 'class="ng-hide"' : '' ?>>
			Iløpet av et år vil du:</h5>
		<h5 ng-show="data.input.display === 'week'" <?php echo !$this->is_default_display('week') ? 'class="ng-hide"' : '' ?>>
			Iløpet av en uke vil du:</h5>
		<h5 ng-show="data.input.display === 'day'" <?php echo !$this->is_default_display('day') ? 'class="ng-hide"' : '' ?>>
			På en dag vil du:</h5>

		<ul>

			<li class="slf-calculator-result-distance-coverd">
				<span class="slf-calculator-key-word">Sykle</span>
				<span class="slf-calculator-number" ng-bind="result.distanceCovered() | number : 0">
					<?php echo number_format ( $this->get_default_km_per_year(), 0 , "," , " " ) ?>
				</span>
				<span>kilometer</span>.
			</li>

			<li class="slf-calculator-result-minutes-exercised">
				<span class="slf-calculator-key-word">Mosjonere</span>
				<span class="slf-calculator-number" ng-bind="result.minutesExercised() | number : 0">
					<?php echo number_format ( $this->get_default_calculation("minutesExercised"), 0 , "," , " " ) ?>
				</span>
				<span>minutter</span>.
			</li>

			<li class="slf-calculator-result-calories-burned">
				<span>Forbrenne</span>
				<span class="slf-calculator-number" ng-bind="result.caloriesBurned() | number : 0">
					<?php echo number_format ( $this->get_default_calculation("caloriesBurned"), 0 , "," , " " ) ?>
				</span>
				<span class="slf-calculator-key-word">kalorier</span>.
			</li>
		</ul>

		<h5>Du vil spare miljøet for:</h5>

		<ul>

			<li class="slf-calculator-reduced-co2">
				<span class="slf-calculator-number" ng-bind="result.reducedCO2Kg() | number : 2">
					<?php echo number_format ( $this->get_default_calculation("reducedCO2Kg"), 2 , "," , " " ) ?>
				</span>
				kg CO2.
			</li>

			<li class="slf-calculator-reduced-nox">
				<span class="slf-calculator-number" ng-bind="result.reducedNOXGram() | number : 2">
					<?php echo number_format ( $this->get_default_calculation("reducedNOXGram"), 2 , "," , " " ) ?>
				</span>
				gram NOx.
			</li>

			<li class="slf-calculator-reduced-nox">
				<span class="slf-calculator-number" ng-bind="result.reducedDustGram() | number : 2">
					<?php echo number_format ( $this->get_default_calculation("reducedDustGram"), 2 , "," , " " ) ?>
				</span>
				gram svevestøv.
			</li>
		</ul>

		<h5>I tillegg sparer samfunnet<br/>
			<span class="slf-calculator-number" ng-bind="result.savedNOK() | number : 0">
				<?php echo number_format ($this->get_default_calculation("savedNOK"), 0 , "," , " " ) ?>
			</span>
			kroner.
		</h5>

		<div class="slf-calculator-result-tabs">
			<span class="slf-calculator-result-tabs-label">Vis resultat for:</span>
			<span class="slf-calculator-result-tabs-choices">
				<label>
					<input type="radio"
						   name="display"
						   value="year"
						   <?php echo $this->is_default_display('year') ? 'checked="true"' : '' ?>
						   ng-model="data.input.display" />
					<span>et år</span>
				</label>
				<label>
					<input type="radio"
						   name="display"
						   value="week"
						   <?php echo $this->is_default_display('week') ? 'checked="true"' : '' ?>
						   ng-model="data.input.display" />
					<span>en uke</span>
				</label>
				<label>
					<input type="radio"
						   name="display"
						   value="day"
						   <?php echo $this->is_default_display('day') ? 'checked="true"' : '' ?>
						   ng-model="data.input.display" />
					<span>en dag</span>
				</label>
			</span>
		</div>

	</div>

</div>

<!-- to create defualt spaceing -->
<p></p>
