<script src='<?php echo base_url("js/ajax.form.js"); ?>'></script>
<!-- recaptcha script -->
<script src='https://www.google.com/recaptcha/api.js?hl=ar'></script>
<div class='container account'>
	<div class='row'>
		<?php
		echo $sidebar;
		?>
		<div class='col-md-9'>
			<div class='msg' style='display: none;'></div>
			<div>
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
						<i class='fa fa-lg fa-user'></i> <?php langLine('account.profile.span.1') ?></a>
					</li>
					<li role="presentation">
						<a href="#repass" aria-controls="repass" role="tab" data-toggle="tab">
						<i class='fa fa-lg fa-unlock-alt'></i> <?php langLine('account.profile.span.2') ?></a>
					</li>
					<?php if (get_config_item('user_delete_account') == 1) { ?>
					<li role="presentation">
						<a href="#block" aria-controls="block" role="tab" data-toggle="tab">
						<i class='fa fa-lg fa-trash-o'></i> <?php langLine('account.profile.span.3') ?></a>
					</li>
					<?php } ?>
					<li role="presentation">
						<a href="#withdraw" aria-controls="withraw" role="tab" data-toggle="tab">
						<i class='fa fa-lg fa-credit-card'></i> <?php langLine('account.profile.span.22') ?></a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="profile">
						<br><br>
							<div class='col-md-3'>
								<div class='box-profile-img' >
								<img class='profile-img pro-img' src='<?php echo get_profile_img($userdata['user_token']); ?>' alt='صورة الحساب الشخصي' >
									<form id='form-img' action='<?php echo base_url($page_path); ?>/ajax' method='post' enctype='multipart/form-data'>
										<input type='file' name='img' >
										<input type='hidden' name='tab' value='img'>
										<span><i class='fa fa-lg fa-camera'></i> <b><?php langLine('account.profile.span.4') ?></b></span>
										<i class='fa fa-2x fa-pencil pencil'></i>
									</form>
									<div class='progressBox'></div>
								</div>
							</div>

						<div class='col-md-8'>
							<form id='updateProfile' action='<?php echo base_url($page_path); ?>/ajax' method='post'>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.5') ?> :</label>
									<input type='text' name='username' value='<?php echo htmlentities($userdata['username'],ENT_QUOTES); ?>' class='form-control' >
								</div>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.6') ?> :</label>
									<input type='text' value='<?php echo $userdata['email']; ?>' disabled class='form-control' >
								</div>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.7') ?> :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type='radio' name='gender' value='1' <?php if ($userdata['gender'] == 1){echo "checked";} ?> > <?php langLine('account.profile.span.8') ?>
									<input type='radio' name='gender' value='2' <?php if ($userdata['gender'] == 2){echo "checked";} ?>> <?php langLine('account.profile.span.9') ?>
								</div>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.10') ?> :</label>
									<?php
									if (isset($userdata["country"]))
									{
										$country = $userdata["country"];
									}
									else
									{
										$country = 0;
									}
									echo get_country_menu('country','form-control',$country); ?>
								</div>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.11') ?> :</label>
									<input type='text' name='birth-day'
									value='<?php if (isset($userdata["birth_date"])){echo $userdata["birth_date"];} ?>' placeholder='DD/MM/YYYY' class='form-control' >
								</div>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.12') ?> :</label>
									<input type='text' name='sec-que'
									value='<?php if (isset($userdata["sec_ques"])){echo htmlentities($userdata["sec_ques"],ENT_QUOTES);} ?>' placeholder='<?php langLine('account.profile.span.13') ?>' class='form-control' >
								</div>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.14') ?> :</label>
									<input type='text' name='ans-que'
									value='<?php if (isset($userdata["ans_ques"])){echo htmlentities($userdata["ans_ques"],ENT_QUOTES);} ?>' placeholder='<?php langLine('account.profile.span.15') ?>' class='form-control' >
								</div>
								<div class='form-group'>
									<input type='hidden' name='tab' value='1' >
									<button type='submit' name='edit-profile' class='btn btn-primary'><i class='fa fa-fw fa-floppy-o'></i> <?php langLine('account.profile.span.16') ?></button>
								</div>
							</form>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="repass">
						<br><br>
						<div class='col-lg-8'>
							<form id='updatePassword' action='<?php echo base_url($page_path); ?>/ajax' method='post'>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.17') ?> :</label>
									<input type='password' name='old-pass' class='form-control' >
								</div>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.18') ?> :</label>
									<input type='password' name='new-pass' class='form-control' >
								</div>
								<div class='form-group'>
									<label><?php langLine('account.profile.span.19') ?> :</label>
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
									<input type='hidden' name='tab' value='2' >
									<button type='submit' name='repass' class='btn btn-primary'><i class='fa fa-fw fa-key'></i> <?php langLine('account.profile.span.20') ?></button>
								</div>
							</form>
						</div>
					</div>
					<?php
					if (get_config_item('user_delete_account') == 1) { ?>
					<div role="tabpanel" class="tab-pane" id="block">
						<br></br>
						<div class='col-lg-12'>
							<?php
							if (get_config_item('notes_delete_account') != '')
							{
								echo "<div class='well'>".get_config_item('notes_delete_account')."</div>";
							}
							?>
						</div><br>
						<div style='width: 300px; margin: 0px auto;'>
							<div class='form-group'>
								<button class='btn btn-danger btn-block' id='deleteAccountByUser'><i class='fa fa-trash-o'></i> <?php langLine('account.profile.span.21') ?></button>
							</div>
						</div>
					</div>
					<?php } ?>

					<div role="tabpanel" class="tab-pane" id="withdraw">
						<div class="col-md-8">
							<h3>Select My Withdrawal Method:</h3>
							<form method='POST' action='<?php echo base_url($page_path); ?>/ajax' id='updateWithdrawalMethod'>
								<div class='form-group'>
									<label>Method:</label>
									<select name='withdrawal_method' class='form-control'>
										<option value='0'>--- Choose a Method ---</option>
										<?php foreach($withdrawal_methods as $method): ?>
											<option value='<?=$method->id ?>' <?=($method->id == $userdata['withdrawal_method_id'])? 'selected': '' ?>><?=$method->name ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label>Withdrawal Account:</label>
									<textarea name="withdrawal_account" rows='5' class="form-control" placeholder="e.g. For PayPal, add your email here."><?=$userdata['withdrawal_account'] ?></textarea>
								</div>
								<div class="form-group">
									<input type='hidden' name='tab' value='3' >
									<button type="submit" class="btn btn-primary">Save</button>
								</div>
							</form>
						</div>
						<div class='col-md-4'>
							<!--
							<h4>Info:</h4>
							<ul>
								<?php foreach($withdrawal_methods as $method): ?>
									<?php if ($method->description): ?>
										<li><?=$method->description ?></li>
									<?php endif ?>
								<?php endforeach ?>
							</ul>
							-->
						</div>
						<div class='col-lg-12'>
							<h3>Available Withdrawal Methods:</h3>
							<?php
							$currency = get_currency();
							?>
							<?php if ($withdrawal_methods): ?>
								<table class='table table-striped'>
									<thead>
										<tr>
											<th>Withdrawal Method</th>
											<th>Minimum Amount to Withdraw</th>
											<th>Description</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($withdrawal_methods as $method): ?>
										<tr>
											<td><?=$method->name ?></td>
											<td><?="{$currency['symbol']}{$method->min_amount}" ?></td>
											<td><?=$method->description ?></td>
										</tr>
										<?php endforeach ?>
									</tbody>
								</table>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
