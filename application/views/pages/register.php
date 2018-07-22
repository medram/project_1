<!-- recaptcha script -->
<script src='https://www.google.com/recaptcha/api.js?hl=ar'></script>
<div class='container'>
	<div class='row'>
		<div class='col-md-12'>
			<div class='page-header'>
				<h1><i class="fa fa-fw fa-user-plus"></i> <?php langLine('theme.register.title') ?></h1>
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-6'>
			<?php

			if (get_config_item('registration_status') == 0)
			{
				echo "<div class='alert alert-info'><i class='fa fa-fw fa-lg fa-info-circle'></i> ".get_config_item('shutdown_msg_register')."</div>";	
			}
			else
			{
				if (isset($msg) && $msg != '')
				{
					echo $msg."<br>";
				}
			?>
				<form action='<?php echo base_url(); ?>register' method='post' role='form'>
					<div class='form-group'>
						<label><?php langLine('theme.register.username') ?> : </label>
						<input type='text' name='user' class='form-control' value="<?php if (!empty($user_name)){echo $user_name;} ?>">
					</div>
					<div class='form-group'>
						<label><?php langLine('theme.register.email') ?> : </label>
						<input type='text' name='email' class='form-control' value="<?php if (!empty($user_email)){echo $user_email;} ?>" >
					</div>
					<div class='form-group'>
						<label><?php langLine('theme.register.password') ?> : </label>
						<input type='password' name='pass' class='form-control' >
					</div>
					<div class='form-group'>
						<label><?php langLine('theme.register.repass') ?> : </label>
						<input type='password' name='conf-pass' class='form-control' >
					</div>
					<div class='form-group'>
						<input type="checkbox" name="agree" value="1" >
						<label>
							&nbsp; <span><?php langLine('theme.register.span.1') ?></span>
						</label>
					</div>
					<?php
					if (get_config_item('recaptcha_status') == 1)
					{

					?>
					<div class='form-group'>
						<div class="g-recaptcha" data-sitekey="<?php echo get_config_item('public_key') ?>"></div>
					</div>
					<?php
					}
					?>
					<div>
						<input type='submit' name='submit' value='<?php langLine('theme.register.btn.register') ?>' class='btn btn-primary' >
					</div>
					<div>
						<br>
						<span><?php langLine('theme.register.span.2') ?> <a href='<?php echo base_url(); ?>login'><?php langLine('theme.register.span.login') ?></a></span><br>
					</div>
				</form>
			<?php
			}
			?>
			<br>
		</div>
		<div class='col-md-6'>
			<div style='text-align: center;'>
			<br>
				<?php
				echo get_ad('ad_300x250').'<br><br>'.get_ad();
				?>
			</div>
		</div>
	</div>
</div> <!-- / container -->