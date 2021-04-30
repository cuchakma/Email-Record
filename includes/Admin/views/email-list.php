<div class="wrap">
<?php
if ( isset( $_REQUEST['bulk-delete'] ) ) {
	if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-delete-nonce' ) ) {
		?>
			<div class="notice notice-success">
				<p><?php esc_attr_e( 'All Records Deleted Sucessfully' ); ?></p>
			</div>
		<?php
	}
}
?>
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
