<br><br><br><br><br><br>
<div class="row" style="text-align: center;">
	<div class="clo-lg-12">
		<h1 class='site-logo-img'><?php echo get_logo(); ?></h1>
	</div>
</div>
<br><br><br>
<div style="text-align: center;">
	<div style="text-align: right; width: 400px;margin: 0px auto;">
		<?php
		if (isset($forb))
		{
			echo "<div>".$forb."<br><br><br><br><br><br></div>";
		}
		else
		{
		?>

		<?php
			if(isset($msg) && $msg != '')
			{
				echo $msg;
			}
		?>

		<form action="<?php echo base_url().$page_path.'/'; ?>login/repass" method="post" role="form">
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
		<?php
		}
		?>
	</div>
</div>
<br><br><br><br><br><br><br>