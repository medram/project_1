<br><br><br><br><br><br>
<div class="row" style="text-align: center;">
	<div class="clo-lg-12">
		<h1 class='site-logo-img'><?php echo get_logo(70); ?></h1>
	</div>
</div>
<br><br><br>
<div style="text-align: center;">
	<div style="text-align: left; width: 400px;margin: 0px auto;">
			<?php
				if(isset($msg) && $msg != '')
				{
					echo $msg;
				}
			?>

		<form action="<?php echo base_url().$page_path.'/'; ?>login" method="post" role="form">
			<div class="form-group">
				<label>E-mail :</label>
				<input type="text" name="email" class="form-control">
			</div>
			<div class="form-group">
				<label>Password :</label>
				<input type="password" name="pass" class="form-control">
			</div>
			<!--
 			<div class="form-group">
				<input type="checkbox" name="remember" value="1"> <span> تذكرني</span>
			</div>
			-->
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
				<input type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
			</div>
			<div>
				<br>
				<span>I forgot my password - <a href="<?php echo base_url().$page_path.'/'; ?>login/forget_pass">restore?</a></span>
			</div>
		</form>
	</div>
</div>
<br><br><br><br><br><br><br>
</div><!-- / container -->
