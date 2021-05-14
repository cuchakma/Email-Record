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
		return '
            <div class="notice notice-success is-dismissible">
                <p>Updated Successfully</p>
            </div>
        ';
    }

    /**
     * Bulk Delete Message
     *
     * @return void
     */
    public function bulk_delete_message() {
        return '
            <div class="notice notice-success is-dismissible">
				<p>Deleted Successfully</p>
			</div>
        ';
    }
}