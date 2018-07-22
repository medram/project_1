<?php $domains = explode("\r\n", get_config_item('packages_domains')); ?>

<!-- recaptcha script -->
<!--<script src='https://www.google.com/recaptcha/api.js?hl=en'></script>-->
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo config_item('validLang')['symbol'] ?>&onload=myCallBack&render=explicit" async defer></script>
<script>
  var recaptcha1;
  var recaptcha2;
  var myCallBack = function() {
    //Render the recaptcha2 on the element with ID "recaptcha1"
    recaptcha1 = grecaptcha.render('recaptcha1', {
      'sitekey' : "<?php echo get_config_item('public_key') ?>", //Replace this with your Site key
      'theme' : 'light'
    });
    //Render the recaptcha2 on the element with ID "recaptcha2"
    recaptcha2 = grecaptcha.render('recaptcha2', {
      'sitekey' : "<?php echo get_config_item('public_key') ?>", //Replace this with your Site key
      'theme' : 'light'
    });
  };
</script>

<div class='container'>
	<div class='row'>
		<?php
		echo $sidebar;
		?>
		<div class='col-md-9'>
			<div><h1><i class="fa fa-fw fa-chain-broken"></i> <?php langLine('account.addlinks.title') ?></h1><hr></div>
			<div class='msg'></div>
			<!--==================== show links result ===============================-->
			<div id='urls' style='display: none;'>
				<textarea dir='ltr' class='form-control' rows='10'></textarea><br>
				<div id='goBack' style='text-align: center;'>
					<span class='btn btn-success'><i class="fa fa-fw fa-share"></i> <?php langLine('account.addlinks.span.1') ?></span>
				</div>
			</div>
			<!--======================================================================-->
			<div id='boxToAddLink'>
				<ul id="myTabs" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true"><?php langLine('account.addlinks.span.2') ?></a>
					</li>
					<li role="presentation">
						<a href="#addLinks" role="tab" id="addLinks-tab" data-toggle="tab" aria-controls="addLinks" aria-expanded="false"><?php langLine('account.addlinks.span.3') ?></a>
					</li>
				</ul>

				<!--=================== form to add a one link =========================-->
				<div id="myTabContent" class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
						<br><br>
						<form class="Addlink" action='<?php echo base_url(); ?>account/ajax' method='post'>
							<div class='form-group'>
								<label><?php langLine('account.addlinks.span.4') ?> : </label>
								<input type='text' name='title' class='form-control' placeholder='<?php langLine('account.addlinks.span.5') ?>' >
							</div>
							<div class='form-group'>
								<label><?php langLine('account.addlinks.span.6') ?> : </label>
								<input type='text' dir='ltr' name='url' class='form-control' placeholder='http://www.example.com/blablabla...' >
							</div>
							<?php
							
							if (count($domains) >= 2)
							{
								// show the select option to select a domain
							?>
								<div class='form-group'>
									<label><?php langLine('account.addlinks.span.7') ?> :</label>
									<select name='domain' class='form-control'>
										<?php
										for ($i = 0; $i < count($domains); $i++)
										{
											echo "<option value='".$i."'>".$domains[$i]."</option>";
										}
										?>
									</select>
								</div>
							<?php
							}
							?>

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
							<div class='form-group'>
								<input type='hidden' name='action' value='addLink' >
								<input type='hidden' name='type' value='0' >
								<button name='shortLinks' class='btn btn-success'><i class="fa fa-fw fa-chain-broken"></i> <?php langLine('account.addlinks.span.8') ?></button>
							</div>
						</form>
					</div>

					<!--================ form to add a lot of links ======================-->

					<div role="tabpanel" class="tab-pane fade" id="addLinks" aria-labelledby="addLinks-tab">
						<br><br>
						<form class="Addlink" action='<?php echo base_url(); ?>account/ajax' method='post'>
							<div class='form-group'>
								<label><?php langLine('account.addlinks.span.9') ?> :</label>
								<input type='text' name='title' class='form-control' placeholder='<?php langLine('account.addlinks.span.10') ?>' >
							</div>
							<div class='form-group'>
								<label><?php langLine('account.addlinks.span.11') ?> :</label>
								<textarea dir='ltr' name='url' rows='7' class='form-control' placeholder='http://www.example.com/blablabla...' ></textarea>
							</div>
							<?php
							
							if (count($domains) >= 2)
							{
								// show the select option to select a domain
							?>
								<div class='form-group'>
									<label><?php langLine('account.addlinks.span.12') ?> :</label>
									<select name='domain' class='form-control'>
										<?php
										for ($i = 0; $i < count($domains); $i++)
										{
											echo "<option value='".$i."'>".$domains[$i]."</option>";
										}
										?>
									</select>
								</div>
							<?php
							}
							?>

							<?php
							if (get_config_item('recaptcha_status') == 1)
							{

							?>
							<div class='form-group'>
								<div id='recaptcha2' ></div>
							</div>
							<?php
							}
							?>
							<div class='form-group'>
								<input type='hidden' name='action' value='addLink' >
								<input type='hidden' name='type' value='1' >
								<button name='shortLinks' class='btn btn-success'><i class="fa fa-fw fa-chain-broken"></i> <?php langLine('account.addlinks.span.13') ?></button>
							</div>
						</form>
					</div>
				</div> <!-- close tab content -->

			</div> <!-- close div -->
		</div> <!-- close col-lg-9 -->
	</div> <!-- close row -->
</div>