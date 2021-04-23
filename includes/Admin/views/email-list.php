<div class="wrap">
  <h2>Records</h2>
	<form id="" method="GET">
		<?php
		  $table = new \Em\Re\Admin\Record_List();
		  $table->prepare_items();
		  $table->display();
		?>
	</form>
</div>
