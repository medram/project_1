<div class='container'>
	<div class='row'>
		<div class='col-lg-12'>
			<h1><i class='fa fa-lock'></i> <?php echo $title; ?></h1>
			<hr>
			<div class='alert alert-danger'>
				<?php
				if (isset($userdata['banned_msg']))
				{
					echo $userdata['banned_msg'];
				}
				?>
			</div>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</div>
</div>