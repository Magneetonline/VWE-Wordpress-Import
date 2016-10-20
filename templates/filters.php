<div id="filters" class="button-group">
		<button class="button is-checked" data-filter="*">Geen filtering</button>
		<ul class="column">
			<li class="main-filter"><h5>brandstof</h5>
			<ul class="sub-filter">
				<?php
					$brandstof = array_unique($brandstof);
					foreach ($brandstof as $value){
						?>
						<li><button class="button" data-filter=".brandstof-<?php echo $value ?>"><?php echo $value ?></button></li>
						<?php
					}
				?>
			</ul>
			</li>
		</ul>
		<ul class="column">
			<li class="main-filter"><h5>Merk</h5>
			<ul class="sub-filter">
				<?php
					$merk = array_unique($merk);
					foreach ($merk as $value){
						?>
						<li><button class="button" data-filter=".merk-<?php echo $value ?>"><?php echo $value ?></button></li>
						<?php
					}
				?>
			</ul>
			</li>
		</ul>
		<ul class="column">
			<li class="main-filter"><h5>Prijs</h5>
			<ul class="sub-filter">
				<li><button class="button" data-filter=".prijs-A">0-1000</button></li>
				<li><button class="button" data-filter=".prijs-B">1000-3000</button></li>
				<li><button class="button" data-filter=".prijs-C">3000-5000</button></li>
				<li><button class="button" data-filter=".prijs-D">5000-8000</button></li>
				<li><button class="button" data-filter=".prijs-E">8000-10000</button></li>
				<li><button class="button" data-filter=".prijs-F">10000-20000</button></li>
			</ul>
			</li>
		</ul>
	</div>