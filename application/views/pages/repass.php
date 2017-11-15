<!-- recaptcha script -->
<script src='https://www.google.com/recaptcha/api.js?hl=ar'></script>
<div class='container'>
	<div class='row'>
			<?php
			if (isset($forb))
			{
				echo "<div class='col-lg-12'>";
				echo $forb."<br><br><br><br><br><br><br><br><br><br><br>";
				echo "</div>";
			}
			else
			{
			?>
			<div class='col-lg-5'>	
				<h1><i class='fa fa-key'></i> تعيين كلمة مرور جديدة</h1>
				<hr>
				<?php
				if (isset($msg))
				{
					echo $msg;
				}
				?>

				<form action='<?php echo base_url($page_path); ?>/repass' method='post'>
					<div class='form-group'>
						<label>كلمة المرور الجديدة :</label>
						<input type='password' name='new-pass' class='form-control' >
					</div>
					<div class='form-group'>
						<label>أعد كتابة كلمة المرور الجديدة :</label>
						<input type='password' name='conf-new-pass' class='form-control' >
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
						<input type='hidden' name='t' value='<?php echo $t; ?>' >
						<input type='submit' name='submit' class='btn btn-success btn-block' value='حفظ' >	
					</div>
				</form>
			</div>
			<?php
			}
			?>
			<!-- ads -->
			<div class='col-lg-7'>
				<div style='text-align: center;'>
					<?php
					echo get_ad('ad_300x250');
					?>
				</div>
			</div>
	</div>
</div>