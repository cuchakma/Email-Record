<?php

namespace Em\Re;

/**
 * Notice Class Handler
 */
class Notices{

    /**
     * Email Contents Updated Message
     *
     * @return void
     */
    public function update_email_content_message() {
		?>
			<div class="notice notice-success is-dismissible">
				<p><?php echo 'Updated Successfully'; ?></p>
			</div>
        <?php
    }

    /**
     * Bulk Delete Message
     *
     * @return void
     */
    public function bulk_delete_message() {
        ?>
            <div class="notice notice-success is-dismissible">
				<p><?php echo 'Deleted Successfully'; ?></p>
			</div>
        <?php
    }
}