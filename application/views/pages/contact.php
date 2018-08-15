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
  };
</script>
<script type='text/javascript'>
	$(document).ready(function(){
		$('#sendMsg').autosubmit('.msg','<i class="fa fa-spin fa-spinner"></i> Sending ...');
	});
</script>
<div class='container'>
	<div class='row'>
		<div class='col-md-12 page-header'>
			<h1><i class='fa fw fa-send'></i> <?php echo $pagedata['title']; ?></h1>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-6'>
			<section>
				<div class='msg'></div>
				<form id='sendMsg' action='<?php echo base_url("ajax"); ?>' method='post'>
					<div class='form-group'>
						<label><?php langLine('theme.contact.title') ?> : </label>
						<input type='text' name='title' class='form-control'>
					</div>
					<div class='form-group'>
						<label><?php langLine('theme.contact.email') ?> : </label>
						<input type='text' name='email' class='form-control'>
					</div>
					<div class='form-group'>
						<label><?php langLine('theme.contact.messageType') ?> : </label>
						<select name='type' class='form-control'>
							<option value='0'><?php langLine('theme.contact.span.1') ?></option>
							<option value='1'><?php langLine('theme.contact.span.2') ?></option>
							<option value='2'><?php langLine('theme.contact.span.3') ?></option>
							<option value='3'><?php langLine('theme.contact.span.4') ?></option>
						</select>
					</div>
					<div class='form-group'>
						<label><?php langLine('theme.contact.messageContent') ?> : </label>
						<textarea name='content' rows='10' class='form-control'></textarea>
					</div>
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
						<input type='hidden' name='contact' value='1' >
						<button type='submit' class='btn btn-primary'><i class='fa fa-fw fa-send'></i> <?php langLine('theme.contact.btn.send') ?> </button>
					</div>
				</form>
			</section>
		</div>
		<div class='col-md-6'>
			<div style='text-align: center;' class='adsBox'>
			<br>
				<?php
				echo get_ad('ad_300x250').'<br><br>'.get_ad();
				?>
			</div>
		</div>
	</div>
</div>