<!-- recaptcha script -->
<script src='https://www.google.com/recaptcha/api.js?hl=ar'></script>
<div class='container'>
	<div class='row'>
		<div class='col-md-12 page-header'>
			<h1><i class="fa fa-fw fa-sign-in"></i> <?php langLine('theme.login.title') ?></h1>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-6'>
			<?php if (isset($msg)){echo $msg."<br>";}?>
			<?php
			//print_r($this->session->userdata());
			//echo get_cookie(config_item('cookie_name'));
			?>
			<form action='<?php echo base_url(); ?>login' method='post' role='form'>
				<div class='form-group'>
					<label><?php langLine('theme.login.email') ?> : </label>
					<input type='text' name='email' class='form-control' >
				</div>
				<div class='form-group'>
					<label><?php langLine('theme.login.password') ?> : </label>
					<input type='password' name='pass' class='form-control' >
				</div>
				<div class='form-group'>
					<input type='checkbox' name='remember' value='1' > <span> <?php langLine('theme.login.rememberMe') ?></span>
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
					<input type='submit' name='submit' value='<?php langLine('theme.login.btn.login') ?>' class='btn btn-primary' >
				</div>
				<div>
					<br>
					<span><?php langLine('theme.login.span.dontHaveAccount') ?> <a href='<?php echo base_url(); ?>register'><?php langLine('theme.login.span.register') ?></a></span><br>
					<span><?php langLine('theme.login.span.getBackPass') ?> <a href='<?php echo base_url(); ?>login/forget_pass'><?php langLine('theme.login.span.recovery') ?></a></span>
				</div>
			</form>
			<br>
		</div>
		<div class='col-md-6'>
			<div style='text-align: center;'>
			<br>
				<?php
				echo get_ad('ad_300x250');
				?>
			</div>
		</div>
	</div>
</div><!-- / container -->