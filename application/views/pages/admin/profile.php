<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-user"></i> My Profile</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-body">
        	<div class='row'>
        		<div class='col-lg-6'>
        			<?php
        			if (isset($msg1) && $msg1 != '')
        			{
        				echo $msg1;
        			}
        			?>
        			<div class='well'>
        				<form action='<?php echo base_url($page_path)."/profile"; ?>' method='post'>
        					<div class='form-group'>
        						<label>Username :</label>
        						<input type='text' name='username' class='form-control' value='<?php echo htmlentities($userdata['username'],ENT_QUOTES); ?>' >
        					</div>
        					<div class='form-group'>
        						<label>Email :</label>
        						<input type='email' name='email' class='form-control' value='<?php echo $userdata['email']; ?>' >
        					</div>
        					<div class='form-group'>
        						<label>Birth Date :</label>
        						<input type='text' name='date-birth' class='form-control' placeholder='DD/MM/YYYY' 
        							value='<?php if (isset($userdata['birth_date'])){echo $userdata['birth_date'];} ?>' >
        					</div>
        					<div class='form-group'>
        						<label>Security Question :</label>
        						<input type='text' name='security-question' class='form-control' placeholder='Your question here ?' value='<?php if (isset($userdata['sec_ques'])){echo htmlentities($userdata['sec_ques'],ENT_QUOTES);} ?>' ><br>
        						<input type='text' name='answer-question' class='form-control' placeholder='Answer of the question here ...' value='<?php if (isset($userdata['ans_ques'])){echo htmlentities($userdata['ans_ques'],ENT_QUOTES);} ?>'>
        					</div>
        					<hr>
        					<div class='form-group'>
        						<input type='submit' name='edit-profile' value='Save profile data' class='btn btn-info' >
        					</div>
        				</form>
        			</div>
        		</div>
        		<div class='col-lg-6'>
        			<?php
        			if (isset($msg2) && $msg2 != '')
        			{
        				echo $msg2;
        			}
        			?>
        			<div class='well'>
        				<form action='<?php echo base_url($page_path)."/profile"; ?>' autocomplete='off' method='post' >
        					<div class='form-group'>
        						<label>old password :</label>
        						<input type='password' name='old-pass' class='form-control' >
        					</div>
        					<div class='form-group'>
        						<label>new password :</label>
        						<input type='password' name='new-pass' class='form-control' >
        					</div>
        					<div class='form-group'>
        						<label>confirm new pass :</label>
        						<input type='password' name='conf-new-pass' class='form-control' >
        					</div>
        					<hr>
        					<div class='form-group'>
        						<input type='submit' name='edit-pass' class='btn btn-success' value='Save the new password' >
        					</div>
        				</form>
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</section>

