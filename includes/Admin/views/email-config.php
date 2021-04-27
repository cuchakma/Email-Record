
<div class="wrap">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Manage Capabilities</a></li>
		<li><a href="#tab-2">Schedules</a></li>
	</ul>

	<div class="tab-content">
		<?php settings_errors(); ?>
		<div id="tab-1" class="tab-pane active">
			<form action="options.php" method="POST">
				<?php
					settings_fields( 'selected-role' );
					do_settings_sections( 'email-configuration' );
					submit_button( 'Save Changes' );
				?>
			</form>
		</div>

		<div id="tab-2" class="tab-pane">
		</div>
	</div>
</div>


