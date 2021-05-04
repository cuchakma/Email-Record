
<div class="wrap">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Manage Capabilities</a></li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">	
			<form action="options.php" method="POST">
				<?php
					settings_fields( 'selected-role' );
					do_settings_sections( 'email-configuration' );
					submit_button( 'Save Changes' );
				?>
			</form>
		</div>
	</div>
</div>


