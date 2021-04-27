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
		$options   = get_option( 'selected_role' );
		?>
			<fieldset>                         
				<?php
				foreach ( $all_roles as $role => $keys ) {
					if ( 'administrator' === $role ) {
						$checked = 'checked disabled';
					} elseif ( in_array( $role, $options, true ) ) {
						$checked = 'checked';
					}
					?>
						<input type="checkbox" name="selected_role[]" value="<?php echo esc_html( $role ); ?>" <?php echo $checked; ?>><?php echo esc_html( $keys['name'] ); ?><br>      
					<?php
					$checked = '';
				}
				?>
			</fieldset>    
		<?php
	}
}
