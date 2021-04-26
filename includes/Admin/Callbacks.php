<?php

namespace Em\Re\Admin;

/**
 * Setting Callbacks Handler
 */
class Callbacks {

	/**
	 * View Setting Section
	 *
	 * @return void
	 */
	public function setting_section_callback() {
		echo '<h3>Select Roles</h3>';
	}

	/**
	 * Field Forms Section
	 *
	 * @return void
	 */
	public function setting_field_callback() {
		global $wp_roles;
		$all_roles = $wp_roles->roles;
		?>
			<fieldset>                         
				<?php
				foreach ( $all_roles as $role ) {
					?>
						<input type="checkbox" name="selected_role[]" value="<?php echo esc_html( $role['name'] ); ?>"><?php echo esc_html( $role['name'] ); ?><br>      
					<?php
				}
				?>
			</fieldset>    
		<?php
	}
}
