<br><br><br><br><br><br>
<div class="row" style="text-align: center;">
	<div class="clo-lg-12">
		<h1 class='site-logo-img'><?php echo get_logo(); ?></h1>
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

		<form action="<?php echo base_url().$page_path.'/'; ?>login/forget_pass" method="post" role="form">
			<div class="form-group">
				<label>E-mail address :</label>
				<input type="text" name="e-mail" class="form-control">
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
				<input type="submit" name="submit" value="Restore" class="btn btn-primary btn-block">
			</div>
		</form>
	</div>
</div>
<br><br><br><br><br><br><br>
</div><!-- / container -->
