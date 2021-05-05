	<h3>Edit Email</h3>
	<form action="" method="post">
		<table class="form-table" role="email-templates">
			<tbody>
				<tr>
					<th scope="row">
						<label for="to_email"><?php echo 'To Email' ?></label>
					</th>
					<td>
						<input type="text" name="to_email" class="regular-text" value="">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="subject"><?php echo 'Subject' ?></label>
					</th>
					<td>
						<input type="text" name="subject" class="regular-text" value="">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="ip_address"><?php echo 'Ip Address' ?></label>
					</th>
					<td>
						<input type="text" name="ip_address" class="regular-text" value="">
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sent_date"><?php echo 'Sent Date' ?></label>
					</th>
					<td>
						<input type="date" name="sent_date" class="regular-text" value="">
					</td>
				</tr>
			</tbody>
		</table>
	</form>
<?php
	$settings = array(
		'media_buttons',
		'editor_css'
	);
	wp_editor( '', 'description', $settings );