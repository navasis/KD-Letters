<div class="wrap">
	<div class="block">
		<h2>Generuoti laiškus</h2>
		<div class="progress-bar">
			<div class="bar" style="width:<?php echo $progress; ?>%"></div>
		</div>
		<p>Laiškai, kurie laukia generavimo: <strong><?php echo $waiting_orders; ?></strong> iš <strong><?php echo $total_orders; ?></strong>.</p>
		<p><a href="?page=kd-letters&generate_letters" class="button-primary">Generuoti</a></p>
	</div>
	<div class="block">
		<h2>Archyvas</h2>
		<p>Kolkas archyvas tuščias.</p>
	</div>
</div>