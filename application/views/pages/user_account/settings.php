<div class='container'>
	<div class='row'>
		<?php
		echo $sidebar;
		?>
		<div class='col-md-9'>
			<div><h1><i class="fa fa-fw fa-cogs"></i> <?php echo langLine('account.settings.title'); ?></h1><hr></div>
			<div class='msg'></div>
			<div>
				<form id='updateUserSettings' action='<?php echo base_url($page_path); ?>/ajax' method='post'>
					<div class='form-group'>
						<label><?php echo langLine('account.settings.span.1'); ?> :</label>
						<input type='text' name='user_pub' class='form-control' placeholder='pub-xxxxxxxxxxxx' 
							value='<?php if (isset($userdata["user_pub"])){echo $userdata["user_pub"];} ?>' >
					</div>
					<div class='form-group'>
						<label><?php echo langLine('account.settings.span.2'); ?> :</label>
						<input type='text' name='user_channel' class='form-control'  
							value='<?php if (isset($userdata["user_channel"])){echo $userdata["user_channel"];} ?>' >
					</div>
					<div class='form-group'>
						<label><?php echo langLine('account.settings.span.3'); ?> :</label>
						<input type='number' name='user_countdown' min='10' max='60' class='form-control'
							value='<?php if (isset($userdata["countdown"])){echo $userdata["countdown"];}else{echo get_config_item("countdown");} ?>' >
					</div>
					<div class='form-group'>
						<label><?php echo langLine('account.settings.span.4'); ?> :</label>
						<input dir='ltr' type='text' name='user_url' class='form-control' placeholder='http://www.example.com' 
							value='<?php if (isset($userdata["user_url"])){echo $userdata["user_url"];} ?>' >
					</div>
					<div class='form-group'>
						<input type='hidden' name='update-Settings' value='ok' >
						<button type='submit' class='btn btn-danger' ><i class='fa fa-floppy-o'></i> <?php echo langLine('account.settings.span.5'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>