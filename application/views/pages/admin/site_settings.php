<script src='<?php echo base_url(); ?>js/ajax.form.js' type='text/javascript'></script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class="fa fa-gear"></i> Site settings <!--<small>Settings</small>-->
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / site settings
            </li>
        </ol>
    </div>
</div>
<div class="row">
	<div class='col-lg-10'>

		<div class='msg'></div>

		<ul id="myTabs" class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active">
				<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">General settings</a>
			</li>
			<li role="presentation" class="">
				<a href="#Registration" role="tab" id="Registration-tab" data-toggle="tab" aria-controls="Registration" aria-expanded="false">Registration</a>
			</li>
			<li role="presentation" class="">
				<a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">Ads settings</a>
			</li>
			<li role="presentation" class="">
				<a href="#Security" role="tab" id="Security-tab" data-toggle="tab" aria-controls="Security" aria-expanded="false">Security</a>
			</li>
			<li role="presentation" class="">
				<a href="#email" role="tab" id="email-tab" data-toggle="tab" aria-controls="email" aria-expanded="false">Email</a>
			</li>
			<li role="presentation" class="">
				<a href="#other" role="tab" id="other-tab" data-toggle="tab" aria-controls="other" aria-expanded="false">Other</a>
			</li>
			<!--
			<li role="presentation" class="">
				<a href="#LayoutSettings" role="tab" id="LayoutSettings-tab" data-toggle="tab" aria-controls="LayoutSettings" aria-expanded="false">Layout Settings</a>
			</li>
			-->
		</ul>

		<div id="myTabContent" class="tab-content">
			<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
				<br><br>
				<div>
					<div class='uploadMsg' style='display: none;'></div>
						<table class='table table-striped'>
							<tr>
								<td width='40%'>
									<label>Site icon :</label>
								</td>
								<td>
									<form action='<?php echo base_url($page_path); ?>/ajax' method='post' enctype='multipart/form-data'>
										<div class='upload'>
											<img src='<?php echo base_url("img/favicon.png"); ?>' width="70px" height="70px">
											<input type='file' name='icon' class='uploadLogoImage' >
											<input type='hidden' name='type' value='icon' >
											<input type='hidden' name='uploadImg' value='yes' >
											<span class='progress'></span>
											<span class='choose-image'><i class='fa fa-image fa-lg'></i><br>Choose an image</span>
										</div>
									</form>
								</td>
							</tr>
							<tr>
								<td width='40%'>
									<label>Site logo :</label><br>
									<small><i>The length of width should be greater than the height with three time</i></small>
								</td>
								<td>
									<form action='<?php echo base_url($page_path); ?>/ajax' method='post' enctype='multipart/form-data'>
										<div class='upload'>
											<img src='<?php echo base_url("img/logo.png"); ?>' >
											<input type='file' name='logo' class='uploadLogoImage' >
											<span class='progress'></span>
											<span class='choose-image'><i class='fa fa-image fa-lg'></i><br>Choose an image</span>
										</div>
										<br>
										<input type='hidden' name='uploadImg' value='yes' >
										<input type='hidden' name='type' value='logo' >
									</form>
								</td>
							</tr>
						</table>
				</div>
				<form class="optionForm" action='<?php echo base_url($page_path); ?>/ajax' method='post'>
					<table class='table table-striped' border='0'>
						<tr>
							<td width='40%'><label>Show logo :</label></td>
							<td><input type='checkbox' name='show_logo' value='1' 
							<?php if (get_config_item('show_logo') == 1){echo "checked";} ?> > Show logo image</td>
						</tr>
						<tr>
							<td width='40%'><label>Site name :</label></td>
							<td><input type='text' name='site_name' class='form-control' value="<?php echo htmlentities(get_config_item('sitename'),ENT_QUOTES); ?>" ></td>
						</tr>
						<tr>
							<td width='40%'>
								<label>keywords :</label><br>
								<em>
									<small>this keywords will be shown on all pages.</small>
								</em>
							</td>
							<td>
								<input type='keywords' name='keywords' class='form-control' value="<?php echo htmlentities(get_config_item('keywords'),ENT_QUOTES); ?>" >
							</td>
						</tr>
						<tr>
							<td width='40%'>
								<label>description :</label><br>
								<em>
									<small>this description will be shown on all pages.</small>
								</em>
							</td>
							<td>
								<textarea rows='5' name='desc' class='form-control'><?php echo get_config_item('description'); ?></textarea>
							</td>
						</tr>
						<tr>
							<td><label>Default language :</label></td>
							<td>
								<select disabled name='default_lang' class='form-control'>
									<option value="1">Arabic</option>
									<option value="2">English</option>
									<option value="3">Fransh</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<label>Default timezone :</label><br>
								<small><i><?php echo "<b>GMT : </b>".gmdate(get_config_item("time_format"));?></i></small>
							</td>
							<td>
								<span>
									<?php echo get_config_item('default_timezone'); ?> : <?php echo date(get_config_item("time_format")); ?>
								</span><br><br>

								<?php
								echo get_timezone_menu('default_timezone','form-control',get_config_item('default_timezone'));
								?>
							</td>
						</tr>
						<tr>
							<td>
								<label>time format :</label>
							</td>
							<td>
								<input type='text' name='time_format' class='form-control' value='<?php echo get_config_item("time_format");?>' >
							</td>
						</tr>
						<tr>
							<td><label>Website Live :</label></td>
							<td>	
								<input type='radio' <?php if (get_config_item("siteclose") == 0){echo "checked";} ?> name='status_site' value='0' > <span>Open</span><br>
								<input type='radio' name='status_site' <?php if (get_config_item("siteclose") == 1){echo "checked";} ?> value='1' > <span>Close</span>
							</td>
						</tr>
						<tr>
							<td><label>Shutdown Message :</label></td>
							<td>	
								<textarea rows='5' cols='30' class='form-control' name='msg_closed_site' ><?php echo get_config_item("shutdown_msg"); ?></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<label>Head code :</label><br>
								<small><i>a code like Analytics/Tracking codes!</i></small>
							</td>
							<td>	
								<textarea rows='5' cols='30' class='form-control' name='analytics_code'><?php echo get_config_item("tracking_code"); ?></textarea>
							</td>
						</tr>
						<tr>
							<td><label>Head code (just for "Go" page) :</label></td>
							<td>	
								<textarea rows='5' cols='30' class='form-control' name='go_head_code'><?php echo get_config_item("go_head_code"); ?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan='2' align='right'>
								<input type='hidden' name='tab' value='1' >
								<button name='submit' class='btn btn-primary' >Save</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="Registration" aria-labelledby="Registration-tab">
				<form class="optionForm" action='<?php echo base_url($page_path); ?>/ajax' method='post'>
					<br><br>
					<table class='table table-striped'>
						<tr>
							<td width='40%'><label>Registration Enable :</label></td>
							<td><input type='checkbox' name='registration_status' value='1' <?php if (get_config_item('registration_status') == 1){echo "checked";} ?> > <span>Allow visitor to register a new account</span></td>
						</tr>
						<tr>
							<td><label>Shutdown message of registration :</label></td>
							<td>
								<textarea class='form-control' rows='5' name='shutdown_msg_register'><?php echo get_config_item('shutdown_msg_register'); ?></textarea>
							</td>
						</tr>
						<tr>
							<td><label>block Account :</label></td>
							<td><input type='checkbox' name='account_status' value='1' <?php if (get_config_item('user_delete_account') == 1){echo "checked";} ?> > <span>Allow user to unlock (delete) his account</span></td>
						</tr>
						<tr>
							<td>
								<label>notes :</label><br>
								<small><i>show notes when a user want to block (delete) his account</i></small>
							</td>
							<td>
								<textarea class='form-control' rows='7' name='notes_delete_account'><?php echo get_config_item('notes_delete_account'); ?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan='2' align='right'>
								<input type='hidden' name='tab' value='2' >
								<button name='sub-regi' class='btn btn-primary' >Save</button>
							</td>
						</tr>
						
					</table>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
				<br><br>
				<form class="optionForm" action='<?php echo base_url($page_path); ?>/ajax' method='post'>
					<table class='table table-striped'>
						<tr>
							<td width="35%"><label>Show Ads on website :</label></td>
							<td>
								<label>
									<input type='checkbox' name='ads_status' value='1' <?php if(get_config_item('ads_status') == 1){echo "checked";}; ?> >
									 Turn On
								</label>
							</td>
						</tr>
						<tr>
							<td><label>Show ads on users accounts :</label></td>
							<td>
								<label>
									<input type='checkbox' name='ads_status_on_accounts' value='1' <?php if(get_config_item('ads_status_on_accounts') == 1){echo "checked";}; ?> >
									 Turn On
								</label>
							</td>
						</tr>
						<tr>
							<td><label>Ad (728 x 90) :</label></td>
							<td>
								<textarea name='ad_728x90' rows='5' class='form-control'><?php echo get_config_item("ad_728x90"); ?></textarea>
							</td>
						</tr>
						<tr>
							<td><label>Ad (300 x 250) :</label></td>
							<td>
								<textarea name='ad_300x250' rows='5' class='form-control'><?php echo get_config_item("ad_300x250"); ?></textarea>
							</td>
						</tr>
						<tr>
							<td><label>Ad (300 x 600) :</label></td>
							<td>
								<textarea name='ad_300x600' rows='5' class='form-control'><?php echo get_config_item("ad_300x600"); ?></textarea>
							</td>
						</tr>
						<tr>
							<td><label>Ad (autosize) :</label></td>
							<td>
								<textarea name='ad_autosize' rows='5' class='form-control'><?php echo get_config_item("ad_autosize"); ?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan='2' align='right'>
								<input type='hidden' name='tab' value='3' >
								<button name='sub-regi' class='btn btn-primary' >Save</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="Security" aria-labelledby="Security-tab">
				<form class="optionForm" action='<?php echo base_url($page_path); ?>/ajax' method='post'>
					<br><br>
					<table class='table table-striped'>
						<tr>
							<td width='40%'>
								<label>Cookie name :</label><br>
								<small><i>the name must be composed of the following symbols (<b>a-z A-Z 0-9 - _ </b>) </i></small>
							</td>
							<td>
								<input type="text" name="cookie_name" class="form-control" value='<?php echo get_config_item('cookie_name'); ?>' >
							</td>
						</tr>
						<tr>
							<td>
								<label>Time cookie expiration  :</label><br>
								<small><i>Use <b>15</b> days, it is better</i></small>
							</td>
							<td>
								<div class="input-group">
									<input type="number" name="expir_time" class="form-control" min="1" max="30" id="basic-url" aria-describedby="basic-addon3" value='<?php echo get_config_item('cookie_expire')/(3600*24); ?>' >
									<span class="input-group-addon" id="basic-addon3"><b>Days</b></span>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<label>Restauration time account :</label><br>
								<small><i>- Use <b>1</b> hour, it is better.
								<br>- The time allowed for the user to restore his account after sending a message of recovery, which allows him to set a new password.</i></small>
							</td>
							<td>
								<div class="input-group">
									<input type="number" name="rest_time" class="form-control" min="1" max="1000" id="basic-url" aria-describedby="basic-addon3" value='<?php echo get_config_item('restoration_time_account'); ?>' >
									<span class="input-group-addon" id="basic-addon3"><b>Hours</b></span>
								</div>
							</td>
						</tr>
						<tr>
							<td><label>reCAPTCHA Code (Google):</label></td>
							<td>
								<label>
								<input type='checkbox' name='recaptcha_status' value='1' 
									<?php if (get_config_item('recaptcha_status') == 1){echo "checked";} ?> > 
									<span>Enable recaptcha</span>
								</label>
								<br><br>
								Secret Key :<input type='text' name='secret_key' class='form-control' 
											value="<?php echo get_config_item('secret_key'); ?>" ><br>
								Public Key :<input type='text' name='public_key' class='form-control' 
											value="<?php echo get_config_item('public_key'); ?>" >
							</td>
						</tr>
						<tr>
							<td colspan='2' align='right'>
								<input type='hidden' name='tab' value='4' >
								<button name='sub-security' class='btn btn-primary' >Save</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="email" aria-labelledby="email-tab">
				<form class="optionForm" action='<?php echo base_url($page_path); ?>/ajax' method='post'>
					<br><br>
					<table class='table table-striped'>
						<tr>
							<td width='30%'><label>Email method :</label></td>
							<td>
								<select name="email_method" class="form-control">
									<option value="mail" 
									<?php if (get_config_item('email_method') == 'default'){echo "selected";} ?> >PHP Mail Function</option>
									<option value="smtp" 
									<?php if (get_config_item('email_method') == 'smtp'){echo "selected";} ?> >SMTP</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><label>From Email :</label></td>
							<td>
								<input type='text' name='email_from' class='form-control' 
								value='<?php echo get_config_item('email_from'); ?>' >
							</td>
						</tr>
						<tr>
							<td><label>SMTP Host :</label></td>
							<td>
								<input type='text' name='SMTP_Host' class='form-control'
								value='<?php echo get_config_item('SMTP_Host'); ?>' >
							</td>
						</tr>
						<tr>
							<td><label>SMTP Port :</label></td>
							<td>
								<input type='number' name='SMTP_Port' class='form-control'
								value='<?php echo get_config_item('SMTP_Port'); ?>' >
							</td>
						</tr>
						<tr>
							<td><label>SMTP Username :</label></td>
							<td>
								<input type='text' name='SMTP_User' class='form-control'
								value='<?php echo get_config_item('SMTP_User'); ?>' >
							</td>
						</tr>
						<tr>
							<td><label>SMTP Password :</label></td>
							<td>
								<input type='password' name='SMTP_Pass' class='form-control'
								value='<?php echo get_config_item('SMTP_Pass'); ?>' >
							</td>
						</tr>
						<tr>
							<td><label>mail encription :</label></td>
							<td>
								<select name="mail_encription" class="form-control">
									<option value="tls" 
									<?php if (get_config_item('mail_encription') == 'tls'){echo "selected";} ?> >tls</option>
									<option value="ssl" 
									<?php if (get_config_item('mail_encription') == 'ssl'){echo "selected";} ?> >ssl</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><label>emails templates :</label></td>
							<td>
								you can costum or change the emails templates<br>
								- for <b>account activation email (registration)</b> you can update this template 
								<code>application\views\email_tpls\activation.html</code><br>
								- for <b>forget password</b> : <code>application\views\email_tpls\forget_password.html</code><br>
								- for <b>contact</b> : <code>application\views\email_tpls\contact.html</code><br>
							</td>
						</tr>
						<tr>
							<td colspan='2' align='right'>
								<input type='hidden' name='tab' value='5' >
								<button name='sub-email' class='btn btn-primary' >Save</button>
							</td>
						</tr>
					</table>
				</form>
			</div>

			<!--====================== by type of the website =======================-->
			<div role="tabpanel" class="tab-pane fade" id="other" aria-labelledby="other-tab">
				<br><br>
				<form class="optionForm" action='<?php echo base_url($page_path); ?>/ajax' method='post'>
					<table class='table table-striped'>
						<tr>
							<td><label>show fake statistics:</label></td>
							<td>
								<label>
									<input type='checkbox' name='showFakeNumbers' value='1' <?php echo (get_config_item("showFakeNumbers") == 1)? 'checked' : ''; ?>>
									<span> Turn On</span>
								</label>
							</td>
						</tr>
						<tr>
							<td><label>Set fake views:</label></td>
							<td>
								<input type='number' name='fakeViews' min='0' class='form-control' value='<?php echo get_config_item("fakeViews"); ?>'>
							</td>
						</tr>
						<tr>
							<td><label>Set fake users:</label></td>
							<td>
								<input type='number' name='fakeUsers' min='0' class='form-control' value='<?php echo get_config_item("fakeUsers"); ?>'>
							</td>
						</tr>
						<tr>
							<td><label>Set fake links:</label></td>
							<td>
								<input type='number' name='fakeLinks' min='0' class='form-control' value='<?php echo get_config_item("fakeLinks"); ?>'>
							</td>
						</tr>
						<tr>
							<td width='40%'>
								<label>URLs will be forbidden:</label><br>
								<small><i>if you have a lot of URLs, put each URL on one line.</i></small>
							</td>
							<td>
								<textarea name="bad_urls" class="form-control" rows="5" placeholder="http://www.exemple.com" ><?php echo get_config_item('bad_urls'); ?></textarea>
							</td>
						</tr>
						<tr>
							<td><label>Pub Code of Google Adsense :</label></td>
							<td>
								<input type='text' name='pub' placeholder='pub-xxxxxxxxxxxxxx'class='form-control' value='<?php echo get_config_item("admin_pub"); ?>'>
							</td>
						</tr>
						<tr>
							<td><label>Channel Code of Google Adsense :</label></td>
							<td>
								<input type='text' name='channel' placeholder='xxxxxxxx'class='form-control' 
									value='<?php echo get_config_item("admin_channel"); ?>'>
							</td>
						</tr>
						<tr>
							<td><label>Default countdown :</label></td>
							<td>
								<input type='number' name='countdown' class='form-control' max='120' min='5' 
									value='<?php echo get_config_item("countdown"); ?>'>
							</td>
						</tr>
						<tr>
							<td>
								<label>just show admin ads :</label><br>
								<small><i>the users ads won't show up any more!</i></small>
							</td>
							<td>
								<label>
								<input type='checkbox' name='just_show_admin_ads' value='1' 
									<?php if (get_config_item('just_show_admin_ads') == 1){echo "checked";} ?> > 
									<span>Enable this mode</span>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label>just show users ads :</label><br>
								<small><i>the admin ads won't show up any more!</i></small>
							</td>
							<td>
								<label>
								<input type='checkbox' name='just_show_users_ads' value='1' 
									<?php if (get_config_item('just_show_users_ads') == 1){echo "checked";} ?> > 
									<span>Enable this mode</span>
								</label>
							</td>
						</tr>
						<tr>
							<td width='40%'>
								<label>packages domains: </label><br>
								<small><i>we will use this domians on the sorted links.</i></small><br>
								<small><i><b>NOTE:</b> the links order is important.</i></small>
							</td>
							<td>
								<textarea name="packages_domains" class="form-control" rows="5" placeholder="example.com OR www.example.com" ><?php echo get_config_item('packages_domains'); ?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan='2' align='right'>
								<input type='hidden' name='tab' value='10' >
								<button name='submit' class='btn btn-primary' >Save</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<!--
			<div role="tabpanel" class="tab-pane fade" id="LayoutSettings" aria-labelledby="LayoutSettings-tab">
				Layout Settings
			</div>
			-->
		</div> <!-- close the tab-content id -->
	</div> <!-- close the col-lg-12 -->
</div> <!-- close the row class -->

<?php
/*
$timezones = array (
'(GMT-11:00) Midway Island' => 'Pacific/Midway',
'(GMT-11:00) Samoa' => 'Pacific/Samoa',
'(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
'(GMT-09:00) Alaska' => 'US/Alaska',
'(GMT-08:00) Pacific Time (US &amp; Canada)' => 'America/Los_Angeles',
'(GMT-08:00) Tijuana' => 'America/Tijuana',
'(GMT-07:00) Arizona' => 'US/Arizona',
'(GMT-07:00) Chihuahua' => 'America/Chihuahua',
'(GMT-07:00) La Paz' => 'America/Chihuahua',
'(GMT-07:00) Mazatlan' => 'America/Mazatlan',
'(GMT-07:00) Mountain Time (US &amp; Canada)' => 'US/Mountain',
'(GMT-06:00) Central America' => 'America/Managua',
'(GMT-06:00) Central Time (US &amp; Canada)' => 'US/Central',
'(GMT-06:00) Guadalajara' => 'America/Mexico_City',
'(GMT-06:00) Mexico City' => 'America/Mexico_City',
'(GMT-06:00) Monterrey' => 'America/Monterrey',
'(GMT-06:00) Saskatchewan' => 'Canada/Saskatchewan',
'(GMT-05:00) Bogota' => 'America/Bogota',
'(GMT-05:00) Eastern Time (US &amp; Canada)' => 'US/Eastern',
'(GMT-05:00) Indiana (East)' => 'US/East-Indiana',
'(GMT-05:00) Lima' => 'America/Lima',
'(GMT-05:00) Quito' => 'America/Bogota',
'(GMT-04:00) Atlantic Time (Canada)' => 'Canada/Atlantic',
'(GMT-04:30) Caracas' => 'America/Caracas',
'(GMT-04:00) La Paz' => 'America/La_Paz',
'(GMT-04:00) Santiago' => 'America/Santiago',
'(GMT-03:30) Newfoundland' => 'Canada/Newfoundland',
'(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
'(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
'(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
'(GMT-03:00) Greenland' => 'America/Godthab',
'(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
'(GMT-01:00) Azores' => 'Atlantic/Azores',
'(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
'(GMT+00:00) Casablanca' => 'Africa/Casablanca',
'(GMT+00:00) Edinburgh' => 'Europe/London',
'(GMT+00:00) Greenwich Mean Time : Dublin' => 'Etc/Greenwich',
'(GMT+00:00) Lisbon' => 'Europe/Lisbon',
'(GMT+00:00) London' => 'Europe/London',
'(GMT+00:00) Monrovia' => 'Africa/Monrovia',
'(GMT+00:00) UTC' => 'UTC',
'(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
'(GMT+01:00) Belgrade' => 'Europe/Belgrade',
'(GMT+01:00) Berlin' => 'Europe/Berlin',
'(GMT+01:00) Bern' => 'Europe/Berlin',
'(GMT+01:00) Bratislava' => 'Europe/Bratislava',
'(GMT+01:00) Brussels' => 'Europe/Brussels',
'(GMT+01:00) Budapest' => 'Europe/Budapest',
'(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
'(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
'(GMT+01:00) Madrid' => 'Europe/Madrid',
'(GMT+01:00) Paris' => 'Europe/Paris',
'(GMT+01:00) Prague' => 'Europe/Prague',
'(GMT+01:00) Rome' => 'Europe/Rome',
'(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
'(GMT+01:00) Skopje' => 'Europe/Skopje',
'(GMT+01:00) Stockholm' => 'Europe/Stockholm',
'(GMT+01:00) Vienna' => 'Europe/Vienna',
'(GMT+01:00) Warsaw' => 'Europe/Warsaw',
'(GMT+01:00) West Central Africa' => 'Africa/Lagos',
'(GMT+01:00) Zagreb' => 'Europe/Zagreb',
'(GMT+02:00) Athens' => 'Europe/Athens',
'(GMT+02:00) Bucharest' => 'Europe/Bucharest',
'(GMT+02:00) Cairo' => 'Africa/Cairo',
'(GMT+02:00) Harare' => 'Africa/Harare',
'(GMT+02:00) Helsinki' => 'Europe/Helsinki',
'(GMT+02:00) Istanbul' => 'Europe/Istanbul',
'(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
'(GMT+02:00) Kyiv' => 'Europe/Helsinki',
'(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
'(GMT+02:00) Riga' => 'Europe/Riga',
'(GMT+02:00) Sofia' => 'Europe/Sofia',
'(GMT+02:00) Tallinn' => 'Europe/Tallinn',
'(GMT+02:00) Vilnius' => 'Europe/Vilnius',
'(GMT+03:00) Baghdad' => 'Asia/Baghdad',
'(GMT+03:00) Kuwait' => 'Asia/Kuwait',
'(GMT+03:00) Minsk' => 'Europe/Minsk',
'(GMT+03:00) Nairobi' => 'Africa/Nairobi',
'(GMT+03:00) Riyadh' => 'Asia/Riyadh',
'(GMT+03:00) Volgograd' => 'Europe/Volgograd',
'(GMT+03:30) Tehran' => 'Asia/Tehran',
'(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
'(GMT+04:00) Baku' => 'Asia/Baku',
'(GMT+04:00) Moscow' => 'Europe/Moscow',
'(GMT+04:00) Muscat' => 'Asia/Muscat',
'(GMT+04:00) St. Petersburg' => 'Europe/Moscow',
'(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
'(GMT+04:00) Yerevan' => 'Asia/Yerevan',
'(GMT+04:30) Kabul' => 'Asia/Kabul',
'(GMT+05:00) Islamabad' => 'Asia/Karachi',
'(GMT+05:00) Karachi' => 'Asia/Karachi',
'(GMT+05:00) Tashkent' => 'Asia/Tashkent',
'(GMT+05:30) Chennai' => 'Asia/Calcutta',
'(GMT+05:30) Kolkata' => 'Asia/Kolkata',
'(GMT+05:30) Mumbai' => 'Asia/Calcutta',
'(GMT+05:30) New Delhi' => 'Asia/Calcutta',
'(GMT+05:30) Sri Jayawardenepura' => 'Asia/Calcutta',
'(GMT+05:45) Kathmandu' => 'Asia/Katmandu',
'(GMT+06:00) Almaty' => 'Asia/Almaty',
'(GMT+06:00) Astana' => 'Asia/Dhaka',
'(GMT+06:00) Dhaka' => 'Asia/Dhaka',
'(GMT+06:00) Ekaterinburg' => 'Asia/Yekaterinburg',
'(GMT+06:30) Rangoon' => 'Asia/Rangoon',
'(GMT+07:00) Bangkok' => 'Asia/Bangkok',
'(GMT+07:00) Hanoi' => 'Asia/Bangkok',
'(GMT+07:00) Jakarta' => 'Asia/Jakarta',
'(GMT+07:00) Novosibirsk' => 'Asia/Novosibirsk',
'(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
'(GMT+08:00) Chongqing' => 'Asia/Chongqing',
'(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
'(GMT+08:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
'(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
'(GMT+08:00) Perth' => 'Australia/Perth',
'(GMT+08:00) Singapore' => 'Asia/Singapore',
'(GMT+08:00) Taipei' => 'Asia/Taipei',
'(GMT+08:00) Ulaan Bataar' => 'Asia/Ulan_Bator',
'(GMT+08:00) Urumqi' => 'Asia/Urumqi',
'(GMT+09:00) Irkutsk' => 'Asia/Irkutsk',
'(GMT+09:00) Osaka' => 'Asia/Tokyo',
'(GMT+09:00) Sapporo' => 'Asia/Tokyo',
'(GMT+09:00) Seoul' => 'Asia/Seoul',
'(GMT+09:00) Tokyo' => 'Asia/Tokyo',
'(GMT+09:30) Adelaide' => 'Australia/Adelaide',
'(GMT+09:30) Darwin' => 'Australia/Darwin',
'(GMT+10:00) Brisbane' => 'Australia/Brisbane',
'(GMT+10:00) Canberra' => 'Australia/Canberra',
'(GMT+10:00) Guam' => 'Pacific/Guam',
'(GMT+10:00) Hobart' => 'Australia/Hobart',
'(GMT+10:00) Melbourne' => 'Australia/Melbourne',
'(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
'(GMT+10:00) Sydney' => 'Australia/Sydney',
'(GMT+10:00) Yakutsk' => 'Asia/Yakutsk',
'(GMT+11:00) Vladivostok' => 'Asia/Vladivostok',
'(GMT+12:00) Auckland' => 'Pacific/Auckland',
'(GMT+12:00) Fiji' => 'Pacific/Fiji',
'(GMT+12:00) International Date Line West' => 'Pacific/Kwajalein',
'(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
'(GMT+12:00) Magadan' => 'Asia/Magadan',
'(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
'(GMT+12:00) New Caledonia' => 'Asia/Magadan',
'(GMT+12:00) Solomon Is.' => 'Asia/Magadan',
'(GMT+12:00) Wellington' => 'Pacific/Auckland',
'(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
);
*/
?>

