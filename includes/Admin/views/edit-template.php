	<h2>Edit Email</h2>
	<?php $datas = get_editted_selected_email_contents_by_id( $_REQUEST['id'] ); ?>
	<form method="POST">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="to_email"><?php echo 'To Email' ?></label>
					</th>
					<td>
						<input type="text" name="to_email" class="regular-text" value="<?php echo $datas[0]->to_email; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="subject"><?php echo 'Subject' ?></label>
					</th>
					<td>
						<input type="text" name="subject" class="regular-text" value="<?php echo $datas[0]->subject; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ip_address"><?php echo 'Ip Address' ?></label>
					</th>
					<td>
						<input type="text" name="ip_address" class="regular-text" value="<?php echo $datas[0]->ip_address; ?>">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sent_date"><?php echo 'Sent Date' ?></label>
					</th>
					<td>
					<?php $date = explode(" ",$datas[0]->sent_date ); ?>
						<input type="date" name="sent_date" class="regular-text" value="<?php echo $date[0] ?>">
					</td>
				</tr>
			</tbody>
		</table>
		<?php $settings = array('media_buttons', 'editor_css' ); wp_editor( $datas[0]->message, 'email_template_editor', $settings );?>
		<?php submit_button('Submit', 'primary', 'submit_datas'); ?>
	</form>
<?php
	
	