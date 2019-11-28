<!-- recaptcha script -->
<script src='https://www.google.com/recaptcha/api.js?hl=en'></script>
<div class='container'>
	<div class='row'>
		<div class='col-md-12 page-header'>
			<h1><i class="fa fa-fw fa-refresh"></i> <?php langLine('theme.forget.title') ?></h1>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-5'>
			<?php
			if (isset($msg))
			{
				echo $msg;
			}

			if (!isset($showForm))
			{
			?>
			<form action='<?php echo base_url($page_path); ?>/forget_pass' method='post'>
				<div class='form-group'>
					<label><?php langLine('theme.forget.span.1') ?> : </label>
					<input type='text' name='e-mail' class='form-control' >
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
				<div class='form-group'>
					<button name='submit' class='btn btn-primary btn-block' value='ok' ><i class="fa fa-fw fa-refresh"></i> <?php langLine('theme.forget.btn.recovery') ?></button>
				</div>
			</form>
			<?php
			}
			?>
		</div>
		<div class='col-md-7'>
		<!-- ads -->
			<div style='text-align: center;'>
				<?php
				echo get_ad('ad_300x250');
				?>
			</div>
		</div>
	</div>
</div>