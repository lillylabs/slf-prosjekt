<div class="slf-calculator"
	 ng-controller="SLFCalculatorController"
	 ng-init='data = <?php $this->the_data_as_JSON() ?>'>


<div class="slf-calculator-questions">
	<h2>Dersom du sykler...</h2>

	<div class="slf-calculator-result-tabs">
		<span class="slf-calculator-result-tabs-choices">
			<label>
				<input type="radio"
					   name="display"
					   value="year"
					   <?php echo $this->is_default_display('year') ? 'checked="true"' : '' ?>
					   ng-model="data.input.display" />
				<span>Et år</span>
			</label>
			<label>
				<input type="radio"
					   name="display"
					   value="week"
					   <?php echo $this->is_default_display('week') ? 'checked="true"' : '' ?>
					   ng-model="data.input.display" />
				<span>En uke</span>
			</label>
			<label>
				<input type="radio"
					   name="display"
					   value="day"
					   <?php echo $this->is_default_display('day') ? 'checked="true"' : '' ?>
					   ng-model="data.input.display" />
				<span>En dag</span>
			</label>
		</span>
	</div>



	<div class="slf-calculator-form">

		<div class="slf-sliders">

			<div class="slf-calculator-question slf-calculator-question-distance">
				<span class="spinner">
					<button ng-click="decrease('distanceToWork')">-</button>
					<input type="text"
						   pattern="[0-9]*"
						   value="<?php $this->the_default_input('distanceToWork') ?>"
						   ng-model="data.input.distanceToWork" />
					<button ng-click="increase('distanceToWork')">+</button>
				</span>
				<span class="slf-sliders-label">Km til jobben <small>(en vei)</small></span>
			</div>
			
			<div class="slf-calculator-question slf-calculator-question-frequency">
				<span class="spinner">
					<button ng-click="decrease('daysPerWeek')">-</button>
					<input type="text"
						   pattern="[0-9]*"
						   value="<?php $this->the_default_input('daysPerWeek') ?>"
						   ng-model="data.input.daysPerWeek" />
					<button ng-click="increase('daysPerWeek')">+</button>
				</span>
				<span class="slf-sliders-label">Ganger i uka</span>
			</div>
			
			<div class="slf-calculator-question slf-calculator-question-distance">
				<span class="spinner">
					<button ng-click="decrease('weeksPerYear')">-</button>
					<input type="text"
						   pattern="[0-9]*"
						   value="<?php $this->the_default_input('weeksPerYear') ?>"
						   ng-model="data.input.weeksPerYear" />
					<button ng-click="increase('weeksPerYear')">+</button>
				</span>
				<span class="slf-sliders-label">Uker i året</span>
			</div>

		</div>

		<div class="slf-calculator-question slf-calculator-question-car-type">
			<h5>Og bilen din går på</h5>
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
				<span>Har ikke</span>
			</label>
		</div>

	</div>
</div>

	<div class="slf-calculator-result">

		<h2 ng-show="data.input.display === 'year'" <?php echo !$this->is_default_display('year') ? 'class="ng-hide"' : '' ?>>
			Vil du iløpet av et år</h2>
		<h2 ng-show="data.input.display === 'week'" <?php echo !$this->is_default_display('week') ? 'class="ng-hide"' : '' ?>>
			Vil du iløpet av en uke</h2>
		<h2 ng-show="data.input.display === 'day'" <?php echo !$this->is_default_display('day') ? 'class="ng-hide"' : '' ?>>
			Vil du på en dag</h2>


		<div class="slf-calculator-result-health">

			<div class="slf-calculator-result-health-result slf-calculator-result-distance-coverd">
				<span class="slf-calculator-title-word"><strong>Sykle</strong></span>
				<span class="slf-calculator-number" ng-bind="result.distanceCovered() | number : 0">
					<?php echo number_format ( $this->get_default_km_per_year(), 0 , "," , " " ) ?>
				</span>
				<span class="slf-calculator-key-word">kilometer</span>
			</div>

			<div class="slf-calculator-result-health-result slf-calculator-result-minutes-exercised">
				<span class="slf-calculator-title-word"><strong>Mosjonere</strong></span>
				<span class="slf-calculator-number" ng-bind="result.minutesExercised() | number : 0">
					<?php echo number_format ( $this->get_default_calculation("minutesExercised"), 0 , "," , " " ) ?>
				</span>
				<span class="slf-calculator-key-word">minutter</span>
			</div>


			<div class="slf-calculator-result-health-result slf-calculator-result-calories-burned">
				<span class="slf-calculator-title-word"><strong>Forbrenne</strong></span>
				<span class="slf-calculator-number" ng-bind="result.caloriesBurned() | number : 0">
					<?php echo number_format ( $this->get_default_calculation("caloriesBurned"), 0 , "," , " " ) ?>
				</span>
				<span class="slf-calculator-key-word">kalorier</span>
			</div>


		</div>





		<div class="slf-calculator-result-earth">

		<h5>Og spare miljøet for</h5>


			<div class="slf-calculator-result-earth-result slf-calculator-reduced-co2">
				<span class="slf-calculator-number" ng-bind="result.reducedCO2Kg() | number : 2">
					<?php echo number_format ( $this->get_default_calculation("reducedCO2Kg"), 2 , "," , " " ) ?>
				</span>
				<span class="slf-calculator-key-word">kg CO2</span>
			</div>

			<div class="slf-calculator-result-earth-result slf-calculator-reduced-nox">
				<span class="slf-calculator-number" ng-bind="result.reducedNOXGram() | number : 2">
					<?php echo number_format ( $this->get_default_calculation("reducedNOXGram"), 2 , "," , " " ) ?>
				</span>
				<span class="slf-calculator-key-word">gram NOx</span>
			</div>

			<div class="slf-calculator-result-earth-result slf-calculator-reduced-nox">
				<span class="slf-calculator-number" ng-bind="result.reducedDustGram() | number : 2">
					<?php echo number_format ( $this->get_default_calculation("reducedDustGram"), 2 , "," , " " ) ?>
				</span>
				<span class="slf-calculator-key-word">gram svevestøv</span>
			</div>



		</div>

		<div class="slf-calculator-result-costs">
			<h5>I tillegg sparer samfunnet</h5>
				<span class="slf-calculator-number">
					<span ng-bind="result.savedNOK() | number : 0"><?php echo number_format ($this->get_default_calculation("savedNOK"), 0 , "," , " " ) ?></span>,-
				</span>
		</div>


	</div>

</div>

<!-- to create defualt spaceing -->
<p></p>
