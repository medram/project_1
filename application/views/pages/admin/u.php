<style>
	.DeleteProfile
	{
		cursor: pointer;
	}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class="fa fa-pencil"></i> Edit User (<?php if (isset($userInfo['id'])){echo $userInfo['id'];}else{echo "?";} ?>)
        </h1>
    </div>
</div>
<div class='row'>
	<div class='col-lg-11'>
		<div class='msg'>
			<?php
			if (isset($msg))
			{
				echo $msg;
			}
			?>
		</div>
	</div>
</div>
<div class='row'>
	<?php
	if (isset($forb_msg))
	{
		echo "<div class='col-lg-12' ><div class='alert alert-danger'><b>".$forb_msg."</b></div></div>";
	}
	else
	{
	?>
	<div class='col-lg-4'>
		<div>
			<ul class="list-group">
				<li class="list-group-item" style='background: <?php echo color(); ?>; color: #fff; border: none;'>
					<img src='<?php echo get_profile_img($userInfo["user_token"]); ?>' 
						class='img-circle' width='120px' height='120px' >
					<span style='font-size: 20px'><?php echo $userInfo['username']; ?></span>
					<br><small><span class='DeleteProfile' id='<?php echo $userInfo['user_token']; ?>'><i class='fa fa-xs fa-times'></i> Delete profile image</span></small>
				</li>
				<li class="list-group-item"><b>Joined :</b> <?php echo date(config_item('time_format'),$userInfo['user_joined']);?></li>
				<li class="list-group-item"><b>Last login </b><br>
				<?php

				echo "date : ";
				if (isset($userInfo['last_login']))
				{
					echo date(config_item('time_format'),$userInfo['last_login'])."<br>";
				}else{echo "Unknown !<br>";}
				
				echo "ip : ";
				if (isset($userInfo['ip']))
				{
					echo $userInfo['ip']."<br>";
				}else{echo "Unknown !<br>";}

				echo "platform : ";
				if (isset($userInfo['platform']))
				{
					echo $userInfo['platform']."<br>";
				}else{echo "Unknown !<br>";}

				echo "browser : ";
				if (isset($userInfo['browser']))
				{
					echo $userInfo['browser']."<br>";
				}else{echo "Unknown !<br>";}
				?>
				</li>
				<li class="list-group-item"><b>User token : </b><br><small><?php echo $userInfo['user_token']; ?></small></li>

				
			</ul>
		</div>
	</div>

	<div class='col-lg-7'>
		<form id='updateProfileUser' action='<?php echo base_url($page_path); ?>/ajax' method='post'>
			<div class='form-group'>
				<label>Username :</label>
				<input type='text' name='username' value='<?php echo htmlentities($userInfo['username'],ENT_QUOTES); ?>' class='form-control' >
			</div>
			<div class='form-group'>
				<label>E-mail :</label>
				<input type='text' name='email' value='<?php echo $userInfo['email']; ?>' class='form-control' >
			</div>
			<div class='form-group'>
				<label>Account Status :</label>
				<select name='status' class='form-control'>
					<option value='0' <?php if ($userInfo['account_status'] == 0){echo "selected";} ?> >Active</option>
					<option value='1' <?php if ($userInfo['account_status'] == 1){echo "selected";} ?> >Inactive</option>
					<option value='2' <?php if ($userInfo['account_status'] == 2){echo "selected";} ?> >Banned</option>
				</select>
			</div>
			<div class='form-group'>
				<label>Message of banned :</label>
				<textarea name='banned_msg' class='form-control' rows='5'><?php if (isset($userInfo['banned_msg'])){echo $userInfo['banned_msg'];} ?></textarea>
			</div>
			<div class='form-group'>
				<label>Gender :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>
					<input type='radio' name='gender' value='1' <?php if ($userInfo['gender'] == 1){echo "checked";} ?>  > Male 
				</label>
				&nbsp;&nbsp;&nbsp; 
				<label>
					<input type='radio' name='gender' value='2' <?php if ($userInfo['gender'] == 2){echo "checked";} ?>> Female
				</label>
			</div>
			<div class='form-group'>
				<label>Country :</label>
				<?php
				if (isset($userInfo["country"]))
				{
					$country = $userInfo["country"];
				}
				else
				{
					$country = 0;
				}
				echo get_country_menu('country','form-control',$country,'en'); ?>
			</div>
			<div class='form-group'>
				<label>Pub code :</label>
				<input type='text' name='pub' value='<?php if (isset($userInfo['user_pub'])){echo $userInfo['user_pub'];} ?>' class='form-control' >
			</div>
			<div class='form-group'>
				<label>Channel :</label>
				<input type='text' name='channel' value='<?php if (isset($userInfo['user_channel'])){echo $userInfo['user_channel'];} ?>' class='form-control' >
			</div>
			<div class='form-group'>
				<label>Birth day :</label>
				<input type='text' name='birth-day' 
				value='<?php if (isset($userInfo["birth_date"])){echo $userInfo["birth_date"];} ?>' placeholder='DD/MM/YYYY' class='form-control' >
			</div>
			<div class='form-group'>
				<label>Security question :</label>
				<input type='text' name='sec-que' 
				value='<?php if (isset($userInfo["sec_ques"])){echo htmlentities($userInfo["sec_ques"],ENT_QUOTES);} ?>' class='form-control' >
			</div>
			<div class='form-group'>
				<label>Answer question :</label>
				<input type='text' name='ans-que' 
				value='<?php if (isset($userInfo["ans_ques"])){echo htmlentities($userInfo["ans_ques"],ENT_QUOTES);} ?>' class='form-control' >
			</div>
			<div class='form-group'>
				<input type='hidden' name='edit-profile' value='1' >
				<input type='hidden' name='user_id' value='<?php echo $userInfo["id"]; ?>' >
				<button type='submit' name='edit-profile' class='btn btn-primary'><i class='fa fa-fw fa-floppy-o'></i> Save</button>
			</div>
		</form>
	</div>
	<?php
	} // end else
	?>
</div><!-- end div row -->