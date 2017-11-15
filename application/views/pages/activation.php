<div class='container'>
	<div class='row'>
		<div class='col-lg-12'>
			<h1><?php echo $title; ?></h1>
			<hr>
		</div>
	</div>
	<div class='row'>
		<div class='col-lg-12'>
			<?php
			if (isset($msg))
			{
				echo $msg;
			}
			?>
		</div>
		<br><br><br>
	</div>
	<div class='row'>
		<div class='col-lg-12'>
			<div style='text-align: center;'>
				<?php
				echo get_ad();
				?>
			</div>
		</div>
	</div>
</div>