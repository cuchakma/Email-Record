<div class="wrap">
  <h2>Records</h2>
	<form id="email-table" method="POST">
		<?php
		  $table = new \Em\Re\Admin\Record_List();
		  $table->prepare_items();
		  $table->search_box( 'Search By date', 'sbd' );
		  $table->display();
		?>
	</form>
</div>
