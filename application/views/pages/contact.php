<script src="https://www.google.com/recaptcha/api.js?hl=ar&onload=myCallBack&render=explicit" async defer></script>
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
		$('#sendMsg').autosubmit('.msg','<i class="fa fa-spin fa-spinner"></i> جار إرسال الرسالة ...');
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
						<label>العنوان :</label>
						<input type='text' name='title' class='form-control'>
					</div>
					<div class='form-group'>
						<label>البريد الإلكتروني الخاص بك :</label>
						<input type='text' name='email' class='form-control'>
					</div>
					<div class='form-group'>
						<label>نوع الرسالة :</label>
						<select name='type' class='form-control'>
							<option value='0'>رسالة عادية</option>
							<option value='1'>الإبلاغ عن شيء ما</option>
							<option value='2'>طلب استفسار</option>
							<option value='3'>واجهت مشكلة بالموقع</option>
						</select>
					</div>
					<div class='form-group'>
						<label>محتوى الرسالة :</label>
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
						<button type='submit' class='btn btn-primary'><i class='fa fa-fw fa-send'></i> إرسال</button>
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