<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo config_item('validLang')['symbol'] ?>&onload=myCallBack&render=explicit" async defer></script>
<script type='text/javascript'>
  var recaptcha1;
  var recaptcha2;
  var myCallBack = function() {
    //Render the recaptcha2 on the element with ID "recaptcha1"
    recaptcha1 = grecaptcha.render('recaptcha1', {
      'sitekey' : "<?php echo get_config_item('public_key') ?>", //Replace this with your Site key
      'theme' : 'light'
    });
  };
</script>

<?php
/*if ($linkdata['status'] != 0 && isset($linkdata['countdown']) && $linkdata['countdown'] != '')
{
	$count = $linkdata['countdown'];
}
else
{
	$count = get_config_item('countdown');
}*/
?>


<?php
if (!$linkdata['showReCaptcha'])
{

?>
<script type='text/javascript'>
$(document).ready(function (){
	var set;
	var count = '<?php echo get_config_item('countdown'); ?>';

	set = setInterval(function (){

		if (count < 0)
		{
			clearInterval(set);
			// إنتظر من فضلك ...
			$('#stp1 .btn').html(` <a style="color: #FFF;" href="${window.location.origin}/link/${window.location.pathname.split('/')[window.location.pathname.split('/').length - 1]}">Click to Continue!</a>`);
/*			setTimeout(function (){
				//window.location.href = `${window.location.href}?t=<?php echo time(); ?>`;
				window.location.href = `${window.location.origin}/link/${window.location.pathname.split('/')[2]}`;
			},1300);*/
		}
		else
		{
			$('#stp1 .btn').html(count + '<br> <?php langLine('theme.go.span.3') ?>');
			count--;
		}
	},1000);
});
</script>
<?php
}
else
{
?>
<script type='text/javascript'>
	$(document).ready(function (){
		$('#getLink').autosubmit('.msg','<?php langLine('theme.go.span.4') ?>');
	});
</script>

<?php
}
?>

<div class='container'>
	<div class='row alert_adblock' style='display: none;'>
		<br><br>
		<div class='col-md-12'>
			<div class='alert alert-warning lead' ><i class='fa fa-fw fa-lg fa-warning'></i> <?php langLine('theme.go.span.5') ?> ^_^ </div>
		</div>
		<br><br><br><br><br>
		<br><br><br><br><br>
	</div>
	<div class='row centent_box'>
		<div class='col-md-12'>
			<!-- ads -->
			<div class='text-center'>
				<?php
				if ($linkdata['status'] != 0 && isset($linkdata['user_pub']))
				{
					// show user ads
					echo get_google_ad($linkdata['user_pub'], $linkdata['user_channel']);
				}
				else
				{
					// show admin ads
					echo get_google_ad();
				}

				?>
			</div>
		</div>
	</div>
	<div class='row centent_box'>
		<?php
		/*
		echo "<pre dir='ltr'>";
		print_r($linkdata);
		echo "</pre>";
		*/
		?>
		<div class='col-md-8 section-box'>
		<section>
			<div class='row'>
				<div class='col-md-12'>
					<h1 class='lead'><i class='fa fa-fw fa-link'></i> <?php echo $linkdata['title'] ?></h1>
					<hr>
				</div>
			</div>
			<?php
			if ($linkdata['status'] == 0)
			{
			?>
			<div class='row'>
				<div class='col-md-12'>
					<div class='alert alert-danger'><i class='fa fa-lg fa-info-circle'></i> <?php langLine('theme.go.span.6') ?> <a href='<?php echo base_url('p/terms'); ?>'><?php langLine('theme.go.span.7') ?></a> أو <a href='<?php echo base_url('p/privacy'); ?>'><?php langLine('theme.go.span.8') ?> </a>.</div>
				</div>
			</div>
			<?php
			}
			?>
			<div class='row'>
				<div class='col-md-7'>
					<table class='table table-bordered'>
						<tr>
							<td><i class='fa fa-user'></i> <?php langLine('theme.go.span.9') ?> :</td>
							<td><?php echo $linkdata['username']; ?></td>
						</tr>
						<tr>
							<td width=''><i class='fa fa-clock-o'></i> <?php langLine('theme.go.span.10') ?> :</td>
							<td><?php echo date(config_item('time_format'),$linkdata['created']); ?></td>
						</tr>
						<tr>
							<td><i class='fa fa-eye'></i> <?php langLine('theme.go.span.11') ?> :</td>
							<td><?php echo $linkdata['views']; ?></td>
						</tr>
						<tr>
							<td><i class='fa fa-link'></i> <?php langLine('theme.go.span.12') ?> :</td>
							<td>
							<?php
							if (isset($linkdata['user_url']) && !empty($linkdata['user_url']))
							{
								echo "<a href='".$linkdata['user_url']."' target='_blank'>".mb_substr(str_ireplace("http://","",$linkdata['user_url']),0,20)."</a>";
							}
							else
							{
								echo langLine('theme.go.span.13', false);
							}
							?>
							</td>
						</tr>
					</table>
				</div>

				<div class='col-md-5'>
					<div>
						<?php

						if ($linkdata['status'] == 1)
						{
							if ($linkdata['showReCaptcha'])
							{
						?>
						<div class='msg'></div>
						<div id='stp2'>
							<form id='getLink' action='<?php echo base_url($page_path.'/ajax'); ?>' method='post'>
								<?php
								if (get_config_item('recaptcha_status') == 1)
								{

								?>
								<div class='form-group'>
									<div id='recaptcha1' ></div>
								</div>
								<?php
								}
								?>
								<input type='hidden' name='get_link' value='yes' >
								<input type='hidden' name='slug' value='<?php echo $linkdata['slug']; ?>' >
								<button class='btn btn-primary btn-block' style='text-align: center;height: 70px;font-size: 20px;'><?php langLine('theme.go.span.14') ?></button>
							</form>
						</div>
							<?php
							}
							else
							{
							?>
						<div id='stp1'>
							<button class='btn btn-danger btn-block' style='text-align: center;height: 70px;font-size: 20px;'><?php langLine('theme.go.span.15') ?></button>
						</div>
						<?php
							}
						}
						else
						{

						}
						?>

					</div>
				</div>
			</div> <!-- end prev row -->

			<div class='row'>
				<div class='col-md-12'>
					<div class='alert alert-info'><i class='fa fa-info-circle fa-fw'></i> <?php langLine('theme.go.span.16') ?> <a href='<?php echo base_url(); ?>p/contact' ><b><?php langLine('theme.go.span.17') ?></b></a> !</div>
				</div>
			</div>

			<?php
			if ($lastLinksOfUser->num_rows() != 0)
			{
			?>
			<div class='row'>
				<div class='text-center'>
				<?php
				if ($linkdata['is_mobile'] == 'yes' && $linkdata['status'] != 0 && isset($linkdata['user_pub']))
				{
					echo get_google_ad($linkdata['user_pub'], $linkdata['user_channel']);
				}
				elseif ($linkdata['is_mobile'] == 'yes')
				{
					echo get_google_ad();
				}
				?>
				</div>
			</div>
			<div class='row'>
				<div class='col-md-6'>
					<h2 class='h4'><i class='fa fa-flag'></i> <?php langLine('theme.go.span.18') ?> <?php echo $linkdata['username']; ?> : </h2>
					<hr>
					<div>
						<?php
						foreach ($lastLinksOfUser->result_array() as $row)
						{
							echo "<a href='".base_url('go')."/".$row['slug']."' target='_blank' title='".$row['title']."'><i class='fa fa-link fa-link'></i> ".$row['title']."</a><br>";
						}
						?>
					</div>
				</div>
			<?php
				$lastLinksOfUser->free_result();
			}
			?>
			<?php

			if ($otherLinks->num_rows() != 0)
			{
			?>
				<div class='col-md-6'>
					<h2 class='h4'><i class='fa fa-thumbs-o-up'></i> <?php langLine('theme.go.span.19') ?> : </h2>
					<hr>
					<div>
						<?php
						foreach ($otherLinks->result_array() as $row)
						{
							echo "<a href='".base_url('go')."/".$row['slug']."' target='_blank' title='".$row['title']."'><i class='fa fa-link fa-link'></i> ".$row['title']."</a><br>";
						}
						?>
					</div>
				</div>
			</div>
			<?php
				$otherLinks->free_result();
			}
			?>
			<br>
		</section>
		</div> <!-- end of col-lg-8 -->
		<div class='col-md-4'>
			<br>
			<!-- space of ads -->
			<div class='text-center'>
				<?php
				if ($linkdata['status'] != 0 && isset($linkdata['user_pub']))
				{
					echo get_google_ad($linkdata['user_pub'],$linkdata['user_channel']);
				}
				else
				{
					echo get_google_ad();
				}
				?>

				<br><br>

				<?php
				if ($linkdata['status'] != 0 && isset($linkdata['user_pub']))
				{
					echo get_google_ad($linkdata['user_pub'],$linkdata['user_channel'],'300x250');
				}
				else
				{
					echo get_google_ad('','','300x250');
				}
				?>

			</div>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-12'>
			<!-- space of ads -->
		</div>
	</div>
	<br>
</div>
<?php
if (config_item('ads_status') == 1)
{
?>
<!-- <script type='text/javascript'>
	$(document).ready(function (){
		var i = 0;
		$('.boxAds').each(function (){
			i = i + $(this).height();
		});

		if (i == 0)
		{
			$('.centent_box').html('');
			$('.alert_adblock').show();

			//alert('<?php echo base_url("adblock")."?u=".encode(base_url('go')."/".$row['slug'],TRUE); ?>');
			//window.location.href='<?php echo base_url("adblock")."?u=".encode(base_url('go')."/".$row['slug'],TRUE); ?>';
			//alert('عذرا، قم بتعطيل adblock من على متصفحك لتتمكن من الذهاب للرابط المقصود !');
		}

	});
</script> -->
<?php
}
?>
